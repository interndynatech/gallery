<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class ClientGalleryController extends Controller
{
    
    public function index(Request $request)
    {
        $type = $request->type ?? 'training';

        $clients = DB::table('clients')
            ->join('client_gallery', 'clients.clientId', '=', 'client_gallery.client_id')
            ->where('client_gallery.type', $type)
            ->select('clients.clientId', 'clients.clientName')
            ->distinct()
            ->get();

        $query = DB::table('client_gallery')
            ->join('clients', 'clients.clientId', '=', 'client_gallery.client_id')
            ->where('client_gallery.type', $type)
            ->select('client_gallery.*', 'clients.clientName')
            ->orderBy('client_gallery.date', 'desc');

        if ($request->has('clients')) {
            $query->whereIn('clients.clientId', $request->clients);
        }

        $gallery = $query->get();

        $pageTitle = 'Gallery';

        return view('clientGallery', compact('gallery', 'clients', 'type', 'pageTitle'));
    }

    public function selectClient($type)
    {
        $clients = DB::table('clients')
            ->join('client_gallery', 'clients.clientId', '=', 'client_gallery.client_id')
            ->where('client_gallery.type', $type)
            ->select('clients.clientId', 'clients.clientName')
            ->distinct()
            ->get();

        $pageTitle = 'Gallery';
        return view('selectClient', compact('clients', 'type', 'pageTitle'));
    }

    public function clientGallery($type, $client_id)
    {
        $gallery = DB::table('client_gallery')
            ->join('clients', 'clients.clientId', '=', 'client_gallery.client_id')
            ->where('client_gallery.type', $type)
            ->where('client_gallery.client_id', $client_id)
            ->select('client_gallery.*', 'clients.clientName')
            ->orderBy('client_gallery.date', 'desc')
            ->get();

        $client = DB::table('clients')->where('clientId', $client_id)->first();

        // ✅ Tambah grouping untuk paparan Masonry Card per group
        $groupedGallery = $gallery->groupBy(function ($item) {
            return $item->client_id . '-' . $item->title . '-' . $item->description . '-' . $item->date . '-' . $item->type;
        });

        $pageTitle = 'Gallery';
        return view('clientGallery', compact('gallery', 'type', 'client', 'groupedGallery', 'pageTitle'));
    }

  public function showAll()
    {
        $galleryItems = DB::table('client_gallery')
            ->join('clients', 'client_gallery.client_id', '=', 'clients.clientId')
            ->select(
                'client_gallery.id',
                'client_gallery.client_id', 
                'client_gallery.id_group',
                'clients.clientName',
                'client_gallery.description',
                'client_gallery.title',
                'client_gallery.type',
                'client_gallery.date',
                'client_gallery.created_at',
                'client_gallery.image_path'
            )
            ->orderBy('client_gallery.created_at', 'desc')
            ->get();

        // ✅ Group hanya ikut ID group
        $groupedGallery = $galleryItems->groupBy('id_group');

        $pageTitle = 'Client Gallery';

        return view('admin.pages.clients.allClientGallery', compact('groupedGallery', 'pageTitle'));
    }


    public function create()
    {
        $pageTitle = 'Client Gallery';

        $galleryItems = DB::table('client_gallery')
            ->join('clients', 'client_gallery.client_id', '=', 'clients.clientId')
            ->select(
                'client_gallery.id',
                'client_gallery.client_id',
                'client_gallery.id_group',
                'clients.clientName',
                'client_gallery.description',
                'client_gallery.title',
                'client_gallery.type',
                'client_gallery.date',
                'client_gallery.created_at',
                'client_gallery.image_path'
            )
            ->orderBy('client_gallery.created_at', 'desc')
            ->get();

        // ✅ Group ikut id_group sahaja
        $groupedGallery = $galleryItems->groupBy('id_group');

        $clients = DB::table('clients')->where('status', 1)->get();

        return view('admin.pages.clients.allClientGallery', compact('pageTitle', 'groupedGallery', 'clients'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,clientId',
            'type' => 'required|in:training,exhibition,visit',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buat satu UUID untuk id_group baru
        $id_group = Str::uuid();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/images/clientGallery/' . $request->type);

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                $image->move($path, $filename);

                DB::table('client_gallery')->insert([
                    'client_id' => $request->client_id,
                    'id_group' => $id_group,
                    'type' => $request->type,
                    'title' => $request->title,
                    'description' => $request->description,
                    'date' => $request->date,
                    'image_path' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.pages.clients.createClientGallery')
            ->with('success', 'Gallery images uploaded successfully.');
    }

    public function destroy($id)
    {
        // Dapatkan id_group gambar berdasarkan id yang diberikan
        $item = DB::table('client_gallery')->where('id', $id)->first();

        if (!$item) {
            return response()->json(['message' => 'Item not found.'], 404);
        }

        // Padam semua gambar yang ada dalam id_group yang sama
        $deleted = DB::table('client_gallery')->where('id_group', $item->id_group)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Deleted all images in the group successfully.']);
        } else {
            return response()->json(['message' => 'Delete failed.'], 500);
        }
    }


    public function edit($id)
    {
        $item = DB::table('client_gallery')->where('id', $id)->first();

        if (!$item) {
            abort(404);
        }

        // Ambil semua gambar yang sama dalam kumpulan
        $relatedImages = DB::table('client_gallery')
            ->where('id_group', $item->id_group)
            ->get();

        return view('admin.pages.clients.includes.editClientGallery', compact('item', 'relatedImages'));
    }


    public function update(Request $request, $id_group)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'type' => 'required|in:training,exhibition,visit',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve any existing record from the group
        $existingGallery = DB::table('client_gallery')->where('id_group', $id_group)->first();
        if (!$existingGallery) {
            return redirect()->back()->with('error', 'Gallery not found.');
        }

        $newType = $request->input('type');
        $newTitle = $request->input('title');
        $newDescription = $request->input('description');
        $newDate = $request->input('date');

        // Update all existing records in the same group with new metadata
        DB::table('client_gallery')->where('id_group', $id_group)->update([
            'title' => $newTitle,
            'description' => $newDescription,
            'date' => $newDate,
            'type' => $newType,
            'updated_at' => now(),
        ]);

        // If the type was changed, move existing image files to the new type folder
        if ($existingGallery->type !== $newType) {
            $oldPath = public_path('assets/images/clientGallery/' . $existingGallery->type);
            $newPath = public_path('assets/images/clientGallery/' . $newType);

            // Create the new directory if it doesn't exist
            if (!File::exists($newPath)) {
                File::makeDirectory($newPath, 0755, true);
            }

            // Move each file to the new folder
            $oldImages = DB::table('client_gallery')->where('id_group', $id_group)->get();
            foreach ($oldImages as $image) {
                $oldFilePath = $oldPath . '/' . $image->image_path;
                $newFilePath = $newPath . '/' . $image->image_path;

                if (File::exists($oldFilePath)) {
                    File::move($oldFilePath, $newFilePath);
                }
            }
        }

        // If new images are uploaded, insert them as new records (append)
        if ($request->hasFile('images')) {
            $uploadPath = public_path('assets/images/clientGallery/' . $newType);

            // Ensure the folder exists
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Loop and save each uploaded image
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $filename);

                DB::table('client_gallery')->insert([
                    'client_id' => $existingGallery->client_id,
                    'id_group' => $id_group,
                    'type' => $newType,
                    'title' => $newTitle,
                    'description' => $newDescription,
                    'date' => $newDate,
                    'image_path' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Gallery updated successfully.');
    }

    public function getGallery($id)
    {
        $gallery = DB::table('client_gallery')->where('id', $id)->first();

        if (!$gallery) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($gallery);
    }
}
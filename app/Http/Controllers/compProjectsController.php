<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class compProjectsController extends Controller
{
    public function compProjects()
{
    // Ambil satu projek bagi setiap title untuk dijadikan kad utama
    $mainProjects = DB::table('mainproject as mp1')
        ->join(DB::raw('(SELECT title, MIN(mainProjectId) as minId FROM mainproject GROUP BY title) as mp2'), function ($join) {
            $join->on('mp1.mainProjectId', '=', 'mp2.minId');
        })
        ->select('mp1.*')
        ->get();

    $clients = DB::table('clients')->where('status', 1)->get(); // optional
    $pageTitle = 'Company Projects';

    return view('admin.pages.compProjects.compProjects', [
        'mainProjects' => $mainProjects,
        'clients' => $clients,
        'pageTitle' => $pageTitle,
    ]);
}


    public function groupByTitle($title)
    {
        $projects = DB::table('mainproject')
        ->select(DB::raw('MIN(mainProjectId) as mainProjectId'), 'title', DB::raw('MIN(introContent) as introContent'), DB::raw('MIN(imagePath) as imagePath'))
        ->groupBy('title')
        ->get();


        $pageTitle = $title;

        return view('admin.pages.compProjects.projectGroupDetails', [
            'projects' => $projects,
            'pageTitle' => $pageTitle,
        ]);
    }

    public function storeProjects(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'introContent' => 'nullable|string',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $folderName = Str::slug($request->title, '_');
            $path = public_path("assets/images/mainProjects/{$folderName}");

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move($path, $imageName);
                $imagePath = "{$folderName}/{$imageName}";
            }

            $mainProjectId = DB::table('mainproject')->insertGetId([
                'title' => $request->title,
                'introContent' => $request->introContent,
                'desc' => $request->desc,
                'imagePath' => $imagePath,
                'dateCreated' => now(),
                'dateModified' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Project stored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store project: ' . $e->getMessage()]);
        }
    }

    public function showProjects($id)
    {
        $mainProject = DB::table('mainproject')->where('mainProjectId', $id)->first();

        if (!$mainProject) {
            return response()->json(['message' => 'Project not found.'], 404);
        }

        return response()->json($mainProject);
    }

    public function updateProjects(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'introContent' => 'nullable|string',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $project = DB::table('mainproject')->where('mainProjectId', $id)->first();

        if (!$project) {
            return response()->json(['success' => false, 'message' => 'Project not found.'], 404);
        }

        $updateData = [
            'title' => $request->input('title'),
            'introContent' => $request->input('introContent'),
            'desc' => $request->input('desc'),
            'dateModified' => now(),
        ];

        $folderName = Str::slug($request->title, '_');
        $path = public_path("assets/images/mainProjects/{$folderName}");

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move($path, $imageName);
            $imagePath = "{$folderName}/{$imageName}";
            $updateData['imagePath'] = $imagePath;
        }

        DB::table('mainproject')->where('mainProjectId', $id)->update($updateData);

        return response()->json(['success' => true, 'message' => 'Project updated successfully.']);
    }

    public function delete($mainProjectId)
    {
        DB::table('mainproject')->where('mainProjectId', $mainProjectId)->delete();

        return response()->json(['success' => true]);
    }
}

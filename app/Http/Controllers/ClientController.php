<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function clients()
    {
        $clients = DB::table('clients')->get();
        $pageTitle = 'Clients';


        return view('admin.pages.clients.clients', [
            'clients' => $clients,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function storeClients(Request $request)
    {
        $request->validate([
            'clientName' => 'required|string|max:255',
            'activeStatus' => 'nullable',
            'clientType' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $folderName = Str::slug($request->clientType, '_');
            $path = public_path("assets/images/clients/{$folderName}");
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

            DB::table('clients')->insertGetId([
                'clientName' => $request->clientName,
                'active' => $request->activeStatus,
                'clientType' => $request->clientType,
                'imagePath' => $imagePath,
                'dateCreated' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Client stored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store client details: ' . $e->getMessage()]);
        }
    }

    public function showClients($id)
    {
        $clientList = DB::table('clients')->where('clientId', $id)->first();

        if (!$clientList) {
            return response()->json(['message' => 'Project not found.'], 404);
        }

        return response()->json($clientList);
    }

    public function updateClients(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'displayClientName' => 'nullable|string|max:255',
            'displayActiveStatus' => 'nullable',
            'displayClientType' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the project from the database
        $project = DB::table('clients')->where('clientId', $id)->first();

        if (!$project) {
            return response()->json(['success' => false, 'message' => 'Project not found.'], 404);
        }

        // Prepare data for update
        $updateData = [
            'clientName' => $request->displayClientName,
            'active' => $request->displayActiveStatus,
            'clientType' => $request->displayClientType,
            'dateCreated' => now(),
        ];

        // Get the image folder path based on title
        $folderName = Str::slug($request->clientType, '_');
        $path = public_path("assets/images/clients/{$folderName}");

        // Create the directory if it does not exist
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move($path, $imageName);
            $imagePath = "{$folderName}/{$imageName}";

            // Add image path to update data
            $updateData['imagePath'] = $imagePath;
        }

        // Update the project in the database
        DB::table('clients')->where('clientId', $id)->update($updateData);

        return response()->json(['success' => true, 'message' => 'Project updated successfully.']);
    }
    public function delete($clientId)
    {
        // Perform the delete operation, e.g., using DB queries
        DB::table('clients')->where('clientId', $clientId)->delete();
    
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DocumentsController extends Controller
{
    public function documents()
    {
        $documents = DB::table('documents')->get();
        $pageTitle = 'Documents';


        return view('admin.pages.documents.documents', [
            'documents' => $documents,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function storeDocuments(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'docName' => 'required|string|max:255',
            'activeStatus' => 'nullable|boolean',
            'filePath' => 'required|mimes:pdf,doc,docx', // File size limit to 2MB
        ]);
    
        DB::beginTransaction(); // Start the transaction
    
        try {
            // Prepare the folder where the document will be stored
            $folderName = Str::slug($request->docName, '_'); // Slugify the document name
            $path = public_path("assets/images/documents/{$folderName}");
    
            // Create the directory if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
    
            // Check if a file has been uploaded
            if ($request->hasFile('filePath')) {
                // Get the uploaded file
                $file = $request->file('filePath');
    
                // Generate a unique file name with its extension
                $fileName = time() . '_' . $file->getClientOriginalName();
    
                // Move the file to the specified folder
                $file->move($path, $fileName);
    
                // Save the relative file path (inside the public directory)
                $filePath = "assets/images/documents/{$folderName}/{$fileName}";
            }
    
            // Insert the document details into the database
            DB::table('documents')->insertGetId([
                'docName' => $request->docName,
                'status' => $request->activeStatus,
                'filePath' => $filePath ?? null, // Ensure file path is set correctly
                'dateCreated' => now(),
            ]);
    
            DB::commit(); // Commit the transaction
    
            // Return a success response
            return response()->json(['success' => true, 'message' => 'Documents stored successfully.']);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction
            return response()->json(['success' => false, 'message' => 'Failed to store document details: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    public function deleteDocuments($docId)
    {
        DB::table('documents')->where('docId', $docId)->delete();
    
        return response()->json(['success' => true]);
    }

    public function showDocuments($docId)
    {
        $documents = DB::table('documents')->where('docId', $docId)->first();

        if (!$documents) {
            return response()->json(['message' => 'Documents not found.'], 404);
        }

        return response()->json($documents);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function achievements()
    {
        $achievements = DB::table('categories')->get();
        $pageTitle = 'Achievements'; 


        return view('admin.pages.company.achievements', [
            'achievements' => $achievements,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoriesTitle' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $categoryId = DB::table('categories')->insertGetId([
                'categoriesTitle' => $request->categoriesTitle,
                'dateCreated' => now(),
            ]);

            $folderName = Str::slug($request->categoriesTitle, '_');
            $path = public_path("assets/images/achievements/{$folderName}");

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Store images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName(); 
                    $image->move($path, $imageName);

                    DB::table('categoriesimage')->insert([
                        'categoriesId' => $categoryId,
                        'imagePath' => "{$folderName}/{$imageName}",
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Category and images stored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store category and images: ' . $e->getMessage()]);
        }
    }
    public function show($id)
    {
        $category = DB::table('categories')
            ->leftJoin('categoriesimage', 'categories.categoriesId', '=', 'categoriesimage.categoriesId')
            ->where('categories.categoriesId', $id)
            ->select('categories.*', 'categoriesimage.imagePath')
            ->first();

        if ($category) {
            $baseUrl = asset('assets/images/achievements/');

            $images = DB::table('categoriesimage')
                ->where('categoriesId', $id)
                ->pluck('imagePath');

            $category->imageUrls = $images->map(function ($imagePath) use ($baseUrl) {
                return $baseUrl . '/' . $imagePath;
            });

            return response()->json($category);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            // Find the existing category by ID
            $category = DB::table('categories')->where('categoriesId', $id)->first();
    
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }
    
            // Update the category title
            $oldTitle = $category->categoriesTitle;
            $newTitle = $request->input('title');
            
            DB::table('categories')->where('categoriesId', $id)->update([
                'categoriesTitle' => $newTitle,
            ]);
    
            $oldFolderName = Str::slug($oldTitle, '_');
            $newFolderName = Str::slug($newTitle, '_');
    
            $newPath = public_path("assets/images/achievements/{$newFolderName}");
    
            // If the title has changed, rename the folder
            if ($oldFolderName !== $newFolderName) {
                $oldPath = public_path("assets/images/achievements/{$oldFolderName}");
    
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                } else {
                    mkdir($newPath, 0777, true);
                }
    
                // Update the image paths in the database to reflect the new folder name
                DB::table('categoriesimage')
                    ->where('categoriesId', $id)
                    ->update([
                        'imagePath' => DB::raw("REPLACE(imagePath, '{$oldFolderName}', '{$newFolderName}')")
                    ]);
            } else {
                if (!file_exists($newPath)) {
                    mkdir($newPath, 0777, true);
                }
            }
    
            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName(); // Ensure unique names
                    $image->move($newPath, $imageName);
    
                    DB::table('categoriesimage')->insert([
                        'categoriesId' => $id,
                        'imagePath' => "{$newFolderName}/{$imageName}",
                    ]);
                }
            }
    
            return response()->json(['success' => true, 'message' => 'Category and images updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update category and images: ' . $e->getMessage()]);
        }
    }
    public function delete($categoriesId)
{
    try {
        // Delete related images
        DB::table('categoriesimage')->where('categoriesId', $categoriesId)->delete();

        // Then delete the category
        DB::table('categories')->where('categoriesId', $categoriesId)->delete();

        return response()->json(['success' => true, 'message' => 'Category and associated images deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete category: ' . $e->getMessage()]);
    }
}


    
    
    

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function news()
    {
        $news = DB::table('news')->get();
        $pageTitle = 'News';


        return view('admin.pages.news.news', [
            'news' => $news,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'introContent' => 'string|max:255',
            'status' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $newsId = DB::table('news')->insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'introContent' => $request->introContent,
                'status' => $request->status,
                'dateCreated' => now(),
            ]);

            $folderName = Str::slug($request->title, '_');
            $path = public_path("assets/images/news/{$folderName}");

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Store images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName();
                    $image->move($path, $imageName);

                    DB::table('newsimage')->insert([
                        'newsId' => $newsId,
                        'imagePath' => "{$folderName}/{$imageName}",
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'News have been stored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store news: ' . $e->getMessage()]);
        }
    }

    public function showNews($id)
    {
        $news = DB::table('news')
            ->leftJoin('newsimage', 'news.newsId', '=', 'newsimage.newsId')
            ->where('news.newsId', $id)
            ->select('news.*', 'newsimage.imagePath')
            ->first();

        if ($news) {
            $baseUrl = asset('assets/images/news/');

            $images = DB::table('newsimage')
                ->where('newsId', $id)
                ->pluck('imagePath');

            $news->imageUrls = $images->map(function ($imagePath) use ($baseUrl) {
                return $baseUrl . '/' . $imagePath;
            });

            return response()->json($news);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }

    }

    public function updateNews(Request $request, $id)
    {
        $request->validate([
            'titleDisplay' => 'nullable',
            'displayFullContent' => 'nullable',
            'displayIntroContent' => 'nullable|max:255',
            'displayStatus' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            // Retrieve the existing news record
            $news = DB::table('news')->where('newsId', $id)->first();
    
            if (!$news) {
                return response()->json(['error' => 'News not found'], 404);
            }
    
            // Since we're not updating the title, skip the title update logic
            $oldTitle = $news->title;
            // $newTitle is removed, as the title is not being updated
    
            // Update the news record in the database (without the title)
            DB::table('news')->where('newsId', $id)->update([
                'title' => $request->input('titleDisplay'),
                'description' => $request->input('displayFullContent'),
                'introContent' => $request->input('displayIntroContent'),
                'status' => $request->input('displayStatus'),
            ]);
    
            // Keep the old folder name, since the title is not changing
            $folderName = Str::slug($oldTitle, '_');
            $path = public_path("assets/images/news/{$folderName}");
    
            // Create folder if it doesn't exist
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
    
            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName(); // Unique name with timestamp
                    $image->move($path, $imageName);
    
                    // Insert the new image path into the `newsimage` table
                    DB::table('newsimage')->insert([
                        'newsId' => $id,
                        'imagePath' => "{$folderName}/{$imageName}",
                    ]);
                }
            }
    
            return response()->json(['success' => true, 'message' => 'News and images updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update news: ' . $e->getMessage()]);
        }
    }
    public function deleteNews($newsId)
    {
        try {
            // Delete related images
            DB::table('newsimage')->where('newsId', $newsId)->delete();
    
            // Then delete the category
            DB::table('news')->where('newsId', $newsId)->delete();
    
            return response()->json(['success' => true, 'message' => 'News and associated images deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete news: ' . $e->getMessage()]);
        }
    }
    
    
    
}

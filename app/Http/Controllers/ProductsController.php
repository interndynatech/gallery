<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProductsController extends Controller
{
    public function products()
    {
        $products = DB::table('products')->get();
        $pageTitle = 'Products';


        return view('admin.pages.products.products', [
            'products' => $products,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function storeProducts(Request $request)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDesc' => 'required|string',
            'productFeatures' => 'required|string',
            'filePath' => 'nullable|mimes:pdf,doc,docx',
            'status' => 'required|integer',
            'categories' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'imagecarousel.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        DB::beginTransaction();

        try {
            $productId = DB::table('products')->insertGetId([
                'productName' => $request->productName,
                'productDesc' => $request->productDesc,
                'productFeatures' => $request->productFeatures,
                'status' => $request->status,
                'category' => $request->categories,
                'dateCreated' => now(),
            ]);

            $folderName = Str::slug($request->productName, '_');
            $pathMainImages = public_path("assets/images/products/{$folderName}/mainImg");
            $pathCarouselImages = public_path("assets/images/products/{$folderName}/imgCarousel");
            $pathFiles = public_path("assets/files/products/{$folderName}");

            foreach ([$pathMainImages, $pathCarouselImages, $pathFiles] as $path) {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
            }

            if ($request->hasFile('filePath')) {
                $file = $request->file('filePath');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move($pathFiles, $fileName);

                DB::table('products')->where('productId', $productId)->update([
                    'filePath' => "files/products/{$folderName}/{$fileName}",
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName();
                    $image->move($pathMainImages, $imageName);

                    DB::table('products')->updateOrInsert(
                        ['productId' => $productId],
                        ['imagePath' => "images/products/{$folderName}/mainImg/{$imageName}"]
                    );
                }
            }

            if ($request->hasFile('imagecarousel')) {
                foreach ($request->file('imagecarousel') as $carouselImage) {
                    $carouselImageName = time() . '-' . $carouselImage->getClientOriginalName();
                    $carouselImage->move($pathCarouselImages, $carouselImageName);

                    DB::table('productsimage')->insert([
                        'productId' => $productId,
                        'imagePathCarousel' => "images/products/{$folderName}/imgCarousel/{$carouselImageName}",
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product and images stored successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to store product and images: ' . $e->getMessage()]);
        }
    }
    public function showProducts($id)
    {
        $products = DB::table('products')
            ->leftJoin('productsimage', 'products.productId', '=', 'productsimage.productId')
            ->where('products.productId', $id)
            ->select('products.*', 'productsimage.imagePathCarousel')
            ->first();

        if ($products) {
            $baseUrl = asset('assets');

            $images = DB::table('productsimage')
                ->where('productId', $id)
                ->pluck('imagePathCarousel');

            $products->imageUrls = $images->map(function ($imagePath) use ($baseUrl) {
                return $baseUrl . '/' . $imagePath;
            });

            return response()->json($products);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    public function categoriesList()
    {
        $categories = DB::table('productscategories')->get(['categoriesId', 'categoriesTitle']);

        return response()->json($categories);
    }

    public function deleteProducts($productId)
    {
        // Begin a database transaction
        DB::beginTransaction();
    
        try {
            // Check if the product exists
            $product = DB::table('products')->where('productId', $productId)->first();
            
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
            }
    
            // Delete associated images
            DB::table('productsimage')->where('productId', $productId)->delete();
    
            // Delete the product
            DB::table('products')->where('productId', $productId)->delete();
    
            // Commit the transaction
            DB::commit();
    
            return response()->json(['success' => true, 'message' => 'Product and associated images deleted successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            
            return response()->json(['success' => false, 'message' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }
    

    public function updateProducts(Request $request, $productId)
    {
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDesc' => 'required|string',
            'productFeatures' => 'required|string',
            'filePath' => 'nullable|mimes:pdf,doc,docx',
            'status' => 'required|integer',
            'categories' => 'nullable|string',
            'mainImage.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'carouselImages.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        DB::beginTransaction();

        try {
            // Update product information
            DB::table('products')->where('productId', $productId)->update([
                'productName' => $request->productName,
                'productDesc' => $request->productDesc,
                'productFeatures' => $request->productFeatures,
                'status' => $request->status,
                // 'category' => $request->categories,
                'dateModified' => now(),
            ]);

            $folderName = Str::slug($request->productName, '_');
            $pathMainImages = public_path("assets/images/products/{$folderName}/mainImg");
            $pathCarouselImages = public_path("assets/images/products/{$folderName}/imgCarousel");
            $pathFiles = public_path("assets/files/products/{$folderName}");

            foreach ([$pathMainImages, $pathCarouselImages, $pathFiles] as $path) {
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
            }

            // Update or add new file attachment if present
            if ($request->hasFile('filePath')) {
                $file = $request->file('filePath');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move($pathFiles, $fileName);

                DB::table('products')->where('productId', $productId)->update([
                    'filePath' => "files/products/{$folderName}/{$fileName}",
                ]);
            }

            // Update or add new main images if present
            if ($request->hasFile('mainImage')) {
                // Handle single file upload
                $image = $request->file('mainImage');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move($pathMainImages, $imageName);

                // Update the image path in the 'products' table
                DB::table('products')->where('productId', $productId)->update([
                    'imagePath' => "images/products/{$folderName}/mainImg/{$imageName}"
                ]);
            }

            // Update or add new carousel images if present
            if ($request->hasFile('carouselImages')) {
                foreach ($request->file('carouselImages') as $carouselImage) {
                    $carouselImageName = time() . '-' . $carouselImage->getClientOriginalName();
                    $carouselImage->move($pathCarouselImages, $carouselImageName);

                    DB::table('productsimage')->insert([
                        'productId' => $productId,
                        'imagePathCarousel' => "images/products/{$folderName}/imgCarousel/{$carouselImageName}",
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Product and images updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update product and images: ' . $e->getMessage()]);
        }
    }

    public function storeCategories(Request $request)
    {
        $request->validate([
            'categories' => 'required|string|max:255',
        ]);

        try {
            DB::table('productscategories')->insert([
                'categoriesTitle' => $request->categories,
            ]);

            return response()->json(['success' => true, 'message' => 'Category stored successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store category: ' . $e->getMessage()]);
        }
    }
    public function deleteCategories($categoryId)
    {
        // Perform the delete operation, e.g., using DB queries
        DB::table('productscategories')->where('categoriesId', $categoryId)->delete();
    
        return response()->json(['success' => true]);
    }
    
}

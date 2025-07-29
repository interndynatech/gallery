<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PagesController extends Controller
{
    public function homepage()
    {
        $products = DB::table('products')
        ->where('status', 1)
        ->get();
        $pageTitle = 'Homepage';



        return view('homepage', [
            'pageTitle' => $pageTitle,
            'products' => $products,


        ]);
    }
    public function aboutUs()
    {
        $categories = DB::table('categories')->get();
        $images = DB::table('categoriesimage')->get();
        $pageTitle = 'About Us';


        return view('aboutUs', [
            'categories' => $categories,
            'images' => $images,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function ourTeam()
    {
        $orgchart = DB::table('organizationchart')->get();
        $pageTitle = 'Organization Chart';


        return view('ourTeam', [
            'orgchart' => $orgchart,
            'pageTitle' => $pageTitle,

        ]);
    }

//display project by group card 9 july 2025
   public function projects()
    {
        $projects = DB::table('mainproject')
        ->select(DB::raw('MIN(mainProjectId) as mainProjectId'), 'title', DB::raw('MIN(introContent) as introContent'), DB::raw('MIN(imagePath) as imagePath'))
        ->groupBy('title')
        ->get();

        $clients = DB::table('clients')->get();
        $pageTitle = 'Main Projects';

        return view('projects', compact('projects', 'pageTitle', 'clients'));
    }


    public function projectGroupDetails($title)
    {
        $projects = DB::table('mainproject')
            ->where('title', urldecode($title))
            ->orderBy('mainProjectId', 'desc') 
            ->paginate(6); 

        $pageTitle =urldecode($title);
        $projectTitle = urldecode($title);

        return view('projectGroupDetails', compact('projects', 'pageTitle', 'projectTitle'));
    }

    //end card projects 9 july 2025

    public function projectDetails($id)
    {
        $project = DB::table('mainproject')->where('mainProjectId', $id)->first();
        $pageTitle = 'Project Details';


        if (!$project) {
            abort(404, 'Project not found');
        }

        return view('projectDetails', [
            'project' => $project,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function careers()
    {
        $careers = DB::table('careers')->get();
        $pageTitle = 'Career';



        return view('careers', [
            'careers' => $careers,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function products(Request $request)
    {
        // Initialize the query for the products
        $query = DB::table('products');
    
        // Check if any category filter is applied
        if ($request->has('category')) {
            // Filter the products by the selected categories
            $query->whereIn('category', $request->category);
        }
    
        // Paginate the results (9 products per page)
        $products = $query->paginate(6);
    
        // Get the unique categories from the products table
        $categories = DB::table('products')->select('category')->distinct()->pluck('category');
    
        $pageTitle = 'Products';
    
        return view('products', [
            'products' => $products,
            'categories' => $categories, // Pass categories to the view
            'pageTitle' => $pageTitle,
        ]);
    }
    
    public function productsDetails($id)
    {
        // Fetch the product details, including main image
        $product = DB::table('products')
            ->leftJoin('productsimage', 'products.productId', '=', 'productsimage.productId')
            ->select(
                'products.productName',
                'products.productFeatures',
                'products.productDesc',
                'products.imagePath',
                'products.filePath',
                'productsimage.imagePathCarousel',
                'productsimage.productId'
            )
            ->where('products.productId', $id)
            ->first();
    
        // Check if the product was found
        if (!$product) {
            abort(404, 'Product not found');
        }
    
        // Fetch related images (if any)
        $images = DB::table('productsimage')
            ->where('productId', $id)
            ->get();
    
        // Ensure images are included in the view
        $product->images = $images;
    
        $pageTitle = 'Product Details';
    
        return view('productsDetails', [
            'product' => $product,
            'pageTitle' => $pageTitle,
        ]);
    }
    
    public function careersApply($id)
    {
        $career = DB::table('careers')->where('careerId', $id)->first();

        if (!$career) {
            abort(404);
        }

        return view('careersApply', [
            'career' => $career
        ]);
    }


    public function storeApplicants(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',  // Removed unique rule
            'age' => 'required|integer',
            'phoneNumber' => 'required|string|max:255',
            'address' => 'required|string',
            'postcode' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'supportingDocs' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'transcriptExam' => 'mimes:pdf,doc,docx|max:2048',
        ]);

        // Generate folder name and path
        $folderName = Str::slug($validatedData['fullName'], '_');
        $path = public_path("assets/files/applicants/{$folderName}");

        // Create directory if it does not exist
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Create 'images' subfolder for profileImage
        $imagesPath = $path . '/images';
        if (!file_exists($imagesPath)) {
            mkdir($imagesPath, 0777, true);
        }

        // Handle file uploads
        $filePaths = [];
        if ($request->hasFile('profileImage')) {
            $file = $request->file('profileImage');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move($imagesPath, $fileName);
            $filePaths['profileImage'] = "{$folderName}/images/{$fileName}";
        }
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move($path, $fileName);
            $filePaths['resume'] = "{$folderName}/{$fileName}";
        }
        if ($request->hasFile('transcriptExam')) {
            $file = $request->file('transcriptExam');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move($path, $fileName);
            $filePaths['transcriptExam'] = "{$folderName}/{$fileName}";
        }
        if ($request->hasFile('supportingDocs')) {
            $file = $request->file('supportingDocs');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move($path, $fileName);
            $filePaths['supportingDocs'] = "{$folderName}/{$fileName}";
        }


        // Insert data into the applicants table
        DB::table('applicants')->insert(array_merge($validatedData, $filePaths, [
            'status' => 'Pending',
            'dateCreated' => now(),
            'dateUpdated' => now(),
        ]));

        // Return a response
        return response()->json(['message' => 'Applicant stored successfully.'], 201);
    }
    public function contactUs()
    {

        $pageTitle = 'Contact Us';


        return view('contactUs', [

            'pageTitle' => $pageTitle,

        ]);
    }
    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'nullable|string|max:20',
            'typeOfEnquiry' => 'required|string',
            'message' => 'required|string|max:255',
        ]);

        DB::table('contactus')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phoneNum' => $request->input('contact_no'),
            'typeOfEnquiry' => $request->input('typeOfEnquiry'),
            'message' => $request->input('message'),
            'status' => 'Pending',
            'dateCreated' => now(),
        ]);

        return response()->json(['message' => 'Your message has been sent!'], 200);
    }

    public function newsAndUpdate()
    {
        $news = DB::table('news')->get();
        $newsimage = DB::table('newsimage')->get();
        $pageTitle = 'News And Updates';



        return view('newsAndUpdate', [
            'news' => $news,
            'newsimage' => $newsimage,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function newsAndUpdateDetails()
    {
        // Join the 'news' table with the 'newsimage' table
        $news = DB::table('news')
            ->join('newsimage', 'news.newsId', '=', 'newsimage.newsId') 
            ->select('news.title', 'news.introContent', 'news.description', 'newsimage.imagePath', 'newsimage.newsId')
            ->get()
            ->groupBy('newsId'); // Group by newsId to gather multiple images for each news item
    
        $pageTitle = 'News And Updates';
    
        return view('newsAndUpdateDetails', [
            'news' => $news,
            'pageTitle' => $pageTitle,
        ]);
    }

    public function documents()
    {
        $documents = DB::table('documents')
        ->where('status', 1)
        ->get();
        $pageTitle = 'Documents';



        return view('documents', [
            'pageTitle' => $pageTitle,
            'documents' => $documents,


        ]);
    }
    
    
    
}

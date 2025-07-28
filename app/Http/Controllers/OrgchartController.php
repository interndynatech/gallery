<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrgchartController extends Controller
{
    public function orgchart()
    {
        $orgchart = DB::table('organizationchart')->get();
        $pageTitle = 'Organizational Chart';


        return view('admin.pages.orgChart.orgchart', [
            'orgchart' => $orgchart,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function showOrgchart($orgChartId)
    {
        try {
            // Fetch images using query builder
            $images = DB::table('organizationchart') // Ensure the table name is correct
                ->where('orgChartId', $orgChartId)
                ->pluck('imagePath'); // Ensure the column name is correct

            // Return JSON response with images
            return response()->json($images);
        } catch (\Exception $e) {
            // Return a JSON response with error message
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function updateOrgChart(Request $request, $orgChartId)
{
    // Validate the request
    $request->validate([
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'orgChartId' => 'required|integer', // Ensure orgChartId is provided and valid
    ]);

    try {
        // Retrieve the existing org chart record
        $orgChart = DB::table('organizationchart')->where('orgChartId', $orgChartId)->first();

        if (!$orgChart) {
            return response()->json(['error' => 'OrgChart not found'], 404);
        }

        // Define the folder path
        $path = public_path('assets/images/about-us');

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Process only the first image (or adjust if you need to handle multiple)
            $file = $request->file('images')[0];

            // Generate a unique name for the image file
            $imageName = time() . '-' . $file->getClientOriginalName();
            
            // Move the file to the specified path
            $file->move($path, $imageName);

            // Update the org chart record with the new image path
            $imagePath = "images/about-us/{$imageName}";
            DB::table('organizationchart')
                ->where('orgChartId', $orgChartId)
                ->update([
                    'imagePath' => $imagePath
                ]);
        }

        return response()->json(['success' => true, 'message' => 'OrgChart and image updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to update OrgChart: ' . $e->getMessage()]);
    }
}

    
    
}

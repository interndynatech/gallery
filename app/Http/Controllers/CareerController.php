<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CareerController extends Controller
{
    public function career()
    {
        $career = DB::table('careers')->get();
        $pageTitle = 'Careers';


        return view('admin.pages.career.career', [
            'career' => $career,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function storeCareer(Request $request)
    {
        $request->validate([
            'jobTitle' => 'required|string|max:255',
            'jobPosition' => 'nullable',
            'jobDesc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $path = public_path("assets/images/career");
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move($path, $imageName);
                $imagePath = "{$imageName}";
            }

            DB::table('careers')->insertGetId([
                'title' => $request->jobTitle,
                'position' => $request->jobPosition,
                'description' => $request->jobDesc,
                'imagePath' => $imagePath,
                'dateCreated' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Job have been created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to store job details: ' . $e->getMessage()]);
        }
    }

    public function showCareer($id)
    {
        $career = DB::table('careers')->where('careerId', $id)->first();

        if (!$career) {
            return response()->json(['success' => false, 'message' => 'Job not found.'], 404);
        }

        return response()->json(['success' => true, 'career' => $career]);
    }

    public function updateCareer(Request $request, $id)
    {
        $request->validate([
            'jobTitle' => 'required|string|max:255',
            'jobPosition' => 'nullable|string',
            'jobDesc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Find the existing career record by ID
            $career = DB::table('careers')->where('careerId', $id)->first();

            if (!$career) {
                return response()->json(['success' => false, 'message' => 'Career not found.']);
            }

            $path = public_path("assets/images/career");
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Handle the image file
            $imagePath = $career->imagePath; // Default to existing image if no new image is provided
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($career->imagePath && file_exists($path . '/' . $career->imagePath)) {
                    unlink($path . '/' . $career->imagePath);
                }

                // Save the new image
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move($path, $imageName);
                $imagePath = $imageName;
            }

            // Update the career record
            DB::table('careers')->where('careerId', $id)->update([
                'title' => $request->jobTitle,
                'position' => $request->jobPosition,
                'description' => $request->jobDesc,
                'imagePath' => $imagePath,
                'dateCreated' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Job updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update job details: ' . $e->getMessage()]);
        }
    }
    public function delete($careerId)
    {
        try {
            // Delete related applicants first
            DB::table('applicants')
                ->where('position', $careerId)
                ->delete();

            DB::table('applicants')
                ->where('title', $careerId)
                ->delete();

            // Then delete the career record
            $deleted = DB::table('careers')->where('careerId', $careerId)->delete();

            if ($deleted) {
                return response()->json(['success' => true, 'message' => 'Career deleted successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Career not found or already deleted.']);
            }
        } catch (\Exception $e) {
       

            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the career.']);
        }
    }
}

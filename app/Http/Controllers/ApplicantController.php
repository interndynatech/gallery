<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    public function applicants()
    {
        $applicants = DB::table('applicants')->get();
        $pageTitle = 'applicants';


        return view('admin.pages.applicants.applicants', [
            'applicants' => $applicants,
            'pageTitle' => $pageTitle,

        ]);
    }
    public function showApplicants($id)
    {
        // Retrieve the applicant record by ID
        $applicant = DB::table('applicants')->where('applicantId', $id)->first();
        
        if (!$applicant) {
            return response()->json(['success' => false, 'message' => 'Applicant not found.']);
        }
        
        // Base path for assets
        $basePath = "assets/files/applicants";
        
        $files = [
            'profileImage' => $applicant->profileImage ? url($basePath . '/' . $applicant->profileImage) : null,
            'resume' => $applicant->resume ? url($basePath . '/' . $applicant->resume) : null,
            'transcriptExam' => $applicant->transcriptExam ? url($basePath . '/' . $applicant->transcriptExam) : null,
            'supportingDocs' => $applicant->supportingDocs ? url($basePath . '/' . $applicant->supportingDocs) : null,
        ];
    
        return response()->json(['success' => true, 'applicant' => $applicant, 'files' => $files]);
    }

    public function updateApplicants(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'status' => 'required|string|in:Pending,Done',
        ]);

        // Update applicant data
        $updated = DB::table('applicants')
            ->where('applicantId', $id)
            ->update([

                'status' => $request->input('status'), // Update status
            ]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Applicant updated successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update applicant. Please check if the applicant exists or has already been updated.'
            ]);
        }
    }

    public function deleteApplicants($applicantId)
    {
        // Perform the delete operation, e.g., using DB queries
        DB::table('applicants')->where('applicantId', $applicantId)->delete();
    
        return response()->json(['success' => true]);
    }
    
    
    
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function contact()
    {
        $contact = DB::table('contactus')->get();
        $pageTitle = 'Contact Us';


        return view('admin.pages.contact.contact', [
            'contact' => $contact,
            'pageTitle' => $pageTitle,

        ]);
    }

    public function deleteContact($contactId)
    {
        // Perform the delete operation, e.g., using DB queries
        DB::table('contactus')->where('contactId', $contactId)->delete();
    
        return response()->json(['success' => true]);
    }

    public function updateContact(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Done',
        ]);

        $updated = DB::table('contactus')
            ->where('contactId', $id)
            ->update([

                'status' => $request->input('status'), // Update status
            ]);

        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Contact Submission has been updated successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update submission.'
            ]);
        }
    }

    public function showContact($id)
    {
        $contact = DB::table('contactus')->where('contactId', $id)->first();

        if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Job not found.'], 404);
        }

        return response()->json(['success' => true, 'contact' => $contact]);
    }
}

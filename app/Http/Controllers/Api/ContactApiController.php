<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactDetails;

class ContactApiController extends Controller
{

    public function saveContact(Request $request)
    {
        try {
          
        $insertedContacts = [];
        $skippedContacts = [];

        foreach ($request->contacts as $contactData) {
            // Check if phone number already exists
            $existingContact = ContactDetails::where('phone', $contactData['phone'])->first();

            if ($existingContact) {
                // Skip existing contact
                $skippedContacts[] = $contactData['phone'];
                continue;
            }

            // Save new contact
            $contact = new ContactDetails();
            $contact->contact_id = "CONTACT" . rand(1000, 9999);
            $contact->name = $contactData['name'];

            $phone = ltrim($contactData['phone'], '0');
            
            if (str_starts_with($phone, '91')) {
                $contact->phone = '+' . $phone;
            } else {
                $contact->phone = '+91' . $phone;
            }
            
            $contact->save();

            $insertedContacts[] = $contact;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Contacts processed successfully!',
            'data' => $insertedContacts,
            'skipped' => $skippedContacts,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
    }
}

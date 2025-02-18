<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupAssign;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;



class WhatsappController extends Controller
{
    
    
    public function sendWhatsAppMessage(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'group_ids' => 'required|array', // Ensure group_ids are an array
            'group_ids.*' => 'exists:groups,id' // Validate each group_id exists in the database
        ]);
    
        try {
            // Get all assigned contacts safely, with null checks
            $contacts = GroupAssign::with('contactDetails') // Ensure the relationship is loaded
                ->whereIn('group_id', $request->group_ids)
                ->get()
                ->map(function ($groupAssign) {
                    // Check if contactDetails is null and log if necessary
                    if (!$groupAssign->contactDetails) {
                        Log::debug("No contactDetails for groupAssign ID: " . $groupAssign->id);
                        return null; // Return null if there's no contactDetails
                    }
    
                    // Ensure the phone number is in the correct format with the +91 country code
                    $phoneNumber = $groupAssign->contactDetails->phone;
                    if (!preg_match('/^\+91\d{10}$/', $phoneNumber)) {
                        Log::debug("Invalid phone number format for contact ID: " . $groupAssign->id);
                        return null; // Return null if the phone number format is incorrect
                    }
    
                    return $phoneNumber; // Return the valid phone number in the required format
                })
                ->filter() // Remove any null values from the collection
                ->values();

    
            // If no contacts are found, return an appropriate error
            if ($contacts->isEmpty()) {
                session()->flash('error', 'No valid contacts found for the provided group IDs.');
                return back();
            }
    
            // Get the Twilio credentials from the .env file
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $from = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER');  // WhatsApp-enabled number
    
            $client = new Client($sid, $token);
    
            // Handle file upload if image is provided
            $mediaUrl = null;
            if ($request->hasFile('image')) {
                // Ensure the uploaded image is valid
                $image = $request->file('image');
                $path = $image->storeAs('whatsapp_images', time() . '.' . $image->getClientOriginalExtension(), 'public');
                $mediaUrl = asset('storage/' . $path);  // Path to the uploaded image
            }
    
            // Send the message to each contact
            foreach ($contacts as $contact) {
                try {
                    $messageData = [
                        'body' => $request->message,
                        'from' => $from,
                        'to' => 'whatsapp:' . $contact, // Use the correct phone number format (e.g., +917749968976)
                    ];
    
                    // Include the image if available
                    if ($mediaUrl) {
                        $messageData['mediaUrl'] = [$mediaUrl];
                    }
    
                    // Try sending the message
                    $client->messages->create(
                        'whatsapp:' . $contact, // WhatsApp number with the country code
                        $messageData
                    );
                } catch (\Twilio\Exceptions\RestException $e) {
                    // Catch Twilio-specific errors and log them
                    Log::error('Twilio API Error for contact ' . $contact . ': ' . $e->getMessage());
                    session()->flash('error', 'Twilio API Error: ' . $e->getMessage());
                    return back();
                } catch (\Exception $e) {
                    // Catch general errors and log them
                    Log::error('General Error for contact ' . $contact . ': ' . $e->getMessage());
                    session()->flash('error', 'Error sending message to ' . $contact . ': ' . $e->getMessage());
                    return back();
                }
            }
    
            // If all messages are sent successfully, return a success message
            session()->flash('success', 'Messages sent successfully!');
            return back();
    
        } catch (\Exception $e) {
            // Catch any other general errors in the entire method
            Log::error('General Error: ' . $e->getMessage());
            session()->flash('error', 'Error sending messages: ' . $e->getMessage());
            return back();
        }
    }
    
    
}

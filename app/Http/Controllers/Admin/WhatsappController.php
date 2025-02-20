<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupAssign;
use Twilio\Rest\Client;
use App\Models\ContactDetails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;




class WhatsappController extends Controller
{
    
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:contact__assign_group,group_id',
            'message'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $groupId = $request->group_id;
        $message = $request->message;
        $imageUrl = null;
    
        // Handle Image Upload if Provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('whatsapp_images', 'public');
            $imageUrl = url("storage/$imagePath"); // Ensure a full URL is used
        }
    
        // Fetch All Contacts in the Group
        $contacts = GroupAssign::where('group_id', $groupId)
            ->where('status', 'active')
            ->with('contactDetails')
            ->get();
    
        if ($contacts->isEmpty()) {
            return back()->with('error', 'No active contacts found in this group.');
        }
    
        // Initialize Twilio Client
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    
        // Twilio WhatsApp From Number (Must be the Twilio Sandbox or Verified Number)
        $twilioWhatsAppFrom = env('TWILIO_WHATSAPP_FROM', 'whatsapp:+14155238886');
    
        // Send WhatsApp Message to Each Contact
        foreach ($contacts as $contact) {
            if ($contact->contactDetails && $contact->contactDetails->phone) {
                try {
                    $recipientPhone = "whatsapp:" . $contact->contactDetails->phone;
    
                    $twilioMessage = [
                        "from" => $twilioWhatsAppFrom,
                        "body" => $message
                    ];
    
                    // If Image Exists, Attach Media
                    if ($imageUrl) {
                        $twilioMessage["mediaUrl"] = [$imageUrl];
                    }
    
                    $twilio->messages->create($recipientPhone, $twilioMessage);
                } catch (\Exception $e) {
                    Log::error("Twilio Error: " . $e->getMessage());
                }
            }
        }
    
        return back()->with('success', 'WhatsApp messages sent successfully.');
    }
    
}

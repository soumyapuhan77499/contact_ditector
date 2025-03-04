<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactDetails;
use App\Models\Group;
use Carbon\Carbon;


class ContactController extends Controller
{

  public function manageContact($filter = null)
  {
      $query = ContactDetails::where('status', 'active');
  
      switch ($filter) {
          case 'today':
              $query->whereDate('created_at', Carbon::today());
              break;
  
          case 'monthly':
              $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
              break;
  
          case 'yearly':
              $query->whereYear('created_at', Carbon::now()->year);
              break;
  
          default:
              break;
      }
  
      $manageContact = $query->get();
  
      return view('admin.manage-contact', compact('manageContact', 'filter'));
  }

    public function deleteContact($id)
    {
        try {
            $contact = ContactDetails::findOrFail($id);
            $contact->update(['status' => 'deleted']); // Soft delete by updating status
            
            return response()->json(['success' => true, 'message' => 'Contact deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete Contact Error: ' . $e->getMessage()); 
            return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $contact = ContactDetails::findOrFail($id);
            $contact->update([
                'name' => $request->name,
            ]);

            return response()->json(['success' => true, 'message' => 'Contact updated successfully']);
        } catch (\Exception $e) {
            Log::error('Update Contact Error: ' . $e->getMessage()); 
            return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
        }
    }
    public function addContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);
    
        $phoneNumber = '+91' . ltrim($request->phone, '0');
    
        // Check if phone already exists
        $exists = ContactDetails::where('phone', $phoneNumber)->exists();
    
        if ($exists) {
            return redirect()->back()->with('error', 'This phone number already exists!');
        }
    
        // Create contact if phone does not exist
        ContactDetails::create([
            'contact_id' => "CONTACT" . rand(1000, 9999),
            'name' => $request->name,
            'phone' => $phoneNumber,
        ]);
    
        return redirect()->back()->with('success', 'Contact added successfully!');
    }
    


}

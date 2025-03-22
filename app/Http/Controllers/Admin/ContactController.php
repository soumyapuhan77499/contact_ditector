<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactDetails;
use App\Models\GroupAssign;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class ContactController extends Controller
{


public function uploadCsv(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    try {
        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        $header = fgetcsv($handle); // Skip header row
        $inserted = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $name = trim($row[0] ?? '');
            $phone = trim($row[1] ?? '');

            if ($name && $phone) {
                ContactDetails::create([
                    'name' => $name,
                    'phone' => $phone,
                    'group_status' => 'unassigned',
                ]);
                $inserted++;
            }
        }

        fclose($handle);  

        return redirect()->back()->with('success', "$inserted contacts uploaded successfully.");
    } catch (\Exception $e) {
        Log::error('CSV Upload Failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong while uploading the CSV file.');
    }
}

public function manageContact(Request $request, $filter = null)
{
    $groups = Group::where('status', 'active')->get();

    $query = DB::table('contact_details as c')
        ->leftJoin('contact__assign_group as ag', 'c.contact_id', '=', 'ag.contact_id')
        ->leftJoin('group_master as g', 'ag.group_id', '=', 'g.group_id')
        ->select(
            'c.id',
            'c.contact_id',
            'c.name',
            'c.phone',
            'c.created_at',
            DB::raw('GROUP_CONCAT(g.group_name SEPARATOR ", ") as group_names'),
            DB::raw('MAX(ag.group_id) as group_id') // For edit modal (assumes single active group)
        )
        ->where('c.status', 'active')
        ->groupBy('c.id', 'c.contact_id', 'c.name', 'c.phone', 'c.created_at');

    // Apply filters
    if ($filter === 'today') {
        $query->whereDate('c.created_at', Carbon::today());
    } elseif ($filter === 'yearly') {
        $query->whereYear('c.created_at', Carbon::now()->year);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('c.created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('c.created_at', '<=', $request->to_date);
    }

    $manageContact = $query->orderBy('c.name', 'asc')->get();

    return view('admin.manage-contact', compact('manageContact', 'filter', 'groups'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:group_master,group_id',
        ]);

        $contact = ContactDetails::findOrFail($id);
        $contact->update(['name' => $request->name]);

        GroupAssign::where('contact_id', $request->contact_id)
            ->update(['status' => 'inactive']);

        GroupAssign::create([
            'contact_id' => $request->contact_id,
            'group_id' => $request->group_id,
            'group_status' => 'assigned'
        ]);

        return response()->json(['success' => true, 'message' => 'Contact updated successfully']);
    } catch (ValidationException $ve) {
        return response()->json([
            'success' => false,
            'errors' => $ve->errors()
        ], 422);
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

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Log;
use App\Models\ContactDetails;
use App\Models\GroupAssign;


class GroupController extends Controller
{
    
    public function addGroup()
    {
        return view('admin.add-group');
    }

    public function saveGroup(Request $request)
{
    $group_id = "GROUP-" . rand(1000, 9999);

    try {
        Group::create([
            'group_id' => $group_id,
            'group_name' => $request->group_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Group added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }
}

public function manageGroup()
{
    $groups = Group::where('status', 'active')->get();

    return view('admin.manage-group', compact('groups'));

}
public function updateGroup(Request $request, $id)
{
    $request->validate([
        'group_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    try {
        $group = Group::findOrFail($id);
        $group->update([
            'group_name' => $request->group_name,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Group updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }
}
public function deleteGroup($id)
{
    try {
        $group = Group::findOrFail($id);

        // Debugging: Check if status updates
        $updated = $group->update(['status' => 'deleted']); 
        
        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Group deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    } catch (\Exception $e) {
        Log::error('Delete Group Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

}

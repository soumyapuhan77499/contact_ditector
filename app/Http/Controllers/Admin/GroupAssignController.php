<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\ContactDetails;
use App\Models\GroupAssign;


class GroupAssignController extends Controller
{
    public function assignGroup()
{
    $groups = Group::where('status', 'active')->get();
    $manageContact = ContactDetails::where('status', 'active')->where('group_status','nonassign')->get();

    return view('admin.assign-group', compact('manageContact', 'groups'));
}



public function saveAssignContacts(Request $request)
{
    try {
        $groupId = $request->group_id;
        $contactIds = $request->contact_ids;

        if (empty($groupId) || empty($contactIds)) {
            return response()->json(['error' => 'Please select a group and at least one contact!'], 400);
        }

        foreach ($contactIds as $contactId) {
            // Assign the contact to the group
            GroupAssign::updateOrCreate(
                ['group_id' => $groupId, 'contact_id' => $contactId]
            );

            // Update the contact_details table to set group_status = 'assigned'
            ContactDetails::where('contact_id', $contactId)->update(['group_status' => 'assigned']);
        }

        return response()->json(['success' => 'Contacts assigned successfully!'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Something went wrong! ' . $e->getMessage()], 500);
    }
}

public function manageAssignGroup()
{
    $groupedContacts = GroupAssign::with(['group', 'contactDetails'])
    ->get()
    ->groupBy('group_id');


    return view('admin.manage-assign-group', compact('groupedContacts'));
}


}
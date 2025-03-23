<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YatriDetails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class YatriController extends Controller
{
    public function getYatri()
    {
        return view('admin.yatri-details');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yatri_name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:20',
            'whatsapp_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_coming' => 'required|date',
            'date_of_going' => 'required|date|after_or_equal:date_of_coming',
            'description' => 'nullable|string',
            'pincode' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city_village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            YatriDetails::create($validator->validated());
    
            return redirect()->back()->with('success', 'Yatri details saved successfully.');
        } catch (\Exception $e) {
            Log::error('Yatri Save Error: ' . $e->getMessage());
            return redirect()->back()->with('db_error', $e->getMessage());
        }
    }

    public function list()
{
    $yatriDetails = YatriDetails::all();
    return view('admin.manage-yatri', compact('yatriDetails'));
}

}

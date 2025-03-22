<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YatriDetails;
use Illuminate\Support\Facades\Log;

class YatriController extends Controller
{
    public function getYatri()
    {
        return view('admin.yatri-details');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'yatri_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'coming_date' => 'required|date',
            'going_date' => 'required|date|after_or_equal:coming_date',
            'description' => 'nullable|string',
            'landmark' => 'nullable|string|max:255',
            'city_village' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        try {
            YatriDetails::create([
                'yatri_name' => $validated['yatri_name'],
                'mobile_no' => $validated['mobile'],
                'whatsapp_no' => $validated['whatsapp'] ?? null,
                'email' => $validated['email'] ?? null,
                'date_of_coming' => $validated['coming_date'],
                'date_of_going' => $validated['going_date'],
                'description' => $validated['description'] ?? null,
                'landmark' => $validated['landmark'] ?? null,
                'city_village' => $validated['city_village'] ?? null,
                'district' => $validated['district'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? null,
                'status' => 'pending', // default value if not in form
            ]);

            return redirect()->back()->with('success', 'Yatri details saved successfully.');
        } catch (\Exception $e) {
            Log::error('Yatri Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}

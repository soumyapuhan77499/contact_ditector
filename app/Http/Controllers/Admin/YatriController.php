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
            'mobile_no' => 'required|string|max:20',
            'whatsapp_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'date_of_coming' => 'required|date',
            'date_of_going' => 'required|date|after_or_equal:coming_date',
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
                'mobile_no' => $validated['mobile_no'],
                'whatsapp_no' => $validated['whatsapp_no'] ?? null,
                'email' => $validated['email'] ?? null,
                'date_of_coming' => $validated['date_of_coming'],
                'date_of_going' => $validated['date_of_going'],
                'description' => $validated['description'] ?? null,
                'landmark' => $validated['landmark'] ?? null,
                'city_village' => $validated['city_village'] ?? null,
                'district' => $validated['district'] ?? null,
                'state' => $validated['state'] ?? null,
                'country' => $validated['country'] ?? null,
            ]);

            return redirect()->back()->with('success', 'Yatri details saved successfully.');
        } catch (\Exception $e) {
            Log::error('Yatri Save Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}

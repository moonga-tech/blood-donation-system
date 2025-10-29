<?php

namespace App\Http\Controllers;

use App\Models\BloodDonation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BloodDonationController extends Controller
{
    public function index()
    {
        $donations = Auth::user()->bloodDonations()
            ->orderBy('donation_date', 'desc')
            ->paginate(10);
            
        return view('user.donations.index', compact('donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donation_date' => 'required|date|after_or_equal:today',
            'blood_group' => 'required|string',
            'units' => 'required|integer|min:1|max:5',
            'donation_center' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500'
        ]);

        BloodDonation::create([
            'user_id' => Auth::id(),
            'donation_date' => $request->donation_date,
            'blood_group' => $request->blood_group,
            'units' => $request->units,
            'donation_center' => $request->donation_center,
            'notes' => $request->notes
        ]);

        return redirect()->route('dashboard')->with('success', 'Blood donation request submitted successfully!');
    }

    public function destroy(BloodDonation $bloodDonation)
    {
        if ($bloodDonation->user_id !== Auth::id()) {
            abort(403);
        }

        $bloodDonation->delete();
        return redirect()->route('dashboard')->with('success', 'Donation request cancelled successfully!');
    }
}

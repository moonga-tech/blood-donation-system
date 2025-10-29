<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodDonation;
use Illuminate\Http\Request;

class BloodDonationController extends Controller
{
    public function index()
    {
        $donations = BloodDonation::with('user')
            ->orderBy('donation_date', 'asc')
            ->paginate(20);
            
        return view('admin.donations.index', compact('donations'));
    }

    public function updateStatus(Request $request, BloodDonation $donation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled'
        ]);

        $donation->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Donation status updated successfully!');
    }
}

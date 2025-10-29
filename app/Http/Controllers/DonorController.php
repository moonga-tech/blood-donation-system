<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->whereNotNull('blood_group');
        
        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }
        
        if ($request->filled('location')) {
            $query->where(function($q) use ($request) {
                $q->where('address', 'like', '%' . $request->location . '%')
                  ->orWhere('country', 'like', '%' . $request->location . '%');
            });
        }
        
        $donors = $query->withCount(['bloodDonations' => function($q) {
                         $q->where('status', 'completed');
                     }])
                     ->orderBy('created_at', 'desc')
                     ->paginate(12);
        
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        
        return view('pages.donors', compact('donors', 'bloodGroups'));
    }
}

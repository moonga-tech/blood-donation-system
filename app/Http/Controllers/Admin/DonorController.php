<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }
        
        $donors = $query->withCount('bloodDonations')
                       ->orderBy('created_at', 'desc')
                       ->paginate(20);
        
        return view('admin.donors.index', compact('donors'));
    }
}

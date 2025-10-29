<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    public function create()
    {
        $cities = [
            'Mumbai' => 'Mumbai, Maharashtra',
            'Delhi' => 'Delhi, Delhi',
            'Bangalore' => 'Bangalore, Karnataka',
            'Hyderabad' => 'Hyderabad, Telangana',
            'Chennai' => 'Chennai, Tamil Nadu',
            'Kolkata' => 'Kolkata, West Bengal',
            'Pune' => 'Pune, Maharashtra',
            'Ahmedabad' => 'Ahmedabad, Gujarat',
            'Jaipur' => 'Jaipur, Rajasthan',
            'Surat' => 'Surat, Gujarat',
        ];
        
        return view('blood-request.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_email' => 'nullable|email|max:255',
            'blood_group' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'units_needed' => 'required|integer|min:1|max:10',
            'needed_by' => 'required|date|after_or_equal:today',
            'city' => 'required|string',
            'hospital_name' => 'required|string|max:255',
            'hospital_address' => 'required|string|max:500',
            'medical_condition' => 'nullable|string|max:1000',
            'urgency' => 'required|in:low,medium,high,critical'
        ]);

        $requestData = $request->all();
        
        // Get coordinates for selected city
        $coordinates = $this->getIndianCityCoordinates($request->city);
        if ($coordinates) {
            $requestData['latitude'] = $coordinates['lat'];
            $requestData['longitude'] = $coordinates['lng'];
        }
        
        $bloodRequest = BloodRequest::create($requestData);

        return redirect()->route('blood-request.matches', $bloodRequest)
                        ->with('success', 'Blood request submitted successfully!');
    }

    public function findMatches(BloodRequest $bloodRequest)
    {
        // Compatible blood groups for receiving
        $compatibleGroups = [
            'A+' => ['A+', 'A-', 'O+', 'O-'],
            'A-' => ['A-', 'O-'],
            'B+' => ['B+', 'B-', 'O+', 'O-'],
            'B-' => ['B-', 'O-'],
            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
            'O+' => ['O+', 'O-'],
            'O-' => ['O-']
        ];

        $compatibleBloodGroups = $compatibleGroups[$bloodRequest->blood_group] ?? [];

        $donors = User::whereIn('blood_group', $compatibleBloodGroups)
                     ->whereNotNull('blood_group')
                     ->whereNotNull('latitude')
                     ->whereNotNull('longitude')
                     ->with(['bloodDonations' => function($query) {
                         $query->where('status', 'completed')
                               ->orderBy('donation_date', 'desc')
                               ->limit(1);
                     }])
                     ->get();

        // Calculate distance and sort by proximity if request has coordinates
        if ($bloodRequest->latitude && $bloodRequest->longitude) {
            $donors = $donors->map(function ($donor) use ($bloodRequest) {
                $donor->distance = $this->calculateDistance(
                    $bloodRequest->latitude,
                    $bloodRequest->longitude,
                    $donor->latitude,
                    $donor->longitude
                );
                return $donor;
            })->sortBy('distance');
        }

        return view('blood-request.matches', compact('bloodRequest', 'donors'));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return round($earthRadius * $c, 1);
    }

    private function getIndianCityCoordinates($address)
    {
        $cities = [
            'mumbai' => ['lat' => 19.0760, 'lng' => 72.8777],
            'delhi' => ['lat' => 28.7041, 'lng' => 77.1025],
            'bangalore' => ['lat' => 12.9716, 'lng' => 77.5946],
            'hyderabad' => ['lat' => 17.3850, 'lng' => 78.4867],
            'chennai' => ['lat' => 13.0827, 'lng' => 80.2707],
            'kolkata' => ['lat' => 22.5726, 'lng' => 88.3639],
            'pune' => ['lat' => 18.5204, 'lng' => 73.8567],
            'ahmedabad' => ['lat' => 23.0225, 'lng' => 72.5714],
            'jaipur' => ['lat' => 26.9124, 'lng' => 75.7873],
            'surat' => ['lat' => 21.1702, 'lng' => 72.8311],
        ];
        
        foreach ($cities as $city => $coords) {
            if (stripos($address, $city) !== false) {
                return $coords;
            }
        }
        
        return null;
    }
}

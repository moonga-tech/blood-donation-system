<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class IndianDonorsSeeder extends Seeder
{
    public function run(): void
    {
        $donors = [
            ['name' => 'Rajesh Kumar', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'lat' => 19.0760, 'lng' => 72.8777, 'blood_group' => 'O+'],
            ['name' => 'Priya Sharma', 'city' => 'Delhi', 'state' => 'Delhi', 'lat' => 28.7041, 'lng' => 77.1025, 'blood_group' => 'A+'],
            ['name' => 'Amit Singh', 'city' => 'Bangalore', 'state' => 'Karnataka', 'lat' => 12.9716, 'lng' => 77.5946, 'blood_group' => 'B+'],
            ['name' => 'Sunita Patel', 'city' => 'Ahmedabad', 'state' => 'Gujarat', 'lat' => 23.0225, 'lng' => 72.5714, 'blood_group' => 'AB+'],
            ['name' => 'Vikram Reddy', 'city' => 'Hyderabad', 'state' => 'Telangana', 'lat' => 17.3850, 'lng' => 78.4867, 'blood_group' => 'O-'],
            ['name' => 'Kavya Nair', 'city' => 'Chennai', 'state' => 'Tamil Nadu', 'lat' => 13.0827, 'lng' => 80.2707, 'blood_group' => 'A-'],
            ['name' => 'Rohit Gupta', 'city' => 'Pune', 'state' => 'Maharashtra', 'lat' => 18.5204, 'lng' => 73.8567, 'blood_group' => 'B-'],
            ['name' => 'Meera Joshi', 'city' => 'Jaipur', 'state' => 'Rajasthan', 'lat' => 26.9124, 'lng' => 75.7873, 'blood_group' => 'AB-'],
            ['name' => 'Arjun Yadav', 'city' => 'Kolkata', 'state' => 'West Bengal', 'lat' => 22.5726, 'lng' => 88.3639, 'blood_group' => 'O+'],
            ['name' => 'Deepika Iyer', 'city' => 'Kochi', 'state' => 'Kerala', 'lat' => 9.9312, 'lng' => 76.2673, 'blood_group' => 'A+'],
            ['name' => 'Sanjay Agarwal', 'city' => 'Indore', 'state' => 'Madhya Pradesh', 'lat' => 22.7196, 'lng' => 75.8577, 'blood_group' => 'B+'],
            ['name' => 'Anita Verma', 'city' => 'Lucknow', 'state' => 'Uttar Pradesh', 'lat' => 26.8467, 'lng' => 80.9462, 'blood_group' => 'AB+'],
            ['name' => 'Kiran Desai', 'city' => 'Surat', 'state' => 'Gujarat', 'lat' => 21.1702, 'lng' => 72.8311, 'blood_group' => 'O-'],
            ['name' => 'Ravi Malhotra', 'city' => 'Chandigarh', 'state' => 'Punjab', 'lat' => 30.7333, 'lng' => 76.7794, 'blood_group' => 'A-'],
            ['name' => 'Pooja Saxena', 'city' => 'Bhopal', 'state' => 'Madhya Pradesh', 'lat' => 23.2599, 'lng' => 77.4126, 'blood_group' => 'B-'],
        ];

        foreach ($donors as $index => $donor) {
            User::create([
                'name' => $donor['name'],
                'email' => strtolower(str_replace(' ', '.', $donor['name'])) . '@example.com',
                'phone' => '9' . str_pad($index + 1000000000, 9, '0', STR_PAD_LEFT),
                'address' => $donor['city'] . ', ' . $donor['state'],
                'blood_group' => $donor['blood_group'],
                'date_of_birth' => now()->subYears(rand(20, 50))->format('Y-m-d'),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'country' => 'India',
                'latitude' => $donor['lat'],
                'longitude' => $donor['lng'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}

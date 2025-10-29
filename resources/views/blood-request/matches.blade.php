<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Matches Found - Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Request Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">Blood Request Summary</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">Patient:</span>
                            <p class="font-semibold">{{ $bloodRequest->patient_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Blood Group Needed:</span>
                            <p class="font-semibold text-red-600">{{ $bloodRequest->blood_group }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Units Needed:</span>
                            <p class="font-semibold">{{ $bloodRequest->units_needed }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Urgency:</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($bloodRequest->urgency === 'critical') bg-red-100 text-red-800
                                @elseif($bloodRequest->urgency === 'high') bg-orange-100 text-orange-800
                                @elseif($bloodRequest->urgency === 'medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($bloodRequest->urgency) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Needed By:</span>
                            <p class="font-semibold">{{ $bloodRequest->needed_by->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Hospital:</span>
                            <p class="font-semibold">{{ $bloodRequest->hospital_name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compatible Donors -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        Compatible Donors Found ({{ $donors->count() }})
                    </h2>

                    @if($donors->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($donors as $donor)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow
                                    @if(isset($donor->distance))
                                        @if($donor->distance <= 10) border-green-300 bg-green-50
                                        @elseif($donor->distance <= 50) border-yellow-300 bg-yellow-50
                                        @elseif($donor->distance <= 100) border-orange-300 bg-orange-50
                                        @else border-red-300 bg-red-50
                                        @endif
                                    @endif">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-semibold text-gray-900">{{ $donor->name }}</h3>
                                        <div class="flex items-center space-x-2">
                                            @if(isset($donor->distance))
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                    @if($donor->distance <= 10) bg-green-100 text-green-800
                                                    @elseif($donor->distance <= 50) bg-yellow-100 text-yellow-800
                                                    @elseif($donor->distance <= 100) bg-orange-100 text-orange-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ $donor->distance }} km
                                                </span>
                                            @endif
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ $donor->blood_group }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <div>
                                            <span class="font-medium">Phone:</span> {{ $donor->phone }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Email:</span> {{ $donor->email }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Location:</span> {{ $donor->address ?: $donor->country }}
                                        </div>
                                        @if($donor->bloodDonations->count() > 0)
                                            <div>
                                                <span class="font-medium">Last Donation:</span> 
                                                {{ $donor->bloodDonations->first()->donation_date->format('M Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex space-x-2">
                                        <a href="tel:{{ $donor->phone }}" 
                                           class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-3 rounded text-sm font-medium">
                                            Call
                                        </a>
                                        <a href="mailto:{{ $donor->email }}" 
                                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm font-medium">
                                            Email
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <h3 class="font-semibold text-blue-900 mb-2">Next Steps:</h3>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Contact donors directly using the phone or email buttons above</li>
                                <li>• Explain the urgency and medical situation</li>
                                <li>• Coordinate with the hospital for donation scheduling</li>
                                <li>• Ensure proper medical screening before transfusion</li>
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Compatible Donors Found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                We couldn't find any registered donors with compatible blood groups at this time.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('blood-request.create') }}" 
                                   class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Submit Another Request
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
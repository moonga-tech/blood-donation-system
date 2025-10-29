<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Find Donors - Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-2">
                        <svg class="h-8 w-auto text-red-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" fill="currentColor"/>
                        </svg>
                        <span class="text-xl font-semibold text-gray-800">Blood Donation</span>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                        <a href="{{ route('blood-request.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Request Blood</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Find Blood Donors</h1>
                    <p class="mt-2 text-gray-600">Search for registered blood donors in your area</p>
                </div>

                <!-- Search Filters -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <form method="GET" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-64">
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" id="location" value="{{ request('location') }}"
                                   placeholder="Search by city, address, or country"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                            <select name="blood_group" id="blood_group"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">All Blood Groups</option>
                                @foreach($bloodGroups as $group)
                                    <option value="{{ $group }}" {{ request('blood_group') == $group ? 'selected' : '' }}>
                                        {{ $group }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium">
                            Search
                        </button>
                        <a href="{{ route('donors') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md font-medium">
                            Clear
                        </a>
                    </form>
                </div>

                <!-- Results Summary -->
                <div class="mb-6">
                    <p class="text-gray-600">
                        Found {{ $donors->total() }} donor{{ $donors->total() !== 1 ? 's' : '' }}
                        @if(request('blood_group'))
                            with blood group <strong>{{ request('blood_group') }}</strong>
                        @endif
                        @if(request('location'))
                            in <strong>{{ request('location') }}</strong>
                        @endif
                    </p>
                </div>

                <!-- Donors Grid -->
                @if($donors->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($donors as $donor)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $donor->name }}</h3>
                                    <span class="px-3 py-1 text-sm font-bold rounded-full bg-red-100 text-red-800">
                                        {{ $donor->blood_group }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $donor->address ?: $donor->country }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ ucfirst($donor->gender) }}
                                        @if($donor->date_of_birth)
                                            • {{ \Carbon\Carbon::parse($donor->date_of_birth)->age }} years
                                        @endif
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        {{ $donor->blood_donations_count }} donation{{ $donor->blood_donations_count !== 1 ? 's' : '' }}
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="tel:{{ $donor->phone }}" 
                                       class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-3 rounded text-sm font-medium">
                                        📞 Call
                                    </a>
                                    <a href="mailto:{{ $donor->email }}" 
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm font-medium">
                                        ✉️ Email
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($donors->hasPages())
                        <div class="flex justify-center">
                            {{ $donors->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No donors found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Try adjusting your search criteria or check back later.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('donors') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                View All Donors
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Call to Action -->
                <div class="mt-12 bg-red-50 rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-red-900 mb-2">Need Blood Urgently?</h3>
                    <p class="text-red-700 mb-4">Submit a blood request to find compatible donors quickly</p>
                    <a href="{{ route('blood-request.create') }}" 
                       class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg">
                        Request Blood Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
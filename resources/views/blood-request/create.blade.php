<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Blood - Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Request Blood</h1>
                        <p class="text-gray-600">Fill out this form to request blood for a patient</p>
                    </div>

                    <form method="POST" action="{{ route('blood-request.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="patient_name" class="block text-sm font-medium text-gray-700">Patient Name *</label>
                                <input type="text" name="patient_name" id="patient_name" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       value="{{ old('patient_name') }}">
                                @error('patient_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="patient_phone" class="block text-sm font-medium text-gray-700">Contact Phone *</label>
                                <input type="text" name="patient_phone" id="patient_phone" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       value="{{ old('patient_phone') }}">
                                @error('patient_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="patient_email" class="block text-sm font-medium text-gray-700">Email (Optional)</label>
                                <input type="email" name="patient_email" id="patient_email" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       value="{{ old('patient_email') }}">
                                @error('patient_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group Needed *</label>
                                <select name="blood_group" id="blood_group" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_group')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="units_needed" class="block text-sm font-medium text-gray-700">Units Needed *</label>
                                <input type="number" name="units_needed" id="units_needed" min="1" max="10" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       value="{{ old('units_needed', 1) }}">
                                @error('units_needed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="needed_by" class="block text-sm font-medium text-gray-700">Needed By *</label>
                                <input type="date" name="needed_by" id="needed_by" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       min="{{ date('Y-m-d') }}" value="{{ old('needed_by') }}">
                                @error('needed_by')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="urgency" class="block text-sm font-medium text-gray-700">Urgency Level *</label>
                                <select name="urgency" id="urgency" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('urgency', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('urgency') == 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                                @error('urgency')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City *</label>
                                <select name="city" id="city" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select City</option>
                                    @foreach($cities as $key => $city)
                                        <option value="{{ $key }}" {{ old('city') == $key ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hospital_name" class="block text-sm font-medium text-gray-700">Hospital Name *</label>
                                <input type="text" name="hospital_name" id="hospital_name" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                       value="{{ old('hospital_name') }}">
                                @error('hospital_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="hospital_address" class="block text-sm font-medium text-gray-700">Hospital Address *</label>
                            <textarea name="hospital_address" id="hospital_address" rows="3" required 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('hospital_address') }}</textarea>
                            @error('hospital_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="medical_condition" class="block text-sm font-medium text-gray-700">Medical Condition (Optional)</label>
                            <textarea name="medical_condition" id="medical_condition" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                      placeholder="Brief description of the medical condition requiring blood transfusion">{{ old('medical_condition') }}</textarea>
                            @error('medical_condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-gray-900">
                                ← Back to Home
                            </a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg">
                                Submit Request & Find Matches
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
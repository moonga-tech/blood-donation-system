<x-admin-dashboard>
    @section('title', 'Donors')

    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Donors</h2>
        <p class="text-gray-500">Manage registered blood donors</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded shadow p-4 mb-6">
        <form method="GET" class="flex gap-4 items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Search by name, email, or phone"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                <select name="blood_group" id="blood_group" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Blood Groups</option>
                    <option value="A+" {{ request('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ request('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ request('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ request('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ request('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ request('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ request('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ request('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Filter
            </button>
            <a href="{{ route('admin.donors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Clear
            </a>
        </form>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donor Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Group</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Age</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donors as $donor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $donor->name }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($donor->gender) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $donor->email }}</div>
                                <div class="text-sm text-gray-500">{{ $donor->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $donor->blood_group ?: '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($donor->date_of_birth)
                                    {{ \Carbon\Carbon::parse($donor->date_of_birth)->age }} years
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $donor->address ?: '—' }}</div>
                                <div class="text-sm text-gray-500">{{ $donor->country }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donor->blood_donations_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $donor->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No donors found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($donors->hasPages())
            <div class="px-6 py-3 border-t">
                {{ $donors->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-admin-dashboard>
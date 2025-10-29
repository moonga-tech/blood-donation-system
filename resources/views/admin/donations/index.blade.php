<x-admin-dashboard>
    @section('title', 'Blood Donations')

    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Blood Donations</h2>
        <p class="text-gray-500">Manage scheduled blood donations</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Blood Group</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Units</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Center</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donations as $donation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $donation->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $donation->user->email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->donation_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->blood_group }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->units }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $donation->donation_center ?: '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($donation->status === 'completed') bg-green-100 text-green-800
                                    @elseif($donation->status === 'approved') bg-blue-100 text-blue-800
                                    @elseif($donation->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form method="POST" action="{{ route('admin.donations.update-status', $donation) }}" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="text-sm border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $donation->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="completed" {{ $donation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $donation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No donations found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($donations->hasPages())
            <div class="px-6 py-3 border-t">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</x-admin-dashboard>
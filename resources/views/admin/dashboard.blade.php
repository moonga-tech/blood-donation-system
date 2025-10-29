<x-admin-dashboard>
    @section('title', 'Dashboard')

    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Dashboard</h2>
        <p class="text-gray-500">Overview of donors, donations and blood stock.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Total Donors</div>
            <div class="text-2xl font-bold text-blue-600">{{ $totalDonors }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Total Donations</div>
            <div class="text-2xl font-bold">{{ $totalDonations }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Pending Approvals</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $pendingDonations }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Completed Donations</div>
            <div class="text-2xl font-bold text-green-600">{{ $completedDonations }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-sm text-gray-500">Units Collected</div>
            <div class="text-2xl font-bold text-red-600">{{ $totalUnits }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="col-span-2 bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Recent Donations</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs text-gray-500 border-b">
                        <tr>
                            <th class="py-2">Donor</th>
                            <th class="py-2">Blood Type</th>
                            <th class="py-2">Units</th>
                            <th class="py-2">Date</th>
                            <th class="py-2">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse($recentDonations as $donation)
              <tr class="border-b">
                <td class="py-2">{{ $donation->donor->full_name ?? '—' }}</td>
                <td class="py-2">{{ $donation->donor->bloodType->name ?? '—' }}</td>
                <td class="py-2">{{ $donation->units }}</td>
                <td class="py-2">{{ $donation->donated_at->format('Y-m-d') }}</td>
                <td class="py-2">{{ $donation->location ?? '—' }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-4 text-center text-gray-500">No donations yet</td></tr>
            @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">Blood Stock by Type</h3>
            <canvas id="stockChart" width="300" height="300"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- <script>
            (function() {
                const ctx = document.getElementById('stockChart').getContext('2d');
                const labels = @json(array_values($allTypes)); // order-aligned names
                const dataMap = @json($stockByType);
                const data = labels.map(l => dataMap[l] ?? 0);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Units',
                            data,
                            // color choices left to Chart.js defaults
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            })();
        </script> --}}
    @endpush

</x-admin-dashboard>

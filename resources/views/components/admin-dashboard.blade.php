<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', '') - Online Blood Donation</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 text-gray-800 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 bg-white border-r p-4 transform transition-transform -translate-x-0 md:translate-x-0">
            <div class="mb-8">
                <h1 class="text-xl font-bold text-red-600">Online Blood Donation</h1>
                <p class="text-sm text-gray-500">Admin Panel</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 p-2 rounded-md hover:bg-red-50 {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 font-semibold' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.donors.index') }}"
                    class="flex items-center gap-3 p-2 rounded-md hover:bg-red-50 {{ request()->routeIs('admin.donors.*') ? 'bg-red-50 font-semibold' : '' }}">
                    Donors
                </a>
                <a href="{{ route('admin.donations.index') }}"
                    class="flex items-center gap-3 p-2 rounded-md hover:bg-red-50 {{ request()->routeIs('admin.donations.*') ? 'bg-red-50 font-semibold' : '' }}">
                    Donations
                </a>
                <a href="#" class="flex items-center gap-3 p-2 rounded-md hover:bg-red-50">Reports</a>
            </nav>

            <div class="mt-8 text-xs text-gray-500">
                v1.0 • Admin
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1">
            <!-- Topbar -->
            <header class="bg-white border-b p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button id="sidebar-toggle" class="md:hidden p-2 rounded bg-gray-100">
                        ☰
                    </button>
                    <form action="#" class="hidden md:flex items-center gap-2">
                        <input type="search" placeholder="Search donors, donations..."
                            class="px-3 py-2 border rounded w-80" />
                    </form>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-sm text-gray-600">Welcome, {{ Auth::user()->name ?? 'Admin' }}</div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="px-3 py-1 bg-red-600 text-white rounded">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

<x-guest-layout>
    <!-- Session Status -->

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-red-600">Online Blood Donation</h1>
        <p class="text-gray-500">Donor Register Form</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="name" name="name" id="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500"
                    placeholder="Full Name">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500"
                    placeholder="Email">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="phone" name="phone" id="phone" value="{{ old('phone') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500"
                    placeholder="Phone Number">
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="address" name="address" id="address" value="{{ old('address') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500"
                    placeholder="Physical Address">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                <select name="blood_group" id="blood_group" required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <option value="" disabled selected>Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>

            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Date of Birth">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <input type="text" name="country" id="country" value="{{ old('country') }}" required autofocus
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500"
                    placeholder="Country">
            </div>            
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Password">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password_confirmation" required autocomplete="new-password"
                    class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Confirm Password">
            </div>
        </div>

        <button type="submit"
            class="w-full py-2 px-4 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
            Register
        </button>

        <div>
            <p class="text-sm text-center text-gray-600">
                Have an account?
                <a href="{{ route('login') }}" class="text-gray-600 hover:underline"> Login</a>
            </p>
        </div>
    </form>

</x-guest-layout>

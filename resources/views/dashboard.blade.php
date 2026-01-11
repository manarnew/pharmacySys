<div>
    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Welcome to Optical Project Admin</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Patients -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    👥
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Patients</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    📅
                </div>
                <div>
                    <p class="text-sm text-gray-500">Today's Appointments</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    💰
                </div>
                <div>
                    <p class="text-sm text-gray-500">Monthly Revenue</p>
                    <p class="text-2xl font-bold">$0</p>
                </div>
            </div>
        </div>

        <!-- Inventory -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    📦
                </div>
                <div>
                    <p class="text-sm text-gray-500">Low Stock Items</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.patients.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                👥 Manage Patients
            </a>
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                📅 Add Appointment
            </button>
            <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
                📊 View Reports
            </button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded mr-3">
                        👤
                    </div>
                    <div>
                        <p class="font-medium">New patient registered</p>
                        <p class="text-sm text-gray-500">5 minutes ago</p>
                    </div>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    View
                </button>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 text-green-600 rounded mr-3">
                        📅
                    </div>
                    <div>
                        <p class="font-medium">Appointment scheduled</p>
                        <p class="text-sm text-gray-500">1 hour ago</p>
                    </div>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    View
                </button>
            </div>
        </div>
    </div>
</div>

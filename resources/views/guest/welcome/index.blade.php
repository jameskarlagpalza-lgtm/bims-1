@extends('guest.shell')

@section('guest-content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Building Information
                    <span class="text-blue-600">Management System</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Efficiently manage campus buildings, rooms, and facilities with our comprehensive BIMS platform.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 mb-16">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gopuram text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Building Management</h3>
                    <p class="text-gray-600">Comprehensive building information including certificates, specifications, and
                        documentation.</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dungeon text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Room Tracking</h3>
                    <p class="text-gray-600">Track and manage individual rooms, their capacity, and assigned purposes within
                        each building.</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-boxes text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Item Inventory</h3>
                    <p class="text-gray-600">Keep track of furniture, equipment, and other items across all campus buildings
                        and rooms.</p>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">System Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $totalBuildings ?? 0 }}</div>
                        <div class="text-gray-600">Buildings</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalRooms ?? 0 }}</div>
                        <div class="text-gray-600">Rooms</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">{{ $totalItems ?? 0 }}</div>
                        <div class="text-gray-600">Items</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-600 mb-2">{{ $totalCampuses ?? 0 }}</div>
                        <div class="text-gray-600">Campuses</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
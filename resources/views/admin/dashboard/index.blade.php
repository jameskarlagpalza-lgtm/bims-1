@extends('admin.shell')

@section('admin-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6 overflow-x-auto">
            <span class="text-gray-900 font-medium whitespace-nowrap">Dashboard</span>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Welcome, {{ $user->name ?? 'Admin' }}</h1>
            <p class="text-gray-600 mt-2">Overview of your institution's inventory management</p>
        </div>

        <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-14 h-14 bg-blue-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-700 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-blue-700 uppercase tracking-wider">Total Users</h3>
                            <p class="text-3xl font-bold text-blue-900 mt-1">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-14 h-14 bg-green-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map text-green-700 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-green-700 uppercase tracking-wider">Campuses</h3>
                            <p class="text-3xl font-bold text-green-900 mt-1">{{ $totalCampuses ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-14 h-14 bg-purple-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-gopuram text-purple-700 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-purple-700 uppercase tracking-wider">Buildings</h3>
                            <p class="text-3xl font-bold text-purple-900 mt-1">{{ $totalBuildings ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-14 h-14 bg-orange-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dungeon text-orange-700 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-orange-700 uppercase tracking-wider">Total Rooms</h3>
                            <p class="text-3xl font-bold text-orange-900 mt-1">{{ $totalRooms ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-zap text-yellow-500 mr-3"></i>
                    Quick Actions
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-users mr-2"></i>
                        View Users
                    </a>
                    <a href="{{ route('admin.buildings.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-medium rounded-lg hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-building mr-2"></i>
                        View Buildings
                    </a>
                </div>
            </div>

            <!-- Latest Buildings -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-clock text-blue-600 mr-3"></i>
                    Latest Buildings
                </h2>
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-300">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Campus</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Rooms</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($latestBuildings as $building)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $building->name }}</div>
                                        <div class="text-xs text-gray-600 mt-1">{{ Str::limit($building->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-university mr-1"></i>
                                            {{ $building->campus->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <i class="fas fa-door-open mr-1"></i>
                                            {{ $building->rooms_count ?? $building->rooms->count() ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.buildings.show', $building) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-md text-blue-600 hover:bg-blue-50 transition-colors duration-200 font-semibold">
                                            <i class="fas fa-eye mr-1"></i>
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                            <p class="font-medium">No buildings found</p>
                                            <p class="text-xs mt-1">Create your first building to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

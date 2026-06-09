@extends('campus.shell')

@section('campus-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('campus.dashboard') }}" class="hover:text-blue-600 transition-colors">
                <i class="fas fa-home mr-1"></i>Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('campus.buildings.index') }}" class="hover:text-blue-600 transition-colors">Buildings</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium">{{ $building->name }}</span>
        </nav>

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">{{ $building->name }}</h1>
                    <p class="text-gray-600">
                        <i class="fas fa-location-dot mr-2 text-red-500"></i>
                        {{ $building->address ?? 'No address available' }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span @class([
                        'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold',
                        'bg-green-100 text-green-800' => $building->status === 'active' || !isset($building->status),
                        'bg-yellow-100 text-yellow-800' => $building->status === 'pending',
                        'bg-orange-100 text-orange-800' => $building->status === 'under_maintenance',
                        'bg-red-100 text-red-800' => $building->status === 'closed',
                    ])>
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ ucfirst($building->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $building->number_of_floors ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-blue-800 mt-1">Floors</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $building->number_of_rooms ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-green-800 mt-1">Rooms</div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $building->number_of_CRs ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-purple-800 mt-1">Comfort Rooms</div>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-orange-600">{{ $building->items_count ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-orange-800 mt-1">Items</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            <!-- Main Content - Tabs -->
            <div class="lg:col-span-3">
                <!-- Tab Navigation -->
                <div class="bg-white rounded-lg shadow-lg border-b border-gray-200 mb-6">
                    <div class="flex border-b border-gray-200 overflow-x-auto">
                        <button onclick="switchTab('overview')" id="tab-overview"
                            class="tab-btn active px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-blue-600 text-blue-600 hover:text-blue-700 whitespace-nowrap">
                            <i class="fas fa-info-circle mr-2"></i>
                            Overview
                        </button>
                        <button onclick="switchTab('location')" id="tab-location"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Location
                        </button>
                        <button onclick="switchTab('documents')" id="tab-documents"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-file-alt mr-2"></i>
                            Documents
                        </button>
                        <button onclick="switchTab('certificates')" id="tab-certificates"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-scroll mr-2"></i>
                            Certificates
                        </button>
                    </div>
                </div>

                <!-- OVERVIEW TAB -->
                <div id="content-overview" class="tab-content space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <a href="{{ route('campus.buildings.rooms.index', $building) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-door-open text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">View Rooms</span>
                            </a>
                            <a href="{{ route('campus.buildings.items.index', $building) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-boxes text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">View Items</span>
                            </a>
                            <a href="{{ route('campus.buildings.edit', $building) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-edit text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">Edit</span>
                            </a>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Building Type</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $building->type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Floor Area</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $building->floor_area ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Department/Agency</label>
                                <p class="text-gray-900">{{ $building->department_agency ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">College/Office Assigned</label>
                                <p class="text-gray-900">{{ $building->college_office_assigned ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($building->description)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <p class="text-gray-900 leading-relaxed">{{ $building->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Infrastructure & Condition -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Infrastructure & Condition</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Physical Condition</label>
                                <p class="text-gray-900 text-lg font-medium">
                                    @if($building->physical_condition)
                                        <span @class([
                                            'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                            'bg-green-100 text-green-800' => $building->physical_condition === 'good',
                                            'bg-yellow-100 text-yellow-800' => $building->physical_condition === 'needs repair',
                                            'bg-orange-100 text-orange-800' => $building->physical_condition === 'needs rehabilitation',
                                            'bg-red-100 text-red-800' => $building->physical_condition === 'condemnable',
                                        ])>
                                            {{ ucfirst($building->physical_condition) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Classification</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $building->classification ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Improvements -->
                        @if($building->improvements && count($building->improvements) > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Improvements Undertaken</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($building->improvements as $improvement)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            {{ ucfirst($improvement) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Utilities -->
                        @if($building->existing_utilities && count($building->existing_utilities) > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Existing Utilities</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($building->existing_utilities as $utility)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            {{ ucfirst($utility) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- LOCATION TAB -->
                <div id="content-location" class="tab-content space-y-6 hidden">
                    <!-- Building Map -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Building Location</h2>
                        @if($building->latitude && $building->longitude)
                            <div class="w-full h-96 rounded-lg overflow-hidden border border-gray-200 mb-4">
                                <div id="buildingMap" class="w-full h-full"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Latitude</label>
                                    <p class="text-gray-900 font-mono">{{ $building->latitude }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Longitude</label>
                                    <p class="text-gray-900 font-mono">{{ $building->longitude }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Action</label>
                                    <a href="https://maps.google.com/?q={{ $building->latitude }},{{ $building->longitude }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Open in Maps
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-96 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-map-marker-alt text-4xl mb-3"></i>
                                    <p class="text-lg font-medium">No Location Data</p>
                                    <p class="text-sm">Coordinates not available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Location Details -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Location Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Street</label>
                                <p class="text-gray-900">{{ $building->location_street ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Barangay</label>
                                <p class="text-gray-900">{{ $building->location_brgy ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Municipality</label>
                                <p class="text-gray-900">{{ $building->location_municipality ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Province</label>
                                <p class="text-gray-900">{{ $building->location_province ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DOCUMENTS TAB -->
                <div id="content-documents" class="tab-content space-y-6 hidden">
                    <!-- Acquisition & Ownership -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Acquisition & Ownership</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Date of Acquisition</label>
                                <p class="text-gray-900 text-lg font-medium">
                                    {{ $building->acquisition_date ? $building->acquisition_date->format('F j, Y') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Mode of Acquisition</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $building->acquisition_mode ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Registered Name</label>
                                <p class="text-gray-900">{{ $building->registered_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Land Ownership Status</label>
                                <p class="text-gray-900">{{ $building->land_ownership_status ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Date Completed</label>
                                <p class="text-gray-900">{{ $building->completed_at ? $building->completed_at->format('F j, Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Estimated Fund</label>
                                <p class="text-lg font-medium text-green-600">
                                    ₱{{ number_format($building->estimated_fund ?? 0, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Document Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Prepared By</label>
                                <p class="text-gray-900 font-medium">{{ $building->prepared_by ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $building->preparer_position ?? '' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Certified By</label>
                                <p class="text-gray-900 font-medium">{{ $building->certified_by ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $building->certifier_position ?? '' }}</p>
                            </div>
                        </div>
                        @if($building->specific_use)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Specific Use of Building</label>
                                <p class="text-gray-900">{{ $building->specific_use }}</p>
                            </div>
                        @endif
                        @if($building->condition_description)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Condition Description</label>
                                <p class="text-gray-900">{{ $building->condition_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- CERTIFICATES TAB -->
                <div id="content-certificates" class="tab-content space-y-6 hidden">
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Building Certificates</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- CSU Certificate -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">CSU Certificate</h3>
                                        <p class="text-xs text-gray-500 mt-1">Civil State University</p>
                                    </div>
                                    @if ($building->CSU_cert)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Missing
                                        </span>
                                    @endif
                                </div>
                                @if ($building->CSU_cert)
                                    <a href="{{ asset('storage/' . $building->CSU_cert) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm font-medium w-full justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Certificate
                                    </a>
                                @else
                                    <div class="text-xs text-gray-500 text-center py-2">Not uploaded</div>
                                @endif
                            </div>

                            <!-- FIRE Certificate -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Fire Certificate</h3>
                                        <p class="text-xs text-gray-500 mt-1">Fire Safety Permit</p>
                                    </div>
                                    @if ($building->FIRE_cert)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Missing
                                        </span>
                                    @endif
                                </div>
                                @if ($building->FIRE_cert)
                                    <a href="{{ asset('storage/' . $building->FIRE_cert) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium w-full justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Certificate
                                    </a>
                                @else
                                    <div class="text-xs text-gray-500 text-center py-2">Not uploaded</div>
                                @endif
                            </div>

                            <!-- OCCUPANCY Certificate -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Occupancy Certificate</h3>
                                        <p class="text-xs text-gray-500 mt-1">Building Occupancy Permit</p>
                                    </div>
                                    @if ($building->OCCUPANCY_cert)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Missing
                                        </span>
                                    @endif
                                </div>
                                @if ($building->OCCUPANCY_cert)
                                    <a href="{{ asset('storage/' . $building->OCCUPANCY_cert) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm font-medium w-full justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Certificate
                                    </a>
                                @else
                                    <div class="text-xs text-gray-500 text-center py-2">Not uploaded</div>
                                @endif
                            </div>

                            <!-- LGU Certificate -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">LGU Certificate</h3>
                                        <p class="text-xs text-gray-500 mt-1">Local Government Unit</p>
                                    </div>
                                    @if ($building->LGU_cert)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Missing
                                        </span>
                                    @endif
                                </div>
                                @if ($building->LGU_cert)
                                    <a href="{{ asset('storage/' . $building->LGU_cert) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 text-sm font-medium w-full justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        View Certificate
                                    </a>
                                @else
                                    <div class="text-xs text-gray-500 text-center py-2">Not uploaded</div>
                                @endif
                            </div>
                        </div>

                        <!-- Certificate Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-3">Certificate Status Summary</h3>
                            <div class="flex flex-wrap gap-2">
                                <span @class([
                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $building->CSU_cert,
                                    'bg-gray-100 text-gray-800' => !$building->CSU_cert,
                                ])>
                                    <i class="fas mr-1" :class="$building->CSU_cert ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                    CSU
                                </span>
                                <span @class([
                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $building->FIRE_cert,
                                    'bg-gray-100 text-gray-800' => !$building->FIRE_cert,
                                ])>
                                    <i class="fas mr-1" :class="$building->FIRE_cert ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                    FIRE
                                </span>
                                <span @class([
                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $building->OCCUPANCY_cert,
                                    'bg-gray-100 text-gray-800' => !$building->OCCUPANCY_cert,
                                ])>
                                    <i class="fas mr-1" :class="$building->OCCUPANCY_cert ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                    OCCUPANCY
                                </span>
                                <span @class([
                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $building->LGU_cert,
                                    'bg-gray-100 text-gray-800' => !$building->LGU_cert,
                                ])>
                                    <i class="fas mr-1" :class="$building->LGU_cert ? 'fa-check-circle' : 'fa-times-circle'"></i>
                                    LGU
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('campus.buildings.edit', $building) }}"
                            class="w-full px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Building
                        </a>
                        <button onclick="deleteBuilding('{{ $building->id }}')"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Building
                        </button>
                        <a href="{{ route('campus.buildings.index') }}"
                            class="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Building Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Building Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Created:</span>
                            <span class="text-gray-900 text-right">{{ $building->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Updated:</span>
                            <span class="text-gray-900 text-right">{{ $building->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Campus:</span>
                            <span class="text-gray-900 text-right">{{ $building->campus->name ?? 'N/A' }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-gray-600">Building ID:</span>
                                <span class="text-gray-900 font-mono text-xs text-right break-words">{{ $building->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-lg p-4 sm:p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Statistics</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Rooms:</span>
                            <span class="text-lg font-bold text-blue-600">{{ $building->number_of_rooms ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items:</span>
                            <span class="text-lg font-bold text-green-600">{{ $building->items_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Floors:</span>
                            <span class="text-lg font-bold text-purple-600">{{ $building->number_of_floors ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Comfort Rooms:</span>
                            <span class="text-lg font-bold text-orange-600">{{ $building->number_of_CRs ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

    <script>
        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active', 'border-blue-600', 'text-blue-600');
                el.classList.add('border-transparent', 'text-gray-600');
            });

            // Show selected tab
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('tab-' + tabName).classList.add('active', 'border-blue-600', 'text-blue-600');
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-600');
        }

        // Delete building
        function deleteBuilding(buildingId) {
            const buildingName = '{{ $building->name }}';
            if (confirm(`Are you sure you want to delete "${buildingName}"? This will also delete all associated rooms, items, and certificate files. This action cannot be undone.`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('campus.buildings.destroy', ':id') }}`.replace(':id', buildingId);
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Initialize map
        document.addEventListener('DOMContentLoaded', function () {
            @if($building->latitude && $building->longitude)
                var map = L.map('buildingMap').setView([{{ $building->latitude }}, {{ $building->longitude }}], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

                // Building marker
                var buildingIcon = L.divIcon({
                    html: '<i class="fas fa-building" style="color: #2563eb; font-size: 20px;"></i>',
                    iconSize: [30, 30],
                    className: 'custom-marker'
                });

                L.marker([{{ $building->latitude }}, {{ $building->longitude }}], {icon: buildingIcon})
                    .addTo(map)
                    .bindPopup(`<div class="font-semibold">{{ $building->name }}</div><div class="text-sm text-gray-600">{{ $building->address }}</div>`)
                    .openPopup();
            @endif
        });
    </script>

    <style>
        .custom-marker {
            background: white;
            border: 2px solid #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .leaflet-popup-tip {
            background: white;
        }

        .tab-btn {
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background-color: rgba(59, 130, 246, 0.05);
        }
    </style>
@endsection

@extends('campus.shell')

@push('styles')
    <style>
        .leaflet-container {
            background: #f0f0f0 !important;
        }

        .building-marker {
            background: transparent;
            border: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@section('campus-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Welcome Back</h1>
            <p class="text-gray-600 mt-2">Manage and monitor all campus buildings and resources</p>
        </div>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-blue-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-gopuram text-blue-700 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-blue-700 uppercase tracking-wider">Buildings</h3>
                        <p class="text-3xl font-bold text-blue-900 mt-1">{{ $buildings->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-green-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dungeon text-green-700 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-green-700 uppercase tracking-wider">Total Rooms</h3>
                        <p class="text-3xl font-bold text-green-900 mt-1">{{ $totalRooms ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-300 rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-purple-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-purple-700 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-purple-700 uppercase tracking-wider">Total Items</h3>
                        <p class="text-3xl font-bold text-purple-900 mt-1">{{ $totalItems ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campus Overview Map -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-map text-blue-600 mr-3"></i>
                    Campus Overview
                </h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                    <i class="fas fa-building mr-1"></i>
                    {{ $buildings->count() }} Buildings
                </span>
            </div>
            <div class="rounded-lg overflow-hidden border border-gray-300">
                <div id="overview-map" class="h-96 w-full"></div>
            </div>
        </div>

        <!-- Buildings Grid -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-city text-blue-600 mr-3"></i>
                    Your Buildings
                </h2>
                <a href="{{ route('campus.buildings.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Add Building
                </a>
            </div>

            @if($buildings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($buildings as $building)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Building Map Card Image -->
                            <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200">
                                <div id="building-map-{{ $building->id }}" class="w-full h-full"></div>
                                <!-- Address Badge -->
                                <div class="absolute bottom-3 left-3 right-3 bg-white bg-opacity-95 backdrop-blur rounded-lg px-3 py-2 shadow-md">
                                    <p class="text-xs font-medium text-gray-600">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                        {{ $building->address ?? 'No address set' }}
                                    </p>
                                </div>
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Active
                                    </span>
                                </div>
                            </div>

                            <!-- Building Info -->
                            <div class="p-6">
                                <!-- Building Name -->
                                <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-2">{{ $building->name }}</h3>

                                @if($building->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $building->description }}</p>
                                @else
                                    <div class="mb-4 h-8"></div>
                                @endif

                                <!-- Building Stats -->
                                <div class="grid grid-cols-3 gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $building->rooms_count ?? 0 }}</div>
                                        <div class="text-xs text-gray-600 mt-1 font-medium">Rooms</div>
                                    </div>
                                    <div class="text-center border-l border-r border-gray-300">
                                        <div class="text-2xl font-bold text-green-600">{{ $building->items_count ?? 0 }}</div>
                                        <div class="text-xs text-gray-600 mt-1 font-medium">Items</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $building->number_of_floors ?? 1 }}</div>
                                        <div class="text-xs text-gray-600 mt-1 font-medium">Floors</div>
                                    </div>
                                </div>

                                <!-- Building Details -->
                                <div class="space-y-2 text-sm text-gray-600 mb-6">
                                    @if($building->floor_area)
                                        <div class="flex items-center">
                                            <i class="fas fa-ruler-combined w-4 text-gray-400 mr-3"></i>
                                            <span>{{ number_format((float)$building->floor_area, 2) }} sq.m Floor Area</span>
                                        </div>
                                    @endif
                                    @if($building->classification)
                                        <div class="flex items-center">
                                            <i class="fas fa-cube w-4 text-gray-400 mr-3"></i>
                                            <span>{{ ucfirst($building->classification) }} Structure</span>
                                        </div>
                                    @endif
                                    @if($building->physical_condition)
                                        <div class="flex items-center">
                                            <i class="fas fa-heartbeat w-4 text-gray-400 mr-3"></i>
                                            <span class="capitalize">{{ $building->physical_condition }} Condition</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3 pt-4 border-t border-gray-200">
                                    <a href="{{ route('campus.buildings.show', $building) }}"
                                        class="flex-1 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="{{ route('campus.buildings.edit', $building) }}"
                                        class="flex-1 inline-flex items-center justify-center bg-yellow-50 hover:bg-yellow-100 text-yellow-700 py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-200 border border-yellow-200">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-lg p-12 text-center border border-gray-200">
                    <div class="mb-6">
                        <i class="fas fa-building text-gray-300 text-7xl mb-4 block"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No buildings yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by creating your first building. You can add details like rooms, floors, and certification documents.</p>
                    <a href="{{ route('campus.buildings.create') }}"
                        class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md">
                        <i class="fas fa-plus mr-2"></i>Create First Building
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Buildings data from PHP
            var buildings = @json($buildings);

            // Initialize overview map
            var overviewMap = L.map('overview-map').setView([17.6364, 121.6783], 13);

            // Add base maps
            var streets = L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=bZpmItn2cuWjeIdpgbH5', {
                attribution: '&copy; <a href="https://www.maptiler.com/copyright/">MapTiler</a>',
                tileSize: 512,
                zoomOffset: -1,
                minZoom: 1
            });

            var satellite = L.tileLayer('https://api.maptiler.com/maps/satellite/{z}/{x}/{y}.jpg?key=bZpmItn2cuWjeIdpgbH5', {
                attribution: '&copy; <a href="https://www.maptiler.com/copyright/">MapTiler</a>',
                tileSize: 512,
                zoomOffset: -1,
                minZoom: 1
            });

            // Add streets as default base layer
            streets.addTo(overviewMap);

            // Setup layer control
            var baseMaps = {
                "Streets": streets,
                "Satellite": satellite
            };

            L.control.layers(baseMaps, null, { position: 'topright' }).addTo(overviewMap);

            // Create a group for all building markers
            var markersGroup = L.layerGroup().addTo(overviewMap);
            var bounds = L.latLngBounds();

            // Add markers to overview map and create individual building maps
            buildings.forEach(function (building, index) {
                if (building.latitude && building.longitude) {
                    var lat = parseFloat(building.latitude);
                    var lng = parseFloat(building.longitude);

                    // Add to overview map
                    var marker = L.marker([lat, lng]).addTo(markersGroup)
                        .bindPopup(
                            '<div class="text-center p-2">' +
                            '<b class="text-lg">' + building.name + '</b><br>' +
                            '<span class="text-gray-600">' + (building.address || 'No address') + '</span><br>' +
                            '<div class="mt-2 flex justify-center space-x-2">' +
                            '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">' + (building.rooms_count || 0) + ' rooms</span>' +
                            '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">' + (building.items_count || 0) + ' items</span>' +
                            '</div>' +
                            '<a href="/campus/buildings/' + building.id + '" class="inline-block mt-2 bg-blue-600 !text-white px-3 py-1 rounded text-xs hover:bg-blue-700">View Building</a>' +
                            '</div>'
                        );

                    bounds.extend([lat, lng]);

                    // Create individual building map
                    var buildingMapId = 'building-map-' + building.id;
                    if (document.getElementById(buildingMapId)) {
                        var buildingMap = L.map(buildingMapId, {
                            zoomControl: false,
                            scrollWheelZoom: false,
                            doubleClickZoom: false,
                            boxZoom: false,
                            keyboard: false,
                            dragging: false,
                            tap: false,
                            touchZoom: false
                        }).setView([lat, lng], 16);

                        // Add satellite tile layer to building map
                        L.tileLayer('https://api.maptiler.com/maps/satellite/{z}/{x}/{y}.jpg?key=bZpmItn2cuWjeIdpgbH5', {
                            attribution: '',
                            tileSize: 512,
                            zoomOffset: -1,
                            minZoom: 1
                        }).addTo(buildingMap);


                        // Add building marker with custom icon
                        var buildingIcon = L.divIcon({
                            className: 'building-marker',
                            html: '<div class="w-6 h-6 bg-red-500 border-2 border-white rounded-full shadow-lg flex items-center justify-center"><i class="fas fa-building text-white text-xs"></i></div>',
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        });

                        L.marker([lat, lng], { icon: buildingIcon }).addTo(buildingMap)
                            .bindPopup('<b>' + building.name + '</b>');

                        // Make the map clickable to view building details
                        buildingMap.on('click', function () {
                            window.location.href = '/campus/buildings/' + building.id;
                        });

                        // Add hover effect
                        document.getElementById(buildingMapId).style.cursor = 'pointer';
                    }
                }
            });

            // Fit overview map to show all buildings if there are any
            if (buildings.length > 0 && bounds.isValid()) {
                overviewMap.fitBounds(bounds, { padding: [20, 20] });
            }
        </script>
    @endpush
@endsection

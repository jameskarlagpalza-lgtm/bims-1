@extends('admin.shell')

@section('admin-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-1"></i>Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium whitespace-nowrap">Buildings</span>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">All Buildings</h1>
                    <p class="text-gray-600 mt-2">View and manage buildings across all campuses</p>
                </div>
                <div class="flex items-center px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                    <i class="fas fa-building text-blue-600 mr-2"></i>
                    <span class="text-sm font-medium text-blue-900">{{ $buildings->count() }} Total</span>
                </div>
            </div>
        </div>

        <!-- Buildings Grid -->
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
                                    <i class="fas fa-location-dot text-red-500 mr-1"></i>
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
                                <a href="{{ route('admin.buildings.show', $building) }}"
                                    class="flex-1 inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-building text-gray-300 text-7xl mb-4 block"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No buildings found</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Start by adding your first building to the system. You can add details like rooms, floors, and certification documents.</p>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Buildings data from PHP
            var buildings = @json($buildings);

            // Create individual building maps
            buildings.forEach(function (building, index) {
                if (building.latitude && building.longitude) {
                    var lat = parseFloat(building.latitude);
                    var lng = parseFloat(building.longitude);

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

                        // Add tile layer to building map
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors',
                            maxZoom: 19
                        }).addTo(buildingMap);

                        // Add building marker with custom icon
                        var buildingIcon = L.divIcon({
                            className: 'building-marker',
                            html: '<div class="w-8 h-8 bg-blue-600 border-2 border-white rounded-full shadow-lg flex items-center justify-center"><i class="fas fa-building text-white text-sm"></i></div>',
                            iconSize: [32, 32],
                            iconAnchor: [16, 16]
                        });

                        L.marker([lat, lng], { icon: buildingIcon }).addTo(buildingMap);

                        buildingMap.on('click', function () {
                            window.location.href = `/admin/buildings/${building.id}`;
                        });

                        // Add hover effect
                        document.getElementById(buildingMapId).style.cursor = 'pointer';
                    }
                } else {
                    // If no coordinates, show a placeholder map
                    var buildingMapId = 'building-map-' + building.id;
                    if (document.getElementById(buildingMapId)) {
                        var mapContainer = document.getElementById(buildingMapId);
                        mapContainer.innerHTML = '<div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center"><div class="text-center"><i class="fas fa-map-marker-alt text-gray-400 text-3xl mb-2"></i><p class="text-gray-500 text-sm font-medium">No location set</p></div></div>';
                        mapContainer.style.cursor = 'pointer';
                        mapContainer.onclick = function () {
                            window.location.href = `/admin/buildings/${building.id}`;
                        };
                    }
                }
            });

            // Custom CSS for building markers and styling
            var style = document.createElement('style');
            style.textContent = `
                .building-marker {
                    background: transparent;
                    border: none;
                }

                .leaflet-container {
                    background: #f3f4f6 !important;
                    border-radius: 0;
                }

                .line-clamp-2 {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }

                .leaflet-popup-content-wrapper {
                    border-radius: 8px;
                }

                .leaflet-popup-tip {
                    background: white;
                }
                `;
            document.head.appendChild(style);
        </script>
    @endpush
@endsection

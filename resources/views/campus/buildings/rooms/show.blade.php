@extends('campus.shell')

@section('campus-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6 overflow-x-auto">
            <a href="{{ route('campus.dashboard') }}" class="hover:text-blue-600 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-1"></i>Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('campus.buildings.index') }}" class="hover:text-blue-600 transition-colors whitespace-nowrap">Buildings</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('campus.buildings.show', $building) }}" class="hover:text-blue-600 transition-colors whitespace-nowrap truncate">
                {{ $building->name }}
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium whitespace-nowrap">{{ $room->name }}</span>
        </nav>

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">{{ $room->name }}</h1>
                    <p class="text-gray-600">
                        <i class="fas fa-building mr-2 text-blue-500"></i>
                        <a href="{{ route('campus.buildings.show', $building) }}" class="text-blue-600 hover:text-blue-800 underline">
                            {{ $building->name }}
                        </a>
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        Active
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $room->items->count() }}</div>
                <div class="text-xs sm:text-sm text-blue-800 mt-1">Total Items</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $room->items->count() }}</div>
                <div class="text-xs sm:text-sm text-green-800 mt-1">Room Items</div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $room->items->sum('quantity') ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-purple-800 mt-1">Total Units</div>
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
                        <button onclick="switchTab('items')" id="tab-items"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-boxes mr-2"></i>
                            Items
                        </button>
                        <button onclick="switchTab('statistics')" id="tab-statistics"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-chart-column mr-2"></i>
                            Statistics
                        </button>
                    </div>
                </div>

                <!-- OVERVIEW TAB -->
                <div id="content-overview" class="tab-content space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <a href="{{ route('campus.buildings.rooms.edit', [$building, $room]) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-edit text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">Edit Room</span>
                            </a>
                            <a href="{{ route('campus.buildings.items.create', ["building" => $building, "room" => $room]) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-plus-circle text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">Add Item</span>
                            </a>
                            <a href="{{ route('campus.buildings.show', $building) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-building text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">View Building</span>
                            </a>
                        </div>
                    </div>

                    <!-- Room Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Room Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Room Name</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $room->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Building</label>
                                <p class="text-gray-900">
                                    <a href="{{ route('campus.buildings.show', $building) }}" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        {{ $building->name }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        @if($room->description)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <p class="text-gray-900 leading-relaxed">{{ $room->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Metadata -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Metadata</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Created</label>
                                <p class="text-gray-900">{{ $room->created_at->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                                <p class="text-gray-900">{{ $room->updated_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ITEMS TAB -->
                <div id="content-items" class="tab-content space-y-6 hidden">
                    <!-- Add Item Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('campus.buildings.items.create', ["building" => $building, "room" => $room]) }}"
                            class="inline-flex items-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Add New Item
                        </a>
                    </div>

                    @if($room->items && $room->items->count() > 0)
                        <!-- Items Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($room->items as $item)
                                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 break-words">{{ $item->name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">Serial: {{ $item->serial_number ?? 'N/A' }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 bg-blue-100 text-blue-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Active
                                        </span>
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Quantity</label>
                                            <p class="text-gray-900 font-medium">{{ $item->quantity ?? 0 }} units</p>
                                        </div>
                                        @if($item->acquisition_cost)
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Acquisition Cost</label>
                                                <p class="font-medium text-green-600">₱{{ number_format($item->acquisition_cost, 2) }}</p>
                                            </div>
                                        @endif
                                        @if($item->description)
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500">Description</label>
                                                <p class="text-gray-900 text-sm line-clamp-2">{{ $item->description }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex gap-2 pt-4 border-t border-gray-200">
                                        <a href="{{ route('campus.buildings.items.show', [$building, $item]) }}"
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i>
                                            View
                                        </a>
                                        <a href="{{ route('campus.buildings.items.edit', [$building, $item]) }}"
                                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 text-sm font-medium">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-lg p-8 text-center border border-gray-200">
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Items Found</h3>
                            <p class="text-gray-500 mb-4">This room doesn't have any items yet.</p>
                            <a href="{{ route('campus.buildings.items.create', ["building" => $building, "room" => $room]) }}"
                                class="inline-flex items-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Item
                            </a>
                        </div>
                    @endif
                </div>

                <!-- <!-- STATISTICS TAB -->
                <div id="content-statistics" class="tab-content space-y-6 hidden">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 border border-blue-200">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-blue-600">Total Items</h3>
                                <i class="fas fa-boxes text-2xl text-blue-400"></i>
                            </div>
                            <p class="text-3xl font-bold text-blue-900">{{ $room->items->count() }}</p>
                            <p class="text-xs text-blue-700 mt-2">Items in this room</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-lg p-6 border border-purple-200">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-purple-600">Total Quantity</h3>
                                <i class="fas fa-cubes text-2xl text-purple-400"></i>
                            </div>
                            <p class="text-3xl font-bold text-purple-900">{{ $room->items->sum('quantity') ?? 0 }}</p>
                            <p class="text-xs text-purple-700 mt-2">Units total</p>
                        </div>
                    </div>

                    <!-- Item Breakdown -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Breakdown</h2>
                        @if($room->items->count() > 0)
                            <div class="space-y-3">
                                @php
                                    $totalCost = $room->items->sum('acquisition_cost');
                                    $totalQuantity = $room->items->sum('quantity');
                                @endphp
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                    <span class="text-gray-600">Total Acquisition Cost:</span>
                                    <span class="text-lg font-bold text-green-600">₱{{ number_format($totalCost, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                    <span class="text-gray-600">Total Quantity:</span>
                                    <span class="text-lg font-bold text-blue-600">{{ $totalQuantity }} units</span>
                                </div>
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                    <span class="text-gray-600">Average Cost per Item:</span>
                                    <span class="text-lg font-bold text-purple-600">
                                        ₱{{ number_format($room->items->count() > 0 ? $totalCost / $room->items->count() : 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No item data available</p>
                        @endif
                    </div>

                    <!-- Room Capacity -->
                    @if($room->items->count() > 0)
                        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Summary</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Average Cost per Item:</span>
                                    <span class="text-lg font-bold text-purple-600">
                                        ₱{{ number_format($room->items->count() > 0 ? $room->items->sum('acquisition_cost') / $room->items->count() : 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('campus.buildings.rooms.edit', [$building, $room]) }}"
                            class="w-full px-4 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Room
                        </a>
                        <button onclick="deleteRoom('{{ $room->id }}')"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Room
                        </button>
                        <a href="{{ route('campus.buildings.rooms.index', $building) }}"
                            class="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Rooms
                        </a>
                    </div>
                </div>

                <!-- Room Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Room Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Building:</span>
                            <span class="text-gray-900 text-right">{{ $building->name }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Created:</span>
                            <span class="text-gray-900 text-right">{{ $room->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="text-gray-900 text-right">{{ $room->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-gray-600">Room ID:</span>
                                <span class="text-gray-900 font-mono text-xs text-right break-words">{{ $room->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-lg p-4 sm:p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Statistics</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items:</span>
                            <span class="text-lg font-bold text-blue-600">{{ $room->items->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Quantity:</span>
                            <span class="text-lg font-bold text-green-600">{{ $room->items->sum('quantity') ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Cost:</span>
                            <span class="text-lg font-bold text-purple-600">₱{{ number_format($room->items->sum('acquisition_cost'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        // Delete room
        function deleteRoom(roomId) {
            const roomName = '{{ $room->name }}';
            if (confirm(`Are you sure you want to delete "${roomName}"? This will also delete all associated items. This action cannot be undone.`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('campus.buildings.rooms.destroy', [$building, ':id']) }}`.replace(':id', roomId);
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <style>
        .tab-btn {
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background-color: rgba(59, 130, 246, 0.05);
        }
    </style>
@endsection

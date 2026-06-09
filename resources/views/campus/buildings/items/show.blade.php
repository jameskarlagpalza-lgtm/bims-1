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
            <a href="{{ route('campus.buildings.items.index', $building) }}" class="hover:text-blue-600 transition-colors whitespace-nowrap">Items</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium whitespace-nowrap">{{ $item->name }}</span>
        </nav>

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">{{ $item->name }}</h1>
                    <p class="text-gray-600">
                        <i class="fas fa-box-archive mr-2 text-blue-500"></i>
                        <span class="font-mono text-sm">{{ $item->serial_number ?? 'No serial number' }}</span>
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ ucfirst($item->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Bar -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $item->quantity ?? 0 }}</div>
                <div class="text-xs sm:text-sm text-blue-800 mt-1">Quantity</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <div class="text-lg sm:text-xl font-bold text-green-600">₱{{ number_format($item->acquisition_cost ?? 0, 0) }}</div>
                <div class="text-xs sm:text-sm text-green-800 mt-1">Unit Cost</div>
            </div>
            @if($item->acquisition_cost && $item->quantity)
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <div class="text-lg sm:text-xl font-bold text-purple-600">₱{{ number_format($item->acquisition_cost * $item->quantity, 0) }}</div>
                    <div class="text-xs sm:text-sm text-purple-800 mt-1">Total Value</div>
                </div>
            @endif
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
                <div class="text-sm sm:text-base font-bold text-orange-600">{{ $item->acquired_at ? $item->acquired_at->diffForHumans() : 'N/A' }}</div>
                <div class="text-xs sm:text-sm text-orange-800 mt-1">Acquired</div>
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
                        <button onclick="switchTab('inventory')" id="tab-inventory"
                            class="tab-btn px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 whitespace-nowrap">
                            <i class="fas fa-warehouse mr-2"></i>
                            Inventory
                        </button>
                    </div>
                </div>

                <!-- OVERVIEW TAB -->
                <div id="content-overview" class="tab-content space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <a href="{{ route('campus.buildings.items.edit', [$building, $item]) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-edit text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">Edit Item</span>
                            </a>
                            @if($item->room)
                                <a href="{{ route('campus.buildings.rooms.show', [$building, $item->room]) }}"
                                    class="inline-flex flex-col items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 min-h-[80px]">
                                    <i class="fas fa-door-open text-2xl mb-2"></i>
                                    <span class="text-sm font-medium text-center">View Room</span>
                                </a>
                            @endif
                            <a href="{{ route('campus.buildings.show', $building) }}"
                                class="inline-flex flex-col items-center justify-center px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 min-h-[80px]">
                                <i class="fas fa-building text-2xl mb-2"></i>
                                <span class="text-sm font-medium text-center">View Building</span>
                            </a>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Item Name</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $item->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Quantity</label>
                                <p class="text-gray-900 text-lg font-medium">{{ $item->quantity ?? 0 }} units</p>
                            </div>
                            @if($item->serial_number)
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Serial Number</label>
                                    <p class="text-gray-900 font-mono">{{ $item->serial_number }}</p>
                                </div>
                            @endif
                            @if($item->acquisition_cost)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Unit Cost</label>
                                    <p class="font-medium text-green-600">₱{{ number_format($item->acquisition_cost, 2) }}</p>
                                </div>
                            @endif
                            @if($item->acquisition_cost && $item->quantity)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Total Value</label>
                                    <p class="font-bold text-green-700 text-lg">₱{{ number_format($item->acquisition_cost * $item->quantity, 2) }}</p>
                                </div>
                            @endif
                        </div>
                        @if($item->description)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <p class="text-gray-900 leading-relaxed">{{ $item->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- LOCATION TAB -->
                <div id="content-location" class="tab-content space-y-6 hidden">
                    <!-- Location Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Location Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Building</label>
                                <p class="text-gray-900">
                                    <a href="{{ route('campus.buildings.show', $building) }}" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                        {{ $building->name }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Room</label>
                                <p class="text-gray-900">
                                    @if($item->room)
                                        <a href="{{ route('campus.buildings.rooms.show', [$building, $item->room]) }}" class="text-blue-600 hover:text-blue-800 underline font-medium">
                                            {{ $item->room->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">Not assigned to a room</span>
                                    @endif
                                </p>
                            </div>
                            @if($item->location)
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Specific Location</label>
                                    <div class="flex items-start">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-3 mt-1 flex-shrink-0"></i>
                                        <p class="text-gray-900">{{ $item->location }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Related Items -->
                    @if($item->room && $item->room->items->where('id', '!=', $item->id)->count() > 0)
                        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Other Items in {{ $item->room->name }}</h2>
                            <div class="space-y-3">
                                @foreach($item->room->items->where('id', '!=', $item->id)->take(5) as $relatedItem)
                                    <a href="{{ route('campus.buildings.items.show', [$building, $relatedItem]) }}"
                                        class="block p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                                        <h3 class="font-medium text-gray-900">{{ $relatedItem->name }}</h3>
                                        <div class="flex items-center gap-4 text-xs text-gray-600 mt-1">
                                            <span><i class="fas fa-cubes mr-1"></i>Qty: {{ $relatedItem->quantity }}</span>
                                            @if($relatedItem->acquisition_cost)
                                                <span><i class="fas fa-money-bill mr-1"></i>₱{{ number_format($relatedItem->acquisition_cost, 2) }}</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach

                                @if($item->room->items->where('id', '!=', $item->id)->count() > 5)
                                    <div class="pt-3 border-t border-gray-200 text-center">
                                        <a href="{{ route('campus.buildings.rooms.show', [$building, $item->room]) }}"
                                            class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            View all {{ $item->room->items->count() - 1 }} items in this room
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- INVENTORY TAB -->
                <div id="content-inventory" class="tab-content space-y-6 hidden">
                    <!-- Inventory Information -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Inventory Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @if($item->acquired_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Date Acquired</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-plus text-green-500 mr-2"></i>
                                        <p class="text-gray-900">{{ $item->acquired_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($item->inventoried_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Date Inventoried</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-clipboard-check text-blue-500 mr-2"></i>
                                        <p class="text-gray-900">{{ $item->inventoried_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($item->accountable_officer)
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Accountable Officer</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                                        <p class="text-gray-900">{{ $item->accountable_officer }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Item Summary -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Item Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                <span class="text-gray-600">Status:</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ ucfirst($item->status ?? 'active') }}
                                </span>
                            </div>
                            @if($item->acquisition_cost && $item->quantity)
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                    <span class="text-gray-600">Total Value:</span>
                                    <span class="font-bold text-green-600">₱{{ number_format($item->acquisition_cost * $item->quantity, 2) }}</span>
                                </div>
                            @endif
                            @if($item->acquired_at)
                                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                                    <span class="text-gray-600">Age:</span>
                                    <span class="text-gray-900">{{ $item->acquired_at->diffForHumans() }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="text-gray-900">{{ $item->updated_at->diffForHumans() }}</span>
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
                        <a href="{{ route('campus.buildings.items.edit', [$building, $item]) }}"
                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Item
                        </a>
                        <button onclick="deleteItem('{{ $item->id }}')"
                            class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Item
                        </button>
                        <a href="{{ route('campus.buildings.items.index', $building) }}"
                            class="w-full px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 text-sm font-medium flex items-center justify-center min-h-[44px]">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Items
                        </a>
                    </div>
                </div>

                <!-- Item Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Status:</span>
                            <span class="text-gray-900 text-right">{{ ucfirst($item->status ?? 'active') }}</span>
                        </div>
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Quantity:</span>
                            <span class="text-gray-900 text-right">{{ $item->quantity ?? 0 }} units</span>
                        </div>
                        @if($item->acquisition_cost)
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-gray-600">Unit Cost:</span>
                                <span class="text-right font-medium text-green-600">₱{{ number_format($item->acquisition_cost, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-600">Building:</span>
                            <span class="text-gray-900 text-right">{{ $building->name }}</span>
                        </div>
                        @if($item->room)
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-gray-600">Room:</span>
                                <span class="text-gray-900 text-right">{{ $item->room->name }}</span>
                            </div>
                        @endif
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-start gap-2">
                                <span class="text-gray-600">Item ID:</span>
                                <span class="text-gray-900 font-mono text-xs text-right break-words">{{ $item->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-lg p-4 sm:p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Statistics</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Units:</span>
                            <span class="text-lg font-bold text-blue-600">{{ $item->quantity ?? 0 }}</span>
                        </div>
                        @if($item->acquisition_cost)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Unit Cost:</span>
                                <span class="text-lg font-bold text-green-600">₱{{ number_format($item->acquisition_cost, 0) }}</span>
                            </div>
                        @endif
                        @if($item->acquisition_cost && $item->quantity)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Value:</span>
                                <span class="text-lg font-bold text-purple-600">₱{{ number_format($item->acquisition_cost * $item->quantity, 0) }}</span>
                            </div>
                        @endif
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

        // Delete item
        function deleteItem(itemId) {
            const itemName = '{{ $item->name }}';
            if (confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ route('campus.buildings.items.destroy', [$building, ':id']) }}`.replace(':id', itemId);
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

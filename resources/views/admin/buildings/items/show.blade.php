@extends('admin.shell')

@section('admin-content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <span>/</span>
                <a href="{{ route('admin.buildings.show', $item->building) }}"
                    class="hover:text-blue-600">{{ $item->building->name ?? 'Building' }}</a>
                <span>/</span>
                <a href="{{ route('admin.buildings.items.index', $item->building) }}" class="hover:text-blue-600">Items</a>
                <span>/</span>
                <span class="text-gray-900">{{ $item->name }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">{{ $item->name }}</h1>
                    <p class="text-gray-600 mt-1">Item details and inventory information</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.buildings.items.edit', [$item->building, $item]) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        <i class="fas fa-edit mr-2"></i>Edit Item
                    </a>
                    <a href="{{ route('admin.buildings.items.index', $item->building) }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Items
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Item Name</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $item->name }}</p>
                            </div>

                            @if($item->serial_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Serial Number</label>
                                    <p class="text-gray-900 font-mono">{{ $item->serial_number }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Quantity</label>
                                <p class="text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item->quantity }} {{ $item->quantity > 1 ? 'units' : 'unit' }}
                                    </span>
                                </p>
                            </div>

                            @if($item->acquisition_cost)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Acquisition Cost</label>
                                    <p class="text-lg font-semibold text-green-600">
                                        ₱{{ number_format($item->acquisition_cost, 2) }}</p>
                                </div>
                            @endif
                        </div>

                        @if($item->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-900 leading-relaxed">{{ $item->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Location Information -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Location Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Building</label>
                                <p class="text-gray-900">{{ $item->building->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Room</label>
                                <p class="text-gray-900">
                                    @if($item->room)
                                        <a href="{{ route('admin.buildings.rooms.show', [$item->building, $item->room]) }}"
                                            class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $item->room->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Not assigned to a room</span>
                                    @endif
                                </p>
                            </div>

                            @if($item->location)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Specific Location</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <p class="text-gray-900">{{ $item->location }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Inventory Information -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Inventory Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Accountable Officer</label>
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                                        <p class="text-gray-900">{{ $item->accountable_officer }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.buildings.items.edit', [$item->building, $item]) }}"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>Edit Item
                        </a>

                        <a href="{{ route('admin.buildings.items.index', $item->building) }}"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i>View All Items
                        </a>

                        @if($item->room)
                            <a href="{{ route('admin.buildings.rooms.show', [$item->building, $item->room]) }}"
                                class="w-full border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center justify-center">
                                <i class="fas fa-door-open mr-2"></i>View Room
                            </a>
                        @endif

                        <a href="{{ route('admin.buildings.show', $item->building) }}"
                            class="w-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center justify-center">
                            <i class="fas fa-building mr-2"></i>View Building
                        </a>
                    </div>
                </div>

                <!-- Item Summary -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Item Summary</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Status</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>

                        @if($item->acquisition_cost && $item->quantity)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Total Value</span>
                                <span class="text-sm font-semibold text-green-600">
                                    ₱{{ number_format($item->acquisition_cost * $item->quantity, 2) }}
                                </span>
                            </div>
                        @endif

                        @if($item->acquired_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Age</span>
                                <span class="text-sm text-gray-900">
                                    {{ $item->acquired_at->diffForHumans() }}
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Last Updated</span>
                            <span class="text-sm text-gray-900">
                                {{ $item->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Related Items -->
                @if($item->room && $item->room->items->where('id', '!=', $item->id)->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Other Items in {{ $item->room->name }}</h3>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($item->room->items->where('id', '!=', $item->id)->take(5) as $relatedItem)
                                <div class="p-4 hover:bg-gray-50">
                                    <a href="{{ route('admin.buildings.items.show', [$item->building, $relatedItem]) }}"
                                        class="block">
                                        <h4 class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $relatedItem->name }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Qty: {{ $relatedItem->quantity }}
                                            @if($relatedItem->acquisition_cost)
                                                • ₱{{ number_format($relatedItem->acquisition_cost, 2) }}
                                            @endif
                                        </p>
                                    </a>
                                </div>
                            @endforeach

                            @if($item->room->items->where('id', '!=', $item->id)->count() > 5)
                                <div class="p-4 text-center">
                                    <a href="{{ route('admin.buildings.rooms.show', [$item->building, $item->room]) }}"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                        View all {{ $item->room->items->count() - 1 }} items in this room
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
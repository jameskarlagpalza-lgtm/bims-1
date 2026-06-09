@extends('admin.shell')

@section('admin-content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors whitespace-nowrap">
                <i class="fas fa-home mr-1"></i>Dashboard
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-medium whitespace-nowrap">Users</span>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Manage Users</h1>
                    <p class="text-gray-600 mt-2">Assign users to campuses and manage their roles</p>
                </div>
                <div class="flex items-center px-4 py-2 bg-blue-50 border border-blue-200 rounded-lg">
                    <i class="fas fa-users text-blue-600 mr-2"></i>
                    <span class="text-sm font-medium text-blue-900">{{ $users->count() }} Total</span>
                </div>
            </div>
        </div>

        <!-- Save All Button Section -->
        @if($users->count() > 0)
            <div class="mb-6 flex justify-end">
                <button type="button" id="saveAllBtn" class="inline-flex items-center px-8 py-3 border border-transparent text-sm leading-4 font-bold rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save All Assignments
                </button>
            </div>
        @endif

        <form id="assignmentsForm" action="{{ route('admin.users.saveAllAssignments') }}" method="POST">
            @csrf
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Current Campus</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Assign Campus</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-blue-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                                <span class="text-sm font-bold text-white uppercase">{{ substr($user->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->campus)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-location-dot mr-1"></i>
                                            {{ $user->campus->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                            <i class="fas fa-ban mr-1"></i>
                                            Not Assigned
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->roles as $role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="assignments[{{ $user->id }}]" class="block w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm font-medium">
                                        <option value="">-- Select Campus --</option>
                                        @foreach ($campuses as $campus)
                                            <option value="{{ $campus->id }}" {{ $user->campus_id == $campus->id ? 'selected' : '' }}>
                                                {{ $campus->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        @if($users->count() === 0)
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                                        <p class="font-medium">No users found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Save All Button Section (Bottom) -->
        @if($users->count() > 0)
            <div class="mt-6 flex justify-end">
                <button type="button" id="saveAllBtnBottom" class="inline-flex items-center px-8 py-3 border border-transparent text-sm leading-4 font-bold rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save All Assignments
                </button>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveAllBtn = document.getElementById('saveAllBtn');
            const saveAllBtnBottom = document.getElementById('saveAllBtnBottom');
            const assignmentsForm = document.getElementById('assignmentsForm');

            function submitForm() {
                assignmentsForm.submit();
            }

            if (saveAllBtn) {
                saveAllBtn.addEventListener('click', submitForm);
            }

            if (saveAllBtnBottom) {
                saveAllBtnBottom.addEventListener('click', submitForm);
            }
        });
    </script>
    @endpush
@endsection

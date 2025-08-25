@extends('layouts.superadmin')

@section('header', 'SuperAdmin Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Admin Users Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bookty-purple-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-bookty-purple-100 mr-4">
                    <svg class="w-8 h-8 text-bookty-purple-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Admin Users</p>
                    <p class="text-3xl font-semibold text-gray-700">{{ $totalAdmins }}</p>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bookty-pink-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-bookty-pink-100 mr-4">
                    <svg class="w-8 h-8 text-bookty-pink-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Customers</p>
                    <p class="text-3xl font-semibold text-gray-700">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>

        <!-- Books Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bookty-purple-400">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-bookty-purple-100 mr-4">
                    <svg class="w-8 h-8 text-bookty-purple-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Books</p>
                    <p class="text-3xl font-semibold text-gray-700">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <svg class="w-8 h-8 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <p class="text-3xl font-semibold text-gray-700">RM {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Order Statistics -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-serif font-semibold mb-4 text-bookty-black">Order Statistics</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <span class="text-blue-600 text-lg font-bold">{{ $orderStats['pending'] }}</span>
                    <p class="text-gray-600 text-sm mt-1">Pending</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg text-center">
                    <span class="text-yellow-600 text-lg font-bold">{{ $orderStats['processing'] }}</span>
                    <p class="text-gray-600 text-sm mt-1">Processing</p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg text-center">
                    <span class="text-indigo-600 text-lg font-bold">{{ $orderStats['shipped'] }}</span>
                    <p class="text-gray-600 text-sm mt-1">Shipped</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <span class="text-green-600 text-lg font-bold">{{ $orderStats['completed'] }}</span>
                    <p class="text-gray-600 text-sm mt-1">Completed</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg text-center">
                    <span class="text-red-600 text-lg font-bold">{{ $orderStats['cancelled'] }}</span>
                    <p class="text-gray-600 text-sm mt-1">Cancelled</p>
                </div>
            </div>
        </div>

        <!-- User Registration Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-serif font-semibold mb-4 text-bookty-black">User Registrations ({{ date('Y') }})</h2>
            <div class="h-64">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-serif font-semibold text-bookty-black">Recent Users</h2>
            <a href="#" class="text-sm text-bookty-purple-600 hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-bookty-cream">
                        <th class="px-4 py-2 text-left text-sm font-medium text-bookty-black">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-bookty-black">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-bookty-black">Role</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-bookty-black">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentUsers as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($role->name == 'superadmin') bg-bookty-purple-100 text-bookty-purple-800
                                    @elseif($role->name == 'admin') bg-blue-100 text-blue-800
                                    @else bg-bookty-pink-100 text-bookty-pink-800 @endif">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('userRegistrationChart').getContext('2d');
            
            // Prepare data for chart
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const registrationData = Array(12).fill(0);
            
            @foreach($userRegistrations as $data)
                registrationData[{{ $data->month - 1 }}] = {{ $data->count }};
            @endforeach
            
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'New Users',
                        data: registrationData,
                        backgroundColor: '#9061F9',
                        borderColor: '#6D28D9',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection

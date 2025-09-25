@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    <!-- Quick Actions Section -->
    {{-- <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.books.create') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-4 hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="font-medium">Add Book</span>
                </div>
            </a>
            
            <a href="{{ route('admin.coupons.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="font-medium">Create Coupon</span>
                </div>
            </a>
            
            <a href="{{ route('admin.flash-sales.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg p-4 hover:from-orange-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="font-medium">Flash Sale</span>
                </div>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg p-4 hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:scale-105 shadow-md">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Pending Orders</span>
                </div>
            </a>
        </div>
    </div> --}}

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                    </svg>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-white">{{ $totalBooks ?? 0 }}</h4>
                    <div class="text-gray-500 dark:text-gray-200">Total Books</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                    </svg>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-white">{{ $totalOrders ?? 0 }}</h4>
                    <div class="text-gray-500 dark:text-gray-200">Total Orders</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-white">{{ $totalCustomers ?? 0 }}</h4>
                    <div class="text-gray-500 dark:text-gray-200">Total Customers</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-white">RM {{ $totalRevenue ?? '0.00' }}</h4>
                    <div class="text-gray-500 dark:text-gray-200">Total Revenue</div>
                </div>
            </div>
        </div>

        <!-- New Pending Orders Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-yellow-400">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-white">{{ $pendingOrdersCount ?? 0 }}</h4>
                    <div class="text-gray-500 dark:text-gray-200">Pending Orders</div>
                    @if($pendingOrdersCount > 0)
                        <div class="text-xs text-yellow-600 dark:text-yellow-300 font-medium mt-1">Needs Attention</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @if(isset($recentOrders) && count($recentOrders) > 0)
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">RM {{ $order->total_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($order->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($order->status === 'shipped')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Shipped</span>
                                        @elseif($order->status === 'completed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No recent orders found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">View all orders →</a>
            </div>
        </div>

        <!-- Best Selling Books (Flowbite-styled card + ApexCharts) -->
        <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 md:p-6">
            <div class="flex justify-between border-gray-200 border-b pb-3">
                <dl>
                    <dt class="text-base font-normal text-gray-500 pb-1">Top Selling Books</dt>
                    <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-gray-200">
                        <span id="topBooksTotalSold">0</span> sold
                    </dd>
                </dl>
                <div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md">
                        <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                        </svg>
                        This month
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 py-3">
                <dl>
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-200 pb-1">Top Title</dt>
                    <dd class="leading-none text-sm md:text-base font-semibold text-purple-600 truncate" id="topBooksTopTitle">—</dd>
                </dl>
                <dl class="text-right">
                    <dt class="text-base font-normal text-gray-500 dark:text-gray-200 pb-1">Total Titles</dt>
                    <dd class="leading-none text-xl font-bold text-gray-900 dark:text-gray-200" id="topBooksCount">0</dd>
                </dl>
            </div>

            <div  id="bar-chart"></div>
            <div class="grid grid-cols-1 items-center border-gray-200 border-t justify-between">
              <div class="flex justify-between items-center pt-5">
                <button
                  id="dropdownDefaultButton"
                  data-dropdown-toggle="lastDaysdropdown"
                  data-dropdown-placement="bottom"
                  class="text-sm font-medium text-gray-500 hover:text-gray-900 text-center inline-flex items-center"
                  type="button">
                  Last 6 months
                  <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
                </button>
                <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                      <li><a href="#" data-period="yesterday" class="block px-4 py-2 hover:bg-gray-100">Yesterday</a></li>
                      <li><a href="#" data-period="today" class="block px-4 py-2 hover:bg-gray-100">Today</a></li>
                      <li><a href="#" data-period="last_7_days" class="block px-4 py-2 hover:bg-gray-100">Last 7 days</a></li>
                      <li><a href="#" data-period="last_30_days" class="block px-4 py-2 hover:bg-gray-100">Last 30 days</a></li>
                      <li><a href="#" data-period="last_90_days" class="block px-4 py-2 hover:bg-gray-100">Last 90 days</a></li>
                      <li><a href="#" data-period="last_6_months" class="block px-4 py-2 hover:bg-gray-100">Last 6 months</a></li>
                      <li><a href="#" data-period="last_year" class="block px-4 py-2 hover:bg-gray-100">Last year</a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.reports.sales') }}" class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-purple-600 hover:text-purple-700 px-3 py-2">
                  Sales Report
                  <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                  </svg>
                </a>
              </div>
            </div>
        </div>

        <!-- Sales This week -->
        <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
            <div class="flex justify-between">
                <div>
                    <h5 id="salesWeekTotal" class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">RM 0.00</h5>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Sales this Week</p>
                </div>
                <div id="salesWeekChangeWrap" class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
                    <span id="salesWeekChange">0%</span>
                    <svg id="salesWeekChangeIcon" class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                    </svg>
                </div>
            </div>
            <div id="data-series-chart" class="mt-2"></div>
            <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-5">
                <div class="flex justify-between items-center pt-5">
                  <button
                    id="salesWeekButton"
                    data-dropdown-toggle="salesWeekDropdown"
                    data-dropdown-placement="bottom"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                    type="button">
                    This week
                    <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </button>
                  <div id="salesWeekDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                      <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="salesWeekButton">
                        <li><a href="#" data-period="this_week" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">This week</a></li>
                        <li><a href="#" data-period="yesterday" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a></li>
                        <li><a href="#" data-period="today" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a></li>
                        <li><a href="#" data-period="last_7_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a></li>
                        <li><a href="#" data-period="last_30_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a></li>
                        <li><a href="#" data-period="last_90_days" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a></li>
                      </ul>
                  </div>
                  <a href="{{ route('admin.reports.sales') }}" class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2">
                    Sales Report
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                  </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Books Section -->
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Low Stock Books</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @if(isset($lowStockBooks) && count($lowStockBooks) > 0)
                            @foreach($lowStockBooks as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($book->cover_image)
                                                <div class="flex-shrink-0 h-10 w-10 ">
                                                    <img class="h-10 w-10 object-cover rounded " src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                                </div>
                                            @else
                                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-200">{{ $book->author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $book->stock }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.books.edit', $book) }}" class="text-purple-600 hover:text-purple-900">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No low stock books found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">View all books →</a>
            </div>
        </div>
    </div>
    
    <!-- ApexCharts: Top Selling Books Bar Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categories = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('title') : []);
            var dataSeries = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('total_sold') : []);
            var unitPrices = @json(isset($bestSellingBooks) ? $bestSellingBooks->pluck('price') : []);
            
            var chart = null;
            var chartEl = document.getElementById('bar-chart');

            function renderChart() {
                if (!chartEl || typeof ApexCharts === 'undefined' || categories.length === 0) {
                    if (chartEl) chartEl.innerHTML = '<div class="text-center py-8 text-sm text-gray-500">No sales data available for this period.</div>';
                    return;
                }
                var options = {
                  series: [
                    {
                      name: 'Sold',
                      data: dataSeries.map((value, index) => ({
                        x: categories[index],
                        y: value,
                        fillColor: [
                          '#7c3aed', '#ec4899', '#06b6d4', '#10b981', '#f59e0b', 
                          '#ef4444', '#8b5cf6', '#f472b6', '#22c55e', '#3b82f6',
                          '#84cc16', '#f97316', '#6366f1', '#14b8a6', '#e11d48'
                        ][index % 15]
                      }))
                    }
                  ],
                  chart: {
                    sparkline: { enabled: false },
                    type: 'bar',
                    width: '100%',
                    height: 400,
                    toolbar: { show: false }
                  },
                  plotOptions: {
                    bar: {
                      horizontal: true,
                      columnWidth: '100%',
                      borderRadiusApplication: 'end',
                      borderRadius: 6,
                      dataLabels: { position: 'top' }
                    }
                  },
                  legend: { show: false },
                  dataLabels: { enabled: false },
                  tooltip: {
                    shared: false,
                    intersect: true,
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                      var qty = series[seriesIndex][dataPointIndex] || 0;
                      var price = parseFloat((unitPrices && unitPrices[dataPointIndex]) ? unitPrices[dataPointIndex] : 0) || 0;
                      var total = (qty * price).toFixed(2);
                      var title = w.globals.labels[dataPointIndex] || '';
                      var isDark = document.documentElement.classList.contains('dark');
                      var bgColor = isDark ? 'bg-gray-800' : 'bg-white';
                      var textColor = isDark ? 'text-gray-100' : 'text-gray-900';
                      var subTextColor = isDark ? 'text-gray-300' : 'text-gray-600';
                      var borderColor = isDark ? 'border-gray-700' : 'border-gray-200';
                      return '<div class="px-3 py-2 text-sm ' + bgColor + ' ' + borderColor + ' border rounded-lg shadow-lg">'
                        + '<div class="font-semibold ' + textColor + '">' + title + '</div>'
                        + '<div class="mt-1 ' + subTextColor + '">Quantity: <span class="font-medium">' + qty + '</span></div>'
                        + '<div class="' + subTextColor + '">Total Sales: <span class="font-medium">RM ' + total + '</span></div>'
                        + '</div>';
                    }
                  },
                  xaxis: {
                    labels: {
                      show: true,
                      style: { fontFamily: 'Inter, sans-serif', cssClass: 'text-xs font-normal fill-gray-500' }
                    },
                    categories: categories,
                    axisTicks: { show: false },
                    axisBorder: { show: false }
                  },
                  yaxis: {
                    labels: {
                      show: true,
                      style: { fontFamily: 'Inter, sans-serif', cssClass: 'text-xs font-normal fill-gray-500' }
                    }
                  },
                  grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: { left: 2, right: 2, top: -20 }
                  },
                  fill: { opacity: 1 }
                };
                if (chart) { chart.destroy(); }
                chart = new ApexCharts(chartEl, options);
                chart.render();
            }

            function updateHeader() {
                var totalSold = 0;
                for (var i = 0; i < dataSeries.length; i++) { totalSold += (parseInt(dataSeries[i], 10) || 0); }
                var totalSoldEl = document.getElementById('topBooksTotalSold');
                if (totalSoldEl) totalSoldEl.textContent = totalSold;
                var countEl = document.getElementById('topBooksCount');
                if (countEl) countEl.textContent = categories.length;
                var topTitleEl = document.getElementById('topBooksTopTitle');
                if (topTitleEl && categories.length > 0) {
                    var maxIdx = 0;
                    for (var j = 1; j < dataSeries.length; j++) {
                        if ((dataSeries[j] || 0) > (dataSeries[maxIdx] || 0)) maxIdx = j;
                    }
                    topTitleEl.textContent = categories[maxIdx] + ' (' + dataSeries[maxIdx] + ')';
                }
            }

            // Initial render
            updateHeader();
            renderChart();

            // Dropdown filtering
            var dropdown = document.getElementById('lastDaysdropdown');
            if (dropdown) {
                dropdown.addEventListener('click', function(e) {
                    var target = e.target.closest('a[data-period]');
                    if (!target) return;
                    e.preventDefault();
                    var period = target.getAttribute('data-period');
                    fetch("{{ route('admin.top-selling') }}?period=" + encodeURIComponent(period), {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(function(res){ return res.json(); })
                    .then(function(json){
                        categories = json.titles || [];
                        dataSeries = (json.quantities || []).map(function(v){ return parseInt(v, 10) || 0; });
                        unitPrices = (json.prices || []).map(function(v){ return parseFloat(v) || 0; });
                        updateHeader();
                        renderChart();
                    })
                    .catch(function(){
                        if (chartEl) chartEl.innerHTML = '<div class="text-center py-8 text-sm text-gray-500">Failed to load data.</div>';
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var salesChart = null;
            var el = document.getElementById('data-series-chart');

            function formatRM(n){ n = parseFloat(n||0); return 'RM ' + n.toFixed(2); }

            function renderSalesChart(labels, revenue, orders){
                if (!el || typeof ApexCharts === 'undefined') return;
                if (salesChart) { salesChart.destroy(); }
                var options = {
                    series: [ { name: 'Revenue', data: revenue, color: '#7c3aed' } ],
                    chart: { height: 220, type: 'area', fontFamily: 'Inter, sans-serif', toolbar: { show:false }, dropShadow: { enabled:false } },
                    tooltip: {
                        enabled: true,
                        custom: function({series, seriesIndex, dataPointIndex, w}){
                            var isDark = document.documentElement.classList.contains('dark');
                            var bg = isDark ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200';
                            var text = isDark ? 'text-gray-100' : 'text-gray-900';
                            var sub = isDark ? 'text-gray-300' : 'text-gray-600';
                            var date = labels[dataPointIndex] || '';
                            var rev = series[seriesIndex][dataPointIndex] || 0;
                            var ord = Array.isArray(orders) ? (orders[dataPointIndex]||0) : 0;
                            var aov = ord>0 ? (parseFloat(rev)/ord) : 0;
                            return '<div class="px-3 py-2 border rounded-lg shadow-lg ' + bg + '">'
                                + '<div class="font-semibold ' + text + '">' + date + '</div>'
                                + '<div class="' + sub + '">Revenue: <span class="font-medium">' + formatRM(rev) + '</span></div>'
                                + '<div class="' + sub + '">Orders: <span class="font-medium">' + ord + '</span></div>'
                                + '<div class="' + sub + '">AOV: <span class="font-medium">' + formatRM(aov) + '</span></div>'
                                + '</div>';
                        }
                    },
                    legend: { show:false },
                    fill: { type:'gradient', gradient: { opacityFrom: 0.55, opacityTo: 0, shade: '#7c3aed', gradientToColors:['#7c3aed'] } },
                    dataLabels: { enabled:false },
                    stroke: { width: 4 },
                    grid: { show:false, strokeDashArray:4, padding:{ left:2, right:2, top:0 } },
                    xaxis: { categories: labels, labels: { show:false }, axisBorder:{ show:false }, axisTicks:{ show:false } },
                    yaxis: { show:false }
                };
                salesChart = new ApexCharts(el, options);
                salesChart.render();
            }

            function setHeader(total, change){
                var totalEl = document.getElementById('salesWeekTotal');
                var changeEl = document.getElementById('salesWeekChange');
                var wrap = document.getElementById('salesWeekChangeWrap');
                var icon = document.getElementById('salesWeekChangeIcon');
                if (totalEl) totalEl.textContent = formatRM(total);
                if (changeEl) changeEl.textContent = (change >= 0 ? change : (change)) + '%';
                if (wrap) {
                    if (change >= 0) { wrap.classList.remove('text-red-500','dark:text-red-500'); wrap.classList.add('text-green-500','dark:text-green-500'); }
                    else { wrap.classList.remove('text-green-500','dark:text-green-500'); wrap.classList.add('text-red-500','dark:text-red-500'); }
                }
                if (icon) { icon.style.transform = (change >= 0 ? 'rotate(0deg)' : 'rotate(180deg)'); }
            }

            function loadSales(period, labelText){
                fetch("{{ route('admin.sales-this-period') }}?period=" + encodeURIComponent(period), { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
                    .then(function(r){ return r.json(); })
                    .then(function(json){
                        setHeader(json.summary.total_revenue || 0, json.summary.change_percent || 0);
                        renderSalesChart(json.labels || [], json.revenue || [], json.orders || []);
                        var btn = document.getElementById('salesWeekButton');
                        if (btn && labelText) btn.childNodes[0].nodeValue = labelText + ' ';
                    });
            }

            // init
            loadSales('this_week', 'This week');

            var dd = document.getElementById('salesWeekDropdown');
            if (dd) {
                dd.addEventListener('click', function(e){
                    var a = e.target.closest('a[data-period]');
                    if (!a) return;
                    e.preventDefault();
                    loadSales(a.getAttribute('data-period'), a.textContent.trim());
                });
            }
        });
    </script>
@endsection

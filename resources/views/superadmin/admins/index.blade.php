@extends('layouts.superadmin')

@section('header', 'Manage Admins')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-serif font-semibold text-bookty-black">Admin Users</h2>
        <a href="{{ route('superadmin.admins.create') }}" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Admin
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-bookty-cream">
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                        <span class="text-sm font-medium text-bookty-purple-800">{{ substr($admin->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('superadmin.admins.show', $admin) }}" class="text-bookty-purple-600 hover:text-bookty-purple-900">View</a>
                                    <a href="{{ route('superadmin.admins.edit', $admin) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('superadmin.admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this admin user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No admin users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-white border-t border-gray-200">
            {{ $admins->links() }}
        </div>
    </div>
@endsection

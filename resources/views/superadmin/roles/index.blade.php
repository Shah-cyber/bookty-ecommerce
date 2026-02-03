@extends('layouts.superadmin')

@section('header', 'Roles Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-serif font-semibold text-bookty-black">Roles</h2>
        <a href="{{ route('superadmin.roles.create') }}" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700 transition-colors duration-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Role
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-bookty-cream">
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-bookty-black uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $role->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions as $permission)
                                        <span class="px-2 py-1 text-xs rounded-full bg-bookty-purple-100 text-bookty-purple-800">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                    @if($role->permissions->isEmpty())
                                        <span class="text-sm text-gray-500">No permissions assigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('superadmin.roles.show', $role) }}" class="text-bookty-purple-600 hover:text-bookty-purple-900">View</a>
                                    <a href="{{ route('superadmin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    @if(!in_array($role->name, ['superadmin', 'admin', 'customer']))
                                        <form action="{{ route('superadmin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

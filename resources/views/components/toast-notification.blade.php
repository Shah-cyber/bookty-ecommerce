@props(['id', 'type' => 'success', 'message', 'dismissible' => true])

@php
    $typeConfig = [
        'success' => [
            'containerClass' => 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
            'icon' => '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>',
            'srText' => 'Check icon'
        ],
        'error' => [
            'containerClass' => 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
            'icon' => '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>',
            'srText' => 'Error icon'
        ],
        'warning' => [
            'containerClass' => 'text-orange-500 bg-orange-100 dark:bg-orange-700 dark:text-orange-200',
            'icon' => '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>',
            'srText' => 'Warning icon'
        ],
        'info' => [
            'containerClass' => 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200',
            'icon' => '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>',
            'srText' => 'Info icon'
        ]
    ];
    
    $config = $typeConfig[$type] ?? $typeConfig['success'];
@endphp

<div id="{{ $id }}" class="toast-notification flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 transform transition-all duration-300 ease-out" style="transform: translateX(100%); opacity: 0;" role="alert">
    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 {{ $config['containerClass'] }} rounded-lg">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            {!! $config['icon'] !!}
        </svg>
        <span class="sr-only">{{ $config['srText'] }}</span>
    </div>
    <div class="ms-3 text-sm font-normal">{{ $message }}</div>
    @if($dismissible)
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-toast="{{ $id }}" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    @endif
</div>

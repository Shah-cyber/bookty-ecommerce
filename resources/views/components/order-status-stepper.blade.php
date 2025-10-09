@props(['order', 'size' => 'normal'])

@php
    // Define the order status progression
    $statusSteps = [
        'placed' => ['Order Placed', 'Your order has been received'],
        'processing' => ['Processing', 'We are preparing your books'],
        'shipped' => ['Shipped', 'Your order is on its way'],
        'completed' => ['Delivered', 'Order completed successfully']
    ];
    
    // Determine current step based on order status
    $currentStep = match($order->status) {
        'pending' => 'placed',
        'processing' => 'processing',
        'shipped' => 'shipped',
        'completed' => 'completed',
        'cancelled' => 'cancelled',
        default => 'placed'
    };
    
    // Function to check if step is completed
    $isStepCompleted = function($step) use ($order) {
        return match($step) {
            'placed' => true, // Always completed once order exists
            'processing' => in_array($order->status, ['processing', 'shipped', 'completed']),
            'shipped' => in_array($order->status, ['shipped', 'completed']),
            'completed' => $order->status === 'completed',
            default => false
        };
    };
    
    // Function to check if step is current
    $isStepCurrent = function($step) use ($currentStep) {
        return $step === $currentStep;
    };
    
    // Size configurations
    $sizeClasses = match($size) {
        'small' => [
            'circle' => 'w-8 h-8 lg:w-10 lg:h-10',
            'icon' => 'w-3 h-3 lg:w-3.5 lg:h-3.5',
            'title' => 'text-xs',
            'desc' => 'text-xs'
        ],
        'large' => [
            'circle' => 'w-12 h-12 lg:w-14 lg:h-14',
            'icon' => 'w-4 h-4 lg:w-5 lg:h-5',
            'title' => 'text-sm',
            'desc' => 'text-xs'
        ],
        default => [
            'circle' => 'w-10 h-10 lg:w-12 lg:h-12',
            'icon' => 'w-3.5 h-3.5 lg:w-4 lg:h-4',
            'title' => 'text-xs',
            'desc' => 'text-xs'
        ]
    };
@endphp

@if($order->status === 'cancelled')
    <div class="flex items-center justify-center p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center text-red-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <p class="font-medium">Order Cancelled</p>
                <p class="text-sm">This order has been cancelled.</p>
            </div>
        </div>
    </div>
@else
    <ol class="flex items-center w-full">
        @foreach($statusSteps as $stepKey => $stepInfo)
            @php
                $isCompleted = $isStepCompleted($stepKey);
                $isCurrent = $isStepCurrent($stepKey);
                $isLast = $loop->last;
            @endphp
            
            <li class="flex w-full items-center {{ !$isLast ? 'after:content-[\'\'] after:w-full after:h-1 after:border-b after:border-4 after:inline-block' : '' }} 
                {{ $isCompleted ? 'text-bookty-purple-600 after:border-bookty-purple-200' : ($isCurrent ? 'text-bookty-purple-500 after:border-bookty-pink-200' : 'text-gray-500 after:border-gray-200') }}">
                
                <div class="flex flex-col items-center">
                    <span class="flex items-center justify-center {{ $sizeClasses['circle'] }} rounded-full shrink-0
                        {{ $isCompleted ? 'bg-bookty-purple-600 text-white' : ($isCurrent ? 'bg-bookty-purple-100 text-bookty-purple-600' : 'bg-gray-100 text-gray-500') }}">
                        
                        @if($isCompleted)
                            <svg class="{{ $sizeClasses['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            @if($stepKey === 'placed')
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            @elseif($stepKey === 'processing')
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            @elseif($stepKey === 'shipped')
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            @elseif($stepKey === 'completed')
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        @endif
                    </span>
                    
                    <div class="text-center mt-2">
                        <p class="{{ $sizeClasses['title'] }} font-medium {{ $isCompleted ? 'text-bookty-purple-700' : ($isCurrent ? 'text-bookty-purple-600' : 'text-gray-500') }}">
                            {{ $stepInfo[0] }}
                        </p>
                        <p class="{{ $sizeClasses['desc'] }} {{ $isCompleted ? 'text-bookty-purple-600' : ($isCurrent ? 'text-bookty-purple-500' : 'text-gray-400') }}">
                            {{ $stepInfo[1] }}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ol>
@endif

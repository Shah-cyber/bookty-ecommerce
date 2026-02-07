@props(['endTime', 'title' => null])

<div {{ $attributes->merge(['class' => '']) }}>
    @if($title)
        <h3 class="text-lg font-bold mb-4">{{ $title }}</h3>
    @endif

    <div class="countdown-timer flex items-center space-x-3" data-end-time="{{ $endTime }}">
        <div class="flex flex-col items-center">
            <div class="bg-white text-gray-900 rounded px-2 py-1 font-mono font-bold text-center min-w-[2.8rem] shadow-sm">
                <span class="days">00</span>
            </div>
            <span class="mt-1 text-[10px] uppercase tracking-wide opacity-80 current-text-color">Days</span>
        </div>
        <div class="flex flex-col items-center">
            <div class="bg-white text-gray-900 rounded px-2 py-1 font-mono font-bold text-center min-w-[2.8rem] shadow-sm">
                <span class="hours">00</span>
            </div>
            <span class="mt-1 text-[10px] uppercase tracking-wide opacity-80 current-text-color">Hours</span>
        </div>
        <div class="flex flex-col items-center">
            <div class="bg-white text-gray-900 rounded px-2 py-1 font-mono font-bold text-center min-w-[2.8rem] shadow-sm">
                <span class="minutes">00</span>
            </div>
            <span class="mt-1 text-[10px] uppercase tracking-wide opacity-80 current-text-color">Mins</span>
        </div>
        <div class="flex flex-col items-center">
            <div class="bg-white text-gray-900 rounded px-2 py-1 font-mono font-bold text-center min-w-[2.8rem] shadow-sm">
                <span class="seconds">00</span>
            </div>
            <span class="mt-1 text-[10px] uppercase tracking-wide opacity-80 current-text-color">Secs</span>
        </div>
    </div>
    
    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdownTimers = document.querySelectorAll('.countdown-timer');
    
    countdownTimers.forEach(function(timer) {
        const endTimeStr = timer.getAttribute('data-end-time');
        const endTimeDate = new Date(endTimeStr);
        const endTimeMs = endTimeDate.getTime();
        
        const daysEl = timer.querySelector('.days');
        const hoursEl = timer.querySelector('.hours');
        const minutesEl = timer.querySelector('.minutes');
        const secondsEl = timer.querySelector('.seconds');
        
        // Update the countdown every second
        const countdownInterval = setInterval(function() {
            // Get current time
            const now = new Date().getTime();
            
            // Find the distance between now and the countdown date
            const distance = endTimeMs - now;
            
            // If the countdown is over, clear interval and show expired message
            if (distance < 0) {
                clearInterval(countdownInterval);
                daysEl.textContent = '00';
                hoursEl.textContent = '00';
                minutesEl.textContent = '00';
                secondsEl.textContent = '00';
                
                // Optional: reload page or update UI when countdown ends
                // window.location.reload();
                return;
            }
            
            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result with leading zeros
            daysEl.textContent = days.toString().padStart(2, '0');
            hoursEl.textContent = hours.toString().padStart(2, '0');
            minutesEl.textContent = minutes.toString().padStart(2, '0');
            secondsEl.textContent = seconds.toString().padStart(2, '0');
        }, 1000);
    });
});
</script>
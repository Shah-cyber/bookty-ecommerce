@props(['activeFlashSale', 'activeBookDiscounts', 'activeCoupons'])

@if(($activeFlashSale ?? null) || (isset($activeBookDiscounts) && $activeBookDiscounts->count()) || (isset($activeCoupons) && $activeCoupons->count()))
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        {{-- Very subtle ambient light --}}
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-50/50 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-rose-50/50 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8 mb-16" data-aos="fade-up">
                <div class="max-w-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="relative flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-500 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-600"></span>
                        </span>
                        <p class="text-xs font-bold tracking-[0.2em] uppercase text-rose-600">Live Promotions</p>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif tracking-tight leading-tight mb-4">
                        Deals happening right now
                    </h2>
                    <p class="text-lg text-gray-500 font-light leading-relaxed">
                        Exclusive offers and limited-time discounts curated just for you.
                    </p>
                </div>
                
                <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-100 shadow-sm text-xs font-medium text-gray-500">
                    <svg class="w-4 h-4 text-emerald-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Updated in real-time
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- 1. Flash Sale Card (Sophisticated Dark) --}}
                @if(isset($activeFlashSale) && $activeFlashSale)
                    <div class="group relative overflow-hidden rounded-[2.5rem] bg-slate-900 text-white shadow-2xl shadow-slate-900/10 hover:-translate-y-1 transition-all duration-500 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                        {{-- Subtle mesh gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-black opacity-50 pointer-events-none"></div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-[60px] opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                        
                        <div class="relative z-10 p-8 flex flex-col h-full">
                            <div class="flex items-center justify-between mb-8">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/10 backdrop-blur-md text-[10px] font-bold tracking-widest uppercase text-white/90">
                                    Flash Sale
                                </span>
                                <div class="text-xs font-medium text-slate-400">
                                    {{ $activeFlashSale->books->count() }} items
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-3xl font-bold mb-3 font-serif leading-snug text-white">
                                    {{ $activeFlashSale->name }}
                                </h3>
                                <p class="text-sm text-slate-400 font-light leading-relaxed line-clamp-2">
                                    {{ $activeFlashSale->description }}
                                </p>
                            </div>

                            <div class="mt-auto">
                                {{-- Countdown with Liquid Glass Effect --}}
                                <div class="mb-6 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                                    <p class="text-[10px] uppercase tracking-widest text-indigo-200 mb-2 font-bold">Ends in</p>
                                    <div class="flex gap-2">
                                        <x-flash-sale-countdown :end-time="$activeFlashSale->ends_at->toIso8601String()" class="text-white font-mono text-xl font-bold tracking-tight" />
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-white/10">
                                    <div class="flex -space-x-3">
                                        @foreach($activeFlashSale->books->take(3) as $promoBook)
                                            <div class="h-10 w-8 rounded overflow-hidden border border-slate-700 shadow-lg relative bg-slate-800 transition-transform hover:z-10 hover:scale-110">
                                                @if($promoBook->cover_image)
                                                    <img src="{{ asset('storage/' . $promoBook->cover_image) }}" alt="{{ $promoBook->title }}" class="h-full w-full object-cover opacity-80 group-hover:opacity-100">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-[8px] text-slate-500">Img</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('books.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white text-slate-900 hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 2. Book Deals Card (Clean White) --}}
                @if(isset($activeBookDiscounts) && $activeBookDiscounts->count())
                    @php
                        $discountSample = $activeBookDiscounts->first();
                        $discountEndsAt = optional(
                            $activeBookDiscounts->filter(fn($d) => $d->ends_at)->sortBy('ends_at')->first()
                        )->ends_at;
                    @endphp
                    <div class="group relative rounded-[2.5rem] bg-white border border-gray-100 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-gray-200/50 hover:-translate-y-1 transition-all duration-500 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
                        <div class="relative z-10 p-8 flex flex-col h-full">
                            <div class="flex items-center justify-between mb-8">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[10px] font-bold tracking-widest uppercase text-emerald-700">
                                    Book Deals
                                </span>
                                <span class="text-xs text-gray-400 font-medium">
                                    {{ $activeBookDiscounts->count() }} active
                                </span>
                            </div>
                            
                            <div class="mb-8">
                                <h3 class="text-3xl font-bold text-gray-900 mb-3 font-serif leading-snug">
                                    Reader's Choice
                                </h3>
                                <p class="text-sm text-gray-500 font-light leading-relaxed">
                                    Hand‑picked titles with exclusive price drops.
                                </p>
                            </div>

                            <div class="mt-auto">
                                {{-- Liquid Glass Countdown --}}
                                @if($discountEndsAt)
                                    <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 backdrop-blur-md border border-emerald-100/50 relative overflow-hidden">
                                        {{-- Glass shine effect --}}
                                        <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-b from-white/40 to-transparent rotate-45 pointer-events-none"></div>
                                        
                                        <div class="relative z-10 flex items-center justify-between mb-1">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Refreshes in</span>
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <x-flash-sale-countdown :end-time="$discountEndsAt->toIso8601String()" class="relative z-10 text-emerald-900 font-mono text-lg font-bold tracking-tight" />
                                    </div>
                                @endif

                                <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider mb-1">Featured</span>
                                        <span class="text-sm font-medium text-gray-900 truncate max-w-[140px]">
                                            {{ Str::limit($discountSample->book->title, 20) }}
                                        </span>
                                        <span class="text-xs text-emerald-600 font-bold">
                                            RM {{ number_format($discountSample->book->final_price, 2) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('books.index') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-900 text-white hover:bg-black hover:scale-110 transition-all">
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- 3. Coupon Card (Ticket / Voucher Style) --}}
                @if(isset($activeCoupons) && $activeCoupons->count())
                    @php
                        $primaryCoupon = $activeCoupons->first();
                        $couponEndsAt = $primaryCoupon->valid_until ?? now()->addHours(24);
                    @endphp
                    <div class="group relative rounded-[2.5rem] bg-white border border-gray-100 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-purple-100/50 hover:-translate-y-1 transition-all duration-500 overflow-hidden flex flex-col" data-aos="fade-up" data-aos-delay="300">
                        {{-- Ticket Decoration --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-4 bg-gray-50 rounded-b-xl border-x border-b border-gray-100"></div>

                        <div class="relative z-10 p-8 flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 border border-purple-100 text-[10px] font-bold tracking-widest uppercase text-purple-700">
                                    Voucher
                                </span>
                                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-md">
                                    {{ $activeCoupons->count() }} Available
                                </span>
                            </div>

                            <div class="text-center py-4">
                                <h3 class="text-3xl font-bold text-gray-900 mb-2 font-serif leading-tight">
                                    Extra Savings
                                </h3>
                                <p class="text-sm text-gray-500 font-light max-w-[240px] mx-auto leading-relaxed mb-6">
                                    Use this code at checkout to unlock exclusive savings on your next purchase.
                                </p>
                                
                                {{-- Added Countdown for Coupon --}}
                                <div class="inline-block p-3 rounded-xl bg-purple-50/50 border border-purple-100">
                                    <div class="flex items-center justify-center gap-2 mb-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-purple-600">Expires in</span>
                                        <svg class="w-3 h-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <x-flash-sale-countdown :end-time="$couponEndsAt->toIso8601String()" class="text-purple-900 font-mono text-lg font-bold tracking-tight" />
                                </div>
                            </div>

                            <div class="mt-auto relative">
                                {{-- Dashed Cut Line --}}
                                <div class="flex items-center justify-between absolute -left-8 -right-8 top-0">
                                    <div class="w-6 h-6 rounded-full bg-gray-50 border-r border-gray-100"></div>
                                    <div class="flex-1 h-px border-t-2 border-dashed border-gray-100 mx-2"></div>
                                    <div class="w-6 h-6 rounded-full bg-gray-50 border-l border-gray-100"></div>
                                </div>

                                <div class="pt-8 px-2">
                                    {{-- Coupon Code --}}
                                    <div class="relative group/code">
                                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1.5 ml-1">Copy Code</label>
                                        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-1.5 hover:border-purple-300 hover:shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-100 focus-within:border-purple-300">
                                            <span class="font-mono text-xl font-bold text-gray-900 tracking-wider flex-1 pl-4 coupon-code-text">{{ $primaryCoupon->code }}</span>
                                            
                                            <button type="button" 
                                                    class="copy-coupon-btn px-4 py-2 flex items-center gap-2 bg-gray-900 border border-gray-900 rounded-lg text-sm font-bold text-white hover:bg-gray-800 hover:border-gray-800 transition-all shadow-md active:scale-95"
                                                    data-coupon-code="{{ $primaryCoupon->code }}">
                                                <span class="copy-text">COPY</span>
                                                <svg class="w-4 h-4 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                <svg class="w-4 h-4 check-icon hidden text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="hidden copy-success-msg absolute -top-8 left-1/2 -translate-x-1/2 px-3 py-1 bg-gray-800 text-white text-[10px] font-bold rounded-full shadow-lg transition-all transform origin-bottom z-20">
                                            Copied!
                                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-2 h-2 bg-gray-800 rotate-45"></div>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-center">
                                        @if($primaryCoupon->discount_type === 'percentage')
                                            <p class="text-xs text-gray-500">
                                                Valid until {{ $couponEndsAt->format('M d, Y') }}. <span class="font-bold text-purple-600">Get {{ $primaryCoupon->discount_value }}% OFF</span>
                                            </p>
                                        @elseif($primaryCoupon->discount_type === 'fixed')
                                            <p class="text-xs text-gray-500">
                                                Valid until {{ $couponEndsAt->format('M d, Y') }}. <span class="font-bold text-purple-600">Save RM {{ number_format($primaryCoupon->discount_value, 0) }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const copyBtns = document.querySelectorAll('.copy-coupon-btn');
                            copyBtns.forEach(btn => {
                                btn.addEventListener('click', () => {
                                    const code = btn.dataset.couponCode;
                                    navigator.clipboard.writeText(code).then(() => {
                                        const copyText = btn.querySelector('.copy-text');
                                        const copyIcon = btn.querySelector('.copy-icon');
                                        const checkIcon = btn.querySelector('.check-icon');
                                        const wrapper = btn.closest('.group\\/code');
                                        const msg = wrapper ? wrapper.querySelector('.copy-success-msg') : null;

                                        // Update Button State
                                        copyText.textContent = 'COPIED';
                                        // copyText.classList.add('text-emerald-400'); // No need if white text on dark bg
                                        copyIcon.classList.add('hidden');
                                        checkIcon.classList.remove('hidden');
                                        btn.classList.remove('bg-gray-900', 'border-gray-900', 'hover:bg-gray-800');
                                        btn.classList.add('bg-emerald-600', 'border-emerald-600', 'hover:bg-emerald-500'); // Success color

                                        // Show Success Message
                                        if(msg) {
                                            msg.classList.remove('hidden');
                                            msg.classList.add('animate-bounce');
                                        }

                                        setTimeout(() => {
                                            // Reset Button State
                                            copyText.textContent = 'COPY';
                                            // copyText.classList.remove('text-emerald-400');
                                            copyIcon.classList.remove('hidden');
                                            checkIcon.classList.add('hidden');
                                            btn.classList.add('bg-gray-900', 'border-gray-900', 'hover:bg-gray-800');
                                            btn.classList.remove('bg-emerald-600', 'border-emerald-600', 'hover:bg-emerald-500');
                                            
                                            // Hide Success Message
                                            if(msg) {
                                                msg.classList.add('hidden');
                                                msg.classList.remove('animate-bounce');
                                            }
                                        }, 2000);
                                    });
                                });
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </section>
@endif

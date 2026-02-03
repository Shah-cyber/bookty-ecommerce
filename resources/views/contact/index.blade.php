@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-[#FAF7F5] overflow-hidden">
    <!-- Animated Background Blobs (Softer Colors) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-purple-200/40 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-pink-200/40 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-[20%] right-[20%] w-[30%] h-[30%] bg-blue-100/40 rounded-full blur-[80px] animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-down" data-aos-duration="1000">
        <h1 class="text-5xl md:text-7xl font-bold text-[#2D2D2D] mb-6 font-serif tracking-tight">
            Let's Start a <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#9D84B7] to-pink-500">Conversation</span>
        </h1>
        <p class="mt-4 text-xl text-[#5D4B68] max-w-2xl mx-auto leading-relaxed">
            Have a question about our books? Need help with an order? Or just want to talk about your favorite author? We're here for you.
        </p>
    </div>

    <!-- Contact Form Section -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 bg-white/20 backdrop-blur-xl border border-white/30 shadow-2xl rounded-3xl overflow-hidden" data-aos="fade-up" data-aos-duration="1000">
            
            <!-- Contact Info Sidebar -->
            <div class="p-8 lg:p-12 bg-white/10 relative overflow-hidden group border-r border-white/20">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-200/30 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
                
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-[#2D2D2D] mb-6 font-serif">Contact Information</h2>
                        <p class="text-[#5D4B68] mb-10 text-lg leading-relaxed">Fill up the form and our Team will get back to you within 24 hours.</p>
                        
                        <div class="space-y-8">
                            <!-- Email -->
                            <a href="mailto:{{ $email }}" class="flex items-center space-x-4 group/item hover:translate-x-2 transition-transform duration-300">
                                <div class="p-4 bg-white rounded-2xl group-hover/item:bg-purple-50 transition-colors duration-300 shadow-sm border border-[#9D84B7]/10">
                                    <svg class="w-6 h-6 text-[#9D84B7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-sm text-[#9D84B7] font-medium mb-1">Email Us</span>
                                    <span class="text-lg text-[#2D2D2D] font-medium">{{ $email }}</span>
                                </div>
                            </a>

                            <!-- Phone -->
                            <a href="tel:{{ $phone }}" class="flex items-center space-x-4 group/item hover:translate-x-2 transition-transform duration-300">
                                <div class="p-4 bg-white rounded-2xl group-hover/item:bg-pink-50 transition-colors duration-300 shadow-sm border border-[#9D84B7]/10">
                                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-sm text-pink-500 font-medium mb-1">Call Us</span>
                                    <span class="text-lg text-[#2D2D2D] font-medium">{{ $phone }}</span>
                                </div>
                            </a>

                            <!-- Location -->
                            <div class="flex items-center space-x-4 group/item hover:translate-x-2 transition-transform duration-300">
                                <div class="p-4 bg-white rounded-2xl group-hover/item:bg-blue-50 transition-colors duration-300 shadow-sm border border-[#9D84B7]/10">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-sm text-blue-500 font-medium mb-1">Visit Us</span>
                                    <span class="text-lg text-[#2D2D2D] font-medium max-w-xs block">{{ $address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-12 pt-8 border-t border-[#9D84B7]/20">
                        <h3 class="text-[#2D2D2D] font-semibold mb-4">Follow Our Journey</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="p-3 bg-white rounded-full hover:bg-[#9D84B7] hover:text-white hover:scale-110 transition-all duration-300 text-[#5D4B68] shadow-sm border border-[#9D84B7]/10">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.962.925-1.962 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="p-3 bg-white rounded-full hover:bg-[#9D84B7] hover:text-white hover:scale-110 transition-all duration-300 text-[#5D4B68] shadow-sm border border-[#9D84B7]/10">
                                <span class="sr-only">Twitter</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.892 3.213 2.241 4.11a4.926 4.926 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.9 9.9 0 010 21.543a14 14 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646A10.025 10.025 0 0024 4.557z"/></svg>
                            </a>
                            <a href="#" class="p-3 bg-white rounded-full hover:bg-[#9D84B7] hover:text-white hover:scale-110 transition-all duration-300 text-[#5D4B68] shadow-sm border border-[#9D84B7]/10">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.012-4.849-.069-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="p-8 lg:p-12 relative bg-white/10 backdrop-blur-md">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2 group">
                            <label for="name" class="block text-sm font-medium text-[#5D4B68] group-focus-within:text-[#9D84B7] transition-colors">Your Name</label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-4 py-3 bg-white border border-[#9D84B7]/20 rounded-xl text-[#2D2D2D] placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#9D84B7] focus:ring-1 focus:ring-[#9D84B7] transition-all duration-200"
                                placeholder="John Doe">
                        </div>

                        <!-- Email -->
                        <div class="space-y-2 group">
                            <label for="email" class="block text-sm font-medium text-[#5D4B68] group-focus-within:text-[#9D84B7] transition-colors">Email Address</label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-3 bg-white border border-[#9D84B7]/20 rounded-xl text-[#2D2D2D] placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#9D84B7] focus:ring-1 focus:ring-[#9D84B7] transition-all duration-200"
                                placeholder="john@example.com">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2 group">
                        <label for="subject" class="block text-sm font-medium text-[#5D4B68] group-focus-within:text-[#9D84B7] transition-colors">Subject</label>
                        <select name="subject" id="subject" required
                            class="w-full px-4 py-3 bg-white border border-[#9D84B7]/20 rounded-xl text-[#2D2D2D] placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#9D84B7] focus:ring-1 focus:ring-[#9D84B7] transition-all duration-200 appearance-none">
                            <option value="" class="text-gray-400">Select a topic</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Order Support">Order Support</option>
                            <option value="Book Request">Book Request</option>
                            <option value="Partnership">Partnership</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2 group">
                        <label for="message" class="block text-sm font-medium text-[#5D4B68] group-focus-within:text-[#9D84B7] transition-colors">Message</label>
                        <textarea name="message" id="message" rows="5" required
                            class="w-full px-4 py-3 bg-white border border-[#9D84B7]/20 rounded-xl text-[#2D2D2D] placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#9D84B7] focus:ring-1 focus:ring-[#9D84B7] transition-all duration-200 resize-none"
                            placeholder="Tell us more about your inquiry..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-[#9D84B7] to-pink-500 text-white font-bold text-lg shadow-lg transform hover:translate-y-[-2px] hover:shadow-purple-500/30 transition-all duration-200 relative overflow-hidden group">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Send Message
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                        <!-- Button Glow Effect -->
                        <div class="absolute inset-0 bg-white/20 blur-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-32" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        <h2 class="text-3xl font-bold text-center text-[#2D2D2D] mb-12 font-serif">Frequently Asked Questions</h2>
        
        <div class="space-y-4" x-data="{ activeAccordion: null }">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#9D84B7]/10 overflow-hidden hover:shadow-md transition-all duration-300">
                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none bg-white hover:bg-[#FAF7F5] transition-colors duration-200">
                    <span class="text-lg font-medium text-[#2D2D2D]">What are your shipping rates?</span>
                    <svg class="w-5 h-5 text-[#9D84B7] transform transition-transform duration-300" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeAccordion === 1" x-collapse>
                    <div class="px-6 pb-6 text-[#5D4B68] bg-[#FAF7F5]/50 border-t border-[#9D84B7]/5">
                        We offer flat-rate shipping of RM8.00 for West Malaysia and RM15.00 for East Malaysia. Free shipping is available for orders over RM150!
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#9D84B7]/10 overflow-hidden hover:shadow-md transition-all duration-300">
                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none bg-white hover:bg-[#FAF7F5] transition-colors duration-200">
                    <span class="text-lg font-medium text-[#2D2D2D]">Do you ship internationally?</span>
                    <svg class="w-5 h-5 text-[#9D84B7] transform transition-transform duration-300" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeAccordion === 2" x-collapse>
                    <div class="px-6 pb-6 text-[#5D4B68] bg-[#FAF7F5]/50 border-t border-[#9D84B7]/5">
                        Currently, we primarily ship within Malaysia and Singapore. For other international orders, please contact us directly for a custom shipping quote.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#9D84B7]/10 overflow-hidden hover:shadow-md transition-all duration-300">
                <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none bg-white hover:bg-[#FAF7F5] transition-colors duration-200">
                    <span class="text-lg font-medium text-[#2D2D2D]">Can I return a book if I don't like it?</span>
                    <svg class="w-5 h-5 text-[#9D84B7] transform transition-transform duration-300" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeAccordion === 3" x-collapse>
                    <div class="px-6 pb-6 text-[#5D4B68] bg-[#FAF7F5]/50 border-t border-[#9D84B7]/5">
                        We accept returns for damaged or incorrect items within 7 days of receipt. Unfortunately, we cannot accept returns for change of mind due to the nature of printed materials.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden">
    {{-- Ambient Background Blobs --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[400px] h-[400px] bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
        <div class="absolute bottom-20 -left-20 w-[350px] h-[350px] bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-6 py-16 lg:py-24 relative z-10">
        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="inline-block px-4 py-1.5 bg-purple-100 text-purple-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                Get in Touch
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Contact Us
            </h1>
            <p class="text-lg text-gray-600">
                Have questions or feedback? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-12 max-w-6xl mx-auto">
            {{-- Contact Info --}}
            <div class="lg:col-span-2 space-y-8" data-aos="fade-right">
                {{-- Info Cards --}}
                <div class="space-y-4">
                    {{-- Email --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600 text-sm">hello@bookty.com.my</p>
                                <p class="text-gray-500 text-xs mt-1">We reply within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Phone</h3>
                                <p class="text-gray-600 text-sm">+60 12-345 6789</p>
                                <p class="text-gray-500 text-xs mt-1">Mon-Fri, 9am-6pm</p>
                            </div>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Location</h3>
                                <p class="text-gray-600 text-sm">Kuala Lumpur, Malaysia</p>
                                <p class="text-gray-500 text-xs mt-1">Online store only</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="pt-4">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-11 h-11 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-purple-50 hover:text-purple-600 hover:border-purple-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.373c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-sky-50 hover:text-sky-500 hover:border-sky-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-white rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-3" data-aos="fade-left" data-aos-delay="100">
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200"
                                    placeholder="Your name">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200"
                                    placeholder="your@email.com">
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select id="subject" name="subject" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200">
                                <option value="" disabled selected>Select a topic</option>
                                <option value="general">General Inquiry</option>
                                <option value="order">Order Support</option>
                                <option value="feedback">Feedback</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all duration-200 resize-none"
                                placeholder="How can we help you?"></textarea>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-all duration-300">
                            <span>Send Message</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- FAQ Section --}}
        <div class="mt-24 max-w-3xl mx-auto" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Frequently Asked Questions</h2>
                <p class="text-gray-600">Quick answers to common questions</p>
            </div>

            <div class="space-y-4" x-data="{ open: null }">
                {{-- FAQ Item 1 --}}
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <button @click="open = open === 1 ? null : 1" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-medium text-gray-900">What are your delivery times?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 text-sm">We typically process orders within 1-2 business days. Delivery within Peninsular Malaysia takes 3-5 business days, while East Malaysia takes 5-7 business days.</p>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <button @click="open = open === 2 ? null : 2" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-medium text-gray-900">Do you offer returns or exchanges?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 text-sm">Yes, we accept returns within 7 days of delivery for items in original condition. Please contact us with your order number to initiate a return.</p>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <button @click="open = open === 3 ? null : 3" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-medium text-gray-900">How can I track my order?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 text-sm">Once your order is shipped, you'll receive an email with tracking information. You can also check your order status in your account dashboard.</p>
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <button @click="open = open === 4 ? null : 4" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                        <span class="font-medium text-gray-900">Do you ship internationally?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 text-sm">Currently, we only ship within Malaysia. We're working on expanding our delivery services to neighboring countries soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animation-delay-2000 { animation-delay: 2s; }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(10px, -20px) rotate(5deg); }
        50% { transform: translate(-10px, 10px) rotate(-5deg); }
        75% { transform: translate(20px, -10px) rotate(3deg); }
    }
    
    .animate-float {
        animation: float 20s ease-in-out infinite;
    }
</style>
@endsection

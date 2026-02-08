@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden">
    {{-- Ambient Background Blobs --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-float"></div>
        <div class="absolute top-20 right-0 w-[400px] h-[400px] bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float animation-delay-2000"></div>
        <div class="absolute bottom-40 left-1/3 w-[450px] h-[450px] bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float animation-delay-4000"></div>
    </div>

    {{-- Hero Section --}}
    <section class="relative pt-20 pb-24 lg:pt-28 lg:pb-32">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full shadow-sm border border-gray-100 mb-6" data-aos="fade-down">
                    <span class="w-2 h-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-semibold text-gray-600">Est. 2023</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight" data-aos="fade-up" data-aos-delay="100">
                    <span class="text-gray-900">
                        Spreading Love Through
                    </span>
                    <br>
                    <span class="text-purple-600 font-serif">
                        Beautiful Stories
                    </span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed mb-10" data-aos="fade-up" data-aos-delay="200">
                    Malaysia's premier destination for romance novels. We curate the finest love stories that capture hearts and inspire readers.
                </p>

                {{-- Stats Row --}}
                <div class="flex flex-wrap justify-center gap-6 md:gap-12" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-purple-600">1000+</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Curated Books</div>
                    </div>
                    <div class="w-px h-12 bg-gray-200 hidden md:block"></div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-pink-600">50+</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Local Authors</div>
                    </div>
                    <div class="w-px h-12 bg-gray-200 hidden md:block"></div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-indigo-600">5000+</div>
                        <div class="text-sm text-gray-500 font-medium mt-1">Happy Readers</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Story Section --}}
    <section class="relative py-20 lg:py-28">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                {{-- Left: Image/Visual --}}
                <div class="relative" data-aos="fade-right">
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl">
                        <div class="aspect-[4/3] bg-gradient-to-br from-purple-100 via-pink-50 to-indigo-100 flex items-center justify-center">
                            <div class="text-center p-8">
                                <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-32 md:h-40 mx-auto mb-6 drop-shadow-xl">
                                <div class="flex flex-wrap justify-center gap-2">
                                    @foreach(['Romance', 'Drama', 'Love Stories', 'Malaysian Authors'] as $tag)
                                        <span class="px-4 py-1.5 bg-white/80 backdrop-blur-sm rounded-full text-sm font-medium text-gray-700 shadow-sm">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative Elements --}}
                    <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl -z-10 opacity-60"></div>
                    <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-indigo-400 to-purple-400 rounded-full -z-10 opacity-40"></div>
                </div>

                {{-- Right: Content --}}
                <div data-aos="fade-left" data-aos-delay="100">
                    <span class="inline-block px-4 py-1.5 bg-purple-100 text-purple-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                        Our Story
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        Born from a Deep Love for
                        <span class="text-purple-600">Malaysian Romance</span>
                    </h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Founded in 2023, Bookty Enterprise emerged from a passion to celebrate Malaysian romance literature. We saw a gap in the market for a dedicated platform that truly understands and appreciates the nuances of local love stories.
                        </p>
                        <p>
                            Our journey began with a simple mission: to connect readers with stories that resonate with their hearts, featuring characters and settings that feel like home. Today, we're proud to be the go-to destination for romance enthusiasts across Malaysia.
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            <span>Explore Our Collection</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Offer Section --}}
    <section class="relative py-20 lg:py-28 bg-gradient-to-b from-white via-purple-50/30 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                    What We Offer
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                    Why Choose <span class="text-purple-600">Bookty</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Feature Card 1 --}}
                <div class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-5 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Curated Collection</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Every book is handpicked for quality storytelling that captures the essence of Malaysian romance.
                    </p>
                </div>

                {{-- Feature Card 2 --}}
                <div class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-5 shadow-lg shadow-pink-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Support Local Authors</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        We champion Malaysian writers and help their voices reach a broader audience.
                    </p>
                </div>

                {{-- Feature Card 3 --}}
                <div class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-5 shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Quick processing and reliable shipping to get your books to you as soon as possible.
                    </p>
                </div>

                {{-- Feature Card 4 --}}
                <div class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mb-5 shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Community</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Join a vibrant community of readers who share your passion for romance stories.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission & Vision Section --}}
    <section class="relative py-20 lg:py-28">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-8">
                {{-- Mission Card --}}
                <div class="relative group" data-aos="fade-up">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-[2rem] transform rotate-1 group-hover:rotate-2 transition-transform duration-300 opacity-90"></div>
                    <div class="relative bg-white rounded-[2rem] p-8 md:p-10 shadow-xl border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                        <p class="text-gray-600 leading-relaxed">
                            To provide Malaysian readers with access to the finest romance novels that reflect our diverse cultural experiences, while supporting local authors and fostering a vibrant community of book lovers who share our passion for beautiful love stories.
                        </p>
                    </div>
                </div>

                {{-- Vision Card --}}
                <div class="relative group" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-600 to-rose-600 rounded-[2rem] transform -rotate-1 group-hover:-rotate-2 transition-transform duration-300 opacity-90"></div>
                    <div class="relative bg-white rounded-[2rem] p-8 md:p-10 shadow-xl border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                        <p class="text-gray-600 leading-relaxed">
                            To become Malaysia's leading platform for romance literature, recognized for our exceptional curation, unwavering author support, and thriving community of readers who are passionate about discovering and sharing stories that touch their hearts.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    <section class="relative py-20 lg:py-28 bg-gradient-to-b from-white via-gray-50/50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <span class="inline-block px-4 py-1.5 bg-pink-100 text-pink-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                    Our Team
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    The People Behind <span class="text-pink-600">Bookty</span>
                </h2>
                <p class="text-gray-600">
                    Our team shares a deep love for romance novels and is dedicated to bringing the best stories to our readers.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                {{-- Team Member 1 --}}
                <div class="group" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300">
                        <div class="relative w-28 h-28 mx-auto mb-5">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-full animate-pulse opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <div class="relative w-28 h-28 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-3xl font-bold text-purple-600">AZ</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Azizah Rahman</h3>
                        <p class="text-sm font-semibold text-purple-600 mb-3">Founder & CEO</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            A lifelong book lover with a vision to promote Malaysian romance literature to a wider audience.
                        </p>
                        <div class="mt-4 flex justify-center gap-3">
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-purple-50 hover:text-purple-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-purple-50 hover:text-purple-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Team Member 2 --}}
                <div class="group" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300">
                        <div class="relative w-28 h-28 mx-auto mb-5">
                            <div class="absolute inset-0 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full animate-pulse opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <div class="relative w-28 h-28 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-3xl font-bold text-pink-600">LK</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Lee Kai Ming</h3>
                        <p class="text-sm font-semibold text-pink-600 mb-3">Head of Curation</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            With an eye for exceptional storytelling, Kai Ming leads our book selection process with passion.
                        </p>
                        <div class="mt-4 flex justify-center gap-3">
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Team Member 3 --}}
                <div class="group" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300">
                        <div class="relative w-28 h-28 mx-auto mb-5">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-full animate-pulse opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <div class="relative w-28 h-28 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-3xl font-bold text-indigo-600">SD</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Sarah Devi</h3>
                        <p class="text-sm font-semibold text-indigo-600 mb-3">Community Manager</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Sarah builds and nurtures our community of readers through engaging events and interactions.
                        </p>
                        <div class="mt-4 flex justify-center gap-3">
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="w-9 h-9 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-purple-900 to-indigo-900"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                    Ready to Discover Your
                    <span class="text-pink-300">Next Great Read?</span>
                </h2>
                <p class="text-lg text-gray-300 mb-10 max-w-2xl mx-auto">
                    Join thousands of readers who have found their favorite stories through Bookty. Start your romance reading journey today.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-gray-900 font-bold rounded-xl hover:bg-gray-100 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Browse Collection</span>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-transparent text-white font-bold rounded-xl border-2 border-white/30 hover:bg-white/10 hover:border-white/50 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Animation delay utilities */
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    
    /* Float animation for background blobs */
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

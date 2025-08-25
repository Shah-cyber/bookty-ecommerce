@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-bookty-pink-50 to-white">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="text-center">
                        <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-24 mx-auto mb-6" data-aos="fade-down">
                        <h1 class="text-4xl font-serif tracking-tight font-extrabold text-bookty-black sm:text-5xl md:text-6xl" data-aos="fade-up" data-aos-delay="200">
                            About <span class="text-bookty-purple-600">Bookty</span>
                        </h1>
                        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl" data-aos="fade-up" data-aos-delay="400">
                            Malaysia's premier destination for romance novels
                        </p>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-bookty-purple-600 font-semibold tracking-wide uppercase" data-aos="fade-up">Our Story</h2>
                <p class="mt-2 text-3xl leading-8 font-serif font-extrabold tracking-tight text-bookty-black sm:text-4xl" data-aos="fade-up" data-aos-delay="100">
                    Passion for Romance Literature
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Founded in 2023, Bookty Enterprise was born from a deep love for Malaysian romance novels and a desire to share these stories with readers across the country.
                </p>
            </div>

            <div class="mt-16">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative" data-aos="fade-right" data-aos-delay="100">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-bookty-purple-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-serif font-medium text-bookty-black">Curated Collection</h3>
                            <p class="mt-2 text-base text-gray-500">
                                We carefully select each title in our collection, focusing on quality Malaysian romance novels that capture the essence of love in our unique cultural context.
                            </p>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-delay="200">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-bookty-purple-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-serif font-medium text-bookty-black">Supporting Local Authors</h3>
                            <p class="mt-2 text-base text-gray-500">
                                We're committed to promoting Malaysian authors and providing a platform for their voices to reach a wider audience.
                            </p>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-right" data-aos-delay="300">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-bookty-purple-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-serif font-medium text-bookty-black">Fast Delivery</h3>
                            <p class="mt-2 text-base text-gray-500">
                                We understand the excitement of receiving a new book. That's why we ensure quick processing and delivery to get your books to you as soon as possible.
                            </p>
                        </div>
                    </div>

                    <div class="relative" data-aos="fade-left" data-aos-delay="400">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-bookty-purple-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg font-serif font-medium text-bookty-black">Community Engagement</h3>
                            <p class="mt-2 text-base text-gray-500">
                                We foster a community of romance novel enthusiasts through book clubs, author events, and online discussions to share our love for these stories.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="py-16 bg-bookty-pink-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-bookty-purple-600 font-semibold tracking-wide uppercase" data-aos="fade-up">Our Mission & Vision</h2>
                <p class="mt-2 text-3xl leading-8 font-serif font-extrabold tracking-tight text-bookty-black sm:text-4xl" data-aos="fade-up" data-aos-delay="100">
                    Spreading Love Through Literature
                </p>
            </div>

            <div class="mt-10">
                <div class="md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="bg-white p-6 rounded-lg shadow-md" data-aos="zoom-in-right" data-aos-delay="200">
                        <h3 class="text-2xl font-serif font-bold text-bookty-purple-600 mb-4">Our Mission</h3>
                        <p class="text-gray-600">
                            To provide Malaysian readers with access to the finest romance novels that reflect our diverse cultural experiences, while supporting local authors and fostering a community of book lovers.
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md mt-6 md:mt-0" data-aos="zoom-in-left" data-aos-delay="300">
                        <h3 class="text-2xl font-serif font-bold text-bookty-purple-600 mb-4">Our Vision</h3>
                        <p class="text-gray-600">
                            To become Malaysia's leading platform for romance literature, recognized for our quality curation, author support, and vibrant community of readers passionate about love stories.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-bookty-purple-600 font-semibold tracking-wide uppercase" data-aos="fade-up">Our Team</h2>
                <p class="mt-2 text-3xl leading-8 font-serif font-extrabold tracking-tight text-bookty-black sm:text-4xl" data-aos="fade-up" data-aos-delay="100">
                    Meet the Passionate People Behind Bookty
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Our team shares a deep love for romance novels and is dedicated to bringing the best stories to our readers.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg" data-aos="flip-left" data-aos-delay="100">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                <span class="text-2xl font-medium text-bookty-purple-800">AZ</span>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg leading-6 font-medium text-bookty-black">Azizah Rahman</h3>
                                <p class="text-sm text-bookty-purple-600">Founder & CEO</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                A lifelong book lover with a vision to promote Malaysian romance literature to a wider audience.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg" data-aos="flip-left" data-aos-delay="200">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                <span class="text-2xl font-medium text-bookty-purple-800">LK</span>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg leading-6 font-medium text-bookty-black">Lee Kai Ming</h3>
                                <p class="text-sm text-bookty-purple-600">Head of Curation</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                With an eye for exceptional storytelling, Kai Ming leads our book selection process.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg" data-aos="flip-left" data-aos-delay="300">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-20 w-20 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                <span class="text-2xl font-medium text-bookty-purple-800">SD</span>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg leading-6 font-medium text-bookty-black">Sarah Devi</h3>
                                <p class="text-sm text-bookty-purple-600">Community Manager</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">
                                Sarah builds and nurtures our community of readers through events and online engagement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA Section -->
    <div class="bg-bookty-purple-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-serif font-extrabold tracking-tight text-white sm:text-4xl" data-aos="fade-right">
                <span class="block">Ready to explore our collection?</span>
                <span class="block text-bookty-pink-200">Start your romance reading journey today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0" data-aos="fade-left" data-aos-delay="200">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-bookty-purple-700 bg-white hover:bg-bookty-pink-50">
                        Browse Books
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-bookty-purple-600 hover:bg-bookty-purple-500">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

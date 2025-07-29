@extends('layouts.app')
@section('title', ucfirst($type) . ' Gallery')

@section('content')
@vite('resources/js/app.js')

<style>
    /* Smooth scrollbar for description */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(20, 184, 166, 0.5);
        border-radius: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(20, 184, 166, 0.8);
    }

    /* Glass morphism effect */
    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
    }
    
    .backdrop-blur-md {
        backdrop-filter: blur(12px);
    }

    /* Custom animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .group:hover .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<!-- Banner -->
<section class="bg-[#01B6BE] py-16 text-white text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold uppercase">{{ ucfirst($type) }} Gallery</h1>
        <p class="mt-2 text-lg">Explore all {{ strtolower($type) }} activities by our clients</p>
    </div>
</section>

<!-- Gallery Wrapper -->
<div class="container mx-auto px-4 py-6"
     x-data="{
         view: 'grid',
         selectedClient: '',
         selectedDate: '',
         groupedGallery: Object.entries(
             Object.groupBy(@js($gallery), img => img.title + '|' + img.description + '|' + img.client_id + '|' + img.date)
         ),
         matches(images) {
             return (!this.selectedClient || images[0].title === this.selectedClient)
                 && (!this.selectedDate || new Date(images[0].date).toISOString().slice(0,10) === this.selectedDate);
         },
         lightbox: {
             open: false,
             index: 0,
             images: [],
             info: {},
             show(images) {
                 this.images = images;
                 this.index = 0;
                 this.info = images[0];
                 this.open = true;
             },
             next() {
                 this.index = (this.index + 1) % this.images.length;
                 this.info = this.images[this.index];
             },
             prev() {
                 this.index = (this.index - 1 + this.images.length) % this.images.length;
                 this.info = this.images[this.index];
             },
             close() {
                 this.open = false;
             }
         }
     }">

    <!-- Filter + Search + Back -->
    <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4 w-full lg:w-3/4">
            <label for="filterTitle" class="text-sm font-semibold text-gray-700 whitespace-nowrap">Filter by Title:</label>
            <select id="filterTitle" x-model="selectedClient" class="border border-gray-300 px-3 py-2 rounded-md text-sm">
                <option value="">All</option>
                @foreach($gallery->pluck('title')->unique() as $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </select>

            <div class="flex items-center gap-2">
                <label for="filterDate" class="text-sm font-semibold text-gray-700 whitespace-nowrap">Filter by Date:</label>
                <input type="date" id="filterDate" x-model="selectedDate"
                    class="border border-gray-300 px-3 py-2 rounded-md text-sm">
            </div>
        </div>

        <div class="w-full lg:w-auto flex justify-end">
            <a href="{{ route('clientGallery', ['type' => $type]) }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded text-center">
                ← Back to Client List
            </a>
        </div>
    </div>

    <!-- No Data Message -->
    <template x-if="groupedGallery.filter(([key, images]) => matches(images)).length === 0">
        <div class="flex flex-col items-center justify-center mt-16 mb-20 pb-16">
            <img src="{{ asset('assets/images/favicon/error.png') }}" alt="No Data"
                 class="w-32 h-32 mb-4 opacity-60">
            <p class="text-gray-500 text-lg">No matching images found.</p>
        </div>
    </template>

    <!-- Grid View -->
    <div x-show="view === 'grid'" class="mt-6 mb-20">
        <div class="flex flex-wrap -mx-4">
            <template x-for="([key, images], index) in groupedGallery.filter(([key, images]) => matches(images))" :key="key">
                <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                    <article class="overflow-hidden rounded-lg shadow-lg transition hover:scale-[1.02] duration-300">
                        <!-- Carousel -->
                        <div x-data="{ current: 0, timer: null, start() { this.timer = setInterval(() => { this.current = (this.current + 1) % images.length }, 5000) }, stop() { clearInterval(this.timer) } }" x-init="start()" @mouseenter="stop()" @mouseleave="start()">
                            <div class="relative h-60 bg-gray-100">
                                <template x-for="(img, i) in images" :key="img.image_path">
                                    <img x-show="current === i"
                                         class="absolute top-0 left-0 w-full h-full object-contain transition duration-500"
                                         :src="'/assets/images/clientGallery/{{ $type }}/' + img.image_path"
                                         :alt="img.title">
                                </template>
                                <!-- Nav Buttons -->
                                <button @click="current = (current - 1 + images.length) % images.length" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 px-2 py-1">‹</button>
                                <button @click="current = (current + 1) % images.length" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-70 px-2 py-1">›</button>
                            </div>
                        </div>

                        <div class="md:px-5 px-3 pb-7">
                            <!-- Header -->
                            <header class="flex items-center justify-between leading-tight pt-4">
                                <h1 class="text-xl text-[#01B6BE] font-bold" x-text="images[0].title"></h1>
                                <p class="text-gray-500 font-semibold text-sm md:pr-5" x-text="new Date(images[0].date).toLocaleDateString()"></p>
                            </header>

                            <!-- Description -->
                            <div class="py-4">
                                <p class="text-gray-600 mb-4 line-clamp-2" x-text="images[0].description"></p>
                                <button type="button"
                                        class="mt-2 px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500"
                                        @click="lightbox.show(images)">
                                    See More
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </template>
        </div>
    </div>

<!-- Enhanced Lightbox Modal -->
<div x-show="lightbox.open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     class="fixed inset-0 bg-black bg-opacity-25  flex items-center justify-center z-50 p-4">

    <!-- Enhanced Modal Box -->
    <div class="relative w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
        
        <!-- Glass Effect Header -->
        <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-white/10 to-transparent"></div>
        
        <!-- Close Button - Modern Design -->
        <button @click="lightbox.close()"
            class="absolute top-4 right-4 z-50 group bg-white/20 backdrop-blur-sm hover:bg-red-500/90 text-black rounded-full p-3 shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col lg:flex-row">
            <!-- Image Section - Left Side -->
            <div class="w-full lg:w-2/3 p-6 lg:p-8">
                <!-- Image Container with Gradient Border -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-teal-400 via-blue-500 to-purple-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative h-[400px] lg:h-[500px] w-full bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden shadow-inner">
                        <img :src="'/assets/images/clientGallery/{{ $type }}/' + lightbox.info.image_path"
                             class="w-full h-full object-contain transition-transform duration-500 hover:scale-105"
                             :alt="lightbox.info.title">
                        
                        <!-- Floating Image Counter -->
                        <div class="absolute top-4 left-4 bg-black/60 text-black px-3 py-1 rounded-full text-sm font-medium">
                            <span x-text="(lightbox.currentIndex + 1) + ' / ' + lightbox.images.length"></span>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Navigation Buttons -->
                <div class="mt-6 flex justify-center items-center gap-6">
                    <button @click="lightbox.prev()"
                        class="group flex items-center gap-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-black px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed text-lg font-medium">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="font-medium">Previous</span>
                    </button>
                    
                    <!-- Progress Dots -->
                    <div class="flex gap-2">
                        <template x-for="(image, index) in lightbox.images.slice(Math.max(0, lightbox.currentIndex - 2), lightbox.currentIndex + 3)" :key="index">
                            <div class="w-3 h-3 rounded-full transition-all duration-300"
                                 :class="index === lightbox.currentIndex ? 'bg-teal-500 scale-125' : 'bg-gray-300 hover:bg-gray-400'"></div>
                        </template>
                    </div>
                    
                    <button @click="lightbox.next()"
                        class="group flex items-center gap-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-black px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed text-lg font-medium">
                        <span class="font-medium">Next</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Information Section - Right Side -->
            <div class="w-full lg:w-1/3 bg-gradient-to-b from-gray-50/50 to-white/50 backdrop-blur-sm border-l border-gray-200/50">
                <div class="p-6 lg:p-8 h-full">
                    <!-- Title with Icon -->
                    <div class="flex items-start gap-3 mb-6">
                        <div class="flex-1">
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 leading-tight" x-text="lightbox.info.title"></h2>
                        </div>
                    </div>

                    <!-- Date Badge -->
                    <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-100 to-teal-100 text-teal-700 px-4 py-2 rounded-full text-sm font-medium mb-6 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span x-text="new Date(lightbox.info.date).toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })"></span>
                    </div>

                    <!-- Description -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                            Description
                        </h3>
                        <p class="text-gray-700 leading-relaxed mt-2" x-text="lightbox.info.description || 'No description available.'"></p>
                    </div>

                    <!-- Additional Info Cards -->
                    <div class="mt-6 space-y-3">
                        <div class="bg-white/70 backdrop-blur-sm rounded-lg p-3 border border-gray-200/50 shadow-sm">
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="font-medium text-gray-600">Type:</span>
                                <span class="text-purple-600 font-semibold capitalize" x-text="'{{ $type }}'"></span>
                            </div>
                        </div>
                        
                        <div class="bg-white/70 backdrop-blur-sm rounded-lg p-3 border border-gray-200/50 shadow-sm">
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="font-medium text-gray-600">Gallery:</span>
                                <span class="text-green-600 font-semibold" x-text="lightbox.images.length + ' photos'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Gradient -->
                <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white/10 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

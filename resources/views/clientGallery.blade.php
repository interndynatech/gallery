@extends('layouts.app')
@section('title', ucfirst($type) . ' Gallery')

@section('content')
@vite('resources/js/app.js')

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

<!-- Lightbox Modal -->
<div x-show="lightbox.open" x-transition.opacity.duration.300ms
    class="fixed inset-0 bg-black bg-opacity-25 backdrop-blur-sm flex items-center justify-center z-50 ">

    <!-- Modal Box -->
    <div class="relative w-[90%] max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden p-6 md:p-8 border border-gray-200">
            <!-- Butang pangkah di kanan atas skrin -->
        <button @click="lightbox.close()"
            class="fixed top-6 right-6 bg-red-600 hover:bg-red-700 text-white rounded-full p-2 shadow-lg z-50 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Gambar -->
            <div class="w-full md:w-2/3 flex flex-col items-center justify-center">
                <div class="h-[380px] w-full flex items-center justify-center bg-gray-50 border border-gray-200 rounded-xl">
                    <img :src="'/assets/images/clientGallery/{{ $type }}/' + lightbox.info.image_path"
                        class="max-h-full max-w-full object-contain rounded-xl shadow-md">
                </div>

                <!-- Butang Prev/Next -->
                <div class="mt-4 flex justify-center gap-4">
                    <button @click="lightbox.prev()"
                        class="bg-[#f1f1f1] text-sm px-4 py-2 rounded-lg hover:bg-[#e0e0e0] transition">← Prev</button>
                    <button @click="lightbox.next()"
                        class="bg-[#f1f1f1] text-sm px-4 py-2 rounded-lg hover:bg-[#e0e0e0] transition">Next →</button>
                </div>
            </div>

            <!-- Maklumat -->
            <div class="w-full md:w-1/3 text-sm max-h-[400px] overflow-y-auto pr-2">
                <h2 class="text-2xl font-semibold text-[#01B6BE] leading-snug" x-text="lightbox.info.title"></h2>
                <p class="mt-4 text-gray-400 text-xs" x-text="'📅 Date: ' + new Date(lightbox.info.date).toLocaleDateString()"></p>
                <p class="mt-3 text-gray-700 leading-relaxed text-[15px]" x-text="lightbox.info.description"></p>
            </div>
        </div>
    </div>
</div>


</div>

@endsection

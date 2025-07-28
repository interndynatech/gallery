@extends('layouts.app')

@section('content')
@foreach($news as $newsItem)
    <div class="bg-[#01B6BE] flex items-center justify-center">
        <div class="container px-6 py-16 mx-auto text-center">
            <h1 class="text-3xl font-bold text-white md:text-5xl">
                {{ $newsItem->first()->title }}
            </h1>
        </div>
    </div>
@endforeach

<section class="text-gray-600 body-font">
    <div class="container px-5 py-2 pb-8 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            @foreach($news as $newsItem)
            <div class="flex flex-col sm:flex-row mt-10">
                <div class="sm:w-1/3 text-center sm:pr-8">
                    <!-- Carousel using Alpine.js -->
                    <div x-data="carouselData()" x-init="startAutoScroll()" class="relative w-full h-64 md:h-full sm:h-80">
                        <div class="absolute inset-0">
                            @foreach ($newsItem as $image)
                            <div x-show="activeImage === {{ $loop->index }}" class="w-full h-full">
                                <img alt="content" class="object-cover object-center w-full h-full" src="{{ asset('assets/images/news/' . $image->imagePath) }}">
                            </div>
                            @endforeach
                        </div>
                        <!-- Previous Button -->
                        <button @click="activeImage = (activeImage === 0) ? {{ count($newsItem) - 1 }} : activeImage - 1"
                            class="absolute left-0 transform -translate-y-1/2 top-1/2 bg-gray-800 text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Right Arrow Button -->
                        <button @click="activeImage = (activeImage === {{ count($newsItem) - 1 }}) ? 0 : activeImage + 1"
                            class="absolute right-0 transform -translate-y-1/2 top-1/2 bg-gray-800 text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                    <p class="leading-relaxed font-semibold text-lg mb-4">{{ $newsItem->first()->introContent }}</p>
                    <p class="leading-relaxed text-lg mb-4 whitespace-pre-wrap">{{ $newsItem->first()->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function carouselData() {
        return {
            activeImage: 0,
            totalImages: @json(count($newsItem)),
            startAutoScroll() {
                console.log('Auto scroll started');
                setInterval(() => {
                    this.activeImage = (this.activeImage + 1) % this.totalImages;
                    console.log('Active Image:', this.activeImage);
                }, 3000); // Change image every 3 seconds
            }
        }
    }
</script>
@endsection

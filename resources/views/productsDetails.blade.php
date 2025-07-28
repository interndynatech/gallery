@extends('layouts.app')

@section('content')

<div class="bg-[#01B6BE] flex items-center justify-center">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white">
            {{ $product->productName }}
        </h1>
    </div>
</div>

<section class="text-gray-600 body-font">
    <div class="container px-4 sm:px-5 py-2 pb-8 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            <div class="flex flex-col sm:flex-row mt-10">
                <!-- Image section -->
                <div class="sm:w-1/3 text-center sm:pr-8 mb-6 sm:mb-0">
                    <!-- Display main image -->
                    <div class="relative w-full mb-4" style="padding-bottom: 100%; position: relative;">
                        <img alt="content" class="absolute inset-0 object-cover w-full h-full" src="{{ asset('assets/' . $product->imagePath) }}">
                    </div>

                    <!-- Carousel using Alpine.js -->
                    <div x-data="carouselData({{ count($product->images) }})" x-init="startAutoScroll()" class="relative w-full h-64 md:h-full sm:h-80">
                        <div class="absolute inset-0">
                            @forelse ($product->images as $index => $image)
                                <div x-show="activeImage === {{ $index }}" class="w-full h-full">
                                    <div class="relative w-full" style="padding-bottom: 100%; position: relative;">
                                        <img alt="content" class="absolute inset-0 object-cover w-full h-full" src="{{ asset('assets/' . $image->imagePathCarousel) }}">
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>

                        <!-- Previous Button -->
                        @if (count($product->images) > 0)
                            <button @click="activeImage = (activeImage === 0) ? totalImages - 1 : activeImage - 1"
                                class="absolute left-0 transform -translate-y-1/2 top-1/2 bg-gray-800 text-white p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        @endif

                        <!-- Right Arrow Button -->
                        @if (count($product->images) > 0)
                            <button @click="activeImage = (activeImage === totalImages - 1) ? 0 : activeImage + 1"
                                class="absolute right-0 transform -translate-y-1/2 top-1/2 bg-gray-800 text-white p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Text section -->
                <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 sm:mt-0 text-center sm:text-left">
                    <p class="pt-10 md:pt-1 text-teal-500 font-bold text-xl md:text-2xl">Product Description</p>
                    <p class="leading-relaxed text-sm md:text-base lg:text-lg mb-6 whitespace-pre-wrap">{{ $product->productDesc }}</p>

                    <p class="text-teal-500 font-bold text-xl md:text-2xl">Product Features</p>
                    <p class="leading-relaxed text-sm md:text-base lg:text-lg mb-4 whitespace-pre-wrap">{{ $product->productFeatures }}</p>

                    <div class="text-right">
                        <a href="{{ asset('assets/' . $product->filePath) }}" target="_blank" class="inline-flex items-center mt-4 px-5 py-3 bg-teal-500 hover:bg-teal-600 text-white font-bold text-sm md:text-base rounded-lg">
                            Preview Product Brochure
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function carouselData(totalImages) {
        return {
            activeImage: 0,
            totalImages: totalImages,
            startAutoScroll() {
                if (this.totalImages > 0) {
                    setInterval(() => {
                        this.activeImage = (this.activeImage + 1) % this.totalImages;
                    }, 3000); // Change image every 3 seconds
                }
            }
        }
    }
</script>
@endsection

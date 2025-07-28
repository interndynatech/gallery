@extends('layouts.app')

@section('content')
<style>
    /* Add this to your CSS file or within a <style> tag */
    .line-clamp-5 {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
    }
</style>
<div class="bg-[#01B6BE] flex items-center justify-center ">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">
            Products
        </h1>
    </div>
</div>
<div class="container mx-auto p-4">
    <!-- Search and Filter Section -->
    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md col-span-4 md:col-span-1">
            <form method="GET" action="{{ route('products') }}">
                <!-- Filter Section -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Filter</h2>
                    <h3 class="text-md font-semibold border-b border-gray-200 pb-2 mb-4">Category</h3>
                    <ul>
                        @foreach($categories as $category)
                        <li class="bg-teal-500 py-2 px-4 mb-2 rounded-lg flex items-center">
                            <input type="checkbox" name="category[]" value="{{ $category }}"
                                {{ in_array($category, request('category', [])) ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-teal-600 rounded-lg border-gray-300 focus:ring-teal-500 mr-3">
                            <span class="text-white">{{ $category }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <!-- Teal "Apply Filter" Button -->
                    <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg mt-4">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 col-span-4 md:col-span-3">
            @foreach($products as $product)
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col">
                <img src="{{ asset('assets/' . $product->imagePath) }}" alt="{{ $product->productName }}" class="w-full h-100 object-cover rounded-lg mb-4">

                <div class="flex-grow">
                    <h3 class="text-lg font-semibold mb-2">{{ $product->productName }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-5">{{ $product->productDesc }}</p>
                </div>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('productsDetails', ['id' => $product->productId]) }}" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-full flex items-center">
                        <span class="mr-2">View</span>
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M12.293 9H3a1 1 0 100 2h9.293l-3.293 3.293a1 1 0 001.414 1.414l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L12.293 9z" />
                        </svg>
                    </a>
                  
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        {{ $products->links() }}
    </div>
</div>


@endsection
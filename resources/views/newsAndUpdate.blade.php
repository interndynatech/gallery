@extends('layouts.app')

@section('content')
<div class="bg-[#01B6BE] flex items-center justify-center">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">
            News And Updates
        </h1>
    </div>
</div>

<section>
    <div class="container my-12 mx-auto px-4 md:px-12">
        <div class="flex flex-wrap -mx-1 lg:-mx-4">

            @foreach($news as $newsItem)
                @if($newsItem->status == 1)  <!-- Display only if status is 1 -->

                @php
                // Find the corresponding image for the current news item
                $image = $newsimage->firstWhere('newsId', $newsItem->newsId);
                @endphp

                <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                    <article class="overflow-hidden rounded-lg shadow-lg">
                        <a href="{{ route('newsAndUpdateDetails', ['id' => $newsItem->newsId]) }}">
                            @if ($image)
                            <img alt="{{ $newsItem->title }}" class="block w-full h-60 object-cover" src="{{ asset('assets/images/news/' . $image->imagePath) }}">
                            @else
                            <img alt="{{ $newsItem->title }}" class="block w-full h-60 object-cover" src="{{ asset('assets/images/news/default.jpg') }}">
                            @endif
                        </a>

                        <div class="md:px-5 px-3 pb-7">
                            <header class="flex items-center justify-between leading-tight pt-4">
                                <h1 class="text-xl">
                                    <a class="no-underline hover:underline text-teal-500 font-bold" href="{{ route('newsAndUpdateDetails', ['id' => $newsItem->newsId]) }}">
                                        {{ $newsItem->title }}
                                    </a>
                                </h1>
                                <p class="text-grey-darker font-semibold text-sm md:pr-5">
                                    {{ \Carbon\Carbon::parse($newsItem->dateCreated)->format('d/m/y') }}
                                </p>
                            </header>
                            <div class="text-mflex items-center justify-between leading-tight py-4">
                                <a class="no-underline text-black" href="{{ route('newsAndUpdateDetails', ['id' => $newsItem->newsId]) }}">
                                    {{ $newsItem->introContent }}
                                </a>
                            </div>
                            <div class="flex justify-end pt-4">
                                <a href="{{ route('newsAndUpdateDetails', ['id' => $newsItem->newsId]) }}" class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 focus:outline-none focus:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                                    Read More
                                    <svg class="w-4 h-4 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                @endif
            @endforeach

        </div>
    </div>
</section>

@endsection

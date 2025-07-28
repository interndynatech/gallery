@extends('layouts.app')
@section('title', $pageTitle)

@section('content')

<style>
    .scrolling-wrapper {
        overflow: hidden;
        display: flex;
        justify-content: center;
    }

    .scrolling-content {
        display: flex;
        animation: scroll 15s linear infinite;
        width: max-content;
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .image-container {
        width: 100px;
        height: 100px;
        position: relative;
        flex-shrink: 0;
        margin-right: 16px;
    }

    @media (min-width: 640px) {
        .image-container {
            width: 100px;
            height: 100px;
        }
    }

    @media (min-width: 1024px) {
        .image-container {
            width: 200px;
            height: 200px;
        }
    }

    .image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

{{-- Hero Section --}}
<div class="bg-[#01B6BE] flex items-center justify-center">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">Main Projects</h1>
    </div>
</div>

{{-- Project Cards --}}
<section class="bg-white">
    <div class="container mx-auto max-w-7xl px-6 py-16">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-10 mt-12">
            @foreach($projects as $project)
                <div class="relative bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 p-8 text-center">
                    
                    {{-- Gambar Ikon --}}
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('assets/images/favicon/traffic-light.png') }}" 
                             alt="Traffic Light Icon" 
                             class="w-24 h-24 object-contain">
                    </div>

                    {{-- Tajuk Projek --}}
                    <h2 class="text-2xl font-bold text-teal-700 mb-4 uppercase tracking-wide">
                        {{ $project->title }}
                    </h2>

                    {{-- Butang --}}
                    <a href="{{ route('projectGroupDetails', ['title' => urlencode($project->title)]) }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                        See Projects
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- Clients Section --}}
<section class="bg-[#01B6BE]">
    <div class="container px-6 pt-10 mx-auto">
        <div class="container px-6 mx-auto text-center">
            <h1 class="text-3xl font-bold text-white md:text-5xl">Our Clients</h1>
        </div>
        <p class="max-w-6xl py-10 mx-auto mt-6 text-center text-white">
            At DynaTech Sdn Bhd, we are proud to serve a diverse range of clients, including leading contractors and city councils. Our solutions are designed to meet the unique needs of urban development, traffic management, and public safety.
        </p>
    </div>

    {{-- Stats Section --}}
    <div class="relative pb-7">
        <div class="relative max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <dl class="bg-white rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                    <div class="flex flex-col p-6 text-center border-b border-gray-100 sm:border-0 sm:border-r">
                        <dt class="order-2 mt-2 text-lg font-medium leading-6 text-teal-500">Traffic Lights Installed</dt>
                        <dd class="order-1 text-5xl font-extrabold leading-none text-teal-500" id="starsCount">0</dd>
                    </div>
                    <div class="flex flex-col p-6 text-center border-t border-b border-gray-100 sm:border-0 sm:border-l sm:border-r">
                        <dt class="order-2 mt-2 text-lg font-medium leading-6 text-teal-500">In Business Since</dt>
                        <dd class="order-1 text-5xl font-extrabold leading-none text-teal-500" id="downloadsCount">0</dd>
                    </div>
                    <div class="flex flex-col p-6 text-center border-t border-gray-100 sm:border-0 sm:border-l">
                        <dt class="order-2 mt-2 text-lg font-medium leading-6 text-teal-500">Clients</dt>
                        <dd class="order-1 text-5xl font-extrabold leading-none text-teal-500" id="sponsorsCount">0</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</section>

{{-- City Council Clients --}}
<section class="text-gray-600 body-font">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-center py-10">
            <p class="p-4 text-2xl md:text-4xl text-gray-600 border-[#01B6BE] border-b-8 font-bold">City Councils</p>
        </div>
    </div>
    <div class="container px-5 py-10 mx-auto overflow-hidden">
        <div class="scrolling-wrapper">
            <div class="scrolling-content">
                @foreach($clients as $client)
                    @if(isset($client->clientType) && $client->clientType == 'cityCouncil' && isset($client->active) && $client->active == 1)
                    <div class="p-4">
                        <div class="h-full flex flex-col items-center text-center">
                            <div class="image-container mb-4">
                                <img alt="{{ $client->clientName }}" class="rounded-lg object-cover object-center"
                                    src="{{ asset($client->imagePath ? 'assets/images/clients/' . $client->imagePath : 'assets/images/default/default-client-image.png') }}">
                            </div>
                            <div class="w-full">
                                <h2 class="title-font font-medium text-m text-gray-900">{{ $client->clientName }}</h2>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Contractor Clients --}}
<div class="flex items-center justify-center pb-4">
    <p class="p-4 text-2xl md:text-4xl text-gray-600 border-[#01B6BE] border-b-8 font-bold">Contractors</p>
</div>
<div class="pb-10 grid grid-cols-3 md:grid-cols-6 gap-4 md:px-24 px-4 mx-auto">
    @foreach($clients as $client)
        @if(isset($client->clientType) && $client->clientType == 'contractor' && isset($client->active) && $client->active == 1)
        <div class="aspect-w-1 aspect-h-1">
            <img class="border-2 border-gray-50 object-cover w-48 h-48 rounded-lg"
                src="{{ asset($client->imagePath ? 'assets/images/clients/' . $client->imagePath : 'assets/images/default/default.png') }}"
                alt="{{ $client->clientName }}">
        </div>
        @endif
    @endforeach
</div>

{{-- Count Animation Script --}}
<script>
    const targets = [
        { element: document.getElementById('starsCount'), count: 1500, suffix: '+' },
        { element: document.getElementById('downloadsCount'), count: 2012, suffix: '' },
        { element: document.getElementById('sponsorsCount'), count: 100, suffix: '+' }
    ];

    const maxCount = Math.max(...targets.map(target => target.count));

    function animateCountUp(target, duration) {
        let currentCount = 0;
        const increment = Math.ceil(target.count / (duration / 10));
        const interval = setInterval(() => {
            currentCount += increment;
            if (currentCount >= target.count) {
                clearInterval(interval);
                currentCount = target.count;
                target.element.textContent = currentCount + target.suffix;
            } else {
                target.element.textContent = currentCount;
            }
        }, 10);
    }

    targets.forEach(target => {
        animateCountUp(target, maxCount / 100);
    });
</script>

@endsection

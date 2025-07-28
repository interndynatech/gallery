@extends('layouts.app')
@section('title', ucfirst($type) . ' Clients')

@section('content')
<!-- Banner Section -->
<section class="bg-[#01B6BE] py-16 text-white text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold uppercase">{{ strtoupper($type) }} Clients</h1>
        <p class="mt-2 text-lg">Select a client to view their {{ strtolower($type) }} gallery</p>
    </div>
</section>

<!-- Clients Grid Section -->
<section class="bg-white">
    <div class="container mx-auto max-w-7xl px-6 py-16">
        @if($clients->isEmpty())
            <!-- Display if no clients -->
            <div class="text-center py-16">
                <img src="{{ asset('assets/images/favicon/error.png') }}" class="mx-auto w-28 opacity-60 mb-4" alt="No Clients">
                <p class="text-gray-500">No clients available for {{ $type }} gallery.</p>
            </div>
        @else
            <!-- Grid of client cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 mt-8">
                @foreach($clients as $client)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300 p-6 text-center">
                        
                        <!-- Client Icon -->
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('assets/images/favicon/picture.png') }}" 
                                 alt="Client Icon" 
                                 class="w-24 h-24 object-contain hover:scale-105 transition-transform duration-300">
                        </div>

                        <!-- Client Name -->
                        <h2 class="text-lg font-bold text-[#01B6BE] uppercase trackinzg-wide mb-3">
                            {{ $client->clientName }}
                        </h2><br>

                        <!-- View Gallery Button -->
                        <a href="{{ route('clientGallery.client', ['type' => $type, 'client_id' => $client->clientId]) }}"
                           class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-5 rounded-full transition duration-300">
                            <i class="fas fa-images mr-2"></i> View Gallery
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

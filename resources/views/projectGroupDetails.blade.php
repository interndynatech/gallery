<!--  new 2025-->
@extends('layouts.app')
@section('title', $pageTitle)

@section('content')

{{-- Banner --}}
<section class="bg-[#01B6BE]">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">{{ $pageTitle }}</h1>
        <p class="text-white mt-4 text-lg">Explore all projects under "{{ $projectTitle }}"</p>
    </div>
</section>

{{-- Main Content --}}
<section class="bg-white py-16">
    <div class="container mx-auto px-4">

        {{-- Filter + Search + Back --}}
        <div class="mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            
            {{-- Left: Filter + Search in one row --}}
            <div class="flex flex-col md:flex-row md:items-center gap-4 w-full md:w-2/3">
                {{-- Filter Dropdown --}}
                <div class="w-full md:w-auto">
                    <label for="filterLocation" class="font-semibold text-gray-700 mr-2">Filter by Location:</label>
                    <select id="filterLocation" class="border border-gray-300 px-4 py-2 rounded-md w-full md:w-auto">
                        <option value="all">All</option>
                        @foreach($projects->pluck('introContent')->unique() as $location)
                            <option value="{{ $location }}">{{ strtoupper($location) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Search Bar --}}
                <div class="relative w-full md:w-1/2">
                    <input type="text" id="searchInput" placeholder="Search by location..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                </div>
            </div>

           {{-- Right: Back Button --}}
            <div class="flex justify-end w-full md:w-auto">
                <a href="{{ route('projects') }}"
                    class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded w-full md:w-auto text-center">
                    ← Back to Projects
                </a>
            </div>
        </div>


        {{-- Projects Grid --}}
        <div id="projectGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
            <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition duration-300 p-6 relative">
                {{-- Project Image --}}
                @if($project->imagePath)
                 <img src="{{ asset('assets/images/mainProjects/' . $project->imagePath) }}" 
                    alt="Project Image"
                    class="w-full object-contain rounded mb-4">
                @endif

                {{-- Intro Content (Uppercase) --}}
                <h3 class="text-lg font-bold text-teal-700 uppercase mb-2">
                    {{ $project->introContent ?? 'NO INTRO AVAILABLE' }}
                </h3>

                {{-- Description Area --}}
                <p id="desc-{{ $loop->index }}" class="text-gray-600 mb-4 line-clamp-2">
                    {{ Str::limit($project->desc, 100) }}
                </p>

                {{-- Full Description Hidden in Data Attribute --}}
                <button type="button"
                    class="mt-2 px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500"
                    data-full="{{ $project->desc }}"
                    onclick="toggleDesc({{ $loop->index }}, this)">
                    See More
            </button>
            </div>
            @endforeach
        </div>

         {{-- Pagination Links --}}
        <div class="mt-10 flex justify-center">
            {{ $projects->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</section>

{{-- Clamp Style --}}
@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush


{{-- Script --}}
<script>
    const originalText = {};

    function toggleDesc(index, button) {
        const desc = document.getElementById('desc-' + index);

        // Simpan teks asal kalau belum disimpan
        if (!originalText[index]) {
            originalText[index] = desc.innerText;
        }

        const fullText = button.getAttribute('data-full');

        if (desc.classList.contains('line-clamp-2')) {
            desc.classList.remove('line-clamp-2');
            desc.innerText = fullText;
            button.innerText = 'See Less';
        } else {
            desc.classList.add('line-clamp-2');
            desc.innerText = originalText[index];
            button.innerText = 'See More';
        }
    }

    // Search
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        const cards = document.querySelectorAll('#projectGrid > div');

        cards.forEach((card, i) => {
            const intro = card.querySelector('h3').textContent.toLowerCase();
            const desc = card.querySelector('#desc-preview-' + i)?.textContent.toLowerCase();
            if (intro.includes(keyword) || (desc && desc.includes(keyword))) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter
    document.getElementById('filterLocation').addEventListener('change', function () {
        const selected = this.value.toLowerCase();
        const cards = document.querySelectorAll('#projectGrid > div');

        cards.forEach(card => {
            const intro = card.querySelector('h3').textContent.toLowerCase();
            if (selected === 'all' || intro.includes(selected)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection

@extends('layouts.app')
@section('title', $pageTitle)

@section('content')

<div class="font-[sans-serif] bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-y-10 md:grid-cols-2 gap-x-12 items-center"> <!-- items-center centers the text -->
            <!-- Image Section -->
            <div class="text-right">
                <div class="aspect-w-1 aspect-h-1 lg:w-10/12 w-full mx-auto py-12">
                    <img src="{{ $project->imagePath ? asset('assets/images/mainProjects/' . $project->imagePath) : asset('assets/images/default/default.png') }}"
                        alt="{{ $project->title }}"
                        class="object-cover rounded-lg" />
                </div>
            </div>
            <!-- Text Section -->
            <div class="flex flex-col justify-center">
                <h2 class="text-teal-500 text-4xl font-bold mb-6 text-center lg:text-left">{{ $project->title }}</h2>
                <p class="text-base font-semibold text-gray-500 mb-4 text-center lg:text-left">
                    {{ $project->introContent }}
                </p>
                <p class="text-base text-gray-500 text-center lg:text-left">
                    {!! nl2br(e($project->desc)) !!}
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
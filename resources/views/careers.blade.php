@extends('layouts.app')

@section('content')

<div class="bg-[#01B6BE] flex items-center justify-center">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">
            Careers
        </h1>
    </div>
</div>

<section class="bg-white">
    <div class="container px-6 py-10 mx-auto">
        <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2">
            @foreach ($careers as $career)
            <div class="flex flex-col lg:flex-row items-center lg:items-start justify-center lg:justify-start gap-6 lg:gap-8">
                <img class="object-cover w-full h-56 rounded-lg lg:w-64 pt-7"
                    src="{{ $career->imagePath ? asset('assets/images/career/' . $career->imagePath) : asset('assets/images/default/job-default.png') }}"
                    alt="{{ $career->title }}">

                <div class="flex flex-col px-4 py-4 text-center lg:text-left">
                    <a href="#" class="text-2xl font-bold text-gray-800">
                        {{ $career->title }}
                    </a>
                    <a href="#" class="mt-5 italic text-lg font-semibold text-teal-500">
                        {{ $career->position }}
                    </a>

                    <p class="text-gray-600 whitespace-pre-line">
                        {{ $career->description }}
                    </p>
                   
                    <a href="{{ route('careersApply', ['id' => $career->careerId]) }}" class="mt-4 px-8 py-2 bg-yellow-400 text-white rounded-full hover:bg-yellow-500 text-center w-max mx-auto lg:mx-0">
                        Apply Now >>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
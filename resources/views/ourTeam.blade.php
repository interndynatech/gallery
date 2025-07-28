@extends('layouts.app')

@section('content')
    <div class="py-5"></div>
    <div class="flex flex-wrap justify-center items-center">
        @foreach($orgchart as $chart)
            <div class="p-4 flex justify-center items-center">
                <img src="{{ asset('assets/' . $chart->imagePath) }}" alt="Organizational Chart" class="max-w-full h-auto md:w-1/2">
            </div>
        @endforeach
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="bg-[#01B6BE] flex items-center justify-center">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">
            Documents Catalogue
        </h1>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($documents as $document)
        <div class="bg-white shadow-lg rounded-lg p-6">
            {{-- Flexbox to align icon, document name, and download button in one row --}}
            <div class="flex items-center justify-between">
                {{-- Check file extension --}}
                @php
                    $extension = pathinfo($document->filePath, PATHINFO_EXTENSION);
                @endphp

                @if($extension == 'pdf')
                    {{-- Show PDF icon --}}
                    <img src="{{ asset('assets/images/files-type/pdf.png') }}" alt="PDF" class="w-10 h-10">
                @elseif($extension == 'doc' || $extension == 'docx')
                    {{-- Show Word icon --}}
                    <img src="{{ asset('assets/images/files-type/word.png') }}" alt="Word" class="w-10 h-10">
                @else
                    {{-- Default icon for other file types --}}
                    <img src="{{ asset('assets/images/files-type/file.png') }}" alt="File" class="w-10 h-10">
                @endif

                {{-- Display Document Name --}}
                <h2 class="text-lg font-semibold text-gray-800 flex-1 px-4">
                    {{ $document->docName }}
                </h2>

                {{-- Show download button --}}
                <a href="{{ asset($document->filePath) }}" target="_blank" class="inline-block bg-teal-500 text-white px-4 py-2 rounded-lg">
                    Download
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

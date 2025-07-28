@extends('layouts.app')

@section('content')
<div class="bg-[#01B6BE] flex items-center justify-center ">
    <div class="container px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-bold text-white md:text-5xl">
            About Us
        </h1>
    </div>
</div>
<section>
    <div class="relative mx-auto max-w-7xl">

        <div class="grid max-w-lg gap-6 mx-auto mt-8 lg:grid-cols-3 lg:max-w-none">

            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/company.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Company Overview</h3>
                        <p class="text-sm font-normal text-gray-500">Dynamic Traffic System Sdn Bhd, established in 2012, specializes in the design and manufacturing of traffic management products, including traffic light controllers and related systems.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/specialization.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Core Specialization</h3>
                        <p class="text-sm font-normal text-gray-500">Since 2012, the company has focused on traffic light products, expanding its range to include advanced technologies such as Internet of Things (IoT) solutions, RF Greenwave Link, and RF Countdown systems.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/product.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Product Installation</h3>
                        <p class="text-sm font-normal text-gray-500">Over 1500 traffic light controllers have been successfully installed across the nation, demonstrating the company's substantial market presence and reliability.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-8 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/experience.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Vision & Experience</h3>
                        <p class="text-sm font-normal text-gray-500">With extensive experience in the industry, Dynamic Traffic System Sdn Bhd is well-positioned to guide clients through future developments in traffic management technologies.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/quality.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Commitment to Quality</h3>
                        <p class="text-sm font-normal text-gray-500">The company is dedicated to becoming a trusted local brand by delivering efficient and high-quality traffic systems that benefit both customers and the public.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/about-us/network.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Collaborative Network</h3>
                        <p class="text-sm font-normal text-gray-500">Leveraging a broad partner network, Dynamic Traffic System Sdn Bhd enhances its technological capabilities and fosters collaboration to drive innovation and technology independence.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-[#01B6BE] text-gray-600 body-font">
    <div class="container px-5 py-5 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            <div class="flex flex-col sm:flex-row">
                <div class="">
                    <img class=" w-full h-50 rounded-xl" src="{{asset('assets/images/about-us/visions.svg')}}" alt="">
                </div>
                <div class="px-6">
                    <h2 class="font-bold title-font mt-4 text-white text-2xl md:text-4xl md:py-12">Our Vision</h2>
                    <p class="leading-relaxed text-lg mb-4 text-white">At Dynamic Traffic System Sdn Bhd, our vision is to be the best manufacturer company in the eyes of our clients, communities and people. We expect and demand the best we have to offer by always keeping DYNA ‘s values top of mind.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="relative mx-auto max-w-7xl">
        <div class="flex items-center justify-center py-5">
            <p class="p-4 text-2xl md:text-4xl text-gray-600 border-[#01B6BE] border-b-8 font-bold">Our Mission</p>
        </div>
        <div class="flex items-center justify-center text-center md:px-20 px-10">
            <p class="text-gray-600 text-lg">
                Our mission is to maximize each client’s competitive position by providing innovative solutions and value
                <br class="hidden md:block">added services in a way that exceeds their quality expectations.
            </p>
        </div>

        <div class="grid max-w-lg gap-6 mx-auto mt-8 lg:grid-cols-3 lg:max-w-none">

            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-full h-56 rounded-lg" src="{{asset('assets/images/about-us/innovative.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Innovative Designs </h3>
                        <p class="text-sm font-normal text-gray-500">Revolution product designs and technologies are fundamental to our continuous development in the field of Science and Traffic.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-full h-56 rounded-lg" src="{{asset('assets/images/about-us/partnership.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Global Partnerships</h3>
                        <p class="text-sm font-normal text-gray-500">Our carefully selected global partners expand our reach, improve our supply chain and better service customer worldwide.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-coverw-full h-56 rounded-lg" src="{{asset('assets/images/about-us/manufacturer.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Trusted Manufacturer</h3>
                        <p class="text-sm font-normal text-gray-500">Recognizing our role as trusted manufacturer, we take the time to listen and respond to our customer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="mx-auto max-w-auto">
    <div class="space-y-6 bg-[#01B6BE] md:p-8 p-2">
        <div class="flex justify-center md:py-4 pt-4">
            <p class="text-4xl text-white font-bold">Our Achievements</p>
        </div>
        <div class="p-6 max-w-7xl space-y-6 items-center mx-auto">
            @foreach ($categories as $category)
            <details class="group rounded-xl bg-white shadow-[0_10px_100px_10px_rgba(0,0,0,0.05)]">
                <summary class="flex cursor-pointer list-none items-center justify-between p-2 md:p-4 md:text-lg text-sm font-medium text-secondary-900">
                    {{ $category->categoriesTitle }}
                    <div class="text-secondary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block h-5 w-5 transition-all duration-300 group-open:-rotate-90">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </summary>
                <div class="px-6 pb-6 text-secondary-500">
                    <div class="overflow-x-auto space-x-4 flex">
                        @foreach ($images as $image)
                        @if ($image->categoriesId == $category->categoriesId)
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/images/achievements/'  . $image->imagePath) }}" alt="{{ $image->imagePath }}" class="object-contain max-w-full max-h-60">
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </details>
            @endforeach
        </div>
    </div>
</div>



@endsection
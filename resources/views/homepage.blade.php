@extends('layouts.app')

@section('content')
<style>
    /* Add this to your CSS file or within a <style> block */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

</style>
<div class="bg-[#01B6BE] flex items-center justify-center ">
    <div class="container px-6 py-16 max-w-7xl">
        <div class="items-center lg:flex">
            <div class="w-full lg:w-1/2">
                <div class="lg:max-w-lg">
                    <h1 class="text-3xl font-bold text-white md:text-7xl">Navigate <br> The Future</h1>
                    <p class="mt-5 text-white">Dynamic Traffic System Sdn Bhd is privately owned Malaysian which focuses on and is committed to the development of traffic light products.</p>
                    <button
                        class="mt-2 md:mt-5 align-middle select-none font-sans font-semibold text-center transition-all disabled:opacity-50 text-m py-3 px-6 bg-[#FECA08] text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none rounded-full"
                        type="button"
                        onclick="window.location.href='{{ route('about-us') }}';">
                        <h1 class="px-6">Learn More</h1>
                    </button>

                </div>
            </div>

            <div class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-1/2">
                <img class="w-full h-full lg:max-w-3xl" src="{{asset('assets/images/homepage/cover-hg.jpg')}}" alt="cover">
            </div>
        </div>
    </div>
</div>

<section>
    <div class="relative mx-auto max-w-7xl">
        <div class="flex items-center justify-center py-5">
            <p class="p-4 text-2xl md:text-4xl text-gray-600 border-[#01B6BE] border-b-8 font-bold">Our Services</p>
        </div>

        <div class="grid max-w-lg gap-6 mx-auto mt-8 lg:grid-cols-3 lg:max-w-none">
            <div class="flex flex-col items-center mb-8 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/custom.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Custom Traffic Light Solutions</h3>
                        <p class="text-sm font-normal text-gray-500">We create custom traffic management systems tailored to the needs of cities, highways, and private sites, working closely with you to find the ideal solution.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/installation.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Installation & Setup</h3>
                        <p class="text-sm font-normal text-gray-500">Our expert technicians ensure seamless traffic light installation and configuration, handling everything from site assessment to final implementation for a hassle-free process.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/support.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">24/7 Technical Support</h3>
                        <p class="text-sm font-normal text-gray-500">We provide 24/7 support to quickly address any traffic light issues, minimizing downtime and ensuring smooth operation.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/repair.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Maintenance & Repairs</h3>
                        <p class="text-sm font-normal text-gray-500">Regular maintenance keeps your traffic lights performing optimally. We provide thorough maintenance plans and prompt repairs for lasting reliability.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/upgrade.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">System Upgrades</h3>
                        <p class="text-sm font-normal text-gray-500">We offer system upgrades to keep your traffic lights updated with the latest technology, including smart controls and energy-efficient LEDs.</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center mb-12 overflow-hidden cursor-pointer">
                <div class="flex-shrink-0">
                    <img class="object-cover w-20 h-20 rounded-lg" src="{{asset('assets/images/homepage/6.svg')}}" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 items-center text-center">
                    <div class="flex flex-col items-center mt-2 space-y-3 text-center px-8">
                        <h3 class="text-2xl font-semibold text-gray-700">Training & Consultation</h3>
                        <p class="text-sm font-normal text-gray-500">Our experts offer training on operating, maintaining, and troubleshooting traffic systems, along with consultation to optimize traffic flow and product use.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="bg-[#01B6BE] py-12 px-4 text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
        <div class="text-left">
            <h2 class="text-3xl font-bold">Our Products</h2>
            <p class="mt-6">
                Illuminate the future of traffic management with Dynamic Traffic System’s advanced solutions. Our innovative traffic light controllers and cutting-edge IoT technologies are designed to enhance road safety and efficiency, ensuring smarter and more connected urban environments.
            </p>
            <a href="{{route('products')}}" class="mt-6 inline-block bg-[#FECA08] text-white px-6 py-2 rounded-full font-semibold">See More >></a>
        </div>

        <div class="col-span-2 overflow-x-auto">
            <div class="flex space-x-8 min-w-max">
                @foreach($products as $product)
                <div class="bg-white p-6 rounded-lg shadow-lg text-center" style="width: 250px;">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('assets/' . $product->imagePath) }}" alt="{{ $product->productName }}" class="w-32 h-32 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-black">{{ $product->productName }}</h3>
                    <p class="text-xs text-gray-600 text-center mt-2 line-clamp-3">{{ $product->productDesc }}</p>
                    <a href="{{route('products')}}" class="mt-6 inline-block bg-[#D10713] text-white px-4 py-2 rounded-full">See Product</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- <section class="bg-white">
    <div class="container px-6 py-10 mx-auto">
    <div class="flex items-center justify-center py-5">
            <p class="p-4 text-2xl md:text-3xl text-gray-600 border-[#01B6BE] border-b-8 font-bold">Feedback From Our Clients</p>
        </div>
      
        <section class="grid grid-cols-1 gap-8 mt-8 xl:mt-12 lg:grid-cols-2 xl:grid-cols-3">
            <div class="p-8 border rounded-lg ">
                <p class="leading-loose text-gray-500 ">
                    “Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quibusdam ducimus libero ad
                    tempora doloribus expedita laborum saepe voluptas perferendis delectus assumenda rerum, culpa
                    aperiam dolorum, obcaecati corrupti aspernatur a.”.
                </p>

                <div class="flex items-center mt-8 -mx-2">
                    <img class="object-cover mx-2 rounded-full w-14 shrink-0 h-14 ring-4 ring-gray-300 " src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80" alt="">

                    <div class="mx-2">
                        <h1 class="font-semibold text-gray-800 ">Robert</h1>
                        <span class="text-sm text-gray-500">CTO, Robert Consultency</span>
                    </div>
                </div>
            </div>

            <div class="p-8 border rounded-lg ">
                <p class="leading-loose text-gray-500 ">
                    “Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quibusdam ducimus libero ad
                    tempora doloribus expedita laborum saepe voluptas perferendis delectus assumenda rerum, culpa
                    aperiam dolorum, obcaecati corrupti aspernatur a.”.
                </p>

                <div class="flex items-center mt-8 -mx-2">
                    <img class="object-cover mx-2 rounded-full w-14 shrink-0 h-14 ring-4 ring-gray-300 " src="https://images.unsplash.com/photo-1531590878845-12627191e687?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="">

                    <div class="mx-2">
                        <h1 class="font-semibold text-gray-800 ">Jeny Doe</h1>
                        <span class="text-sm text-gray-500">CEO, Jeny Consultency</span>
                    </div>
                </div>
            </div>

            <div class="p-8 border rounded-lg ">
                <p class="leading-loose text-gray-500 ">
                    “Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore quibusdam ducimus libero ad
                    tempora doloribus expedita laborum saepe voluptas perferendis delectus assumenda rerum, culpa
                    aperiam dolorum, obcaecati corrupti aspernatur a.”.
                </p>

                <div class="flex items-center mt-8 -mx-2">
                    <img class="object-cover mx-2 rounded-full w-14 shrink-0 h-14 ring-4 ring-gray-300 " src="https://images.unsplash.com/photo-1488508872907-592763824245?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" alt="">

                    <div class="mx-2">
                        <h1 class="font-semibold text-gray-800 ">Ema Watson </h1>
                        <span class="text-sm text-gray-500">Marketing Manager at Stech</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section> -->






@endsection
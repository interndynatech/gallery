<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ isset($metaDescription) ? $metaDescription : config('app.name', 'DynaTech') }}">
    <meta name="robots" content="follow, index">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/images/favicon/site.webmanifest')}}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>{{ isset($pageTitle) ? $pageTitle : '' . config('app.name', 'DynaTech') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    @push('styles')
<style>
    /* Masonry Custom CSS */
.grid-masonry {
    display: grid;
    grid-gap: 30px;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    grid-auto-rows: 150px;
    grid-auto-flow: row dense;
}

.item-masonry {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    background-size: cover;
    background-position: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

.item-masonry:hover {
    transform: scale(1.03);
}

.item-masonry-details {
    position: relative;
    z-index: 1;
    padding: 15px;
    background: rgba(255,255,255,0.85);
    font-size: 14px;
    color: #333;
}
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #b8b8b8;
        border-radius: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
@endpush

</head>

<body class="font-sans antialiased">
    
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NCZ286GZ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div class="min-h-screen bg-gray-50 ">
        <nav x-data="{ isOpen: false }" class="sticky top-0 z-50 bg-gray-50 shadow">
            <div class="container mx-auto py-4 px-4 md:px-2 md:flex md:items-center md:justify-between">
                <div class="flex items-center justify-between">
                    <a href="">
                        <img class="h-8 w-auto sm:h-14" src="{{asset('assets/images/svg-dyna-logo.svg')}}" alt="Skynet Logo">
                    </a>

                    <!-- Mobile menu button -->
                    <div class="flex lg:hidden">
                        <button @click="isOpen = !isOpen" type="button" class="text-gray-500 hover:text-gray-600 focus:text-gray-600 focus:outline-none" aria-label="toggle menu">
                            <!-- Icon when menu is closed. -->
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>

                            <!-- Icon when menu is open. -->
                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div :class="isOpen ? 'block' : 'hidden'" class="absolute inset-x-0 z-20 h-[100vh] w-full bg-white py-4 transition-all duration-300 ease-in-out sm:h-0 md:relative md:top-0 md:mt-0 md:flex md:w-auto md:translate-x-0 md:items-center md:bg-transparent md:p-0">
                    <div class="flex flex-col md:mx-6 md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                        <!-- Dashboard link -->
                        <a href="{{ route('home-page') }}"
                            class="p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('home-page')) text-teal-500 border-b-4 border-teal-500 @endif">
                            Homepage
                        </a>
                        <a href="{{ route('products') }}"
                            class="p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('products')) text-teal-500 border-b-4 border-teal-500 @endif">
                            Products
                        </a>
                        <a href="{{ route('projects') }}"
                            class="p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('projects')) text-teal-500 border-b-4 border-teal-500 @endif">
                            Projects
                        </a>

                        <!-- Gallery Menu -->
                        <div class="relative" x-data="{ isOpen: false }">
                            <!-- Main Link -->
                            <button @click="isOpen = !isOpen"
                                class="p-2 pr-3 font-semibold text-gray-700 flex items-center focus:outline-none"
                                :class="{'text-teal-500 border-b-4 border-teal-500': isOpen }">
                                Gallery
                                <svg class="ml-1 h-4 w-4 transform" :class="{ 'rotate-180': isOpen }" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown content -->
                            <div x-show="isOpen" @click.away="isOpen = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-b z-50">

                                <!-- Training -->
                                <a href="{{ route('clientGallery', ['type' => 'training']) }}"
                                    class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 font-semibold">
                                    Training
                                </a>

                                <!-- Exhibition -->
                                <a href="{{ route('clientGallery', ['type' => 'exhibition']) }}"
                                    class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 font-semibold">
                                    Exhibition
                                </a>

                                <!-- Visit -->
                                <a href="{{ route('clientGallery', ['type' => 'visit']) }}"
                                    class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 font-semibold">
                                    Visit
                                </a>
                                </div>
                            </div>

                            <!-- About Us Dropdown -->
                            <div x-data="{ isOpen: false }" class="relative inline-block">
                                <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                                    class="flex items-center p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('our-team') || request()->routeIs('about-us')) || request()->routeIs('documents'))
                                    text-teal-500 border-b-4 border-teal-500 
                                @endif">
                                    About Us
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-2 fill-current transition-colors duration-300"
                                        viewBox="0 0 24 24">
                                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                                    </svg>
                                </button>


                            <!-- Dropdown content -->
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-90"
                                class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-b transition-opacity duration-300 opacity-100 z-10">
                                <!-- Achievements link -->
                                <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                    <a href="{{ route('about-us') }}"
                                        class="font-semibold @if (request()->routeIs('about-us')) text-teal-500 border-teal-500 @endif">
                                        About Us
                                    </a>
                                </div>
                                <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                    <a href="{{ route('our-team') }}"
                                        class="font-semibold @if (request()->is('our-team')) text-teal-500 border-teal-500 @endif">
                                        Organizational Chart
                                    </a>
                                </div>
                                <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                    <a href="{{ route('documents') }}"
                                        class="font-semibold @if (request()->routeIs('documents')) text-teal-500 border-teal-500 @endif">
                                        Documents Catalogue
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div x-data="{ isOpen: false }" class="relative inline-block">
                            <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                                class="flex items-center p-2 pr-3 font-semibold text-gray-700 
                                @if (request()->routeIs('contactUs') || request()->routeIs('newsAndUpdate') || request()->routeIs('careers')) || request()->routeIs('careersApply'))
                                    text-teal-500 border-b-4 border-teal-500 
                                @endif">
                                Contact Us
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-2 fill-current transition-colors duration-300"
                                    viewBox="0 0 24 24">
                                    <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                                </svg>
                            </button>

                        <!-- Dropdown content -->
                        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-b transition-opacity duration-300 opacity-100 z-10">
                            <!-- Contact Us link -->
                            <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                <a href="{{ route('contactUs') }}"
                                    class="font-semibold 
                                    @if (request()->routeIs('contactUs'))
                                        text-teal-500 
                                    @endif">
                                    Contact Us
                                </a>
                            </div>
                            <!-- News & Update link -->
                            <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                <a href="{{ route('newsAndUpdate') }}"
                                    class="font-semibold 
                                    @if (request()->routeIs('newsAndUpdate'))
                                        text-teal-500 
                                    @endif">
                                    News & Update
                                </a>
                            </div>
                            <!-- Be Part Of The Team link -->
                            <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                                <a href="{{ route('careers') }}"
                                    class="font-semibold 
                                    @if (request()->routeIs('careers'))
                                        text-teal-500 
                                    @endif">
                                    Be Part Of The Team
                                </a>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="mx-auto bg-white">
            @yield('content')
        </div>

        <footer class="">
            <footer class="bg-gray-50 flex justify-center">
                <div class="mx-auto max-w-auto space-y-8 px-4 py-16 sm:px-6 lg:space-y-16 ">
                    <div class="grid grid-cols-1 gap-20 lg:grid-cols-3">
                        <div>
                            <div class="text-lg font-bold md:py-0 py-4">
                                <img src="{{asset('assets/images/svg-dyna-logo.svg')}}" alt="Logo" class="h-10 md:h-14">
                            </div>

                            <p class="mt-4 max-w-xs text-gray-500 text-xs">
                                Our deep experience gives us a clear and confident vision to help clients navigate the future. The dedication to becoming a trusted brand locally, Dynamic Traffic System Sdn Bhd is committed to deliver highly efficient traffic system for benefit of customer and public.
                            </p>


                        </div>

                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:col-span-2 lg:grid-cols-4">
                            <div>
                                <p class="font-medium text-gray-900">Menu</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="{{ route('home-page') }}" class="text-gray-700 transition hover:opacity-75"> Home </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('products') }}" class="text-gray-700 transition hover:opacity-75"> Products</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('projects') }}" class="text-gray-700 transition hover:opacity-75"> Projects</a>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Company</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="{{ route('about-us') }}" class="text-gray-700 transition hover:opacity-75"> About Us </a>
                                    </li>
                                   

                                    <li>
                                        <a href="{{ route('our-team') }}" class="text-gray-700 transition hover:opacity-75"> Organizational Chart </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('documents') }}" class="text-gray-700 transition hover:opacity-75"> Documents Catalogue </a>
                                    </li>


                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Contact Us</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="{{ route('contactUs') }}" class="text-gray-700 transition hover:opacity-75"> Contact Us </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('newsAndUpdate') }}" class="text-gray-700 transition hover:opacity-75"> News And Update </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('careers') }}" class="text-gray-700 transition hover:opacity-75"> Be Part Of Our Team </a>
                                    </li>

                                </ul>
                            </div>

                            <div>
                                <p class="font-medium text-gray-900">Contact Us</p>

                                <ul class="mt-6 space-y-4 text-sm">
                                    <li>
                                        <a href="https://www.facebook.com/dynamictrafficsystemsdnbhd" class="text-gray-700 transition hover:opacity-75 flex items-center">
                                            <i class="fab fa-facebook-f mr-2 text-black"></i> Facebook
                                        </a>
                                    </li>

                                    <li>
                                        <a href="https://maps.app.goo.gl/3g9Jqk4M4nc2155u6" class="text-gray-700 transition hover:opacity-75 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-black"></i> Location
                                        </a>
                                    </li>

                                    <li>
                                        <a href="mailto:sales@dynasystem.info" class="text-gray-700 transition hover:opacity-75 flex items-center">
                                            <i class="fas fa-envelope mr-2 text-black"></i> Email
                                        </a>
                                    </li>
                                </ul>


                            </div>
                        </div>
                    </div>

                </div>
            </footer>
        </footer>
    </div>

    <script>
        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            var mobileMenu = document.getElementById('mobileMenu');
            var menuIcon = document.getElementById('mobileMenuToggle');

            mobileMenu.classList.toggle('active');
            menuIcon.classList.toggle('active');
        });
    </script>

    @stack('scripts')
</body>
</html>
<nav x-data="{ isOpen: false }" class="sticky top-0 z-50 bg-white shadow">
    <div class="container mx-auto py-4 md:flex md:items-center md:justify-between">
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
                <a href="{{ route('admin.pages.dashboard') }}"
                    class="p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('admin.pages.dashboard')) text-teal-500 border-b-4 border-teal-500 @endif">
                    Dashboard
                </a>

                <!-- Company Profile Dropdown -->
                <div x-data="{ isOpen: false }" class="relative inline-block">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                        class="flex items-center p-2 pr-3 font-semibold text-gray-700 @if (request()->routeIs('admin.pages.achievements') || request()->routeIs('admin.pages.orgchart')) 
                        @endif">
                        Company Profile
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
                            <a href="{{ route('admin.pages.achievements') }}"
                                class="font-semibold @if (request()->routeIs('admin.pages.achievements')) text-teal-500 border-teal-500 @endif">
                                Achievements
                            </a>
                        </div>

                        <!-- Our Team link -->
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.orgchart') }}"
                                class="font-semibold @if (request()->is('admin.pages.orgchart')) text-teal-500 border-teal-500 @endif">
                                Organizational Chart
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isOpen: false }" class="relative inline-block">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                        class="flex items-center p-2 pr-3 font-semibold text-gray-700 
                        @if (request()->routeIs('admin.pages.compProjects') || request()->routeIs('admin.pages.client'))
                            text-teal-500 border-b-4 border-teal-500 
                        @endif">
                        Projects
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
                            <a href="{{ route('admin.pages.compProjects') }}"
                                class="font-semibold @if (request()->routeIs('admin.pages.compProjects')) text-teal-500 border-teal-500 @endif">
                                Main Projects
                            </a>
                        </div>

                        <!-- Our Team link -->
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.clients') }}"
                                class="font-semibold @if (request()->is('admin.pages.clients')) text-teal-500 border-teal-500 @endif">
                                Clients
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isOpen: false }" class="relative inline-block">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                        class="flex items-center p-2 pr-3 font-semibold text-gray-700 
                        @if (request()->routeIs('admin.pages.career') || request()->routeIs('admin.pages.applicants'))
                            text-teal-500 border-b-4 border-teal-500 
                        @endif">
                        Careers
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
                            <a href="{{ route('admin.pages.career') }}"
                                class="font-semibold @if (request()->routeIs('admin.pages.career')) text-teal-500 border-teal-500 @endif">
                                Careers
                            </a>
                        </div>

                        <!-- Our Team link -->
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.applicants') }}"
                                class="font-semibold @if (request()->is('admin.pages.applicants')) text-teal-500 border-teal-500 @endif">
                                Applicants
                            </a>
                        </div>
                    </div>
                </div>
                <div x-data="{ isOpen: false }" class="relative inline-block">
                    <button @click="isOpen = !isOpen" @click.away="isOpen = false"
                        class="flex items-center p-2 pr-3 font-semibold text-gray-700 
                        @if (request()->routeIs('admin.pages.contact') || request()->routeIs('admin.pages.news')) || request()->routeIs('admin.pages.products')) || request()->routeIs('admin.pages.documents'))
                            text-teal-500 border-b-4 border-teal-500 
                        @endif">
                        General
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
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.products') }}"
                                class="font-semibold @if (request()->is('admin.pages.products')) text-teal-500 border-teal-500 @endif">
                                Products
                            </a>
                        </div>
                        <!-- Gallery 2025-->
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.client.gallery.showAll') }}"
                                class="font-semibold @if (request()->is('admin.pages.client.gallery.showAll')) text-teal-500 border-teal-500 @endif">
                                Gallery
                            </a>
                        </div>
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.contact') }}"
                                class="font-semibold @if (request()->routeIs('admin.pages.contact')) text-teal-500 border-teal-500 @endif">
                                Contact Form
                            </a>
                        </div>

                        <!-- Our Team link -->
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.news') }}"
                                class="font-semibold @if (request()->is('admin.pages.news')) text-teal-500 border-teal-500 @endif">
                                News & Updates
                            </a>
                        </div>
                        <div @click="isOpen = false" class="block px-4 py-3 text-sm capitalize text-gray-600 hover:bg-gray-100 hover:text-teal-500 cursor-pointer">
                            <a href="{{ route('admin.pages.documents') }}"
                                class="font-semibold @if (request()->is('admin.pages.documents')) text-teal-500 border-teal-500 @endif">
                                Upload Documents
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Logout button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="transform overflow-hidden truncate text-ellipsis border-b-2 p-2 transition-colors duration-300 sm:mx-1
                    text-gray-700 font-semibold border-transparent
                    hover:text-teal-500 hover:border-teal-500">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
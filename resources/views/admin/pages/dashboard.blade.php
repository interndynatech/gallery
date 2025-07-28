@section('title', '$pageTitle')

<x-app-layout>

    <div class=" flex justify-center mt-10">
        <h1 class="text-3xl md:text-5xl text-bold text-teal-500">Admin Dashboard</h1>
    </div>

    <div class=" text-[#333] font-[sans-serif]">
        <div class="max-w-6xl mx-auto py-10 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 max-md:max-w-md mx-auto">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/project.png') }}" alt="branches Icon"
                            class="h-16 w-16 mx-auto flex justify-center">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">Main Project</h3>
                        <p class="text-gray-500 text-sm text-center">Item count:
                            <span class="text-bold text-black">
                                {{ DB::table('mainproject')->count() }} <!-- Direct query -->
                            </span> Main Project
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/news.png') }}" alt="news Icon"
                            class="h-16 w-16 mx-auto flex justify-center">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">News</h3>
                        <p class="text-gray-500 text-sm text-center">Item count:
                            <span class="text-bold text-black">
                                {{ DB::table('news')->count() }} <!-- Direct query -->
                            </span> News
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/products.png') }}" alt="Sliders Icon"
                            class="h-16 w-16 mx-auto flex justify-center mt-2">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">Products</h3>
                        <p class="text-gray-500 text-sm text-center">Item count:
                            <span class="text-bold text-black">
                                {{ DB::table('products')->count() }} <!-- Direct query -->
                            </span> Products
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Repeat for other elements like Tracks, Zones, Namecards -->
    <div class=" text-[#333] font-[sans-serif]">
        <div class="max-w-6xl mx-auto py-8 px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 max-md:max-w-md mx-auto">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/applicant.png') }}" alt="tracks Icon"
                            class="h-16 w-16 mx-auto flex justify-center">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">Applicants</h3>
                        <p class="text-gray-500 text-sm text-center">Pending Applicants:
                            <span class="text-bold text-black">
                                {{ DB::table('applicants')->where('status', 'pending')->count() }} <!-- Filter for pending applicants -->
                            </span>
                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/contact.png') }}" alt="zones Icon"
                            class="h-16 w-16 mx-auto flex justify-center">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">Contact Us</h3>
                        <p class="text-gray-500 text-sm text-center">Pending Messages:
                            <span class="text-bold text-black">
                                {{ DB::table('contactus')->where('status', 'pending')->count() }} <!-- Filter for pending contact us messages -->
                            </span>
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/dashboard/client.png') }}" alt="namecards Icon"
                            class="h-14 w-14 mx-auto flex justify-center">
                        <h3 class="text-xl font-semibold text-center mt-4 mb-2">Clients</h3>
                        <p class="text-gray-500 text-sm text-center">Item count:
                            <span class="text-bold text-black">
                                {{ DB::table('clients')->count() }} <!-- Direct query -->
                            </span> Clients
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
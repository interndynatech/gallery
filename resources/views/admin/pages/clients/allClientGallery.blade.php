@section('title', $pageTitle)
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
<br><br>
<div class="bg-gray-50 p-6 mx-auto max-w-7xl py-10 rounded-lg">
    <div class="text-center">
        <p class="text-teal-500 font-bold text-4xl">{{ $pageTitle }}</p>
    </div>

    <div class="mb-4 mt-3 flex justify-between items-center flex-wrap gap-2">
        <!-- Filter Dropdown (Type) -->
        <select
            id="typeFilter"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-teal-500"
        >
            <option value="">All Types</option>
            <option value="training">Training</option>
            <option value="exhibition">Exhibition</option>
            <option value="visit">Visit</option>
        </select> 

        <!-- Search Input kiri -->
        <div class="flex-1">
            <input
                type="text"
                id="gallerySearch"
                placeholder="Search title, client name, date..."
                class="px-4 py-2 border border-gray-300 rounded-lg w-full max-w-xs pr-24 focus:outline-none focus:ring focus:border-teal-500"
            >
        </div>

        <!-- Button Add kanan -->
        <div>
            <button type="button" id="openAddGalleryModal" class="inline-flex items-center gap-x-2 px-4 py-2 bg-teal-500 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:bg-teal-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Gallery
            </button>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 text-left dark:bg-neutral-700">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">No.</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Image</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Created At</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                             @foreach ($groupedGallery as $key => $group)
                                @php 
                                    $item = $group->first(); // ambil satu rekod wakil
                                    $relatedImages = $group; // semua dalam group sama
                                @endphp
                                
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $index++ }}</td>
                                    <td class="px-6 py-4 text-sm capitalize">{{ $item->type }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $item->clientName ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <img
                                                src="{{ asset('assets/images/clientGallery/' . $item->type . '/' . $item->image_path) }}"
                                                alt="{{ $item->title }}"
                                                class="w-16 h-16 object-cover rounded shadow hover:scale-105 transition cursor-pointer"
                                            />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $item->title }}</td>
                                    <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <div class="inline-flex items-center rounded-md shadow-sm">
                                       <!-- Edit Button -->
                                        <button 
                                            class="edit-gallery-btn text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center"
                                            data-target="#editClientGalleryModal{{ $item->id_group }}"
                                        >
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </span>
                                            <span class="hidden md:inline-block">Edit</span>
                                        </button>

                                        <!-- Delete Button -->
                                        <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center delete-btn" data-id="{{ $item->id }}">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </span>
                                            <span class="hidden md:inline-block">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($groupedGallery->isEmpty()) 
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">No gallery data available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image -->
<div id="myModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-80 flex justify-center items-center">
    <!-- Close Button di atas kanan skrin -->
    <button id="closeModalBtn" class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-red-400 z-50">
        &times;
    </button>

    <!-- Image container -->
    <div class="max-w-3xl w-full px-4 flex flex-col items-center">
        <img
            id="img01"
            class="w-full max-w-[500px] h-auto object-contain rounded-lg shadow-2xl transition duration-300 border-4 border-white"
            alt="Preview"
        />
        <div id="caption" class="mt-4 text-center text-white text-base max-w-xl px-2"></div>
    </div>
</div>

<!-- Include Create Modal (once) -->
@include('admin.pages.clients.includes.createClientGallery')

<!-- Include Edit Modals (for each item) -->
@foreach ($groupedGallery as $key => $group)
    @php 
        $item = $group->first();
        $relatedImages = $group;
    @endphp
    @include('admin.pages.clients.includes.editClientGallery', ['item' => $item, 'relatedImages' => $relatedImages])
@endforeach

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== FILTER DAN SEARCH ==========
        const searchInput = document.getElementById('gallerySearch');
        const typeFilter = document.getElementById('typeFilter');
        const tableRows = document.querySelectorAll("table tbody tr");

        function filterTable() {
            const searchQuery = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                const typeText = row.children[1]?.innerText.toLowerCase();

                const matchesSearch = rowText.includes(searchQuery);
                const matchesType = !selectedType || typeText === selectedType;

                row.style.display = (matchesSearch && matchesType) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        typeFilter?.addEventListener('change', filterTable);

        // ========== EDIT GALLERY BUTTONS ==========
        document.querySelectorAll('.edit-gallery-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                const modalId = target.substring(1); // Remove the # symbol
                const modal = document.getElementById(modalId);
                
                console.log('Edit button clicked');
                console.log('Target modal ID:', modalId);
                console.log('Modal element:', modal);
                
                if (modal) {
                    modal.classList.remove('hidden');
                    console.log('Modal opened successfully');
                } else {
                    console.error('Modal not found!');
                }
            });
        });

        // ========== DELETE BUTTON ==========
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                const galleryId = button.getAttribute('data-id');
                const url = `/pages/deleteClientGallery/${galleryId}`;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire('Deleted!', 'Your item has been deleted.', 'success');
                                    button.closest('tr').remove();
                                } else {
                                    Swal.fire('Failed!', 'Failed to delete the item.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error!', 'An error occurred while deleting the item.', 'error');
                            });
                    }
                });
            });
        });
    });
</script>

</x-app-layout>
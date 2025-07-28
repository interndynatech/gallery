<!-- Modal for managing categories -->
<div id="modal2" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6 pb-4">
                <h3 class="text-2xl font-medium capitalize leading-6 text-teal-500" id="modal-title">
                    Manage Categories
                </h3>
                <button id="closeModal2Btn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>

            <!-- Form to add new category -->
            <form class="mt-4" id="addNewCategoryForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.storeCategories') }}">
                @csrf
                <div class="px-5 pb-5">
                    <p class="text-gray-500">Category Title</p>
                    <input placeholder="Enter category title..." name="categories" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>

            <div class="mt-6">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable" class="bg-white divide-y divide-gray-200">
                        <!-- Categories will be loaded here by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal2 = document.getElementById('modal2');
        const openModalBtn = document.getElementById('openModalCatBtn');
        const closeModalBtn = document.getElementById('closeModal2Btn');
        const form = document.getElementById('addNewCategoryForm');
        const categoriesTable = document.getElementById('categoriesTable');

        function openModal() {
            modal2.classList.remove('hidden');
            loadCategories(); // Load categories when modal is opened
        }

        function closeModal() {
            modal2.classList.add('hidden');
        }

        if (openModalBtn) {
            openModalBtn.addEventListener('click', openModal);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        // Close modal when clicking outside the modal content
        modal2.addEventListener('click', (event) => {
            if (event.target === modal2) {
                closeModal();
            }
        });

        // Handle form submission via AJAX
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            fetch('{{ route("admin.pages.storeCategories") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            closeModal();
                            openModal(); // Reload categories after adding
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });

        function loadCategories() {
            fetch('{{ route("admin.pages.categoriesList") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (categoriesTable) {
                        if (Array.isArray(data) && data.length > 0) {
                            categoriesTable.innerHTML = ''; // Clear the table
                            data.forEach(category => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${category.categoriesTitle}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="delete-btn px-4 py-2 bg-red-500 text-white rounded-lg" data-id="${category.categoriesId}">Delete</button>
                                    </td>
                                `;
                                categoriesTable.appendChild(row);
                            });

                            // Attach delete event listeners
                            attachDeleteListeners();
                        } else {
                            console.error('Invalid categories data:', data);
                            Swal.fire('Error!', 'Failed to load categories.', 'error');
                        }
                    } else {
                        console.error('Element with id "categoriesTable" not found.');
                        Swal.fire('Error!', 'Categories table not found.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    Swal.fire('Error!', 'An error occurred while loading categories.', 'error');
                });
        }

        function attachDeleteListeners() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const categoryId = event.target.getAttribute('data-id');
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
                            fetch(`{{ route('admin.pages.deleteCategories', '') }}/${categoryId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        loadCategories(); // Reload categories after deletion
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong!',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            });
        }
    });
</script>

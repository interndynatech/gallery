<div id="modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-titles">
                    Add New Categories
                </h3>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="addNewCategoriesForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.store') }}">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Categories Title" name="categoriesTitle" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <input type="file" name="images[]" accept="image/*" multiple class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" id="fileInput">
                    <div id="imagePreviews" class="mt-4 grid grid-cols-2 gap-4"></div>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const submitFormBtn = document.getElementById('submitFormBtn');
        const fileInput = document.getElementById('fileInput');
        const imagePreviews = document.getElementById('imagePreviews');
        const form = document.getElementById('addNewCategoriesForm');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        openModalBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            imagePreviews.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('object-contain');

                    const container = document.createElement('div');
                    container.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
                    container.style.maxWidth = '150px';
                    container.style.maxHeight = '150px';

                    container.appendChild(img);
                    imagePreviews.appendChild(container);
                };

                reader.readAsDataURL(file);
            }
        });

        submitFormBtn.addEventListener('click', (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            fetch('{{ route("admin.pages.store") }}', {
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
                            location.reload();
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
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
</script>
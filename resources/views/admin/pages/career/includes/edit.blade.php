<!-- Modal HTML -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title">
                    Edit Job Vacancy
                </h3>
                <button id="closeEditModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form id="editCareerForm" method="POST" enctype="multipart/form-data" action="/pages/updateCareer" data-id="">
                @csrf
                <input type="hidden" name="id" id="editJobId">
                <div class="px-5 pb-5">
                    <input placeholder="Job Title" name="jobTitle" id="editJobTitle" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="flex space-x-4 px-5 pb-5">
                    <div class="w-full">
                        <input placeholder="Position" name="jobPosition" id="editJobPosition" type="text" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                    </div>

                </div>
                <div class="px-5 pb-5">
                    <textarea placeholder="Job Description..." name="jobDesc" id="editJobDesc" rows="4" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></textarea>
                </div>
                <div class="px-5 pb-5">
                    <input type="file" name="image" id="editFileInput" accept="image/*" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                    <p class="text-gray-500 py-2 text-xs">*Image uploaded must be in square size for better dimensional display</p>
                    <div id="editImagePreviews" class="mt-4"></div>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" id="editSubmitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');
        const openEditModalBtns = document.querySelectorAll('.openEditProjectsModalBtn');
        const editFileInput = document.getElementById('editFileInput');
        const editImagePreviews = document.getElementById('editImagePreviews');
        const editCareerForm = document.getElementById('editCareerForm');
        let currentCareerId = null;

        function openEditModal(id) {
            fetch(`/pages/showCareer/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const career = data.career;

                        document.querySelector('#editJobId').value = career.careerId || '';
                        document.querySelector('#editJobTitle').value = career.title || '';
                        document.querySelector('#editJobPosition').value = career.position || '';
                        document.querySelector('#editJobDesc').value = career.description || '';

                        // Show existing image
                        if (career.imagePath) {
                            displayImagePreview(`/assets/images/career/${career.imagePath}`, editImagePreviews);
                        } else {
                            editImagePreviews.innerHTML = '<p>No image available</p>';
                        }

                        currentCareerId = id; // Store the ID for form submission
                        editModal.classList.remove('hidden');
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
                        text: `Something went wrong: ${error.message}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function displayImagePreview(imageSrc, container) {
            const img = document.createElement('img');
            img.src = imageSrc;
            img.alt = 'Image Preview';
            img.classList.add('object-cover');
            img.style.width = '150px';
            img.style.height = '150px';

            container.innerHTML = '';
            container.appendChild(img);
        }

        openEditModalBtns.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-category-id');
                openEditModal(id);
            });
        });

        document.querySelector('#closeEditModalBtn').addEventListener('click', () => {
            editModal.classList.add('hidden');
        });

        window.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.classList.add('hidden');
            }
        });

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                editModal.classList.add('hidden');
            }
        });

        editCareerForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(editCareerForm);

            fetch(`/pages/updateCareer/${currentCareerId}`, {
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
                            editModal.classList.add('hidden');
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
                        text: `Something went wrong: ${error.message}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });

        editFileInput.addEventListener('change', () => {
            const file = editFileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    displayImagePreview(e.target.result, editImagePreviews);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
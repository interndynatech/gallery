<!-- Modal HTML -->
<div id="modal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center">
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6 pb-8">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-titles">
                    Add New Job Vacancy
                </h3>
                <div class="flex items-center space-x-4">
                    <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">X</button>
                </div>
            </div>
            <form id="addNewCareerForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Job Title" name="jobTitle" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="flex space-x-4 px-5 pb-5">
                    <div class="w-full">
                        <input placeholder="Position" name="jobPosition" type="text" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                    </div>
                  
                </div>
                <div class="px-5 pb-5">
                    <textarea placeholder="Job Description..." name="jobDesc" rows="4" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></textarea>
                </div>
                <div class="px-5 pb-5">
                    <input type="file" name="image" accept="image/*" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" id="fileInput">
                    <p class="text-gray-500 py-2 text-xs">*Image uploaded must be in square size for better dimensional display</p>
                    <div id="imagePreviews" class="mt-4"></div>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript to handle modal visibility and form submission -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modal = document.getElementById('modal');
        const form = document.getElementById('addNewCareerForm');
        const fileInput = document.getElementById('fileInput');
        const imagePreviews = document.getElementById('imagePreviews');

        // Function to open the modal
        if (openModalBtn) {
            openModalBtn.addEventListener('click', function() {
                modal.style.display = 'block';
            });
        }

        // Function to close the modal
        closeModalBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close the modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Close the modal with the ESC key
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                modal.style.display = 'none';
            }
        });

        // Function to preview the selected image
        fileInput.addEventListener('change', function() {
            const files = this.files;
            if (files && files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create an image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-auto', 'object-cover', 'rounded-lg');
                    // Clear previous previews
                    imagePreviews.innerHTML = '';
                    // Append the new image
                    imagePreviews.appendChild(img);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        // Handle form submission
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form);

            fetch('{{ route("admin.pages.storeCareer") }}', {
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
                        modal.style.display = 'none'; // Close the modal
                        location.reload(); // Reload the page
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
                    text: 'Something went wrong! Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>

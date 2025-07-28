<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Add this to your stylesheet or in a <style> tag */

    #fileContainer div {
        display: flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
        background-color: #ffffff;
    }

    #fileContainer i {
        font-size: 2rem;
        /* Large icon size */
        color: #4b5563;
        /* Default color for icons */
    }

    #fileContainer a {
        margin-left: 16px;
        color: #1d4ed8;
        /* Link color */
        text-decoration: none;
    }

    #fileContainer img {
        margin-left: 16px;
        border-radius: 8px;
        /* Rounded corners for images */
    }
</style>
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-medium capitalize leading-6 pb-4 text-gray-800" id="modal-title">
                    Application Form
                </h3>
                <button id="closeEditModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form id="editapplicantsForm" method="POST" enctype="multipart/form-data" action="/pages/updateapplicants">
                @csrf
                <input type="hidden" name="id" id="editJobId">

                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm bg-gray-100" placeholder="Title">
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" id="position" name="position" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm bg-gray-100" placeholder="Position">
                        </div>
                    </div>
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name*</label>
                        <input type="text" id="fullName" name="fullName" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Full Name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address*</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Email Address">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="age" class="block text-sm font-medium text-gray-700">Age*</label>
                            <input type="number" id="age" name="age" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Age">
                        </div>
                        <div>
                            <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number*</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Phone Number">
                        </div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address*</label>
                        <textarea id="address" name="address" rows="3" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Address"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Postcode*</label>
                            <input type="text" id="postcode" name="postcode" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Postcode">
                        </div>
                        <div>
                            <label for="area" class="block text-sm font-medium text-gray-700">Area*</label>
                            <input type="text" id="area" name="area" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Area">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State*</label>
                            <input type="text" id="state" name="state" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="State">
                        </div>
                    </div>
                </div>

                <div id="fileContainer" class="pt-4"></div>

                <div class="px-5 pt-5 flex justify-end">
                    <button type="submit" id="editSubmitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.openViewModalBtn');
        const modal = document.getElementById('editModal');
        const closeModalButton = document.getElementById('closeEditModalBtn');

        // Event listener for opening the modal
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openEditModal(id); // Open the modal and load data
            });
        });

        // Event listener for closing the modal
        closeModalButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Close the modal by clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });

        function openEditModal(id) {
            fetch(`/pages/showApplicants/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const applicants = data.applicant;
                        const files = data.files;

                        if (!applicants) {
                            console.error('applicants data is undefined.');
                            Swal.fire({
                                title: 'Error!',
                                text: 'No data found for the selected applicant.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        // Populate form fields
                        document.querySelector('#editJobId').value = applicants.applicantId || '';
                        document.querySelector('#title').value = applicants.title || '';
                        document.querySelector('#position').value = applicants.position || '';
                        document.querySelector('#fullName').value = applicants.fullName || '';
                        document.querySelector('#email').value = applicants.email || '';
                        document.querySelector('#age').value = applicants.age || '';
                        document.querySelector('#phoneNumber').value = applicants.phoneNumber || '';
                        document.querySelector('#address').value = applicants.address || '';
                        document.querySelector('#postcode').value = applicants.postcode || '';
                        document.querySelector('#area').value = applicants.area || '';
                        document.querySelector('#state').value = applicants.state || '';

                        // Display files with large icons and style
                        const fileContainer = document.querySelector('#fileContainer');
                        fileContainer.innerHTML = '';

                        const getFileIcon = (type) => {
                            switch (type) {
                                case 'image':
                                    return '<i class="fas fa-image text-blue-500"></i>';
                                case 'pdf':
                                    return '<i class="fas fa-file-pdf text-red-500"></i>';
                                case 'doc':
                                case 'docx':
                                    return '<i class="fas fa-file-word text-blue-500"></i>';
                                default:
                                    return '<i class="fas fa-file-alt text-gray-500"></i>';
                            }
                        };

                        if (files.profileImage) {
                            fileContainer.innerHTML += `
                        <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="text-4xl">${getFileIcon('image')}</div>
                            <a href="${files.profileImage}" target="_blank" class="text-blue-500 font-medium">Profile Image</a>
                            <img src="${files.profileImage}" alt="Profile Image" class="w-32 h-32 rounded-full object-cover ml-4">
                        </div>`;
                        }
                        if (files.resume) {
                            fileContainer.innerHTML += `
                        <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="text-4xl">${getFileIcon('doc')}</div>
                            <a href="${files.resume}" target="_blank" class="text-blue-500 font-medium">Resume</a>
                        </div>`;
                        }
                        if (files.transcriptExam) {
                            fileContainer.innerHTML += `
                        <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="text-4xl">${getFileIcon('doc')}</div>
                            <a href="${files.transcriptExam}" target="_blank" class="text-blue-500 font-medium">Transcript Exam</a>
                        </div>`;
                        }

                        modal.classList.remove('hidden');
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'An unknown error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: `Something went wrong: ${error.message}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }




        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const preview = document.querySelector('#imagePreview');
            const uploadText = document.querySelector('#uploadText');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
                uploadText.classList.remove('hidden');
            }
        }
    });
</script>
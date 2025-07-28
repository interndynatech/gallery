<div id="modal1" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title1">
                    Edit Clients
                </h3>
                <button class="closeModalBtn text-gray-500 hover:text-gray-700" data-modal-id="modal1">X</button>
            </div>
            <form class="mt-4" id="editClientsForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-5 pb-5">
                    <input id="clientName1" placeholder="Client Name" name="displayClientName" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <label for="displayActiveStatus1" class="block text-sm font-medium text-gray-700">Active Status</label>
                    <select name="displayActiveStatus" id="displayActiveStatus1" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <label for="displayClientType1" class="block text-sm font-medium text-gray-700">Client Type</label>
                    <select name="displayClientType" id="displayClientType1" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="cityCouncil">City Council</option>
                        <option value="contractor">Contractor</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <input type="file" name="image" accept="image/*" id="fileInput1" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                    <p class="text-gray-500 py-2 text-xs">*Image uploaded must be in square size for better dimensional display</p>
                    <div id="imagePreviews1" class="mt-4"></div>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="editClientsSubmitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const openEditClientsModalBtns = document.querySelectorAll('.openEditClientsModalBtn');
    const closeModalBtns = document.querySelectorAll('.closeModalBtn');
    const form = document.getElementById('editClientsForm');
    const fileInput = document.getElementById('fileInput1');
    let currentClientId = null;

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    async function populateModalWithData(clientId) {
        try {
            const response = await fetch(`/pages/showClients/${clientId}`);
            const data = await response.json();

            if (!data) {
                throw new Error('No client data found');
            }

            const imagePreviews = document.getElementById('imagePreviews1');

            form.querySelector('input[name="displayClientName"]').value = data.clientName || '';
            form.querySelector('select[name="displayActiveStatus"]').value = data.active || '0';
            form.querySelector('select[name="displayClientType"]').value = data.clientType || 'contractor';

            // Show existing image
            if (data.imagePath) {
                displayImagePreview(`/assets/images/clients/${data.imagePath}`, imagePreviews);
            } else {
                imagePreviews.innerHTML = ''; // Clear if no image
            }
        } catch (error) {
            console.error("Error fetching client data:", error);
        }
    }

    function displayImagePreview(imageSrc, container) {
        const img = document.createElement('img');
        img.src = imageSrc;
        img.classList.add('object-contain');

        const imgContainer = document.createElement('div');
        imgContainer.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
        imgContainer.style.maxWidth = '150px';
        imgContainer.style.maxHeight = '150px';

        imgContainer.appendChild(img);
        container.innerHTML = ''; // Clear existing previews
        container.appendChild(imgContainer);
    }

    // Preview newly uploaded image
    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imagePreviews = document.getElementById('imagePreviews1');
                displayImagePreview(e.target.result, imagePreviews); // Show preview of the uploaded image
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    });

    openEditClientsModalBtns.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-id');
            currentClientId = button.getAttribute('data-category-id'); // Get the client ID from the button

            populateModalWithData(currentClientId);

            openModal(modalId);
        });
    });

    closeModalBtns.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-id');
            closeModal(modalId);
        });
    });

    document.getElementById('editClientsSubmitFormBtn').addEventListener('click', (event) => {
        event.preventDefault();

        if (!currentClientId) {
            Swal.fire({
                title: 'Error!',
                text: 'No client selected for update.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        const formData = new FormData(form);

        fetch(`/pages/updateClients/${currentClientId}`, {
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
                    closeModal('modal1');
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
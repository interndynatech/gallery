<!-- Modal -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title">
                    Edit Organizational Chart
                </h3>
                <button id="closeEditModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="orgChartForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="orgChartId">
                <input type="hidden" name="orgChartId" id="formOrgChartId"> <!-- Hidden input for form action -->

                <div class="px-5 pb-5">
                    <input type="file" name="images[]" accept="image/*" multiple class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" id="fileInput">
                    <div id="imagePreviews" class="mt-4 grid grid-cols-2 gap-4"></div>
                </div>
                <div class="px-5 pt-5 flex justify-end">
                    <button type="button" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editModal');
    const openModalBtns = document.querySelectorAll('.openEditOrgChart'); // Ensure class name matches your buttons
    const closeModalBtn = document.getElementById('closeEditModalBtn');
    const imagePreviews = document.getElementById('imagePreviews');
    const fileInput = document.getElementById('fileInput');
    const orgChartIdInput = document.getElementById('orgChartId');
    const formOrgChartIdInput = document.getElementById('formOrgChartId');
    const submitFormBtn = document.getElementById('submitFormBtn');
    const form = document.getElementById('orgChartForm');

    if (!modal || !closeModalBtn || !imagePreviews || !fileInput || !orgChartIdInput || !formOrgChartIdInput || !submitFormBtn || !form) {
        console.error('Essential DOM elements are missing.');
        return;
    }

    function openModal(orgChartId) {
        console.log('Opening modal for orgChartId:', orgChartId); // Debugging
        orgChartIdInput.value = orgChartId; // Set the orgChartId in the hidden input
        formOrgChartIdInput.value = orgChartId; // Set the orgChartId in the form hidden input
        modal.classList.remove('hidden');
        fetchOrgChartImages(orgChartId);
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    openModalBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const orgChartId = btn.getAttribute('data-org-chart-id'); // Make sure the attribute is correct
            if (orgChartId) {
                openModal(orgChartId);
            } else {
                console.error('No orgChartId found'); // Debugging
            }
        });
    });

    closeModalBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    function fetchOrgChartImages(orgChartId) {
        fetch(`/pages/showOrgchart/${orgChartId}`)
            .then(response => response.json())
            .then(data => {
                imagePreviews.innerHTML = ''; // Clear previous images

                data.forEach(imagePath => {
                    const img = document.createElement('img');
                    img.src = `/assets/${imagePath}`; // Adjust path here
                    img.classList.add('object-contain');
                    img.style.maxWidth = '300px'; // Increased size
                    img.style.maxHeight = '300px'; // Increased size
                    img.style.width = '100%'; // Make image take full width of the container
                    img.style.height = 'auto'; // Maintain aspect ratio

                    const container = document.createElement('div');
                    container.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
                    container.style.maxWidth = '300px'; // Adjust container size if needed
                    container.style.margin = 'auto'; // Center align container in the grid

                    container.appendChild(img);
                    imagePreviews.appendChild(container);
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to fetch images. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error fetching org chart images:', error);
            });
    }

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        imagePreviews.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result; // Display image preview
                img.classList.add('object-contain');
                img.style.maxWidth = '300px'; // Adjust size
                img.style.maxHeight = '300px'; // Adjust size
                img.style.width = '100%'; // Make image take full width of the container
                img.style.height = 'auto'; // Maintain aspect ratio

                const container = document.createElement('div');
                container.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
                container.style.maxWidth = '300px'; // Adjust container size if needed
                container.style.margin = 'auto'; // Center align container in the grid

                container.appendChild(img);
                imagePreviews.appendChild(container);
            };
            reader.readAsDataURL(file); // Read file as data URL
        });
    });

    submitFormBtn.addEventListener('click', () => {
        const formData = new FormData(form);
        const url = `/pages/updateOrgChart/${formOrgChartIdInput.value}`; // Dynamic URL with orgChartId and id

        fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Set header for AJAX request
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Handle success (e.g., close the modal, show a success message, etc.)
                    closeModal();
                    Swal.fire({
                        title: 'Success',
                        text: 'Form submitted successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    console.log('Form submitted successfully:', result);
                } else {
                    // Handle error
                    Swal.fire({
                        title: 'Error',
                        text: result.message || 'There was an error submitting the form. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('Form submission error:', result);
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error submitting form:', error);
            });
    });
});


</script>
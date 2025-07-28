<div id="modalDocs" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-titles">
                    Add Documents
                </h3>
                <button id="closeModalxBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="addDocsForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.storeDocuments') }}">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Document Name" name="docName" id="docName" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <label for="activeStatus" class="block text-sm font-medium text-gray-700">Active Status</label>
                    <select name="activeStatus" id="activeStatus" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <label for="docUpload" class="block text-sm font-medium text-gray-700">Upload Document</label>
                    <input type="file" name="filePath" id="filePath" class="mt-2 p-2 border rounded-lg bg-gray-200">
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit Document</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div id="modalDocs" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-titles">
                    Add Documents
                </h3>
                <button id="closeModalxBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="addDocsForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.storeDocuments') }}">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Document Name" name="docName" id="docName" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" required>
                </div>
                <div class="px-5 pb-5">
                    <label for="activeStatus" class="block text-sm font-medium text-gray-700">Active Status</label>
                    <select name="activeStatus" id="activeStatus" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <label for="filePath" class="block text-sm font-medium text-gray-700">Upload Document</label>
                    <input type="file" name="filePath" id="filePath" class="mt-2 p-2 border rounded-lg bg-gray-200" required>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit Document</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modalId = 'modalDocs'; // Unique modal ID
    const modal = document.getElementById(modalId);
    const openNewDocsModalBtn = document.getElementById('openNewDocsModalBtn'); // Ensure this button exists
    const closeModalxBtn = document.getElementById('closeModalxBtn');
    const form = document.getElementById('addDocsForm');

    // Function to open the modal
    function openModal() {
        modal.classList.remove('hidden');
    }

    // Function to close the modal
    function closeModal() {
        modal.classList.add('hidden');
    }

    // Event listeners to open and close the modal
    if (openNewDocsModalBtn) {
        openNewDocsModalBtn.addEventListener('click', openModal);
    }
    closeModalxBtn.addEventListener('click', closeModal);

    // Close the modal if clicked outside of the content
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Form submission handling via AJAX
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch('{{ route("admin.pages.storeDocuments") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server
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



<div id="modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-titles">
                    Edit Documents
                </h3>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <!-- Form for editing document -->
            <form class="mt-4" id="addNewDocsForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.storeDocuments') }}">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Document Name" name="docName" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <label for="activeStatus" class="block text-sm font-medium text-gray-700">Active Status</label>
                    <select name="activeStatus" id="activeStatus" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <p class="text-gray-500">Uploaded Documents Preview</p>
                </div>
                <!-- Document Preview Section -->
                <div class="px-5 pb-5">
                    <p class="text-gray-500">Document Preview:</p>
                    <iframe id="docPreview" class="w-full h-64 border-2 border-gray-200 rounded-lg" src="" hidden></iframe>
                    <p id="noPreviewMessage" class="text-gray-500" hidden>No preview available for this document.</p>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="submitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Preview in full page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const openModalBtns = document.querySelectorAll('.openEditDocsModalBtn');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const docNameInput = document.querySelector('input[name="docName"]');
    const activeStatusSelect = document.getElementById('activeStatus');
    const docPreview = document.getElementById('docPreview');
    const noPreviewMessage = document.getElementById('noPreviewMessage');
    const submitFormBtn = document.getElementById('submitFormBtn');
    
    let currentFileUrl = '';  // Track current file URL

    // Function to fetch document data
    function fetchDocumentData(docId) {
        fetch(`/pages/showDocuments/${docId}`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields with the fetched data
                docNameInput.value = data.docName || '';
                activeStatusSelect.value = data.activeStatus === 1 ? "1" : "0";

                // Build the full URL path for the document
                currentFileUrl = `/assets/images/documents/${data.filePath.split('/documents/')[1]}`;

                // Check file extension to set preview
                const fileExtension = data.filePath.split('.').pop().toLowerCase();
                if (['pdf', 'doc', 'docx', 'ppt', 'pptx'].includes(fileExtension)) {
                    // For PDFs and Office documents, we can use a PDF viewer or similar
                    if (fileExtension === 'pdf') {
                        docPreview.src = currentFileUrl;
                    } else {
                        // For Word and PowerPoint files, use Google Docs Viewer or another viewer
                        docPreview.src = `https://docs.google.com/gview?url=${encodeURIComponent(currentFileUrl)}&embedded=true`;
                    }
                    docPreview.hidden = false;
                    noPreviewMessage.hidden = true;
                } else {
                    docPreview.hidden = true;
                    noPreviewMessage.hidden = false;
                }
            })
            .catch(error => {
                console.error('Error fetching document data:', error);
            });
    }

    // Event listener to open modal and fetch document data
    openModalBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const docId = this.getAttribute('data-category-id'); // Get docId from data attribute
            modal.classList.remove('hidden');
            fetchDocumentData(docId);
        });
    });

    // Close modal
    closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    // Optional: Close modal when clicking outside of it
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Open file in a new tab on button click
    submitFormBtn.addEventListener('click', function () {
        if (currentFileUrl) {
            // Open file in a new tab without triggering a download
            window.open(currentFileUrl, '_blank');
        } else {
            alert('No file available for preview.');
        }
    });
});
</script>

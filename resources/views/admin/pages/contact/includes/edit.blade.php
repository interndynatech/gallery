<div id="viewModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title">
                    Contact Details
                </h3>
                <button id="closeViewModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <div class="py-8">
                <form id="editContactForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="editJobId">
                    <input type="hidden" name="status" id="status" value="Done">


                    <div class="flex flex-col gap-4">

                        <div>
                            <label for="fullName" class="block text-sm pb-2 font-medium text-gray-700">Full Name</label>
                            <input type="text" disabled id="contactName" name="contactName" required class="mt-1 block w-full pl-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Full Name">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="title" class="block text-sm pb-2 font-medium text-gray-700">Phone Number</label>
                                <input type="text" disabled id="contactPhoneNum" name="contactPhoneNum" class="mt-1 block w-full pl-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Phone Number">
                            </div>
                            <div>
                                <label for="position" class="block text-sm pb-2 font-medium text-gray-700">Email</label>
                                <input type="text" disabled id="contactEmail" name="contactEmail" class="mt-1 block w-full pl-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm " placeholder="Email">
                            </div>
                        </div>
                        <div>
                            <label for="typeOfEnquiry" class="block text-sm pb-2 font-medium text-gray-700">Type Of Enquiry</label>
                            <input type="text" disabled id="typeOfEnquiry" name="typeOfEnquiry" required class="mt-1 block w-full pl-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Full Name">
                        </div>
                        <div>
                            <label for="contactMessage" class="block text-sm pb-2 font-medium text-gray-700">Message</label>
                            <textarea id="contactMessage" disabled name="contactMessage" required class="mt-1 block w-full pl-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Your message"></textarea>
                        </div>

                    </div>

                    <div id="fileContainer" class="pt-4"></div>

                    <div class="px-5 pt-5 flex justify-end">
                        <button type="submit" id="editSubmitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Mark As Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const viewModal = document.getElementById('viewModal');
        const openContactModalBtns = document.querySelectorAll('.openContactModal');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');
        const editContactForm = document.getElementById('editContactForm');
        
        let contactId; // Define this globally to capture contact ID for the form

        function openViewModal(id) {
            contactId = id; // Store the contact ID when the modal opens

            fetch(`/pages/showContact/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const contact = data.contact;

                        // Populate input fields with data
                        document.getElementById('contactName').value = contact.name || 'N/A';
                        document.getElementById('contactEmail').value = contact.email || 'N/A';
                        document.getElementById('contactPhoneNum').value = contact.phoneNum || 'N/A';
                        document.getElementById('typeOfEnquiry').value = contact.typeOfEnquiry || 'N/A';
                        document.getElementById('contactMessage').value = contact.message || 'N/A';

                        viewModal.classList.remove('hidden');
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

        // Form submission
        editContactForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(editContactForm);

            fetch(`/pages/updateContact/${contactId}`, {  // Ensure the route matches your backend
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Ensure CSRF token
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
                        viewModal.classList.add('hidden');
                        location.reload(); // Reload the page after success
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

        openContactModalBtns.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                openViewModal(id);
            });
        });

        closeViewModalBtn.addEventListener('click', () => {
            viewModal.classList.add('hidden');
        });

        window.addEventListener('click', (event) => {
            if (event.target === viewModal) {
                viewModal.classList.add('hidden');
            }
        });

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                viewModal.classList.add('hidden');
            }
        });
    });
</script>

<div id="modalEdit" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-2xl font-bold capitalize leading-6 text-gray-800" id="modal-title">
                    Edit
                </h3>
                <button id="closeEditModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>

            <form class="mt-4" id="editCategoriesForm" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="px-5 pb-5">
                    <div class="py-3"></div>

                    <p class="text-teal-500 font-medium text-lg pt-4">News Title</p>
                    <input
                        id="titleDisplay"
                        name="titleDisplay"
                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200"
                        type="text" />

                    <div class="py-3"></div>
                    <p class="text-teal-500 font-medium text-lg pt-4">Content Introduction</p>
                    <textarea
                        id="displayIntroContent"
                        name="displayIntroContent"
                        aria-label="Introduction Content"
                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200"
                        placeholder="Enter your introduction content here...">
</textarea>
                    <div class="py-3"></div>
                    <p class="text-teal-500 font-medium text-lg pt-4">Content Description</p>
                    <textarea
                        id="displayFullContent"
                        name="displayFullContent"
                        aria-label="full Content"
                        class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200"
                        placeholder="Enter your introduction content here...">
</textarea>
                    <p class="text-teal-500 font-medium text-lg pt-4">Status</p>
                    <select name="displayStatus" id="displayStatus" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>




                    <p class="text-teal-500 font-medium text-lg pt-4">Certificates Displayed</p>

                    <table id="image-table" class="w-full mt-4 border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-300">
                                <th class="px-4 py-2 text-left border-r border-gray-300">Image</th>
                                <th class="px-4 py-2 text-left">Name</th>
                            </tr>
                        </thead>
                        <tbody id="image-container"></tbody>
                    </table>

                    <div class="py-3"></div>

                    <p class="text-teal-500 font-medium text-lg pt-4">Upload More Images</p>

                    <div class="mt-4 flex items-center">
                        <input type="file" name="images[]" accept="image/*" multiple class="text-black placeholder-gray-600 w-full px-4 py-2.5 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200" id="fileInput">
                    </div>
                </div>

                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="submitEditFormBtn" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEdit = document.getElementById('modalEdit');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const categoryTitleDisplay = document.getElementById('categoryTitleDisplay');
        const modalTitle = document.getElementById('modal-title');
        const imageContainer = document.getElementById('image-container');
        const fileInput = document.getElementById('fileInput');
        const submitEditFormBtn = document.getElementById('submitEditFormBtn');
        const form = document.getElementById('editCategoriesForm');

        let newsId = null;

        function openModal(id) {
            newsId = id;
            fetch(`/pages/showNews/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error:', data.error);
                        alert('Category not found.');
                    } else {
                        titleDisplay.value = data.title;
                        displayIntroContent.value = data.introContent;
                        displayFullContent.value = data.description;
                        displayStatus.value = data.status;
                        displayFullContent.value = data.description;





                        imageContainer.innerHTML = '';

                        // Display fetched images
                        if (data.imageUrls && data.imageUrls.length > 0) {
                            data.imageUrls.forEach((url) => {
                                const fileName = url.split('/').pop();

                                // Create table row
                                const row = document.createElement('tr');
                                row.classList.add('border-b', 'border-gray-300');

                                // // Delete button
                                // const deleteBtn = document.createElement('button');
                                // deleteBtn.textContent = 'Delete';
                                // deleteBtn.classList.add('px-4', 'py-2', 'bg-red-500', 'text-white', 'hover:bg-red-700', 'rounded');
                                // deleteBtn.onclick = () => row.remove();

                                // Image element
                                const imgElement = document.createElement('img');
                                imgElement.src = url;
                                imgElement.alt = fileName;
                                imgElement.classList.add('object-contain', 'w-24', 'h-24');

                                // Table cells
                                // const actionCell = document.createElement('td');
                                const imageCell = document.createElement('td');
                                const nameCell = document.createElement('td');

                                // actionCell.appendChild(deleteBtn);
                                imageCell.appendChild(imgElement);
                                nameCell.textContent = fileName;

                                // actionCell.classList.add('px-4', 'py-2', 'border-r', 'border-gray-300');
                                imageCell.classList.add('px-4', 'py-2', 'border-r', 'border-gray-300');
                                nameCell.classList.add('px-4', 'py-2');

                                // row.appendChild(actionCell);
                                row.appendChild(imageCell);
                                row.appendChild(nameCell);

                                imageContainer.appendChild(row);
                            });
                        } else {
                            imageContainer.innerHTML = '<tr><td colspan="3" class="text-center px-4 py-2">No images available</td></tr>';
                        }

                        modalEdit.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('An error occurred while fetching the data.');
                });
        }

        function closeModal() {
            modalEdit.classList.add('hidden');
        }

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;

            // Preview selected images
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('object-contain', 'w-24', 'h-24');

                    // Extract file name
                    const fileName = file.name;

                    // Create table row
                    const row = document.createElement('tr');
                    row.classList.add('border-b', 'border-gray-300');

                    // Delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.textContent = 'Delete';
                    deleteBtn.classList.add('px-4', 'py-2', 'bg-red-500', 'text-white', 'hover:bg-red-700', 'rounded');
                    deleteBtn.onclick = () => row.remove();

                    // Table cells
                    const actionCell = document.createElement('td');
                    const imageCell = document.createElement('td');
                    const nameCell = document.createElement('td');

                    actionCell.appendChild(deleteBtn);
                    imageCell.appendChild(img);
                    nameCell.textContent = fileName;

                    actionCell.classList.add('px-4', 'py-2', 'border-r', 'border-gray-300');
                    imageCell.classList.add('px-4', 'py-2', 'border-r', 'border-gray-300');
                    nameCell.classList.add('px-4', 'py-2');

                    row.appendChild(actionCell);
                    row.appendChild(imageCell);
                    row.appendChild(nameCell);

                    imageContainer.appendChild(row);
                };

                reader.readAsDataURL(file);
            }
        });

        document.querySelectorAll('.openEdiNewstModalBtn').forEach(button => {
            button.addEventListener('click', () => {
                const newsId = button.getAttribute('data-category-id');
                openModal(newsId);
            });
        });

        closeEditModalBtn.addEventListener('click', closeModal);

        modalEdit.addEventListener('click', (event) => {
            if (event.target === modalEdit) {
                closeModal();
            }
        });

        submitEditFormBtn.addEventListener('click', (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(`/pages/updateNews/${newsId}`, {
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
                            location.reload(); // Optionally reload the page to reflect changes
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
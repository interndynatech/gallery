<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="edit-modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6 pb-4">
                <h3 class="text-2xl font-medium capitalize leading-6 text-teal-500" id="edit-modal-title">
                    Edit Product
                </h3>
                <button id="closeEditModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>

            <form class="mt-4" id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editProductId" name="productId">

                <div class="px-5 pb-5">
                    <p class="text-gray-500">Product Name</p>
                    <input placeholder="Enter product name..." id="editProductName" name="productName" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white focus:outline-none">
                </div>

                <div class="px-5 pb-5">
                    <label for="editStatus" class="block text-sm font-medium text-gray-700">Status</label>
                    <p class="text-gray-300 text-xs">Status is used to display products on the homepage*</p>
                    <select name="status" id="editStatus" class="text-black w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white focus:outline-none">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                </div>
                <div class="px-5 pb-5">
                    <p class="text-gray-500">Categories</p>
                    <input disabled placeholder="Enter Categories" id="editCategories" name="categories" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-50 focus:border-blueGray-500 focus:bg-white focus:outline-none">
                </div>

                <div class="px-5 pb-5">
                    <p class="text-gray-500">Product Description</p>
                    <textarea placeholder="Enter product description..." id="editProductDesc" name="productDesc" rows="4" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white focus:outline-none"></textarea>
                </div>

                <div class="px-5 pb-5">
                    <p class="text-gray-500">Product Features</p>
                    <textarea placeholder="Enter product features..." id="editProductFeatures" name="productFeatures" rows="6" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white focus:outline-none"></textarea>
                </div>

                <div class="px-5 pb-5">
                    <p class="text-gray-500 pb-2">Product Main Image</p>
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Name</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border border-gray-300">
                                    <img id="editProductImage" class="w-32 h-32 object-cover rounded-lg border border-gray-300" alt="Product Image">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border border-gray-300">
                                    <p id="editProductImageName" class="text-gray-900"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Input for updating main image -->
                    <input type="file" id="editMainImageFile" name="mainImage" class="mt-2 border border-gray-300 rounded-lg py-2 w-full text-sm" accept="image/*">
                </div>

                <div class="px-5 pb-5">
                    <p class="text-gray-500 pb-2">Product Carousel Images</p>
                    <table id="carouselTable" class="min-w-full divide-y divide-gray-200 border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Name</th>
                            </tr>
                        </thead>
                        <tbody id="carouselContainer" class="bg-white divide-y divide-gray-200">
                            <!-- Carousel images will be inserted here -->
                        </tbody>
                    </table>
                    <!-- Input for updating carousel images -->
                    <input type="file" id="editCarouselImages" name="carouselImages[]" class="mt-2 border border-gray-300 rounded-lg w-full  py-2 text-sm" accept="image/*" multiple>
                </div>

                <!-- Submit button -->
                <button type="submit" id="submitEditFormBtn" class=" mt-4 w-full bg-teal-500 text-white py-2 rounded-lg hover:bg-teal-600">Update Product</button>



            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('editModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editProductForm = document.getElementById('editProductForm');
        const carouselContainer = document.getElementById('carouselContainer');
        const editProductId = document.getElementById('editProductId');
        const editProductName = document.getElementById('editProductName');
        const editStatus = document.getElementById('editStatus');
        const editProductDesc = document.getElementById('editProductDesc');
        const editProductFeatures = document.getElementById('editProductFeatures');
        const editProductImage = document.getElementById('editProductImage');
        const editProductImageName = document.getElementById('editProductImageName');
        const editMainImageFile = document.getElementById('editMainImageFile');
        const editCarouselImages = document.getElementById('editCarouselImages');

        // Function to extract file name from file path
        function extractFileName(filePath) {
            return filePath ? filePath.split('/').pop() : 'Unknown File';
        }

        function openEditModal() {
            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }

        // Close modal on button click
        closeEditModalBtn.addEventListener('click', closeEditModal);

        // Close modal on outside click
        editModal.addEventListener('click', (event) => {
            if (event.target === editModal) {
                closeEditModal();
            }
        });

        // Handle form submission
        editProductForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(editProductForm);

            try {
                const response = await fetch(`/pages/updateProducts/${editProductId.value}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Product updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        closeEditModal();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'An error occurred while updating the product.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }

            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Fetch product data and open modal
        document.querySelectorAll('.openEditProductsBtn').forEach(button => {
            button.addEventListener('click', async (event) => {
                const productId = event.currentTarget.getAttribute('data-product-id');

                try {
                    const response = await fetch(`/pages/showProducts/${productId}`);
                    const productData = await response.json();

                    editProductId.value = productData.productId;
                    editProductName.value = productData.productName;
                    editStatus.value = productData.status;
                    editProductDesc.value = productData.productDesc;
                    editProductFeatures.value = productData.productFeatures;
                    editCategories.value = productData.category;


                    // Set main image
                    const mainImageFileName = extractFileName(productData.imagePath);
                    editProductImage.src = `/assets/${productData.imagePath}`;
                    editProductImageName.textContent = mainImageFileName;

                    // Clear previous carousel images
                    carouselContainer.innerHTML = '';

                    // Display fetched carousel images
                    if (productData.imageUrls && productData.imageUrls.length > 0) {
                        productData.imageUrls.forEach((url) => {
                            const fileName = extractFileName(url);

                            const row = document.createElement('tr');
                            row.classList.add('border-b', 'border-gray-300');

                            const imgElement = document.createElement('img');
                            imgElement.src = url;
                            imgElement.alt = fileName;
                            imgElement.classList.add('object-contain', 'w-24', 'h-24');

                            const imageCell = document.createElement('td');
                            const nameCell = document.createElement('td');

                            imageCell.appendChild(imgElement);
                            nameCell.textContent = fileName;

                            imageCell.classList.add('px-4', 'py-2', 'border-r', 'border-gray-300');
                            nameCell.classList.add('px-4', 'py-2');

                            row.appendChild(imageCell);
                            row.appendChild(nameCell);

                            carouselContainer.appendChild(row);
                        });
                    } else {
                        carouselContainer.innerHTML = '<tr><td colspan="2" class="text-center px-4 py-2">No images available</td></tr>';
                    }

                    openEditModal();
                } catch (error) {
                    console.error('Error fetching product data:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while fetching product data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

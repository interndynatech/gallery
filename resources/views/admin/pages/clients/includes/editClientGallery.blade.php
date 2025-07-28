<!-- Modal Edit Client Gallery -->
<div class="fixed inset-0 z-50 overflow-y-auto hidden" id="editClientGalleryModal{{ $item->id_group }}" tabindex="-1" role="dialog" aria-labelledby="editClientGalleryModalLabel{{ $item->id_group }}" aria-hidden="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">

            <div class="flex items-start justify-between pl-6">
                <h3 class="text-2xl font-bold leading-6 text-gray-800" id="modal-title">
                    Edit Client Gallery
                </h3>
                <button type="button" id="closeEditModalBtn{{ $item->id_group }}" class="text-gray-500 hover:text-gray-700 text-xl pr-6">&times;</button>
            </div>

            <form class="mt-4" id="editClientGalleryForm{{ $item->id_group }}" method="POST" action="{{ route('admin.pages.client-gallery.update', $item->id_group) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="px-5 pb-5 space-y-4">
                    <!-- clientName -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Client Name</p>
                        <input type="text" value="{{ $item->clientName }}" disabled class="w-full px-4 py-2.5 rounded-lg bg-gray-200 text-black" />
                    </div>

                    <!-- type -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Type</p>
                        <select name="type" class="w-full px-4 py-2.5 rounded-lg text-black">
                            <option value="training" @if($item->type === 'training') selected @endif>Training</option>
                            <option value="exhibition" @if($item->type === 'exhibition') selected @endif>Exhibition</option>
                            <option value="visit" @if($item->type === 'visit') selected @endif>Visit</option>
                        </select>
                    </div>

                    <!-- title -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Title</p>
                        <input type="text" name="title" value="{{ $item->title }}" class="w-full px-4 py-2.5 rounded-lg text-black" />
                    </div>

                    <!-- description -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Description</p>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-lg text-black">{{ $item->description }}</textarea>
                    </div>

                    <!-- date -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Date</p>
                        <input type="date" name="date" value="{{ $item->date }}" class="w-full px-4 py-2.5 rounded-lg text-black" />
                    </div>

                    <!-- current images -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Current Images</p>
                        <table class="w-full mt-4 border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300">
                                    <th class="px-4 py-2 border-r">Image</th>
                                    <th class="px-4 py-2">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($relatedImages as $img)
                                    <tr class="border-b border-gray-300">
                                        <td class="px-4 py-2 border-r">
                                            <img src="{{ asset('assets/images/clientGallery/' . $img->type . '/' . $img->image_path) }}" alt="{{ $img->image_path }}" class="w-24 h-24 object-contain">
                                        </td>
                                        <td class="px-4 py-2">{{ $img->image_path }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center px-4 py-2">No images found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Enhanced upload section with drag & drop -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">New Images (optional)</p>
                        <div class="upload-area border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-teal-400 hover:bg-teal-50 transition-all cursor-pointer mt-2" id="uploadArea{{ $item->id_group }}">
                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="fileInput{{ $item->id_group }}">
                            
                            <div class="upload-content" id="uploadContent{{ $item->id_group }}">
                                <svg class="w-8 h-8 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-gray-600 mb-2">Drop your images here or <span class="text-teal-600 font-medium">click to browse</span></p>
                                <p class="text-sm text-gray-500">Supports: JPG, PNG, GIF (Max: 2MB each)</p>
                            </div>

                            <!-- Preview Area -->
                            <div class="preview-area hidden mt-4" id="previewArea{{ $item->id_group }}">
                                <div class="grid grid-cols-3 gap-3" id="previewGrid{{ $item->id_group }}">
                                    <!-- Preview images will be inserted here -->
                                </div>
                                <button type="button" class="mt-3 text-sm text-gray-500 hover:text-gray-700 underline" id="clearFiles{{ $item->id_group }}">
                                    Clear all files
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- submit -->
                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Close Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalId = 'editClientGalleryModal{{ $item->id_group }}';
        const closeBtnId = 'closeEditModalBtn{{ $item->id_group }}';
        const uploadAreaId = 'uploadArea{{ $item->id_group }}';
        const fileInputId = 'fileInput{{ $item->id_group }}';
        const previewAreaId = 'previewArea{{ $item->id_group }}';
        const previewGridId = 'previewGrid{{ $item->id_group }}';
        const uploadContentId = 'uploadContent{{ $item->id_group }}';
        const clearFilesId = 'clearFiles{{ $item->id_group }}';
        
        const modal = document.getElementById(modalId);
        const closeBtn = document.getElementById(closeBtnId);
        const uploadArea = document.getElementById(uploadAreaId);
        const fileInput = document.getElementById(fileInputId);
        const previewArea = document.getElementById(previewAreaId);
        const previewGrid = document.getElementById(previewGridId);
        const uploadContent = document.getElementById(uploadContentId);
        const clearFiles = document.getElementById(clearFilesId);

        console.log('Modal setup for:', modalId);
        console.log('Close button:', closeBtn);

        // Close button click handler
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Close button clicked for modal:', modalId);
                if (modal) {
                    modal.classList.add('hidden');
                    clearPreview();
                    console.log('Modal closed');
                } else {
                    console.error('Modal not found when trying to close');
                }
            });
        }

        // Drag and drop functionality
        if (uploadArea && fileInput) {
            // Click to upload
            uploadArea.addEventListener('click', () => fileInput.click());

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });

            // Handle dropped files
            uploadArea.addEventListener('drop', handleDrop, false);

            // Handle file input change
            fileInput.addEventListener('change', function(e) {
                handleFiles(e.target.files);
            });

            // Clear files handler
            if (clearFiles) {
                clearFiles.addEventListener('click', clearPreview);
            }
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            uploadArea.classList.add('border-teal-500', 'bg-teal-100');
        }

        function unhighlight(e) {
            uploadArea.classList.remove('border-teal-500', 'bg-teal-100');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                // Update file input
                const dt = new DataTransfer();
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        dt.items.add(file);
                    }
                });
                

                // Show preview
                showPreview(dt.files);
            }
        }

        function showPreview(files) {
            previewGrid.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'relative group';
                    previewItem.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="w-full h-20 object-cover rounded border-2 border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded transition-all flex items-center justify-center">
                            <button type="button" class="w-6 h-6 bg-red-500 text-white rounded-full text-xs hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100" onclick="removePreviewItem${modalId.replace(/[^a-zA-Z0-9]/g, '')}(${index})">×</button>
                        </div>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                    previewGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });

            uploadContent.classList.add('hidden');
            previewArea.classList.remove('hidden');
        }

        function clearPreview() {
            previewGrid.innerHTML = '';
            previewArea.classList.add('hidden');
            uploadContent.classList.remove('hidden');
            if (fileInput) {
                fileInput.value = '';
                // Prevent any auto-focus or click events
                fileInput.blur();
            }
        }

        // Make removePreviewItem function unique for this modal
        const removePreviewFunctionName = `removePreviewItem${modalId.replace(/[^a-zA-Z0-9]/g, '')}`;
        window[removePreviewFunctionName] = function(index) {
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            
            
            if (files.length === 0) {
                clearPreview();
            } else {
                showPreview(files);
            }
        };
    });
</script>

<style>
    .upload-area.dragover {
        border-color: #14b8a6 !important;
        background-color: #f0fdfa !important;
    }
</style>
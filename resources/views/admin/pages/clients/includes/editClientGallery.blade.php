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
                        <select name="type" class="w-full px-4 py-2.5 rounded-lg bg-gray-200 text-black">
                            <option value="training" @if($item->type === 'training') selected @endif>Training</option>
                            <option value="exhibition" @if($item->type === 'exhibition') selected @endif>Exhibition</option>
                            <option value="visit" @if($item->type === 'visit') selected @endif>Visit</option>
                        </select>
                    </div>

                    <!-- title -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Title</p>
                        <input type="text" name="title" value="{{ $item->title }}" class="w-full px-4 py-2.5 rounded-lg bg-gray-200 text-black" />
                    </div>

                    <!-- description -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Description</p>
                        <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-lg bg-gray-200 text-black">{{ $item->description }}</textarea>
                    </div>

                    <!-- date -->
                    <div>
                        <p class="text-teal-500 font-medium text-lg">Date</p>
                        <input type="date" name="date" value="{{ $item->date }}" class="w-full px-4 py-2.5 rounded-lg bg-gray-200 text-black" />
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

                    <!-- new image upload - SIMPLE VERSION -->
                    <div>
                        <label for="images{{ $item->id_group }}" class="block text-sm font-medium text-gray-700">Upload New Images</label>
                        <input type="file" name="images[]" id="images{{ $item->id_group }}" multiple accept="image/*"
                            class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <p class="text-xs text-gray-500 mt-2">You can select multiple images. Leave empty if you don't want to add new images.</p>
                    </div>
                </div>

                <!-- submit -->
                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="cancelBtn{{ $item->id_group }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-lg mr-4">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-teal-500 hover:bg-teal-700 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SIMPLIFIED Modal Close Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalId = 'editClientGalleryModal{{ $item->id_group }}';
        const closeBtnId = 'closeEditModalBtn{{ $item->id_group }}';
        const cancelBtnId = 'cancelBtn{{ $item->id_group }}';
        const fileInputId = 'images{{ $item->id_group }}';
        
        const modal = document.getElementById(modalId);
        const closeBtn = document.getElementById(closeBtnId);
        const cancelBtn = document.getElementById(cancelBtnId);
        const fileInput = document.getElementById(fileInputId);

        console.log('Modal setup for:', modalId);

        // Function to close modal and reset form
        function closeModal() {
            if (modal) {
                modal.classList.add('hidden');
                // Reset file input
                if (fileInput) {
                    fileInput.value = '';
                }
                console.log('Modal closed and form reset');
            }
        }

        // Close button click handler
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Close button clicked for modal:', modalId);
                closeModal();
            });
        }

        // Cancel button click handler
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Cancel button clicked for modal:', modalId);
                closeModal();
            });
        }

        // Close modal when clicking outside
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>
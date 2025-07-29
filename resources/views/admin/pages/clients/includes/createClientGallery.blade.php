<!--  new 2025-->
<!-- Modal: Add Client Gallery -->
<div id="createGalleryModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title">
                    Add Client Gallery
                </h3>
                <button id="closeGalleryModalBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="addGalleryForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.clients.storeClientGallery') }}">
                @csrf

                <div class="px-5 pb-5">
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                    <select name="client_id" id="client_id" required
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        @foreach(DB::table('clients')->where('status', 1)->get() as $client)
                            <option value="{{ $client->clientId }}">{{ $client->clientName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="px-5 pb-5">
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" required
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <option value="training">Training</option>
                        <option value="exhibition">Exhibition</option>
                        <option value="visit">Visit</option>
                    </select>
                </div>

                <div class="px-5 pb-5">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>

                <div class="px-5 pb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></textarea>
                </div>

                <div class="px-5 pb-5">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date"
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>

                <div class="px-5 pb-5">
                    <label for="images" class="block text-sm font-medium text-gray-700">Upload Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="text-black w-full px-4 py-2.5 mt-2 rounded-lg bg-gray-200 focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                    <p class="text-xs text-gray-500 mt-2">You can select multiple images.</p>
                </div>

                <div class="px-5 pb-5 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('createGalleryModal');
        const openBtn = document.getElementById('openAddGalleryModal');
        const closeBtn = document.getElementById('closeGalleryModalBtn');

        if (openBtn) {
            openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
</script>
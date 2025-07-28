<div id="editProjectsModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center bg-black bg-opacity-25 px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6 sm:align-middle">
            <div class="flex items-start justify-between pl-6">
                <h3 class="text-lg font-medium capitalize leading-6 text-gray-800" id="modal-title">
                    Edit Main Project
                </h3>
                <button id="editProjectsModalCloseBtn" class="text-gray-500 hover:text-gray-700">X</button>
            </div>
            <form class="mt-4" id="editProjectsForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-5 pb-5">
                    <input placeholder="Title" name="title" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <input placeholder="Intro Content" name="introContent" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                </div>
                <div class="px-5 pb-5">
                    <textarea placeholder="Description" name="desc" rows="4" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></textarea>
                </div>

                <div class="px-5 pb-5">
                    <input type="file" name="image" accept="image/*" class="text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-200 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400" id="editProjectsFileInput">
                    <p class="text-gray-500 py-2 text-xs">*Image uploaded must be in square size for better dimensional display</p>
                    <div id="editProjectsImagePreviews" class="mt-4"></div>
                </div>
                <div class="px-5 pb-5 flex justify-end">
                    <button type="button" id="editProjectsSubmitFormBtn" class="px-4 py-2 bg-teal-500 text-white rounded-lg">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editProjectsModal');
    const openModalBtns = document.querySelectorAll('.openEditProjectsModalBtn');
    const closeModalBtn = document.getElementById('editProjectsModalCloseBtn');
    const editProjectsSubmitFormBtn = document.getElementById('editProjectsSubmitFormBtn');
    const fileInput = document.getElementById('editProjectsFileInput');
    const imagePreviews = document.getElementById('editProjectsImagePreviews');
    const form = document.getElementById('editProjectsForm');
    
    let currentCategoryId = null;

    function openModal() {
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        form.reset();
        imagePreviews.innerHTML = '';
    }

    openModalBtns.forEach(btn => {
        btn.addEventListener('click', async (event) => {
            currentCategoryId = btn.getAttribute('data-category-id');

            try {
                const response = await fetch(`/pages/showProjects/${currentCategoryId}`);
                const data = await response.json();

                if (response.ok) {
                    form.querySelector('input[name="title"]').value = data.title;
                    form.querySelector('input[name="introContent"]').value = data.introContent;
                    form.querySelector('textarea[name="desc"]').value = data.desc;

                    if (data.imagePath) {
                        const img = document.createElement('img');
                        img.src = `/assets/images/mainProjects/${data.imagePath}?t=${new Date().getTime()}`; // Add timestamp to prevent caching
                        img.classList.add('object-cover', 'w-full', 'h-full');

                        const container = document.createElement('div');
                        container.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
                        container.style.width = '200px';
                        container.style.height = '200px';
                        container.style.maxHeight = '200px';
                        container.style.maxWidth = '200px';

                        container.appendChild(img);
                        imagePreviews.appendChild(container);
                    }

                    openModal();
                } else {
                    console.error('Failed to fetch project data:', data.message);
                }
            } catch (error) {
                console.error('Error fetching project data:', error);
            }
        });
    });

    closeModalBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        imagePreviews.innerHTML = '';

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('object-cover', 'w-full', 'h-full');

                const container = document.createElement('div');
                container.classList.add('relative', 'overflow-hidden', 'border', 'border-gray-200', 'p-2');
                container.style.width = '200px';
                container.style.height = '200px';
                container.style.maxHeight = '200px';
                container.style.maxWidth = '200px';

                container.appendChild(img);
                imagePreviews.appendChild(container);
            };

            reader.readAsDataURL(file);
        }
    });

    editProjectsSubmitFormBtn.addEventListener('click', (event) => {
        event.preventDefault();

        if (currentCategoryId === null) {
            Swal.fire({
                title: 'Error!',
                text: 'No project selected for update.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        const formData = new FormData(form);

        fetch(`/pages/updateProjects/${currentCategoryId}`, {
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
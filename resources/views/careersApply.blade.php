@extends('layouts.app')

@section('content')
<div class="container mx-auto p-5 py-10">
    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
        <form id="applicantForm" class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-8 py-4 md:py-8">
            <div class="flex flex-col gap-4">
                <div class="pb-5">
                    <h1 class="text-teal-500 text-2xl font-bold">Application Form</h1>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" value="{{ $career->title }}" readonly class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm bg-gray-100" placeholder="Title">
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                        <input type="text" id="position" name="position" value="{{ $career->position }}" readonly class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm bg-gray-100" placeholder="Position">
                    </div>
                </div>
                <div>
                    <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name*</label>
                    <input type="text" id="fullName" name="fullName" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Full Name">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address*</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Email Address">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Age*</label>
                        <input type="number" id="age" name="age" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Age">
                    </div>
                    <div>
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number*</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Phone Number">
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address*</label>
                    <textarea id="address" name="address" rows="3" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Address"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-gray-700">Postcode*</label>
                        <input type="text" id="postcode" name="postcode" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Postcode">
                    </div>
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700">Area*</label>
                        <input type="text" id="area" name="area" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Area">
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State*</label>
                        <input type="text" id="state" name="state" required class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="State">
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center gap-6">
            <div class="relative w-40 h-40 md:w-56 md:h-56 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                    <img id="imagePreview" src="" alt="Profile Image Preview" class="object-cover w-full h-full hidden rounded-full">
                    <span id="uploadText" class="text-gray-500">Upload Image*</span>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                </div>
                <div class="w-full md:px-5">
                    <label for="resume" class="block text-sm font-medium text-gray-700">Resume*</label>
                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>
                
                <div class="w-full md:px-5">
                    <label for="coverLetter" class="block text-sm font-medium text-gray-700">Exam Transcripts</label>
                    <input type="file" id="transcriptExam" name="transcriptExam" accept=".pdf,.doc,.docx"  class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>
                <div class="w-full md:px-5">
                    <label for="supportingDocs" class="block text-sm font-medium text-gray-700">Supporting Documents</label>
                    <input type="file" id="supportingDocs" name="supportingDocs"  accept=".pdf,.doc,.docx"   class="mt-1 block w-full border-2 border-gray-200 rounded-lg shadow-sm px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <button type="submit" class="w-full px-6 py-3 bg-teal-500 text-white rounded-lg shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-opacity-50">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    function previewImage(event) {
        const input = event.target;
        const file = input.files[0];
        const preview = document.getElementById('imagePreview');
        const uploadText = document.getElementById('uploadText');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                uploadText.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            uploadText.classList.remove('hidden');
        }
    }

    document.getElementById('applicantForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('{{ route("storeApplicants") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Application submitted successfully!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload(); // Reload the page
                });
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error submitting your application. Please try again.',
                    confirmButtonText: 'OK'
                });
            });
    });
</script>

@endsection
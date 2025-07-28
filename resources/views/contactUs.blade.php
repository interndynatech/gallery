@extends('layouts.app')

@section('content')
<section class="dark:bg-gray-900">
    <div class="container mx-auto flex justify-center px-6 py-4">
        <div class="mt-10 grid max-w-6xl grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col items-center justify-center text-center md:col-span-2 lg:col-span-2">
                <div class="mx-auto text-left md:pr-20">
                    <h2 class="mt-5 text-3xl font-bold leading-tight text-teal-500 sm:text-4xl lg:text-5xl">Contact Us
                    </h2>
                    <p class="mx-auto mt-3 text-base leading-relaxed text-black">Have questions or need assistance? We're
                        here to help! Reach out to our friendly support team via phone call or find us at the location.
                        We look forward to hearing from you!
                    </p>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center text-center">
                <span class="rounded-full bg-teal-100/80 p-3 text-teal-500 dark:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <h2 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Location</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Dynamic Traffic System Sdn Bhd
                </p>
                <p class="mt-2 text-sm text-teal-500 dark:text-teal-400">
                    <a href="https://maps.app.goo.gl/4sJGuNcKUhzpfh5B6" target="_blank">
                        52, Jalan Seroja 5d/2, Seksyen BS6 Bukit Sentosa, 48300 Rawang, Selangor
                    </a>
                </p>

            </div>
            <div class="flex flex-col items-center justify-center text-center">
                <span class="rounded-full bg-teal-100/80 p-3 text-teal-500 dark:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                    </svg>

                </span>
                <h2 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Email</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Contact us via <br> our email
                </p>
                <a href="mailto:sales@dynasystem.info" class="mt-2 text-teal-500 dark:text-teal-400">
                    sales@dynasystem.info
                </a>

            </div>
        </div>
    </div>
</section>

<section class="pb-10">
    <div
        class="relative mx-auto my-6 grid max-w-6xl gap-16 overflow-hidden rounded-3xl p-10 font-[sans-serif] text-[#333] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] before:absolute before:right-0 before:h-full before:w-[300px] before:bg-teal-500 max-md:before:hidden md:grid-cols-2">
        <div>
            <h2 class="text-3xl">Contact Form</h2>
            <p class="mt-3 text-sm text-gray-400">Do you have any inquiries? We would love to hear from you</p>
            <form id="contactForm" action="{{ route('storeContact') }}" method="POST">
                @csrf <!-- Include CSRF token for security -->
                <div class="mt-8 space-y-4">
                    <input type="text" placeholder="Name" name="name" id="name" autocomplete="name" required
                        class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 placeholder-gray-400 focus:border-teal-400 focus:outline-none focus:ring focus:ring-teal-400 focus:ring-opacity-40 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-teal-400" />
                    <div class="grid grid-cols-2 gap-6">
                        <input type="email" placeholder="Email" name="email" id="email" required
                            autocomplete="email"
                            class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 placeholder-gray-400 focus:border-teal-400 focus:outline-none focus:ring focus:ring-teal-400 focus:ring-opacity-40 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-teal-400" />
                        <input type="text" placeholder="Phone Number" name="contact_no" id="contact_no"
                            class="mt-2 block w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 placeholder-gray-400 focus:border-teal-400 focus:outline-none focus:ring focus:ring-teal-400 focus:ring-opacity-40 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-teal-400" />
                    </div>
                    <div class="form-group mb-4">
                        <label for="typeOfEnquiry" class="sr-only">Type Of Enquiry</label>
                        <select id="typeOfEnquiry" name="typeOfEnquiry" required
                            class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 placeholder-gray-400 focus:border-teal-400 focus:outline-none focus:ring focus:ring-teal-400 focus:ring-opacity-40 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:placeholder-gray-600 dark:focus:border-teal-400">
                            <option value="" disabled selected>Select Type Of Enquiry</option>
                            <option value="General Enquiry">General Enquiry</option>
                            <option value="Products">Complaints and Suggestions</option>
                            <option value="Products">Products</option>
                            <option value="Maintenance">Maintenance</option>

                        </select>
                    </div>
                    <textarea name="message" id="message" placeholder="Your message (Max 255 characters)" required
                        class="mt-1 block w-full resize-none rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-900 placeholder-gray-500 focus:border-teal-500 focus:outline-none focus:ring-teal-500"
                        rows="4" maxlength="255"></textarea>
                </div>

                <button type="submit" id="submit"
                    class="mt-8 flex w-full items-center justify-center rounded bg-teal-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill='#fff'
                        class="mr-2" viewBox="0 0 548.244 548.244">
                        <path fill-rule="evenodd"
                            d="M392.19 156.054 211.268 281.667 22.032 218.58C8.823 214.168-.076 201.775 0 187.852c.077-13.923 9.078-26.24 22.338-30.498L506.15 1.549c11.5-3.697 24.123-.663 32.666 7.88 8.542 8.543 11.577 21.165 7.879 32.666L390.89 525.906c-4.258 13.26-16.575 22.261-30.498 22.338-13.923.076-26.316-8.823-30.728-22.032l-63.393-190.153z"
                            clip-rule="evenodd" data-original="#000000" />
                    </svg>
                    Send Message
                </button>
            </form>

        </div>
        <div class="relative z-10 h-full max-md:min-h-[350px]">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15930.973881332427!2d101.5862666!3d3.4125882!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc693c399e8a57%3A0x7d88adc7aa226bec!2sDynamic%20Traffic%20System%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1725937473873!5m2!1sen!2smy" class="left-0 top-0 h-[350px] w-full rounded-t-lg lg:h-full lg:rounded-bl-lg lg:rounded-tr-none"
                frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch(form.action, { // Use the form's action attribute
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) { // Check if the response has the message property
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
                form.reset(); // Reset the form fields
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong. Please try again later.',
                confirmButtonText: 'OK'
            });
        });
    });
});
</script>


@endsection
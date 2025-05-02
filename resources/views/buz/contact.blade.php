@extends('buz.layouts.layout')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Contact Us
            </h2>
            <p class="mt-4 text-lg leading-6 text-gray-500">
                We'd love to hear from you! Get in touch with us for any inquiries or support.
            </p>
        </div>

        <div class="mt-10 bg-white rounded-lg shadow-lg p-8 sm:p-12">
            <form action="#" method="POST" class="space-y-8">
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                        <div class="mt-1">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-green-500 focus:border-green-500 border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <div class="mt-1">
                            <input type="text" name="last-name" id="last-name" autocomplete="family-name"
                                class="py-3 px-4 block w-full shadow-sm focus:ring-green-500 focus:border-green-500 border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email"
                            class="py-3 px-4 block w-full shadow-sm focus:ring-green-500 focus:border-green-500 border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <div class="mt-1">
                        <input type="text" name="phone" id="phone" autocomplete="tel"
                            class="py-3 px-4 block w-full shadow-sm focus:ring-green-500 focus:border-green-500 border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <div class="mt-1">
                        <textarea id="message" name="message" rows="4"
                            class="py-3 px-4 block w-full shadow-sm focus:ring-green-500 focus:border-green-500 border-gray-300 rounded-md"></textarea>
                    </div>
                </div>

                <div class="pt-5">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Send Message
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <div class="mx-auto h-12 w-12 text-white bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Our Office</h3>
                <p class="mt-2 text-base text-gray-500">
                    Cathedral Road,Nairobi, Kilimo House. P.O. Box 30028-00100 Kenya.<br>
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <div class="mx-auto h-12 w-12 text-white bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-phone"></i>
                    </div>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Phone</h3>
                <p class="mt-2 text-base text-gray-500">
                    +254 700 000 000<br>
                    Mon-Fri 8am-5pm
                </p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <div class="mx-auto h-12 w-12 text-white bg-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Email</h3>
                <p class="mt-2 text-base text-gray-500">
                    info@kilimobuz.com<br>
                    support@kilimobuz.com
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

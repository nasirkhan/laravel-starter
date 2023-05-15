@extends('frontend.layouts.app')

@section('title')
    {{ __('Tags') }}
@endsection

@section('content')
    <section class="bg-gray-100 text-gray-600 py-20">
        <div class="container mx-auto flex px-5 items-center justify-center flex-col">
            <div class="text-center lg:w-2/3 w-full">
                <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                    {{ __('Portfolio') }}
                </h1>
                <p class="mb-8 leading-relaxed">
                    This is a personal portfolio
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </section>

    <section class="bg-white text-gray-600 py-6 sm:py-20">
        <div class="container mx-auto">
            <div class="">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg shadow-md">
                        <img src="{{ url('img/1000px-blue-cube-logo.jpg') }}" alt="Portfolio 1"
                            class="w-full h-64 object-cover rounded-t-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">Project 1</h3>
                            <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin commodo
                                ultrices purus, in elementum est tincidunt non.</p>
                            <a href="javascript:void(0)"
                                class="mt-4 inline-block bg-blue-500 text-dark px-4 py-2 rounded hover:bg-blue-600"
                                onclick="openModal('modal-1')">View Details</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md">
                        <img src="{{ url('img/1000px-blue-cube-logo.jpg') }}" alt="Portfolio 2"
                            class="w-full h-64 object-cover rounded-t-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">Project 2</h3>
                            <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin commodo
                                ultrices purus, in elementum est tincidunt non.</p>
                            <a href="javascript:void(0)"
                                class="mt-4 inline-block bg-blue-500 text-dark px-4 py-2 rounded hover:bg-blue-600"
                                onclick="openModal('modal-2')">View Details</a>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md">
                        <img src="{{ url('img/1000px-blue-cube-logo.jpg') }}" alt="Portfolio 3"
                            class="w-full h-64 object-cover rounded-t-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">Project 3</h3>
                            <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin commodo
                                ultrices purus, in elementum est tincidunt non.</p>
                            <a href="javascript:void(0)"
                                class="mt-4 inline-block bg-blue-500 text-dark px-4 py-2 rounded hover:bg-blue-600"
                                onclick="openModal('modal-3')">View Details</a>
                        </div>
                    </div>
                    <!-- Repeat the above structure for more portfolio items -->
                </div>
            </div>
        </div>
    </section>

    <div id="modal-1" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <!-- Modal content goes here -->
            <h2 class="modal-title">Modal Title</h2>
            <p class="modal-description">Modal description goes here.</p>
            <button class="modal-close" onclick="closeModal('modal-1')">Close</button>
        </div>
    </div>
    <div id="modal-2" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <!-- Modal content goes here -->
            <h2 class="modal-title">Modal Title</h2>
            <p class="modal-description">Modal description goes here.</p>
            <button class="modal-close" onclick="closeModal('modal-2')">Close</button>
        </div>
    </div>
    <div id="modal-3" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <!-- Modal content goes here -->
            <h2 class="modal-title">Modal Title</h2>
            <p class="modal-description">Modal description goes here.</p>
            <button class="modal-close" onclick="closeModal('modal-3')">Close</button>
        </div>
    </div>
@endsection


@push('after-scripts')
    <script>
        // Function to open the modal
        function openModal(modalId) {
            console.log('calling modal');
            const modal = document.getElementById(modalId);
            modal.classList.add('open');
        }

        // Function to close the modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('open');
        }
    </script>
@endpush

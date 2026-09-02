@extends("backend.layouts.app")

@section("title")
    @lang("Dashboard")
@endsection

@section("breadcrumbs")
    <x-cube::backend-breadcrumbs />
@endsection

@section("content")
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6">
            <x-cube::backend-section-header>
                @lang("Admin Dashboard")

                <x-slot name="toolbar">
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-gray-700"
                        type="button"
                        title="Announce"
                    >
                        <i class="fa-solid fa-bullhorn"></i>
                    </button>
                </x-slot>
            </x-cube::backend-section-header>

            <!-- Dashboard Content Area -->

            <!-- / Dashboard Content Area -->
        </div>
    </div>

    {{-- Demo content --}}
    @include("backend.includes.dashboard_demo_data")
@endsection

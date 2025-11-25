<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand d-sm-flex justify-content-center">
            <a href="/">
                <img
                    class="sidebar-brand-full"
                    src="{{ asset("img/logo-with-text.jpg") }}"
                    alt="{{ app_name() }}"
                    height="46"
                />
                <img
                    class="sidebar-brand-narrow"
                    src="{{ asset("img/logo-square.jpg") }}"
                    alt="{{ app_name() }}"
                    height="46"
                />
            </a>
        </div>
        <button
            class="btn-close d-lg-none"
            data-coreui-dismiss="offcanvas"
            data-coreui-theme="dark"
            type="button"
            aria-label="Close"
            onclick='coreui.Sidebar.getInstance(document.querySelector("#sidebar")).toggle()'
        ></button>
    </div>

    {{-- Dynamic Menu from Database --}}
    <x-backend.dynamic-menu location="admin-sidebar" />

    {{-- Fallback: Load menu items from menu_data.json (in case dynamic menu is empty) --}}
    @php
        $hasMenuItems = \Modules\Menu\Models\Menu::getCachedMenuData("admin-sidebar", auth()->user())->isNotEmpty();
    @endphp

    @if (! $hasMenuItems)
        <x-backend.fallback-sidebar-menu />
    @endif

    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" data-coreui-toggle="unfoldable" type="button"></button>
    </div>
</div>

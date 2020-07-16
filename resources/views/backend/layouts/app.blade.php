<!doctype html>
<html lang="en">
 <head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
 <!-- <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="{{ mix('css/backend.css') }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
 </head>
 <body class="c-app">
 
 <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  <div class="c-sidebar-brand"><img class="c-sidebar-brand-full" src="/img/brand/coreui-base-white.svg" width="118" height="46" alt="CoreUI Logo"><img class="c-sidebar-brand-minimized" src="/img/brand/coreui-signet-white.svg" width="118" height="46" alt="CoreUI Logo"></div>
    <ul class="c-sidebar-nav">
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="http://localhost/">
          <i class="cil-speedometer c-sidebar-nav-icon"></i> Dashboard
          </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="http://localhost/login">
          <i class="cil-account-logout c-sidebar-nav-icon"></i> Login
          </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="http://localhost/register">
          <i class="cil-account-logout c-sidebar-nav-icon"></i> Register
          </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="http://localhosthttps://coreui.io">
          <i class="cil-cloud-download c-sidebar-nav-icon"></i> Download CoreUI
          </a>
      </li>
      <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="http://localhosthttps://coreui.io/pro/">
          <i class="cil-layers c-sidebar-nav-icon"></i> Try CoreUI PRO
        </a>
      </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
  </div>

  <div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="/img/brand/coreui-base.svg" width="97" height="46" alt="CoreUI Logo"></a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        <?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
            }
        ?>  
        <ul class="c-header-nav ml-auto mr-4">
          <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-bell"></use>
              </svg></a></li>
          <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-list-rich"></use>
              </svg></a></li>
          <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link">
              <svg class="c-icon">
                <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-envelope-open"></use>
              </svg></a></li>
          <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="c-avatar"><img class="c-avatar-img" src="/img/favicon.png" alt="user@email.com"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
              <div class="dropdown-header bg-light py-2"><strong>Account</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-bell"></use>
                </svg> Updates<span class="badge badge-info ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-envelope-open"></use>
                </svg> Messages<span class="badge badge-success ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-task"></use>
                </svg> Tasks<span class="badge badge-danger ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-comment-square"></use>
                </svg> Comments<span class="badge badge-warning ml-auto">42</span></a>
              <div class="dropdown-header bg-light py-2"><strong>Settings</strong></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-user"></use>
                </svg> Profile</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-settings"></use>
                </svg> Settings</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-credit-card"></use>
                </svg> Payments<span class="badge badge-secondary ml-auto">42</span></a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-file"></use>
                </svg> Projects<span class="badge badge-primary ml-auto">42</span></a>
              <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-lock-locked"></use>
                </svg> Lock Account</a><a class="dropdown-item" href="#">
                <svg class="c-icon mr-2">
                  <use xlink:href="{{ env('APP_URL', '') }}/img/sprites/free.svg#cil-account-logout"></use>
                </svg><form action="/logout" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button></form></a>
            </div>
          </li>
        </ul>
        <div class="c-subheader px-3">
          <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <?php $segments = ''; ?>
            @for($i = 1; $i <= count(Request::segments()); $i++)
                <?php $segments .= '/'. Request::segment($i); ?>
                @if($i < count(Request::segments()))
                    <li class="breadcrumb-item">{{ Request::segment($i) }}</li>
                @else
                    <li class="breadcrumb-item active">{{ Request::segment($i) }}</li>
                @endif
            @endfor
          </ol>
        </div>
    </header>

    <div class="c-body">
      <main class="c-main">
        <div class="container-fluid">

          <div class="animated fadeIn">

              @include('flash::message')

              <!-- Errors block -->
              @include('backend.includes.errors')
              <!-- / Errors block -->

              @yield('content')

          </div>
        </div>
      </main>
    </div>

    <!-- Footer block -->
    @include('backend.includes.footer')
    <!-- / Footer block -->

 <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.bundle.min.js"></script>
 </body>
</html>
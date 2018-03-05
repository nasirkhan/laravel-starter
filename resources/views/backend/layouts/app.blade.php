<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Now UI Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    <link rel="stylesheet" href="{{ mix('css/app_backend.css') }}">

    <script src="/js/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

</head>

<body class="sidebar-mini ">
    <div class="wrapper">
        <div class="sidebar" data-color="orange">
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->

        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                CT
            </a>

            <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                Creative Tim
            </a>
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-simple btn-icon btn-neutral btn-round">
                    <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
                    <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
                </button>
            </div>
        </div>

        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="../assets/img/james.jpg" />
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                        <span>
                            James Amos
                            <b class="caret"></b>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#">
                                    <span class="sidebar-mini-icon">MP</span>
                                    <span class="sidebar-normal">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sidebar-mini-icon">EP</span>
                                    <span class="sidebar-normal">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sidebar-mini-icon">S</span>
                                    <span class="sidebar-normal">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">

                <li class="active">
                    <a href="./dashboard.html">
                        <i class="now-ui-icons design_app"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#pagesExamples">
                        <i class="now-ui-icons design_image"></i>
                        <p>Pages
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="pagesExamples">
                        <ul class="nav">
                            <li>
                                <a href="./pages/pricing.html">
                                    <span class="sidebar-mini-icon">P</span>
                                    <span class="sidebar-normal">Pricing</span>
                                </a>
                            </li>
                            <li>
                                <a href="./pages/timeline.html">
                                    <span class="sidebar-mini-icon">T</span>
                                    <span class="sidebar-normal">Timeline</span>
                                </a>
                            </li>
                            <li>
                                <a href="./pages/login.html">
                                    <span class="sidebar-mini-icon">L</span>
                                    <span class="sidebar-normal">Login</span>
                                </a>
                            </li>
                            <li>
                                <a href="./pages/register.html">
                                    <span class="sidebar-mini-icon">R</span>
                                    <span class="sidebar-normal">Register</span>
                                </a>
                            </li>
                            <li>
                                <a href="./pages/lock.html">
                                    <span class="sidebar-mini-icon">LS</span>
                                    <span class="sidebar-normal">Lock Screen</span>
                                </a>
                            </li>
                            <li>
                                <a href="./pages/user.html">
                                    <span class="sidebar-mini-icon">UP</span>
                                    <span class="sidebar-normal">User Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#componentsExamples">
                        <i class="now-ui-icons education_atom"></i>
                        <p>Components
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="componentsExamples">
                        <ul class="nav">
                            <li>
                                <a href="./components/buttons.html">
                                    <span class="sidebar-mini-icon">B</span>
                                    <span class="sidebar-normal">Buttons</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/grid.html">
                                    <span class="sidebar-mini-icon">GS</span>
                                    <span class="sidebar-normal">Grid System</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/panels.html">
                                    <span class="sidebar-mini-icon">P</span>
                                    <span class="sidebar-normal">Panels</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/sweet-alert.html">
                                    <span class="sidebar-mini-icon">SA</span>
                                    <span class="sidebar-normal">Sweet Alert</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/notifications.html">
                                    <span class="sidebar-mini-icon">N</span>
                                    <span class="sidebar-normal">Notifications</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/icons.html">
                                    <span class="sidebar-mini-icon">I</span>
                                    <span class="sidebar-normal">Icons</span>
                                </a>
                            </li>
                            <li>
                                <a href="./components/typography.html">
                                    <span class="sidebar-mini-icon">T</span>
                                    <span class="sidebar-normal">Typography</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#formsExamples">
                        <i class="now-ui-icons files_single-copy-04"></i>
                        <p>Forms
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="formsExamples">
                        <ul class="nav">
                            <li>
                                <a href="./forms/regular.html">
                                    <span class="sidebar-mini-icon">RF</span>
                                    <span class="sidebar-normal">Regular Forms</span>
                                </a>
                            </li>
                            <li>
                                <a href="./forms/extended.html">
                                    <span class="sidebar-mini-icon">EF</span>
                                    <span class="sidebar-normal">Extended Forms</span>
                                </a>
                            </li>
                            <li>
                                <a href="./forms/validation.html">
                                    <span class="sidebar-mini-icon">VF</span>
                                    <span class="sidebar-normal">Validation Forms</span>
                                </a>
                            </li>
                            <li>
                                <a href="./forms/wizard.html">
                                    <span class="sidebar-mini-icon">W</span>
                                    <span class="sidebar-normal">Wizard</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#tablesExamples">
                        <i class="now-ui-icons design_bullet-list-67"></i>
                        <p>Tables
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="tablesExamples">
                        <ul class="nav">
                            <li>
                                <a href="./tables/regular.html">
                                    <span class="sidebar-mini-icon">RT</span>
                                    <span class="sidebar-normal">Regular Tables</span>
                                </a>
                            </li>
                            <li>
                                <a href="./tables/extended.html">
                                    <span class="sidebar-mini-icon">ET</span>
                                    <span class="sidebar-normal">Extended Tables</span>
                                </a>
                            </li>
                            <li>
                                <a href="./tables/datatables.net.html">
                                    <span class="sidebar-mini-icon">DT</span>
                                    <span class="sidebar-normal">DataTables.net</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a data-toggle="collapse" href="#mapsExamples">
                        <i class="now-ui-icons location_pin"></i>
                        <p>Maps
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="mapsExamples">
                        <ul class="nav">
                            <li>
                                <a href="./maps/google.html">
                                    <span class="sidebar-mini-icon">GM</span>
                                    <span class="sidebar-normal">Google Maps</span>
                                </a>
                            </li>
                            <li>
                                <a href="./maps/fullscreen.html">
                                    <span class="sidebar-mini-icon">FSM</span>
                                    <span class="sidebar-normal">Full Screen Map</span>
                                </a>
                            </li>
                            <li>
                                <a href="./maps/vector.html">
                                    <span class="sidebar-mini-icon">VM</span>
                                    <span class="sidebar-normal">Vector Map</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="./widgets.html">
                        <i class="now-ui-icons objects_diamond"></i>
                        <p>Widgets</p>
                    </a>
                </li>

                <li>
                    <a href="./charts.html">
                        <i class="now-ui-icons business_chart-pie-36"></i>
                        <p>Charts</p>
                    </a>
                </li>

                <li>
                    <a href="./calendar.html">
                        <i class="now-ui-icons media-1_album"></i>
                        <p>Calendar</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>


    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="#pablo">Dashboard</a>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navigation">

                    <form>
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <span class="input-group-addon">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                            </span>
                        </div>
                    </form>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#pablo">
                                <i class="now-ui-icons media-2_sound-wave"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Stats</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="now-ui-icons location_world"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Some Actions</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#pablo">
                                <i class="now-ui-icons users_single-02"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Account</span>
                                </p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <!-- End Navbar -->




        <div class="panel-header panel-header-lg">

            <canvas id="bigDashboardChart"></canvas>


        </div>


        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info">
                                            <div class="icon icon-primary">
                                                <i class="now-ui-icons ui-2_chat-round"></i>
                                            </div>
                                            <h3 class="info-title">859</h3>
                                            <h6 class="stats-title">Messages</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info">
                                            <div class="icon icon-success">
                                                <i class="now-ui-icons business_money-coins"></i>
                                            </div>
                                            <h3 class="info-title"><small>$</small>3,521</h3>
                                            <h6 class="stats-title">Today Revenue</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info">
                                            <div class="icon icon-info">
                                                <i class="now-ui-icons users_single-02"></i>
                                            </div>
                                            <h3 class="info-title">562</h3>
                                            <h6 class="stats-title">Customers</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="info">
                                            <div class="icon icon-danger">
                                                <i class="now-ui-icons objects_support-17"></i>
                                            </div>
                                            <h3 class="info-title">353</h3>
                                            <h6 class="stats-title">Support Requests</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <footer class="footer" >
            <div class="container-fluid">
                <nav>
                    <ul>
                        <li>
                            <a href="https://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://presentation.creative-tim.com">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                                Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    &copy; <script>document.write(new Date().getFullYear())</script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                </div>
            </div>
        </footer>
    </div>
</body>

<!--   Core JS Files   -->

<script src="{{ mix('js/app_backend.js') }}"></script>

</html>

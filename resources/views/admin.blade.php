<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITWarp Consulting</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="/adminlte/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="/adminlte/css/AdminLTE.min.css">

    <link rel="stylesheet" href="/adminlte/css/skins/skin-blue.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>TS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>ITWarp</b>Consulting ATS</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->

                    <!-- Tasks Menu -->

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/adminlte/img/avatar-default.png" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="/adminlte/img/avatar-default.png" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()->name}} {{Auth::user()->surname}} - {{Auth::user()->rol->rol}}
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/profile/'.Auth::user()->id) }}" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/auth/logout') }}" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/adminlte/img/avatar-default.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->name}} {{Auth::user()->surname}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{Auth::user()->rol->rol}}</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <!--<form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>-->
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->

            @if (!Auth::guest())
                @if(Auth::user()->roles_id!=2)
                        <li class="{{ (Request::is('customer*') || Request::is('addcustomer*') || Request::is('addcontact*') || Request::is('contact*')) ? 'active open' : ''  }} treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Ventas</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ (Request::is('customer*') || Request::is('addcustomer*'))  ? 'active open' : ''  }}"><a href="{{ url('/customers') }}">Clientes</a></li>
                                <li class="{{ (Request::is('contact*') || Request::is('addcontact*') || Request::is('addcontact*'))  ? 'active open' : ''  }} "><a href="{{ url('/contacts') }}">Contactos</a></li>
                            </ul>
                        </li>

                    @endif

                    <li class="{{ (Request::is('offer*') || Request::is('home*') || Request::is('addoffer*') || Request::is('/')) ? 'active open' : ''  }}"><a href="{{ url('/offers') }}"><i class="fa fa-link"></i> <span>Ofertas Laborales</span></a></li>

                    <li class="{{ (Request::is('candidate*') || Request::is('addcandidate*') || Request::is('addCandidateOffer*') || Request::is('commentCO*') || Request::is('addOfferCandidate*') || Request::is('candidateComments*')) ? 'active open' : ''  }}"><a href="{{ url('/candidates') }}"><i class="fa fa-link"></i> <span>Candidatos</span></a></li>

                    <li class="{{ (Request::is('reportesOportunidades*') || Request::is('reportesRecruiters*') || Request::is('postReportRecruiter*')) ? 'active open' : ''  }} treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>Reportes</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('reportesOportunidades*') ? 'active open' : ''  }}"><a href="{{ url('reportesOportunidades') }}">Oportunidades</a></li>
                            <li class="{{ (Request::is('reportesRecruiters*') || Request::is('postReportRecruiter*')) ? 'active open' : ''  }}"><a href="{{ url('reportesRecruiters') }}">Recruiters</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('revision*') ? 'active open' : ''  }}"><a href="{{ url('revision') }}"><i class="fa fa-link"></i> <span>Revisión CV</span></a></li>

                    <li class="{{ Request::is('profiles*') ? 'active open' : ''  }} treeview">
                        <a href="#"><i class="fa fa-link"></i> <span>Parametros del Sistema</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is('profiles*') ? 'active open' : ''  }}"><a href="{{ url('/profiles') }}">Perfiles IT</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('offerClosed*') ? 'active open' : ''  }}"><a href="{{ url('offerClosed') }}"><i class="fa fa-link"></i> <span>Ofertas Cerradas/Perdidas</span></a></li>
                @endif
                <!--
                <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#">Link in level 2</a></li>
                        <li><a href="#">Link in level 2</a></li>
                    </ul>
                </li>-->
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('page-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
            <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">

        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#">ItWarp</a>.</strong> Todos los derechos reservados.
    </footer>

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/adminlte/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/js/app.min.js"></script>

@yield('scripts')

</body>
</html>
@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'dashboard')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>QI</b>K') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>QI</b>Kitchen') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="tasks-menu">
                            <a href="{{ url('/') }}" target="_blank">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <span class="label label-success">7</span>
                            </a>
                            <ul class="dropdown-menu">
                              <li class="header">You have 4 messages</li>
                              <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                  <li><!-- start message -->
                                    <a href="#">
                                      <div class="pull-left">
                                        <img src="{{ asset('images/img.jpg')}}" class="img-circle messenger-favicon" alt="User Image">
                                      </div>
                                      <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                    </a>
                                  </li>
                                  <!-- end message -->
                                  <li>
                                    <a href="#">
                                      <div class="pull-left">
                                        <img src="{{ asset('images/img.jpg')}}" class="img-circle messenger-favicon" alt="User Image">
                                      </div>
                                      <h4>
                                        AdminLTE Design Team
                                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                    </a>
                                  </li>
                                </ul>
                              </li>
                              <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span class="label label-warning">12</span>
                            </a>
                                <ul class="dropdown-menu">
                                  <li class="header">You have 12 Modules</li>
                                  <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                          page and may cause design problems
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                      </li>
                                      <li>
                                        <a href="#">
                                          <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                      </li>
                                    </ul>
                                  </li>
                                  <li class="footer"><a href="{{ route('dashboard') }}">View all</a></li>
                                </ul>
                        </li>
                        <li class="dropdown user user-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ asset('images/img.jpg')}}" class="user-image" alt="User Image">
                            {{ Auth::User()->name }}</a>
                            <ul class="dropdown-menu">
                              <!-- User image -->
                              <li class="user-header">
                                <img src="{{ asset('images/img.jpg')}}" class="img-circle" alt="User Image">
                                <p>
                                  {{ Auth::User()->name }}
                                  <small>Member since Nov. 2012</small>
                                </p>
                              </li>
                              <!-- Menu Body -->
                              <li class="user-body">
                                <div class="row">
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                  </div>
                                </div>
                                <!-- /.row -->
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-left">
                                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                  @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                      <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                      </a>
                                  @else
                                      <a href="#"
                                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                                          <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                      </a>
                                      <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;" class="btn btn-default btn-flat">
                                          @if(config('adminlte.logout_method'))
                                              {{ method_field(config('adminlte.logout_method')) }}
                                          @endif
                                          {{ csrf_field() }}
                                      </form>
                                  @endif
                                </div>
                              </li>
                            </ul>                            
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    {{-- @each('adminlte::partials.menu-item', $adminlte->menu(), 'item') --}}

                    <li class="header">User Management</li>
                    @permission('user-crud')
                    <li class="{{ Request::is('users') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-fw fa-user"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('role-crud')
                    <li class="{{ Request::is('roles') ? 'active' : '' }}">
                        <a href="/roles">
                            <i class="fa fa-fw fa-list"></i>
                            <span>Roles</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('role-crud') {{-- for the time being role-crud is used --}}
                    <li class="{{ Request::is('sms') ? 'active' : '' }}">
                        <a href="/sms">
                            <i class="fa fa-envelope-o"></i>
                            <span>SMS</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('receipt-crud')
                    <li class="header">Restaurant</li>
                    <li class="{{ Request::is('income') ? 'active' : '' }}">
                        <a href="{{ route('receipts.income') }}">
                            <i class="fa fa-fw fa-line-chart"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('income') ? 'active' : '' }}">
                        <a href="{{ route('receipts.income') }}">
                            <i class="fa fa-fw fa-bar-chart"></i>
                            <span>Expenditure</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('receipts') ? 'active' : '' }}">
                        <a href="{{ route('receipts.index') }}">
                            <i class="fa fa-fw fa-cutlery"></i>
                            <span>Receipts</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('commodity-crud')
                    <li class="{{ Request::is('commodities') ? 'active menu-open' : '' }} {{ Request::is('categories') ? 'active menu-open' : '' }} {{ Request::is('stocks') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-shopping-basket"></i>
                          <span>Commodity &amp; Stock</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('commodities') ? 'active' : '' }}"><a href="{{ route('commodities.index') }}"><i class="fa fa-file-text-o"></i> Commodities</a></li>
                        <li class="{{ Request::is('stocks') ? 'active' : '' }}"><a href="{{ route('stocks.index') }}"><i class="fa fa-exchange"></i> Stocks</a></li>
                        <li class="{{ Request::is('categories') ? 'active' : '' }}"><a href="{{ route('categories.index') }}"><i class="fa fa-tags"></i> Categories</a></li>
                      </ul>
                    </li>
                    <li class="{{ Request::is('other/class/*') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                        <i class="fa fa-fw fa-users"></i>
                        <span>other</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        {{-- classes will be dynamic after SCHOOL SETUP functionality --}}
                        {{-- classes will be dynamic after SCHOOL SETUP functionality --}}
                        {{-- classes will be dynamic after SCHOOL SETUP functionality --}}
                        <li><a href=""><i class="fa fa-id-badge"></i> Class One</a></li>
                        <li><a href=""><i class="fa fa-id-badge"></i> Class Two</a></li>
                        <li><a href=""><i class="fa fa-id-badge"></i> Class Three</a></li>
                        <li><a href=""><i class="fa fa-id-badge"></i> Class Four</a></li>
                        <li><a href=""><i class="fa fa-id-badge"></i> Class Five</a></li>
                      </ul>
                    </li>                    
                    @endpermission

                    
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop

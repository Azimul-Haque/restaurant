@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
    <style type="text/css">
      .slimScrollBar {
        background: none repeat scroll 0 0 #6b58cd !important;
        border-radius: 0;
        display: none;
        height: 702.936px;
        position: absolute;
        right: 1px;
        top: 145px;
        width: 5px!important;
        z-index: 99;
        opacity:0.5!important;
      }
    </style>
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
                                <i class="fa fa-fw fa-eye" aria-hidden="true"></i> View Website
                            </a>
                        </li>
                        <!-- <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <span class="label label-success">7</span>
                            </a>
                            <ul class="dropdown-menu">
                              <li class="header">You have 4 messages</li>
                              <li>
                                inner menu: contains the actual data
                                <ul class="menu">
                                  <li>start message
                                    <a href="#">
                                      <div class="pull-left">
                                        <img src="" class="img-circle messenger-favicon" alt="User Image">
                                      </div>
                                      <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                    </a>
                                  </li>
                                  end message
                                  <li>
                                    <a href="#">
                                      <div class="pull-left">
                                        <img src="" class="img-circle messenger-favicon" alt="User Image">
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
                        </li> -->
                        <!-- <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                <span class="label label-warning">12</span>
                            </a>
                                <ul class="dropdown-menu">
                                  <li class="header">You have 12 Modules</li>
                                  <li>
                                    inner menu: contains the actual data
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
                                  <li class="footer"><a href="">View all</a></li>
                                </ul>
                        </li> -->
                        <li class="dropdown user user-menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{ asset('images/user.png')}}" class="user-image" alt="User Image">
                            {{ Auth::User()->name }}</a>
                            <ul class="dropdown-menu">
                              <!-- User image -->
                              <li class="user-header">
                                <img src="{{ asset('images/user.png') }}" class="img-circle" alt="User Image">
                                <p>
                                  {{ Auth::User()->name }}
                                  <small>Member since {{ date('F, Y', strtotime(Auth::User()->created_at)) }}</small>
                                </p>
                              </li>
                              <!-- Menu Body -->
                              <li class="user-body">
                                {{-- <div class="row">
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                  </div>
                                </div> --}}
                                <!-- /.row -->
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                <div class="pull-left">
                                  <a href="{{ route('users.edit', Auth::User()->id) }}" class="btn btn-default btn-flat">Profile</a>
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

                    @permission('user-crud')
                    <li class="header">User Management</li>
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
                    @permission('receipt-crud')
                    <li class="header">Restaurant</li>
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-fw fa-tachometer"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('income') ? 'active' : '' }}">
                        <a href="{{ route('receipts.income') }}">
                            <i class="fa fa-fw fa-line-chart"></i>
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('expenditure') ? 'active' : '' }}">
                        <a href="{{ route('commodities.expenditure') }}">
                            <i class="fa fa-fw fa-bar-chart"></i>
                            <span>Expenditure</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('receipts') ? 'active menu-open' : '' }} {{ Request::is('sales') ? 'active menu-open' : '' }} {{ Request::is('deleted/receipts') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-cutlery"></i>
                          <span>Receipts &amp; Sales</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('receipts') ? 'active' : '' }}"><a href="{{ route('receipts.index') }}"><i class="fa fa-file-text"></i> Receipts</a></li>
                        <li class="{{ Request::is('sales') ? 'active' : '' }}"><a href="{{ route('receipts.sales') }}"><i class="fa fa-balance-scale"></i> Sales</a></li>
                        @permission('receipt-delete')
                        <li class="{{ Request::is('deleted/receipts') ? 'active' : '' }}"><a href="{{ route('receipts.deleted') }}"><i class="fa fa-trash-o"></i> Deleted Receipts</a></li>
                        @endpermission
                      </ul>
                    </li>
                    @endpermission
                    @permission('commodity-crud')
                    <li class="{{ Request::is('commodities') ? 'active menu-open' : '' }} {{ Request::is('categories') ? 'active menu-open' : '' }} {{ Request::is('deleted/commodities') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-shopping-basket"></i>
                          <span>Commodity</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('commodities') ? 'active' : '' }}"><a href="{{ route('commodities.index') }}"><i class="fa fa-file-text-o"></i> Commodities</a></li>
                        <li class="{{ Request::is('categories') ? 'active' : '' }}"><a href="{{ route('categories.index') }}"><i class="fa fa-tags"></i> Category &amp; Source</a></li>
                        @permission('commodity-edit')
                        <li class="{{ Request::is('deleted/commodities') ? 'active' : '' }}"><a href="{{ route('commodities.deleted') }}"><i class="fa fa-trash-o"></i> Deleted Commodities</a></li>
                        @endpermission
                      </ul>
                    </li>
                    <li class="{{ Request::is('stocks') ? 'active menu-open' : '' }} {{ Request::is('usages') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-truck"></i>
                          <span>Stock</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('stocks') ? 'active' : '' }}"><a href="{{ route('stocks.index') }}"><i class="fa fa-exchange"></i> Stocks</a></li>
                        <li class="{{ Request::is('usages') ? 'active' : '' }}"><a href="{{ route('usages.index') }}"><i class="fa fa-battery-half"></i> Usage</a></li>
                      </ul>
                    </li>
                    <li class="{{ Request::is('qikstocks') ? 'active menu-open' : '' }} {{ Request::is('qikusage') ? 'active menu-open' : '' }} treeview">
                      <a href="#">
                          <i class="fa fa-fw fa-leaf"></i>
                          <span>QIK Stock</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                      </a>
                      <ul class="treeview-menu">
                        <li class="{{ Request::is('qikstocks') ? 'active' : '' }}"><a href="{{ route('qikstocks.index') }}"><i class="fa fa-pagelines"></i> QIK Stocks</a></li>
                        <li class="{{ Request::is('qikusage') ? 'active' : '' }}"><a href="{{ route('qikstocks.qikusage') }}"><i class="fa fa-hourglass-start"></i> QIK Usage</a></li>
                      </ul>
                    </li>
                    <li class="{{ Request::is('membership') ? 'active' : '' }}">
                        <a href="{{ route('membership.index') }}">
                            <i class="fa fa-fw fa-address-card-o"></i>
                            <span>Membership</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('waiters/*') ? 'active' : '' }}">
                        <a href="{{ route('waiters.index') }}">
                            <i class="fa fa-fw fa-male"></i>
                            <span>Waiter Management</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('reports') ? 'active' : '' }}">
                        <a href="{{ route('reports.index') }}">
                            <i class="fa fa-fw fa-pie-chart"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('sms/*') ? 'active' : '' }}">
                        <a href="{{ route('sms.index') }}">
                            <i class="fa fa-fw fa-envelope-o"></i>
                            <span>SMS Module</span>
                        </a>
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
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2.6.0
          </div>
          <strong>Copyright © {{ date('Y') }}</strong> 
          All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop

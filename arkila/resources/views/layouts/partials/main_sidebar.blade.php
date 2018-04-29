<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image pull-left">
                <img src={{ URL::asset('img/bantrans-logo.png') }} class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Ban Trans - Admin</p>
              <p>UV Express</p>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ Request::is('home/superadmin-dashboard') ? 'active' : '' }}">
                <a href="/home">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('home/trips') ? 'active' : '' }}">
                <a href="{{route('vanqueue.index')}}">
                    <i class="fa fa-list-ol"></i>
                    <span>Van Queue</span>
                </a>
            </li>
            <li class="{{ Request::is('home/transactions') ? 'active' : '' }}">
                <a href="{{route('transactions.index')}}">
                    <i class="fa fa-ticket"></i>
                    <span>Ticket Management</span>
                </a>
            </li>
            <li class="{{ Request::is('home/route') ? 'active' : '' }}">
                <a href="/home/route">
                    <i class="fa fa-road"></i>
                    <span>Routes</span>
                </a>
            </li>
            <li class="treeview {{ Request::is('home/rental') ? 'active' : '' }} || {{ Request::is('home/reservations') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Rental and Resevation</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('home/rental') ? 'active' : '' }}"><a href="{{route('rental.index')}}"><i class="fa fa-circle-o"></i> Rental</a></li>
                    <li class="{{ Request::is('home/reservations') ? 'active' : '' }}"><a href="{{route('reservations.index')}}"><i class="fa fa-circle-o"></i> Reservation</a></li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('home/operators') ? 'active' : '' }} || {{ Request::is('home/drivers') ? 'active' : '' }} || {{ Request::is('home/vans') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Personnel</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('home/operators') ? 'active' : '' }}"><a href="{{route('operators.index')}}"><i class="fa fa-circle-o"></i> Operators</a></li>
                    <li class="{{ Request::is('home/drivers') ? 'active' : '' }}"><a href="{{route('drivers.index')}}"><i class="fa fa-circle-o"></i>Drivers</a></li>
                    <li class="{{ Request::is('home/vans') ? 'active' : '' }}"><a href="{{route('vans.index')}}"><i class="fa fa-circle-o"></i>Vans</a></li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('home/trip-log') ? 'active' : '' }} || {{ Request::is('home/driver-report') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-bus"></i>
                    <span>Trips</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('home/trip-log') ? 'active' : '' }}"><a href="{{route('trips.tripLog')}}"><i class="fa fa-circle-o"></i>Trip Log</a></li>
                    <li class="{{ Request::is('home/driver-report') ? 'active' : '' }}"><a href="{{route('trips.driverReport')}}"><i class="fa fa-circle-o"></i> Driver Report</a></li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('home/ledger') ? 'active' : '' }} || {{ Request::is('home/general-ledger') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-calculator"></i>
                    <span>Accounting</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('home/ledger') ? 'active' : '' }}"><a href="{{route('ledger.index')}}"><i class="fa fa-circle-o"></i> Daily Ledger</a></li>
                    <li class="{{ Request::is('home/general-ledger') ? 'active' : '' }}"><a href="{{route('ledger.generalLedger')}}"><i class="fa fa-circle-o"></i> General Ledger</a></li>
                </ul>
            </li>
            <li class="header">SETTING</li>
            <li class="{{ Request::is('home/settings') ? 'active' : '' }}">
                <a href="{{route('settings.index')}}">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                </a>
            </li>
            <li class="{{ Request::is('home/user-management') ? 'active' : '' }}">
                <a href="{{route('usermanagement.dashboard')}}">
                    <i class="fa fa-male"></i> <span>User Management</span>
                </a>
            </li>
            <li class="{{ Request::is('home/archive') ? 'active' : '' }}">
                <a href="{{route('archive.index')}}">
                    <i class="fa fa-archive"></i> <span>Operator History</span>
                </a>
            </li>

            <li>
                <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                    <span>Sign Out</span>
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{csrf_field()}}
                </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
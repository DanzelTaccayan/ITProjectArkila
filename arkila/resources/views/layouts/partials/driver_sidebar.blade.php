<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding-bottom:10%;">
            <div class="pull-left image">
                <img src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" class="img-circle" alt="User Image" style="margin-top:15px;">
            </div>
            <div class="pull-right info">
                @php 
                    $fullname = null; 
                    $driver_member = \App\Member::where('user_id', Auth::id())->first();
                @endphp
                @if($driver_member->middle_name !== null)
                    @php 
                        $fullname = $driver_member->first_name . " " . $driver_member->middle_name . " " . $driver_member->last_name; 
                    @endphp
                @else
                    @php 
                        $fullname = $driver_member->first_name . " " . $driver_member->last_name; 
                    @endphp
                @endif
                <h4>{{$fullname}}</h4>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
           <li class="{{ Request::is('home/driver-dashboard') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.index') }}">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            <li class="{{ Request::is('home/view-rentals') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.rentals.rental') }}">
                    <i class="fa fa-home"></i> <span>Rentals</span>
                </a>
            </li>
           <li class="{{ Request::is('home/view-trips') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.triplog.driverTripLog') }}">
                    <i class="fa fa-book"></i> <span>Trip Log</span>
                </a>
            </li>
           <li class="{{ Request::is('home/choose-terminal') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.report.driverChooseDestination') }}">
                    <i class="fa fa-plus"></i> <span>Create Report</span>
                </a>
            </li>
           <li class="{{ Request::is('home/profile') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.profile.driverProfile') }}">
                    <i class="fa fa-user"></i> <span>Profile</span>
                </a>
            </li>
           <li class="{{ Request::is('home/driver/help') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.help.driverHelp') }}">
                    <i class="fa fa-question"></i> <span>Help</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fa fa-sign-out"></i>
            <span>Sign Out</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{csrf_field()}}
          </form>
            </li>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->
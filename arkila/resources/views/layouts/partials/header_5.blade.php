<header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="{{ route('home') }}" class="navbar-brand"><b>Ban</b>Trans</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
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
                <a href="{{ route('drivermodule.createReport') }}">
                    <i class="fa fa-plus"></i> <span>Create Report</span>
                </a>
            </li>
           <li class="{{ Request::is('home/driver/help') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.help.driverHelp') }}">
                    <i class="fa fa-question"></i> <span>Help</span>
                </a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- Notifications Menu -->
            <notification :userid="{{auth()->id()}}" :unreads="{{auth()->user()->unreadNotifications}}"></notification>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">Alexander Pierce</span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" class="img-circle" alt="User Image">

                  @php $fullname = null; @endphp
                @if(Auth::user()->middle_name !== null)
                    @php
                        $fullname = Auth::user()->first_name . " " . Auth::user()->middle_name . " " .     Auth::user()->last_name;
                    @endphp
                @else
                    @php
                        $fullname = Auth::user()->first_name . " " . Auth::user()->last_name;
                    @endphp
                @endif
                <p>{{$fullname}}</p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ route('drivermodule.profile.driverProfile') }}" class="btn btn-default btn-flat">Profile
                   </a>
                  </div>
                  <div class="pull-right">
                     <a href="{{route('logout')}}" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{csrf_field()}}
                    </form>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

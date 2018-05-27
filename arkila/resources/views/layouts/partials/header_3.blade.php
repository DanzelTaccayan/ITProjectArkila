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
                    <i class="fa fa-book"></i> <span>Rentals</span>
                </a>
            </li>
           <li class="{{ Request::is('home/view-trips') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.triplog.driverTripLog') }}">
                    <i class="fa fa-list"></i> <span>Trip Log</span>
                </a>
            </li>
           <li class="{{ Request::is('home/choose-terminal') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.createReport') }}">
                    <i class="fa fa-file-text"></i> <span>Create Report</span>
                </a>
            </li>
           <li class="{{ Request::is('home/driver/help') ? 'active' : '' }}">
                <a href="{{ route('drivermodule.help.driverHelp') }}">
                    <i class="fa fa-question-circle"></i> <span>Help</span>
                </a>
            </li>
            <li>
                <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i><span>Sign out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{csrf_field()}}
                </form>
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
              <a href="{{ route('drivermodule.profile.driverProfile') }}">
                <!-- The user image in the navbar-->
                <img src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
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
                <span class="hidden-xs">{{$fullname}}</span>
              </a>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

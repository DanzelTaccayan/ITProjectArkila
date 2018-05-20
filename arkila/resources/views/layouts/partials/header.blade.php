<header class="main-header">
    <!-- Logo -->
    <a href="{{route('vanqueue.index')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>BT</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Ban</b>Trans</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning"></span>
                            </a>
                    <ul class="dropdown-menu">
                        <li class="header">Notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <p style="margin:0 0 0;"> Booking request </p>
                                        <span class="text-orange fa fa-book"></span> 
                                        <small>10/10/2018 01:00 PM</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p style="margin:0 0 0;"> Accepted </p>
                                        <span class="text-green fa fa-check-circle"></span> 
                                        <small>10/10/2018 01:00 PM</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p style="margin:0 0 0;">Deleted/Cancelled</p>
                                        <span class="text-red fa fa-times-circle"></span> 
                                        <small>10/10/2018 01:00 PM</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p style="margin:0 0 0;">
                                            Information </p>
                                            <span class="text-gray fa fa-info-circle"></span> 
                                            <small>10/10/2018 01:00 PM</small>
                                        </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p style="margin:0 0 0;"> Departed </p>
                                        <span class="text-blue fa fa-truck"></span> 
                                        <small>10/10/2018 01:00 PM</small>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bullhorn"></i>
                                <span class="label label-danger"></span>
                            </a>
                    <ul class="dropdown-menu" style="width: 420px;">

                        <form method="post" action="{{ route('announcements.index') }}">
                            {{ csrf_field() }}
                            <li class="header box-body">
                                <h4>Quick Announcement:</h4>
                                <select class="form-control" name="viewer">
                                    <option value="Public">Public</option>
                                    <option value="Driver Only">Driver Only</option>
                                    <option value="Customer Only">Customer Only</option>
                                    <option value="Only Me">Only Me</option>
                                </select>
                            </li>
                            <li class="box-body">
                                <div class="form-group">
                                    <label for="">Title:</label>
                                    <input type="text" name="title" class="form-control" maxlength="50" required>
                                </div>
                                <!-- inner menu: contains the actual data -->
                                <div class="form-group">
                                    <label for="">Message:</label>
                                    <textarea name="announce" rows="5" class="form-control" placeholder="" maxlength="1000" required></textarea>
                                </div>
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-warning btn-group-justified">ANNOUNCE</button>
                                    </div>
                                </div>
                            </li>
                            <li class="footer box-body text-center" style="border-top: 1px solid lightgray;">
                                <a href="{{route('announcements.index')}}"><i class="fa fa-eye"></i> View previous announcements</a>
                            </li>
                        </form>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ URL::asset('img/bantrans-logo.png') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">Admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                          <img src="{{ URL::asset('img/bantrans-logo.png') }}" class="img-circle" alt="User Image">
                            <p style="margin:0;">Admin</p>
                            <small style="color: white;">{{ \App\Destination::mainTerminal()->get()->first()->destination_name ?? 'None' }}</small>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                          <div class="pull-left">
                            <a href="{{route('accountSettings')}}" class="btn btn-default"><i class="fa fa-gear"></i> Account Settings
                           </a>
                          </div>
                          <div class="pull-right">
                             <a  href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default">Sign out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{csrf_field()}}
                            </form>
                          </div>
                        </li>
                    </ul>
                    
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-list-ol"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

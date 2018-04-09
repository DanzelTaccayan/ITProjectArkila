<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
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
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success"></span>
                            </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
                                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning"></span>
                            </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
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
                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
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
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bullhorn"></i>
                                <span class="label label-danger"></span>
                            </a>
                    <ul class="dropdown-menu">

                        <form method="post" action="{{ route('announcements.index') }}">
                            {{ csrf_field() }}
                            <li class="header box-body">
                                <h4>Enter Announcement:</h4>
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
                                <div class="pull-right">
                                    <button class="btn btn-warning">ANNOUNCE</button>
                                </div>
                            </li>
                            <li class="footer box-body text-center">
                                <a href="{{route('announcements.index')}}">View all announcements</a>
                            </li>
                        </form>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ URL::asset('img/jl.JPG') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">Admin Baguio</span>
                            </a>
                    <ul class="dropdown-menu">

                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('img/jl.JPG') }}" alt="User profile picture">

                                <h3 class="profile-username text-center">Admin - Baguio City</h3>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="btn-group btn-group-justified">
                                  <div class="btn-group">
                                      <a href="{{route('accountSettings')}}" class="btn btn-primary">Change Password</a>
                                  </div>
                                  <div class="btn-group">
                                        <a  href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default">Sign out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{csrf_field()}}
                                        </form>
                                  </div>
                                </div>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
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

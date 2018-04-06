<header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ route('home') }}" class="navbar-brand"><b>Ban</b>Trans</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the messages -->
                                        <ul class="menu">
                                            <li>
                                                <!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <!-- The message -->
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- end message -->
                                        </ul>
                                        <!-- /.menu -->
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- /.messages-menu -->

                            <!-- Notifications Menu -->
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- Inner Menu: contains the notifications -->
                                        <ul class="menu">
                                            <li>
                                                <!-- start notification -->
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <!-- end notification -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks Menu -->
                            <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bullhorn"></i>
                            </a>
                            <ul class="dropdown-menu">
                            
                            <form method="post" action="{{ route('announcements.index') }}">
                            {{ csrf_field() }}
                                    <li class="header box-body">Enter Announcement:

                                    <span class="pull-right">
                                        <select name="viewer">
                                            <option value="Public">Public</option>
                                            <option value="Driver Only">Driver Only</option>
                                            <option value="Customer Only">Customer Only</option>
                                            <option value="Only Me">Only Me</option>
                                        </select>
                                    </span>
                                    </li>

                                    <li class="box-body">
                                        <!-- inner menu: contains the actual data -->
                                        <textarea name="announce" rows="5" class="form-control" placeholder="" style="resize: none;"></textarea>
                                    </li>
                                    <li class="footer box-body pull-right">
                                        <button class="btn btn-warning">ANNOUNCE</button>
                                    </li>
                                </form>
                            </ul>
                        </li>
                            <!-- User Account Menu -->
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
                                                    <a href="#" class="btn btn-default">Sign out</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-footer -->
                                    </div>
                                    <!-- /.box -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
                
            </nav>

        </header>
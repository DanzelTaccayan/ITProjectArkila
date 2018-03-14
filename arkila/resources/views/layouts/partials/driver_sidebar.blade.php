<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding-bottom:10%;">
            <div class="pull-left image">
                <img src="{{ URL::asset('adminlte/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <h4>Shaina Caballar</h4>
                <p>123@gmail.com</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="active treeview">
                <a href="{{route('drivermodule.dashboard')}}">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
            </li>
            <li class="treeview">
                <a href="#">
            <i class="fa fa-book"></i>
            <span>Trip Log</span>
          </a>
            </li>
            <li class="treeview">
                <a href="{{route('drivermodule.viewCreateReport')}}">
            <i class="fa fa-plus"></i>
            <span>Create Report</span>
          </a>
            </li>
            <li class="treeview">
                <a href="{{route('drivermodule.showProfile')}}">
            <i class="	fa fa-user"></i>
            <span>Profile</span>
          </a>
            </li>
            <li class="treeview">
                <a href="#">
            <i class="fa fa-question"></i>
            <span>Help</span>
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
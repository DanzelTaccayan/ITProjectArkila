    <!-- Navbar Start-->
    <header class="nav-holder make-sticky">
        <div id="navbar" class="navbar navbar-expand-lg">
            <div class="container">
                <a href="{{route('customermodule.user.index')}}" class="navbar-brand home">
               <img src="{{ URL::asset('img/bantranslogo.png') }}" alt="Ban Trans logo" class="d-none d-md-inline-block" style="width:230px;">
               <img src="{{ URL::asset('img/bantranslogo.png') }}" alt="Ban Trans logo" class="d-inline-block d-md-none" style="width:100px;">
               <span class="sr-only">Ban Trans</span></a>
                <button type="button" data-toggle="collapse" data-target="#navigation" class="navbar-toggler btn-template-outlined">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-align-justify"></i>
                </button>

                <div id="navigation" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{route('customermodule.user.index')}}">Home</a>
                        </li>
                        <li class="nav-item dropdown small"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Services</a>
                            <ul class="dropdown-menu megamenu">
                                <li>
                                    <ul class="list-unstyled">
                                        <li class="nav-item">
                                            <a href="{{route('customermodule.user.rental.customerRental')}}" class="nav-link">Rentals</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('customermodule.user.reservation.customerReservation')}}" class="nav-link">Reservation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('customermodule.fareList')}}" class="nav-link">Fare List</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customermodule.user.about.customerAbout')}}">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customermodule.user.help.customerHelp')}}">FAQ</a>
                        </li>
                        <li class="nav-item dropdown menu-small"><a href="#" data-toggle="dropdown" class="dropdown-toggle">My Account</a>
                            <ul class="dropdown-menu megamenu">
                                <li>
                                    <ul class="list-unstyled">
                                        <li class="nav-item">
                                            <a href="{{route('customermodule.rentalTransaction')}}" class="nav-link">My Transactions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('customermodule.user.changepassword.index')}}" class="nav-link">Change Password</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sign-out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{csrf_field()}}
                            </form>
                        </li>
                        
                    </ul>
                </div>
                <div id="search" class="collapse clearfix">
                    <form role="search" class="navbar-form">
                        <div class="input-group">
                            <input type="text" placeholder="Search" class="form-control"><span class="input-group-btn">
                    <button type="submit" class="btn btn-template-main"><i class="fa fa-search"></i></button></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <!-- Navbar End-->

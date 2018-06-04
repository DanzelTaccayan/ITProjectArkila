@extends(Auth::user() ? 'layouts.customer_user' : 'layouts.customer_non_user')
@section('links')
@parent
<style> 
.bg-blue{
    background: #007bff
}
.bg-green{
    background: #28a745;
}
</style>
@endsection
@section('content')
<div style="padding:5%">
            <section class="">
               <div class="container">
                        <div class="heading text-center">
                            <h2>About Us</h2>
                        </div>
                        <div class="row"><div class="mx-auto">  
                        <img src="{{ URL::asset('img/bantrans-logo.png')}}" alt="bantrans_logo" class="pull-right" style="width:150px ;height:150px ;">
                        <img src="{{ URL::asset('img/apple-touch-icon.png')}}" alt="arkila_logo" class="pull-right" style="width:150px ;height:150px ;">
                        </div>
                        <div>
                            <p class="lead text-justify">
                                Founded in 2006, Ban Trans is a van transport association catering trips from its main terminal to different terminals and vice-versa. Ban Trans uses UV Express van units to cater to customers transportation needs.
                            </p>
                            <p class="lead text-justify">
                            Arkila is a web application has been developed for you, our valued customers of Ban Trans. The application has automated most processes such as reserving seats and renting vans which could certainly help you feel more at ease while making a transaction. The application gives you a wide range of features to choose from such as reserving vans for special trips and also booking line reservations for a particular time and day. Furthermore, the application gives you features such as viewing announcements and also fare rates for all van destinations. Finally, you are able to view your past transactions with the association and viewing all related information about a specific trip.
                            </p>
                        </div>
                </div>
                <!-- row-->
                </div><!-- container-->
            </section>
            <!-- bar-->
            <section class="bar">
               <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Our Terminals</h2>
                        </div>
                        <ul class="ul-icons list-unstyled">
                            <li>
                                <div class="icon-filled bg-blue">
                                    <i class="fa fa-home"></i>
                                </div>
                                San Jose
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Our services</h2>
                        </div>
                        <ul class="ul-icons list-unstyled">
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-clock-o"></i></div>Main terminal open from <strong>{{date('g:i A', strtotime($profile->first()->open_time))}}</strong> to <strong>{{date('g:i A', strtotime($profile->first()->close_time))}}</strong>.
                            </li>
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-check"></i></div>Regular trips to different destinations.
                            </li>
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-check"></i></div>Van rental available to any destination.
                            </li>
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-check"></i></div>Online van rental.
                            </li>
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-check"></i></div>Online line reservation.
                            </li>

                        </ul>
                    </div><!-- col-->
                    @if($profile->count() !== 0)
                    <div class="col-md-4">
                        <div class="heading">
                            <h2>Contact Us</h2>
                        </div>
                        <ul class="ul-icons list-unstyled">
                        @if($profile->first()->contact_number !== null)
                            <li>
                                <div class="icon-filled bg-green">
                                    <i class="fa fa-phone"></i>
                                </div>
                                {{$profile->first()->contact_number}}
                            </li>
                        @endif
                        @if($profile->first()->email !== null)
                            <li>
                                <div class="icon-filled bg-green">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                {{$profile->first()->email}}
                            </li>
                        @endif
                        @if($profile->first()->address !== null)
                            <li>
                                <div class="icon-filled bg-green"><i class="fa fa-map-marker"></i></div>
                                {{$profile->first()->address}}
                            </li>
                        @endif
                        </ul>
                    </div><!-- col-->
                    @endif
                </div>
                <!-- row-->
                </div><!-- container-->
            </section>
            <!-- bar-->

    </div>
    <!--    main section-->
@stop
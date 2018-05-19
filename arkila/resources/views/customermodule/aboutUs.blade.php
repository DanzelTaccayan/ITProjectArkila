@extends(Auth::user() ? 'layouts.customer_user' : 'layouts.customer_non_user')
@section('links')
@parent
<style> 
.bg-green{
    background: #28a745;
}
</style>
@endsection
@section('content')
<section id="">
            <section class="bar">
               <div class="container">
                        <div class="heading text-center">
                            <h2>About Us</h2>
                        </div>
                        <div class="row"><div class="mx-auto" style="margin-bottom:     5%">  
                        <img src="{{ URL::asset('img/bantrans-logo.png')}}" alt="bantrans_logo" class="pull-right" style="width:200px ;height:200px ;">
                        <img src="{{ URL::asset('img/apple-touch-icon.png')}}" alt="arkila_logo" class="pull-right" style="width:200px ;height:200px ;">
                        </div>
                        <p class="lead">Ban Trans is a van transport association established in Baguio City in 2006 for UV Express franchisees or operators. <span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus non quia voluptatem voluptatibus incidunt nulla id animi vel distinctio laborum perspiciatis dolor sit, voluptates architecto, quas laudantium beatae. Reiciendis, ratione.</span>
                        <span>Consequatur rem suscipit, maiores nam adipisci obcaecati, ea laudantium cumque impedit aliquam odio soluta ullam debitis officia illum iste sapiente architecto, unde. Voluptate ullam nobis animi iusto qui eos deleniti.</span>
                        <span>Sint dignissimos aliquid fugiat similique voluptatem earum hic totam quos minima nihil sed voluptas neque itaque deserunt optio commodi, eos illo dolor. Est tenetur, harum provident, quia enim possimus adipisci?</span>
                        <span>Qui voluptatem rem distinctio autem dolore nesciunt praesentium ipsum odit, iure similique? Vel eum possimus officia, laboriosam explicabo facere repellat hic necessitatibus inventore fugiat, quaerat iste, quo fuga debitis natus.</span>
                        <span>Recusandae sit impedit iste laborum mollitia ratione veritatis cupiditate ad dolorum quaerat accusamus libero a nam tempore similique voluptatum repellat, provident earum, facere officiis beatae, molestiae. Consectetur vitae ea, a!</span></p>
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
                                <div class="icon-filled">
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
                                <div class="icon-filled bg-green">
                                    <i class="fa fa-check"></i>
                                </div>
                                Regular trips to different terminals and terminal routes.
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

    </section>
    <!--    main section-->
@stop
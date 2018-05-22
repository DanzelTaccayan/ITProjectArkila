<section style="background: white center top no-repeat; background-size: cover;" class="bar no-mb padding-big text-md-center">
    <div class="dark-mask"></div>
    <div class="container">
        <div class="text-center" >
            <h2 class="text-uppercase"><i class="fa fa-bullhorn"></i> Announcements</h2>
        </div>
        <!-- Carousel Start-->
        @if($announcements->count() == 0)
            <h4 class="text-center">NO ANNOUNCEMENT.</h4>
        @else
            <ul class="owl-carousel testimonials list-unstyled equal-height">
                @foreach($announcements as $announcement)
                    <li class="item" style="height: 500px;">
                        <div class="testimonial d-flex flex-wrap">
                            <div class="text">
                                <h3 class="text-limit-3">{{$announcement->title}}</h3>
                                <p class="text-limit-12" style="text-align: justify;">{{$announcement->description}}</p>
                            </div>
                            <div class="bottom d-flex align-items-center justify-content-between align-self-end">
                                <div class="mx-auto">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="">See More</button>
                                </div>
                                <div class="testimonial-info d-flex">
                                    <h5>{{$announcement->created_at->formatLocalized('%B %d %Y')}}</h5>
                                </div>
                                <!-- estimonial-info-->
                            </div>
                            <!-- bottom-->
                        </div>
                        <!-- testimonial-->
                    </li>
                @endforeach
            </ul>
        @endif
        <!-- Carousel End-->
    </div>
    <!-- container-->
</section>
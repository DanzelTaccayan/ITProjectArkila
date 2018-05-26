@extends(Auth::user() ? 'layouts.customer_user' : 'layouts.customer_non_user')
@section('content')
<section id="packages" class="bar no-mb">
        <div data-animate="fadeInUp" class="container">
              <div class="heading text-center" >
                <h2 style="color: #000040;">Fare list</h2>
              </div>
              <div class="row packages">
              @if($destinations->count() > 0)
               @foreach($destinations as $destination)
                <div class="col-md-8 mx-auto">
                  <div class="package">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Fare</th>
                                </tr>
                            </thead>
                            @foreach($destination->routeFromDestination as $destination)
                                <tr>
                                  <td>{{$destination->destination_name}}</td>
                                  <td>{{$destination->tickets->first()->fare}}</td>
                                </tr>
                            @endforeach
                        </table>
                     </div>
                  </div>
                </div>
                @endforeach
                @endif
              </div>
              <!-- Packages End-->
            </div>
      </section>
@stop
@extends('layouts.customer_user')
@section('content')
<section id="packages" class="bar no-mb" style="background-image: url('{{ URL::asset('img/customer_background.jpg') }}');">
        <div data-animate="fadeInUp" class="container">
              <div class="heading text-center" >
                <h2 style="color: #000040;">Fare list</h2>
              </div>
              <div class="row packages">
               @foreach($terminals as $terminal)
                <div class="col-md-3 mx-auto">
                 <div></div>
                  <div class="package" style="background-color:white;">
                    <div class="package-header light-gray">
                      <h5>Fare list {{$terminal->description}}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Fare</th>
                                </tr>
                            </thead>

                            @foreach($farelist as $fare)
                              @if($fare->terminal_id == $terminal->terminal_id)
                                <tr>
                                  <td>{{$fare->description}}</td>
                                  <td>{{$fare->amount}}</td>
                                </tr>
                              @endif
                            @endforeach
                        </table>
                     </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
      </section>
@stop
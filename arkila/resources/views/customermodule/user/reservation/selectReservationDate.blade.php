@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="heading text-center">
                <h2>Reserve a Trip</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                        {{csrf_field()}}
                        <div class="form-group">

                                @foreach($gago->first()->routeDestination as $chabal)
                                    <p>{{$chabal->destination_name}}</p>
                                @endforeach

                                @foreach($gago->first()->routeDestination as $chabal)
                                @foreach($reservations->where('destination_terminal', $chabal->destination_id) as $reserve)
                                    <p>{{$reserve->reservation_date}}</p>
                                @endforeach
                                @endforeach
                        </div>
                        <div class="container-contact100-form-btn">
                            <a href="{{route('customermodule.createReservation')}}" class="contact100-form-btn"><strong>create</strong></a>
                        </div><!-- container-contact100-form-btn-->
                    <!-- contact100-form-->
                </div>
                <!-- col-->
            </div>
            <!-- row-->
        </div>
        <!-- container-->
    </section>
    <!-- main section-->

@stop 
@section('scripts')
@parent
<script>
    
        $(function() {
            $('.datepicker').datepicker({
                autoclose: true
            });
            
        $('#timepicker').timepicker({
            showInputs: false,
            template: false
        });
        })
        $('[data-mask]').inputmask()
            $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true})
            
    function getDestination(elementId){
        var sel = document.getElementById(elementId);
        if (sel.selectedIndex == -1){
            return null;
        }
        
        return sel.options[sel.selectedIndex].text;
    }

    function showSummary(){
        document.getElementById('summaryDest').textContent = getDestination('destination');
        document.getElementById('summaryContact').textContent = document.getElementById('contactNumber').value;
        document.getElementById('summarySeats').textContent = document.getElementById('seats').value;
        document.getElementById('summaryDate').textContent = document.getElementById('date').value;
        document.getElementById('summaryTime').textContent = document.getElementById('timepicker').value;
        document.getElementById('summaryComments').textContent = document.getElementById('message').value;
       
    }
</script>
<script>
    $(function(){
        $('[data-mask]').inputmask();
        $('.date-mask').inputmask('mm/dd/yyyy',{removeMaskOnSubmit: true});
    });
</script>
@endsection
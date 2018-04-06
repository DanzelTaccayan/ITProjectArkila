@extends('layouts.customer_user')
@section('content')
<section class="mainSection">
        <div class="container">
            <div class="heading text-center">
                <h2>Reserve a Trip</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto" id="boxContainer">
                    <form class="contact100-form" action="{{route('customermodule.storeReservation')}}" method="POST" data-parsley-validate="">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Destination: <span class="text-red">*</span></label>
                            <select id="destination" name="destination" class="form-control">
                                <option selected value="">Select Destination</option>
                                @foreach($destinations as $destination)
                                    <option value="{{$destination->destination_id}}">{{$destination->description}}</option>
                                @endforeach
                           </select>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contact Number: <span class="text-red">*</span></label>
                                    <div class="input-group">
                                    <div class="input-group-num">
                                        <span>+63</span>
                                    </div>
                                    <input id="contactNumber" class="form-control" type="text" name="contactNumber" value="" data-inputmask='"mask": "999-999-9999"' data-mask val-phone required>
                                    </div>
                                </div>
                            </div><!-- col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Number of Person: <span class="text-red">*</span></label>
                                    <input id="seats" class="form-control" type="number" name="numberOfSeats" val-num-seats required >
                                    
                                </div>
                            </div><!-- col-->
                        </div><!-- row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Departure Date: <span class="text-red">*</span></label>
                                    <input id="date" class="form-control date-mask" type="text" name="date" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask val-book-date data-parsley-valid-departure required>
                                    
                                </div>
                            </div><!-- col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Departure Time: <span class="text-red">*</span></label>
                                    <div class="bootstrap-timepicker">
                                        <input type="text" id="timepicker" class="form-control timepicker" name="time" val-book-time required>
                                        
                                    </div><!-- bootstrap-timepicker-->
                                </div>
                            </div><!-- col-->
                        </div><!-- row-->
                        <div class="form-group">
                            <label for="">Comment:</label>
                            <textarea id="message" class="form-control" name="message" placeholder="Additional comments..."></textarea>
                            
                        </div>
                        <div class="container-contact100-form-btn">
                            <button type="button" class="contact100-form-btn" onclick="showSummary()" data-toggle="modal" data-target="#addSuccess"><strong>Book</strong></button>
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
    
    <div id="addSuccess" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#5cb85c; color:white; font-family: Montserrat-Regular;">
                    <h4 class="text-center"><i class="fa fa-info-circle" style="font-size: 80px; padding-left:200px;"></i></h4>
                </div>
                <div class="modal-body">

                    <p class="text-center" style="margin-bottom:10px;"><strong>Reservation Summary</strong></p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Destination</th>
                                <td id="summaryDest"></td>
                            </tr>
                            <tr>
                                <th>Contact Number</th>
                                <td id="summaryContact"></td>
                            </tr>
                            <tr>
                                <th>Number of Seats</th>
                                <td id="summarySeats"></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td id="summaryDate"></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td id="summaryTime"></td>
                            </tr>
                            <tr>
                                <th>Comments</th>
                                <td id="summaryComments"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="contact100-form-btn"><strong>Submit</strong></button>
                </div>
                <!-- modal-body-->
            </div>
            </form>
            <!-- modal-content-->
        </div>
        <!-- modal-dialog-->
    </div>
    <!-- addSuccess-->
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
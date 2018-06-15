<div class="" style="padding: 2% 5%">
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h4 class="report-header sblue">PASSENGER COUNT</h4>
            </div>
            <table class="table table-bordered table-striped form-table">
                <thead>
                    <th></th>
                    <th class="text-center">Regular</th>
                    <th class="text-center">Discounted</th>
                </thead>
                <tbody>
                    @foreach($destinations as $destination)
                    @foreach($destination->routeDestination->where('destination_id', $terminal->destination_id) as $dest)

                    @if($terminal->destination_id == $dest->destination_id)
                    <!-- FROM MAIN TERMINAL -->
                    <tr>
                        <th>{{$destination->destination_name}}</th>
                        <td>
                            <input type="hidden" name="destination[]" value="{{$destination->destination_id}}">
                            <input class='form-control text-right num-pass' onblur='findTotal()' type='number' name='qty[]' id='' value="0" min="0">
                        </td>
                        <td>
                            <input type="hidden" name="discount[]" value="">
                            <input class='form-control text-right num-pass' onblur='findTotal()' type='number' name='disqty[]' id='' value="0" min="0">
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6"> 
            <div class="text-center">
                <h4 class="report-header msgreen">SUMMARY</h4>
            </div>
            <p><strong>ON DECK:</strong></p>
            <table class="table table-bordered table-striped form-table table-condensed">
                @if($vanOnDeck = $terminal->vanQueue->where('queue_number',1)->first() ?? null)
                <thead>
                    <tr>
                        <th class="text-center">Van Unit</th>
                        <th class="text-center">Driver</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{$vanOnDeck->van->plate_number}}</td>
                        <td class="text-center">{{strtoupper($vanOnDeck->driver->full_name)}}</td>
                    </tr>
                </tbody>
                @endif
            </table>
            <p><strong>PASSENGERS:</strong></p>
            <table class="table-bordered table-striped form-table table-condensed">
                <thead>
                    <th></th>
                    <th class="text-center">Count</th>
                </thead>
                <tbody>
                    <tr>
                        <th>Total Regular Passengers</th>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <th>Total Discounted Passengers</th>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <th>Total Passengers</th>
                        <td id="totalPassenger" class="text-right">{{old('totalPassengers')}}
                         <input id="totalPassengers" type="hidden" name="totalPassengers" value=""></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center" style="margin-top: 7%;">
                <button id="cancelboardBtn{{$terminal->destination_id}}" class="btn btn-default">CANCEL</button>
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#discountModal"><i class="fa fa-save"></i> RECORD TRIP</button>
            </div>
        </div>
    </div>
</div>
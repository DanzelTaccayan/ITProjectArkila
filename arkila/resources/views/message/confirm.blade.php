
<script>
    @foreach($tripsObjArr as $trip)
    new PNotify({
        title: 'Confirmation',
        text: '<strong>{{$trip->plate_number}}</strong> of Terminal {{$trip->terminal->description}} is on deck and has a remark of OB. Do you want to move this unit to the special units?',
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            confirm: true,
            buttons: [{
                text: 'No',
                addClass: 'btn-default',
                click: function(notice) {
                    // Negate the OB
                    notice.update({
                        title: 'Confirmed',
                        text: '<strong>{{$trip->plate_number}}</srong> will remain on deck.',
                        icon: true,
                        type: 'info',
                        hide: true,
                        confirm: {
                            confirm: false
                        },
                        buttons: {
                            closer: true,
                            sticker: true
                        }
                    });

                    $.ajax({
                        method:'POST',
                        url: '{{route("trips.changeRemarksOB",[$trip->trip_id])}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'answer':'No'
                        },
                        success: function(){
                            $('#remark{{$trip->trip_id}}').editable('setValue','NULL')
                        }

                    });

                }
            }, {
                // Confirm the OB
                text: 'Yes',
                addClass: 'btn-primary',
                click: function(notice) {
                    notice.update({
                        title: 'Confirmed',
                        text: '<strong>{{$trip->plate_number}}</strong> will be moved to special units',
                        icon: true,
                        type: 'info',
                        hide: true,
                        confirm: {
                            confirm: false
                        },
                        buttons: {
                            closer: true,
                            sticker: true
                        }
                    });

                    $.ajax({
                        method:'POST',
                        url: '{{route("trips.changeRemarksOB",[$trip->trip_id])}}',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'answer':'Yes'
                        },
                        success: function(){
                           location.reload();
                        }

                    });

                }
            }]
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
        history: false
    }
    });
    @endforeach
</script>
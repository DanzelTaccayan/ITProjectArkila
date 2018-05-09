
<script>
    @foreach($vansObjArr as $vansOnQueue)
    new PNotify({
        title: '{{$vansOnQueue->van->plate_number}}',
        text: 'The van unit has a remark of {{$vansOnQueue->remarks}} and cannot depart, therefore it will be move to the <strong>Special Units</strong>',
        icon: 'glyphicon glyphicon-exclamation-sign',
        hide: false,
        confirm: {
            confirm: true,
            buttons: [{
                text: 'Ok',
                addClass: 'btn-primary',
                click: function(notice) {
                    notice.remove();
                    location.reload();
                }
            },
                null]
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
<script>
    @foreach($vansObjArr as $vansOnQueue)
        new PNotify({
            title: '{{$vansOnQueue->plate_number}}',
            text: 'the van unit has a remark of *insert remark* and cannot depart, therefore it will be move to the <strong>Special Units</strong>',
            icon: 'glyphicon glyphicon-exclamation-sign',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: 'Ok',
                    addClass: 'btn-primary',
                    click: function(notice) {
                        notice.remove();
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
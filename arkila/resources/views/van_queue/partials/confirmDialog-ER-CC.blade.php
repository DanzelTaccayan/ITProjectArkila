
<script>
    @foreach($vansObjArr as $vansOnQueue)
    new PNotify({
        title: 'Confirmation',
        text: '<strong>{{$vansOnQueue->plate_number}}</strong> bound for {{$vansOnQueue->destination->destination_name}} has now been moved to the special units list',
        type: 'notice',
        hide: false
    });
    @endforeach
    location.reload();
</script>
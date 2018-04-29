
<div class="modal fade" id="dialogBox">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                @foreach($vansOnQueueObjArr as $vansOnQueue)
                    <p>Van {{$vansOnQueue->plate_number}} bound for {{$vansOnQueue->destination->destination_name}} with a remark of {{$vansOnQueue->remarks}} has now be moved to the special units list</p>
                @endforeach
                    <button type="button" data-dismiss="modal" class="btn btn-primary pull-right">OK</button>
                    <div class="clearfix"></div>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $('#dialogBox').modal({backdrop: 'static', keyboard: false,  display: 'block'});
    $('#dialogBox').on('hidden.bs.modal', function () {
        location.reload();
    })
</script>

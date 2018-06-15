@extends('layouts.master')
@section('title', 'User Management')
@section('links')
@parent
<!-- additional CSS -->
<link rel="stylesheet" href="tripModal.css">

@stop
@section('content')
<div class="padding-side-15">
    <div>
        <h2 class="text-white">USER MANAGEMENT</h2>
    </div>
    <div class="box">
        <div class="col-xl-6">    
            <div class="box-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- customer -->
                        @foreach($userCustomers as $userCustomer)
                        <tr>
                            <td>{{strtoupper($userCustomer->last_name)}}, {{strtoupper($userCustomer->first_name)}}</td>
                            <td>{{$userCustomer->username}}</td>
                            <td>{{$userCustomer->email}}</td>
                            <td class="center-block">
                                <div class="text-center">
                                    <a href="/home/user-management/customer/{{$userCustomer->id}}" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-cog"></i>MANAGE ACCOUNTS</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>                 
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent

    <script>
        $(function() {
            $('.dataTable').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': [-1] /* 1st one, start by the right */
                }]
            })

        });
    </script>

    <script>
        $(function(){
         var url = window.location.href;
         var activeTab = document.location.hash;

         if(!activeTab){
                activeTab = "#driverUser";
        }

         $(".tab-pane").removeClass("active in");
         $(".tab-menu").removeClass("active in");
         $(activeTab).addClass("active");
         $(activeTab + "-menu").addClass("active");

         $('a[href="#'+ activeTab +'"]').tab('show')

        var activeDestinationId = activeTab[activeTab.length-1];

        });

        $(function(){
          var hash = window.location.hash;
          if(!hash){
                hash = "#info";
            }
          hash && $('ul.nav a[href="' + hash + '"]').tab('show');

          $('.nav-tabs a').click(function (e) {
          $(this).tab('show');
          var scrollmem = $('body').scrollTop() || $('html').scrollTop();
          window.location.hash = this.hash;
          $('html,body').scrollTop(scrollmem);
          });
        });
    </script>

@endsection

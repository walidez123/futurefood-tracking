@extends('layouts.master')
@section('pageTitle', 'order history')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'order : '.$order->order_id.'  status history', 'iconClass' => 'fa-map-marker', 'addUrl' => '', 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Status</th>
                  <th>User Name</th>
                  <th>User Type</th>
                  <th>Notes</th>

                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($histories as $history)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$history->status->title}}</td>
                  <td>{{$history->notes}}</td>
                  <td>{{ ! empty($history->user) ? $history->user->name : '' }}</td>
                  <td>{{! empty($history->user) ? $history->user->user_type : ''}}</td>
                  <td>{{$history->dateFormatted('created_at', true)}}</td>

                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                  <th>Status</th>
                  <th>User Name</th>
                  <th>User Type</th>
                  <th>Notes</th>
                  <th>Date</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="col-xs-12">
        <a class="btn btn-info pull-right printhidden" href="{{route('supervisororders.index',['work_type'=>$order->work_type])}}"><i class="fa fa-reply-all"></i> Back to Orders</a>      
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example1').DataTable( {
        //   "language": {
        //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
        // },

        retrieve: true,
        fixedColumns:   true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
        buttons: [

            'excel', 'print'
        ]
    } );
} );
</script>
@endsection

@extends('layouts.master')
@section('pageTitle', 'orders')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'order', 'iconClass' => 'fa-map-marker', 'addUrl' => '', 'multiLang' => 'false'])

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
                  <th>Order ID</th>
                  <th>Status</th>
                  <th>Ship Date</th>
                  <th>Client Name</th>
                  
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($orders as $order)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$order->order_id}}</td>
                  <td>{{$order->status->title}}</td>
                  <td>{{$order->updated_at}}</td>
                  <td>{{$order->user->name}}</td>
            
                  <td>
             
                    <a href="{{route('supervisororders.show', $order->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">View</span> </a>
                    <a href="{{route('supervisororders.history', $order->id)}}" title="History" class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa fa-history fa-spin"></i> <span class="hidden-xs hidden-sm">History</span> </a>
                 
                    <!-- <a href="{{route('supervisororderscomments.index', $order->id)}}" title="View" class="btn btn-sm btn-info" style="margin: 2px;"><i class="fa fa-commenting"></i> <span class="hidden-xs hidden-sm">comments</span> </a> -->
                  
                    <form class="pull-right" style="display: inline;" action="{{route('supervisororders.destroy', $order->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> Delete
                        </button>
                      </form>







                      @if (Request::exists('notDelegated'))

                    <a href="{{route('supervisororders.edit', $order->id)}}" title="pass order to delegate " class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-truck"></i> <span class="hidden-xs hidden-sm">Pass order to delegate </span></a>

                        @endif
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Order ID</th>
                  <th>Status</th>
                  <th>Ship Date</th>
                  <th>Client Name</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
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

@extends('layouts.master')
@section('pageTitle',  __("admin_message.History"))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' =>  __("admin_message.Order").' : '.$order->order_id.''.__("admin_message.History"), 'iconClass' => 'fa-map-marker', 'addUrl' => '', 'multiLang' => 'false'])

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
                  <th>{{ __("admin_message.status")}}</th>
                  <th>{{ __("admin_message.user name")}}</th>
                  <th>{{ __("admin_message.user type")}}</th>
                  <th>{{ __("admin_message.location")}}</th>

                  <th>{{ __("admin_message.Notes")}}</th>
                  <th>{{ __("admin_message.Date")}}</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($histories as $history)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{ ! empty($history->status) ? $history->status->trans('title') : '' }}</td>

                  <td>
                  @if(! empty($history->user))
                      @if($history->user->user_type=="super_admin")
                  
                      {{ ! empty( Auth()->user()->company) ? Auth()->user()->company->name : '' }}

                      @else
                      {{ ! empty($history->user) ? $history->user->name : '' }}
                      @endif

                  @endif
                  </td>
                  <td>
                  @if(! empty($history->user))
                      @if($history->user->user_type=="super_admin")
                  
                       admin
                      @else
                      {{! empty($history->user) ? $history->user->user_type : ''}}
                      @endif

                  @endif
                  </td>
                  <td>
                    @if($history->latitude!=NULL && $history->latitude!=NULL)
                  <a
                  href="https://www.google.com/maps/search/?api=1&query={{ $history->latitude }},{{ $history->longitude }}"
                  target="_blank">{{ __("admin_message.Open Location on Google Maps") }}</a>
                  @endif
                 </td>
                  <td>{{$history->notes}}</td>

                  <td>{{$history->dateFormatted('created_at', true)}}</td>

                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>{{ __("admin_message.status")}}</th>
                  <th>{{ __("admin_message.user name")}}</th>
                  <th>{{ __("admin_message.user type")}}</th>
                  <th>{{ __("admin_message.location")}}</th>

                  <th>{{ __("admin_message.Notes")}}</th>
                  <th>{{ __("admin_message.Date")}}</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="col-xs-12">
        <a class="btn btn-info pull-right printhidden" href="{{route('client-orders.index',['work_type'=>$order->work_type])}}"><i
                        class="fa fa-reply-all"></i>{{__("admin_message.Back to Orders")}}</a>        </div>
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

@extends('layouts.master')
@section('pageTitle', 'notifications')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => __('app.notifications', ['attribute' => '']), 'iconClass' => 'fa-bell', 'addUrl' => '', 'multiLang' => 'false'])
 <!-- Main content -->
 <section class="content">
        <div class="row">
          @include('notifications.layouts._nav')
          <!-- /.col -->
          <div class="col-md-9">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">@lang('app.list')</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">

                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped datatable data_table">
                    <tbody>
                      <thead>
                      <tr>
                          <th>icon</th>
                          <th>Type</th>
                          <th>From</th>
                           <th>To</th>
                          <th>Order Id</th>
                          <th>Message</th>
                          <th>Date</th>
                      </tr>
                      </thead>
                        @forelse ($notifications as $notification)
                        <tr>
                                <td class="mailbox-star"><i class="fa {{$notification->icon}}"></i></td>
                                <td class="mailbox-name">{{$notification->notification_type}}</td>
                                <td class="mailbox-name">{{ ! empty($notification->sender) ? $notification->sender->name : ''}}</td>
                                <td class="mailbox-name">{{ ! empty($notification->recipient) ? $notification->recipient->name : ''}}</td>
                                <td class="mailbox-name">
                                    @if ($notification->order_id && ! empty($notification->order) )
                                    @if(auth()->user()->user_type == 'admin')
                                    
                                        
                                            <a href="{{route('client-orders.show', $notification->order->id)}}" >
                                                <h5>{{$notification->order->order_id}}</h5>
                                            </a>
                                    @endif

                                    @if(auth()->user()->user_type == 'client')
                                            <a href="{{route('orders.show', $notification->order->id)}}" >
                                                <h5>{{$notification->order->order_id}}</h5>
                                            </a>
                                    @endif

                                    @if(auth()->user()->user_type == 'delegate')
                                            <a href="{{route('delegate-orders.show', $notification->order->id)}}" >
                                                <h5>{{$notification->order->order_id}}</h5>
                                            </a>
                                    @endif

                                    @endif
                                </td>
                                <td class="mailbox-subject"><a href="{{route('notifications.show', $notification->id)}}"> {{$notification->message}}</a>
                                </td>
                                <td class="mailbox-date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{$notification->dateFormatted()}}</td>
                              </tr>
                        @empty
                            <center>
                                    <i class="fa fa-bell fa-5x"></i>
                                    <h3>@lang('app.notifications', ['attribute' => __('app.no_have')])</h3>
                            </center>
                        @endforelse

                    </tbody>
                  </table>
                  <nav>
                        <ul class="pager">
                          {{ $notifications->appends($_GET)->links() }}
                        </ul>

                      </nav>
                  <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-padding">

              </div>
            </div>
            <!-- /. box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
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
                pageLength : 50,
                dom: 'lBfrtip',
                buttons: [

                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection

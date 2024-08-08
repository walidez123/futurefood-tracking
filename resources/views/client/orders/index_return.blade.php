@extends('layouts.master')
@section('pageTitle', 'orders')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!-- Main content -->
  <section class="content">
    <div class="row">
</div>

    <div class="row">
      <div class="col-xs-12">
          <div class="nav-tabs-custom">             
               <div class="row text-center" style="padding:12px">
               @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
              @endif

              @if(session('error'))
                  <div class="alert alert-danger">
                      {{ session('error') }}
                  </div>
              @endif
                          <form action="{{route('orders.index')}}" method="GET">
                              {{-- <div class="col-lg-3">
                                  <label>حالة الطلبات</label>
                                  <select class="form-control select2" name="status_id">
                                      <option value="">أختار الحالة</option>
                                      @foreach ($statuses as $status)
                                          <option {{(isset($status_id) && ($status_id == $status->id))? 'selected' : ''}} value="{{$status->id}}">{{$status->title}}</option>
                                      @endforeach
                                  </select>
                              </div> --}}
                              <div class="col-lg-3">
                                  <label>@lang('order.from_date')</label>
                                  <input type="date" name="from" value="{{(isset($from))? $from : ''}}" class="form-control" required>
                              </div>
                              <div class="col-lg-3">
                                  <div class="form-group ">
                                      <label for="to">@lang('order.to_date')</label>
                                      <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control" required>
                                  </div>
                              </div>
                              <div class="col-lg-3">
                                  <div class="form-group ">
                                      <input type="hidden" name="type" value="ship">
                                      <label>@lang('admin_message.search')</label>
                                      <input type="submit" class="btn btn-block btn-primary" value="@lang('admin_message.filter')" />
                                  </div>
                              </div>
                          </form>

                      </div>
          </div>
          
              <div class="nav-tabs-custom" style="padding:12px">
                  <div class="row">
                      <!-- <div class="col-lg-3 col-xs-12">
                           <a class="btn btn-success pull-right"  href="{{url('client/orders/create')}}">@lang('order.add_new_order') </a>
                      </div> -->
                     
                  </div>
                 
                  
              </div>
    
        <div class="box">
        
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped" cellspacing="0">
              <thead>
                <tr>
                  <th><input type="checkbox" id="checkAll"></th>
                  <th>#</th>
                  <th>@lang('order.order_id')</th>
                  <th>@lang('order.sender_name')</th>
                  <th>@lang('order.phone') </th>
                  <th>@lang('order.city')</th>
                  <th>@lang('order.COD')</th>
                  <th>{{ __('admin_message.reference_number') }}</th>
                  <th>@lang('order.ship_date')</th>
                  <th>@lang('order.more')</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($orders as $order)
                <tr>
                    <td><input type="checkbox" name="orders[]" value="{{$order->id}}" class="ordersId"></td>
                  <td>{{$count}}</td>
                  <td>{{$order->order_id}}</td>
                  
                  <td>{{$order->Order->receved_name}}</td>
                  <td>{{substr_replace($order->Order->receved_phone, '', 3, 1)}} <a href="tel:{{$order->Order->received_phone}}" style="padding:5px" target="_blank">
                    <i class="fa fa-phone fa-2x"></i></a>
                  <a href="https://api.whatsapp.com/send?phone={{$order->Order->receved_phone}}"  style="padding:5px" target="_blank"><i class="fa-brands fa-whatsapp fa-2x" style="color:green"></i></a></td>

                  <td>{{! empty( $order->Order->recevedCity ) ? $order->Order->recevedCity->trans('title') : '' }}</td>
              
                  <td>{{$order->amount}}</td>
                  <td>{{$order->reference_number}}</td>
                  <td>{{$order->updated_at}}</td>
                                      
                  <td>
                    <a href="{{url('/client/order-notifications/'.$order->id)}}" class="btn btn-sm {{ $order->notification > 0 ? 'btn-warning' :'btn-default' }}" style="margin: 2px;"><i class="fa fa-bell"></i><span>({{$order->notification_no}})</span></a>
                    <!-- <a href="{{route("track.order",['tracking_id'=>$order->tracking_id])}}" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer">  <i class="fa-solid fa-truck"></i> @lang('website.tracking')</a> -->

                    <a href="{{route('orders.show', $order->id)}}" title="View" class="btn btn-sm btn-warning"
                      style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">@lang('app.view')</span> </a>
                      <a href="{{ route('order.history', $order->id) }}" title="History"
                                                class="btn btn-sm btn-success" style="margin: 2px;"><i class="fa-solid fa-truck"></i>
                                                <span class="hidden-xs hidden-sm">@lang('website.tracking')</span> </a>

                    @if(auth()->user()->work==1)

                    
                    @if (Auth()->user()->available_edit_status == $order->status_id)

                    <a href="{{route('orders.edit', $order->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a>

                    @endif
                    @if (Auth()->user()->available_delete_status == $order->status_id)

                    <form class="pull-right" style="display: inline;"
                    action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Do you want Delete This Record ?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('admin_message.Delete') }}
                    </button>
                </form>
@endif
                    @else
                    @if (Auth()->user()->available_edit_status == $order->status_id)

                      <a  href="{{route('orders.edit', $order->id)}}" title="Edit" class="btn btn-sm btn-primary"
                        style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('app.edit')</span></a>
                        <form class="pull-right" style="display: inline;"
                    action="{{ route('orders.destroy', $order->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Do you want Delete This Record ?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('admin_message.Delete') }}
                    </button>
                </form>
                    @endif
                    @endif
            
                  </td>
                 
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th><input type="checkbox" id="checkAll"></th>
                  <th>#</th>
                  <th>@lang('order.order_id')</th>
                  <th>@lang('order.received_name')</th>
                  <th>@lang('order.phone') </th>
                  <th>@lang('order.city')</th>
                  <th>@lang('order.COD')</th>
            <th>{{ __('admin_message.reference_number') }}</th>
                  <th>@lang('order.ship_date')</th>
                  <th>@lang('order.more')</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Orders</h5>
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/client/place_order_excel') }}" method="POST" enctype='multipart/form-data'>
      <div class="modal-body">
        
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
        <div class="form-group @if($errors->has('excel')) has-error @endif">
          <label for="excel-field">File Excel</label>
          <input type="file" id="excel-field" name="import_file" class="form-control" accept=".xlsx, .xls, .csv"  required />
          @if($errors->has("excel"))
            <span class="help-block">{{ $errors->first("excel") }}</span>
          @endif
        </div>

       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('order.Close')</button>
        <button type="submit" class="btn btn-primary">@lang('order.Save Upload')</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>


<script>
 $(document).ready(function() {
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
          
        });
        $(".ordersId").on('change',function(){
            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
   
            
            
        });
        $(function () {
             $('.select2').select2()
        });
    });
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
        pageLength: 50,

        direction: "ltr",
             dom: 'Blfrtip',
              buttons: [
           {
               extend: 'print',
               footer: true,
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8]
                }
               
              
           },
          
           {
               extend: 'excelHtml5',
               footer: false,
               exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8]
                }
           }         
        ],
    
        } );

    } );
</script>

@endsection

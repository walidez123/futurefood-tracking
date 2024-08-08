@extends('layouts.master')
@section('pageTitle', trans('app.Today orders'))

@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <style>
  
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">

                    <div class="tab-content">
                        <div class="active tab-pane" id="filter1">
                            <div class="row ">
                            @if($work_type==2 &&  in_array('add_order_res', $permissionsTitle) )
                                <a type="button" href="{{route('client-orders.create', ['work_type' => $work_type])}}"
                                    class="btn btn-success">
                                    {{ __('admin_message.Add') }} <i class="fa-solid fa-plus"></i></a>
                                @elseif($work_type==1 &&  in_array('add_order', $permissionsTitle))
                                <a type="button" href="{{route('client-orders.create', ['work_type' => $work_type])}}"
                                    class="btn btn-success">
                                    {{ __('admin_message.Add') }} <i class="fa-solid fa-plus"></i></a>

                                @endif
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal">
                                    {{ __('admin_message.Search and filter') }} </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-body">
                                                <form action="{{route('Today-orders.index')}}" method="GET"
                                                    class="col-xs-12">
                                                    <input type="hidden" name="work_type" value="{{$work_type}}">
                                                    <input type="hidden" name="type" value="ship">

                                                    <div class="col-lg-6">
                                                        @if ($work_type == 1)
                                                        <label>{{ __('admin_message.restaurants') }}</label>
                                                        @else
                                                        <label>{{ __('admin_message.Clients') }}</label>
                                                        @endif
                                                        <select class="form-control select2" name="user_id">
                                                            @if ($work_type == 1)
                                                            <option value="">
                                                                {{ __('admin_message.Choose a store') }}</option>
                                                            </option>
                                                            @else
                                                            <option value="">
                                                                {{ __('admin_message.Choose a restaurant') }}
                                                            </option>
                                                            @endif
                                                            @foreach ($clients as $client)
                                                            <option
                                                                {{(isset($user_id) && ($user_id == $client->id))? 'selected' : ''}}
                                                                value="{{$client->id}}">{{$client->name}} |
                                                                {{$client->store_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.statuses') }}</label>
                                                        <select class="form-control select2" name="status_id">
                                                            <option value="">
                                                                {{ __('admin_message.Choose a statuses') }} </option>
                                                            @foreach ($statuses as $status)
                                                            <option
                                                                {{(isset($status_id) && ($status_id == $status->id))? 'selected' : ''}}
                                                                value="{{$status->id}}">{{$status->trans('title')}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.The delegates') }}</label>
                                                        <select class="form-control select2" name="delegate_id">
                                                            <option value="">
                                                                {{ __('admin_message.Select a delegate') }}</option>
                                                            @foreach ($delegates as $client)
                                                            <option
                                                                {{ isset($delegate_id) && $delegate_id == $client->id ? 'selected' : '' }}
                                                                value="{{ $client->id }}">{{ $client->name }} |
                                                                {{ $client->store_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.statuses') }}</label>
                                                        <select class="form-control select2" name="contact_status">
                                                            <option value="">{{ __('admin_message.statuses') }}
                                                            </option>
                                                            <option
                                                                {{ isset($contact_status) && $contact_status == 1 ? 'selected' : '' }}
                                                                value="1">Yes</option>
                                                            <option
                                                                {{ isset($contact_status) && $contact_status == 0 ? 'selected' : '' }}
                                                                value="0">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.from') }}</label>
                                                        <input type="date" name="from"
                                                            value="{{ isset($from) ? $from : '' }}"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group ">
                                                            <label for="to">{{ __('admin_message.to') }}</label>
                                                            <input type="date" name="to"
                                                                value="{{ isset($to) ? $to : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.from city') }}</label>
                                                        <select class="form-control select2 col-md-12"
                                                            name="sender_city">
                                                            <option value="">
                                                                {{ __('admin_message.Select a city') }}</option>
                                                            @if (!empty($cities))
                                                            @foreach ($cities as $city)
                                                            <option
                                                                {{ isset($sender_city) && $sender_city == $city->id ? 'selected' : '' }}
                                                                value="{{ $city->id }}">
                                                                {{ $city->trans('title') }}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>{{ __('admin_message.to city') }}</label>
                                                        <select class="form-control select2" name="receved_city">
                                                            <option value="">{{ __('admin_message.from city') }}
                                                            </option>
                                                            @if (!empty($cities))
                                                            @foreach ($cities as $city)
                                                            <option
                                                                {{ isset($receved_city) && $receved_city == $city->id ? 'selected' : '' }}
                                                                value="{{ $city->id }}">
                                                                {{ $city->trans('title') }}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                     <!-- service provider -->
                                                     <div class="col-lg-6">
                                                        <label>{{ __('admin_message.Service provider') }}</label>
                                                        <select class="form-control select2" name="service_provider_id">
                                                            <option value="">{{ __('admin_message.Choose a  Service Provider') }}
                                                            </option>
                                                            @if (!empty($service_providers))
                                                            @foreach ($service_providers as $service_provider)
                                                            <option
                                                                {{ isset($service_provider_id) && $service_provider_id == $service_provider->serviceProvider->id ? 'selected' : '' }}
                                                                value="{{ $service_provider->serviceProvider->id }}">
                                                                {{ $service_provider->serviceProvider->name }}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>
                                                    </div>



                                            </div>
                                            <div class="modal-footer">

                                            <div class="col-lg-6">
                                                        <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                                            value="{{ __('admin_message.search') }}" />
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <button type="button" class="btn btn-block btn-secondary "
                                                            data-dismiss="modal">{{ __("admin_message.close") }}</button>
                                                    </div>

                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="box">
                        <div class="box-header">

                            <div class="col-sm-12 invoice-col">
                            @if (in_array('change_status', $permissionsTitle))

                                <div class="col-md-6">
                                    <form action="{{route('order.change_status_all')}}" method="POST">
                                        <td><input type="hidden" name="order_id[]" value="" id="ordersId"></td>
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group col-md-8 ">
                                            <select class="form-control select2" id="status_id" name="status_id"
                                                required>
                                                <option value=""> {{ __('admin_message.Choose a statuses') }}</option>
                                                @foreach ($statuses as $status)
                                                <option value="{{$status->id}}">{{$status->trans('title')}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 ">
                                            <input type="submit" class="btn btn-success" value="{{ __('admin_message.Status change')}}">

                                        </div>
                                    </form>
                                </div>
                            @endif
                            @if (in_array('distribution_order', $permissionsTitle))

                                <div class="col-md-6">
                                    <form action="{{route('order.distribute')}}" method="POST">

                                        <td><input type="hidden" name="orders[]" value="" id="passordersId">
                                            <input type="hidden" name="type" value="data">
                                        </td>
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-8">
                                            <select class="form-control select2" name="delegate_id" required>
                                                <option value="">{{ __('admin_message.Choose a Delegate') }}</option>
                                                @foreach ($delegates as $delegate)
                                                <option value="{{$delegate->id}}">{{$delegate->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input type="submit" class="btn btn-success btn-block"
                                                value="{{ __('admin_message.Assign To Delegate')}}">
                                        </div>

                                    </form>

                                </div>
                            @endif
                            <!--  -->
                       



                            <!--  -->
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:15px;">
                        <div class="col-md-12">
                            <form action="{{route('client-orders.index')}}" method="get" id="search-form" />
                            <input type="hidden" name="type" value="ship">
                            <input type="hidden" name="work_type" value="{{$work_type}}">


                            <div class="col-md-3 col-sm-3">
                                <div id="imaginary_container">
                                    <div class="input-group stylish-input-group">
                                        <input type="text" class="form-control" id="search-field"
                                            value="{{ ! empty($search) ? $search : ''}}" name="search"
                                            placeholder=" {{ __("admin_message.Quick search") }}">
                                        <span class="input-group-addon">
                                            <button type="submit" id="search-btn1">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            </form>


                            <form action="{{route('client-orders.index')}}" method="get" id="search-form" />
                            <input type="hidden" name="type" value="ship">
                            <input type="hidden" name="work_type" value="{{$work_type}}">



                            <div class="col-md-3 col-sm-3">
                                <div id="imaginary_container">
                                    <div class="input-group stylish-input-group">
                                        <input type="text" class="form-control" id="search-field"
                                            value="{{ ! empty($search_order) ? $search_order : ''}}" name="search_order"
                                            placeholder="{{ __("admin_message.Quick search for a group of requests") }}">
                                        <span class="input-group-addon">
                                            <button type="submit" id="search-btn1">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            </form>
                           

@if ( $work_type == 1)
                                <!-- <div class="col-lg-3 col-xs-12">
                                    <button  type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#exampleModalExcel">
                                    @lang('order.import_order')
                                    </button>
                                </div> -->
                                <!-- <div class="col-lg-3 col-xs-12">
                                <a href="{{asset('/storage/website/order_templets.xlsx')}}" download class="btn">@lang('order.download_import_file')</a>
                                </div> -->
                                <div class="col-lg-3 col-xs-12 text-center">
                                
                                <form action="{{route('order_client.print-invoice')}}" method="POST">
                                    <td><input type="hidden" name="order_id[]" value="" id="ordersPolicy"></td>
                                    @csrf
                                
                                    <div class="col-md-4 ">
                                        
                                        <input type="submit" class="btn" value="@lang('app.print_Policy')">
                                    </div>
                                </form>
                                </div>
                            @endif
 </div>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                                 @include('admin.orders.store_table')

                        </div><!-- /.box-body -->

                        {!! $orders->appends($_GET)->links() !!}

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script
    src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
    type="text/javascript"></script>
<script>
$(document).ready(function() {
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);

        var arr = [];
        $('input:checkbox:checked').each(function() {
            arr.push($(this).val());
        });

        $('#ordersId').val(arr)
        $('#passordersId').val(arr)
        $('#serviceordersId').val(arr)
        $('#ordersPolicy').val(arr)


    });
    $(".ordersId").on('change', function() {
        var arr = [];
        $('input:checkbox:checked').each(function() {
            arr.push($(this).val());
        });

        $('#ordersId').val(arr)

        $('#passordersId').val(arr)
        $('#serviceordersId').val(arr)
        $('#ordersPolicy').val(arr)




    });
    $(function() {
        $('.select2').select2()
    });
});
$(document).ready(function() {
    $('#order').DataTable({
      

        retrieve: true,
        fixedColumns: true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
        pageLength: 50,
        scrollX: true,
        dom: 'lBfrtip',
        buttons: [{
                extend: 'print',
                footer: false,
                header: false,
               
            },


            {
                extend: 'excelHtml5',
                footer: false,
            }
        ],

    });

});
</script>
<style>
.select2-container {
    display: block !important;
}

.col-lg-6 {
    margin-bottom: 10px;
}
  .paging_simple_numbers {
        display: none !important;
    }
</style>
@endsection
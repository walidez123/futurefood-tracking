@extends('layouts.master')
@section('pageTitle', 'Order')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'order', 'type' => 'edit', 'iconClass' => 'fa-truck', 'url' =>
    route('delegate-orders.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="invoice">
        @if (\Session::has('message'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('message') !!}</li>
        </ul>
    </div>
@endif
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                    <div class="col-sm-12 invoice-col">
                            <div class="col-sm-6 ">
                                <b>@lang('app.order') #{{$order->order_id}}</b><br>
                                <b>@lang('app.ship_date'):</b> {{$order->pickup_date}}<br>
                            </div>
                            <div  class="col-sm-6 pull-right">
                                <b>@lang('app.status'):</b>{{! empty($order->status) ? $order->status->trans('title') : ''}}<br>
                            </div>
                            <br><br>
                            <br>
                            <br>
                        </div>
                    <div class="col-sm-6 invoice-col">
                            <strong class="h2" style="padding: 15px;">@lang('app.from') </strong>
                            <address>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.name') : </span>{{! empty($order->user) ? $order->user->store_name : ''}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.phone') : </span>{{! empty($order->address) ? $order->address->phone : ''}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.email') : </span>{{! empty($order->user) ? $order->user->email : ''}}</p>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 invoice-col">
                            <strong class="h2" style="padding: 15px;">@lang('app.to') </strong>
                            <address>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.name') : </span>{{$order->receved_name}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.phone') : </span>{{$order->receved_phone}}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.city') : </span>{{! empty($order->recevedCity) ? $order->recevedCity->title : '' }}</p>
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.address') : </span>{{$order->receved_address}}</p>
                                @if($order->work_type==1)
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.email') : </span>{{$order->receved_email}}</p>
                                @endif
                                <p class="lead" style="margin-bottom: 0; border: 1px solid #f3f3f3;padding: 10px"><span class="h4"
                                        style="padding-left: 10px">@lang('app.address_details')  : </span>{{$order->receved_address_2}}</p>
                            </address>
                        </div>
            </div>
            <!-- /.col -->
        </div>
        @if($order->work_type==1 && Auth()->user()->company_setting->status_shop!=$order->status_id)

        @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
          <div class="row invoice-info">
            <form action="{{route('delegate-orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-12 invoice-col">
                        <div class="form-group col-md-4">
                            <select class="form-control" id="status_id" name="status_id" required>
                                <option value="">@lang('app.select')  @lang('app.status')</option>
                                @foreach ($statuses as $status)
                                <option value="{{$status->id}}" >{{$status->trans('title')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" value="@lang('app.Change_status')">
                        
                </div>
            </form>
        </div>  
        @endif

        @elseif($order->work_type==2 && Auth()->user()->company_setting->status_res!=$order->status_id)
        @if ($order->status_id != $order->user->calc_cash_on_delivery_status_id)
          <div class="row invoice-info">
            <form action="{{route('delegate-orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-12 invoice-col">
                        <div class="form-group col-md-4">
                            <select class="form-control" id="status_id" name="status_id" required>
                                <option value="">@lang('app.select')  @lang('app.status')</option>
                                @foreach ($statuses as $status)
                                <option value="{{$status->id}}" >{{$status->trans('title')}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" value="@lang('app.Change_status')">
                        
                </div>
            </form>
        </div>  
        @endif







        @endif
        <!-- info row -->
        
        <!-- /.row -->



        <!-- this row will not appear when printing -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
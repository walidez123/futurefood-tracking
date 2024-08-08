@extends('layouts.master')
@section('nav')
@include('supervisor.layouts._nav')
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      @lang('app.dashboard')
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> @lang('admin_message.Home')</a></li>
      <li class="active">@lang('app.dashboard')</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
   
    <div class="row">
      <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">@lang('order.List Of Orders Pickup Today')</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>@lang('order.order_id')</th>
                    <th>@lang('order.status')</th>
                    <th>@lang('order.ship_date')</th>
                    <th>@lang('order.shipping_from_city')</th>
                    <th>@lang('order.shipping_policy')</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($ordersTodayshop as $ordersTodayRow)
                  <tr>
                      <td><a href="{{route('supervisororders.edit', $ordersTodayRow->id)}}">{{$ordersTodayRow->order_id}}</a></td>
                      <td>{{$ordersTodayRow->status->title}}</td>
                      <td>{{$ordersTodayRow->pickup_date}}</td>
                      <td>{{$ordersTodayRow->senderCity->title}}</td>
                      <td><a href="{{route('supervisororders.show', $ordersTodayRow->id)}}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Show Policy</a></td>
                    </tr>  
                  @empty
                  <center>
                      <span class="fa-stack fa-3x">
                          <i class="fa fa-truck fa-stack-1x"></i>
                          <i class="fa fa-ban fa-stack-2x text-danger"></i>
                        </span>
                      
                      <h3>@lang('order.no_orders_today')</h3>
                  </center>
                  
                  @endforelse
                  
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">@lang('order.view_all_orders')</a>
          </div>
          <!-- /.box-footer -->
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-truck"></i></span>
  
            <div class="info-box-content">
              <span class="info-box-text">@lang('order.shop_shipped_today')</span>
              <span class="info-box-number">{{count($ordersTodayshop)}}</span>
  
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">{{ __('app.Orders_Ship_today') }}  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-truck"></i></span>
  
            <div class="info-box-content">
              <span class="info-box-text">@lang('app.Orders_Ship_today')</span>
              <span class="info-box-number">{{count($ordersTodayres)}}</span>
  
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                 @lang('order.restaurant_orders')
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
           
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-shopping-bag"></i></span>
  
            <div class="info-box-content">
              <span class="info-box-text">@lang('order.total_orders')</span>
              <span class="info-box-number">{{count($orders)}}</span>
  
              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
              <span class="progress-description">
                 >@lang('order.all_orders')
              </span>
            </div>
           
  
        </div>
            <!-- /.info-box-content -->
          </div>
         
          <div class="col-xs-12 col-md-12">

          <ul class="nav nav-pills nav-stacked col-md-2 bg-gray">
            <li class="active"><a data-toggle="tab" href="#menu1">@lang('order.today')</a></li>
            <li><a data-toggle="tab" href="#menu2">@lang('order.all')</a></li>
            <li><a data-toggle="tab" href="#menu3">@lang('order.yesterday')</a></li>
            <li><a data-toggle="tab" href="#menu4">@lang('order.last_month')</a></li>
          </ul>


          <div class="tab-content col-md-10">
             
              <div id="menu1" class="tab-pane fade in active">
                  <?php $today = (new \Carbon\Carbon)->today(); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-3 ">
                          <div class="small-box  bg-gray box_status" style="padding:10px; background-color: {{$status->color}} !important;height: 160px;">
                              <a style="color:#000" href="{{url('/delegate/delegate-orders?status_id='.$status->id .'&&bydate=Today' )}}">
                              <h4 class="text-center" >

                                  {{$status->orders()->whereIn('delegate_id',$Arraydelegates)->whereDate('updated_at', $today)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
               <div id="menu2" class="tab-pane fade in ">
                  @foreach($statuses as $status)
                  <div class="col-sm-4 col-md-3 ">
                      <div class="small-box  bg-gray box_status" style="padding:10px; background-color: {{$status->color}} !important;    height: 160px;">
                          <a style="color:#000" href="{{url('/delegate/delegate-orders?status_id='.$status->id .'&&bydate=All' )}}">
                          <h4 class="text-center" >

                              {{$status->orders()->whereIn('delegate_id', $Arraydelegates)->count()}}
                          </h4>
                          <p class="text-center" >{{$status->title}}</p>
                          </a>
                      </div>
                  </div>
                  @endforeach
              </div>
              <div id="menu3" class="tab-pane fade in">
                  <?php $yesterday = (new \Carbon\Carbon)->yesterday(); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-3 ">
                          <div class="small-box  bg-gray box_status" style="padding:10px; background-color: {{$status->color}} !important; height: 160px;">
                              <a style="color:#000" href="{{url('/delegate/delegate-orders?status_id='.$status->id .'&&bydate=Yesterday' )}}">
                              <h4 class="text-center" >

                                  {{$status->orders()->whereIn('delegate_id', $Arraydelegates)->whereDate('updated_at', $yesterday)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
              <div id="menu4" class="tab-pane fade in">
                  <?php $month = (new \Carbon\Carbon)->subMonth()->submonths(1); ?>
                  @foreach($statuses as $status)
                      <div class="col-sm-4 col-md-3 ">
                          <div class="small-box  bg-gray box_status" style="padding:10px; background-color: {{$status->color}} !important; height: 160px;">
                              <a href="{{url('/delegate/delegate-orders?status_id='.$status->id .'&&bydate=LastMonth' )}}">
                              <h4 class="text-center" >
                                  {{$status->orders()->whereIn('delegate_id', $Arraydelegates)->whereDate('updated_at', '>', $month)->count()}}
                              </h4>
                              <p class="text-center" >{{$status->title}}</p>
                              </a>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>


      </div>
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
@endsection
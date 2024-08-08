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
                    <h3 class="box-title">@lang('app.notifications', ['attribute' =>  ''])</h3>


                  </div>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                      <h3>{{$notification->title}}</h3>
                      <h5>@lang('app.from'): {{$notification->sender->name}}
                      
                        
                        
                        @if ($notification->order_id && ! empty($notification->order) )
                            @if(auth()->user()->user_type == 'admin')
                            
                                
                                    <a href="{{route('client-orders.show', $notification->order->id)}}" >
                                        <h5>بيانات الطلب: {{$notification->order->order_id}}</h5>
                                        
                                        
                                        
                                    </a>
                                    <h5>إسم المستلم: {{$notification->order->receved_name}}</h5>
                                        <h5>مدينه المستلم: {{$notification->order->recevedCity->title}}</h5>
                            @endif
    
                            @if(auth()->user()->user_type == 'client')
                                    <a href="{{route('orders.show', $notification->order->id)}}" >
                                        <h5>Order: {{$notification->order->order_id}}</h5>
                                    </a>
                            @endif
    
                            @if(auth()->user()->user_type == 'delegate')
                                    <a href="{{route('delegate-orders.show', $notification->order->id)}}" >
                                        <h5>Order: {{$notification->order->order_id}}</h5>
                                    </a>
                            @endif

                       
                        
                                    
                          @endif    
                          <br>
                        <span class="mailbox-read-time pull-right">{{$notification->dateFormatted('created_at', true)}}</span></h5>
                    </div>
                    <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                        <form action="{{route('notifications.unread', $notification->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="@lang('app.unread')">
                            <i class="fa fa-bell"></i></button>
                        </form>

                    </div>
                  </div>
                  <!-- /.mailbox-controls -->
                    <div style="direction: rtl;" class="mailbox-read-message">
                      <p>{{$notification->message}}</p>

                    </div>
                    <!-- /.mailbox-read-message -->
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

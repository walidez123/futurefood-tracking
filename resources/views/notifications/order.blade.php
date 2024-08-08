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
 
         <!-- /.col -->
        <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">@lang('app.notifications', ['attribute' =>  ''])</h3>


                  </div>
                  <!-- /.box-header -->
                  @if(! empty($notifications))
                  @foreach($notifications as $notification)
                  <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                      <h3>{{$notification->title}}</h3>
                      <h5>@lang('app.from'): {{$notification->sender->name}}
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

                  @endforeach


                  @endif


                </div>
                <!-- /. box -->
              </div>
              <!-- /.col -->
        </div>
        <!-- /.row -->
        
        <div class="col-md-12" id="send-notification">
       
    <div class="modal-content">
        <div class="modal-header">
          
            <h4 class="modal-title">  {{__("admin_message.Send notifications to the client")}}</h4>
        </div>
        <form action="{{route('notifications.store')}}" method="POST">
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="name">{{__("admin_message.Title")}}</label>
                    <input type="text" class="form-control" name="title" placeholder="{{__("admin_message.Title")}}" required>
                    @error('title')
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">{{__("admin_message.Message")}}</label>
                    <textarea rows="3" class="form-control" name="message" placeholder="{{__("admin_message.Message")}}" required></textarea>
                    
                </div>
                <input type="hidden" name="notification_from" value="{{Auth()->user()->id}}">
                <input type="hidden" name="notification_to" value="{{$order->user_id}}">
                <input type="hidden" name="notification_type" value="order">
                <input type="hidden" name="notification_to_type" value="client">
                <input type="hidden" name="order_id" value="{{$order->id}}">
            </div>
            <div class="modal-footer">
                
                <button type="submit" class="btn btn-primary">{{__("admin_message.Send")}}</button>
            </div>
        </form>
    </div>

<!-- /.modal-content -->
</div>
      </section>
      <!-- /.content -->
</div><!-- /.content-wrapper -->


@endsection

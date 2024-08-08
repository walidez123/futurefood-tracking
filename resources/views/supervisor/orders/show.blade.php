@extends('layouts.master')
@section('pageTitle', 'Order : #'.$order->order_id)
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'Order', 'type' => 'Show', 'iconClass' => 'fa-truck', 'url' =>
    route('client-orders.index'), 'multiLang' => 'false'])
    <!-- Main content -->
      <style>
      .page-logo{
    display:none;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 25px
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: RIGHT;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
span.h4 {
    float: right;
    highet:60px;
}

      @media print {
   .page-header {display:none;}
      .page-logo{
    display:block;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
 margin-bottom: 25px
  
}

td, th {
  border: 1px solid #dddddd;
  text-align: RIGHT;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
span.h4 {
    float: right;
    highet:60px;
}


@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
.main-footer{display:none;}
.printhidden{display:none;}
#send-notification{display:none;}
}

  </style>
    <section class="invoice">
        <!-- title row -->
        <div class="row">
             

            <div class="col-xs-6 printhidden" style="float:left">

                <a class="btn btn-primary" href="{{$order->whatsapp_rate_link}}" target="_blank"> ارسال دعوة للتقييم</a>
                @if($order->status_id == 4 && !$order->is_returned)
                    <a class="btn btn-primary" href="{{ route('supervisororders.return',['order' => $order]) }}" target="_blank"> انشاء مرتجع طلب</a>
                @endif
            </div>
            <div class="col-xs-12 col-md-6 col-lg-6  text-center invoice-col">
            <h2 class="page-logo " >
                    <img src="https://www.onmap.sa/public/storage/website/logo/r93QyitpMa3ZswnJIW6dSh2hkk5DtwfYo342SYTu.png"/>
            </h2>
            </div>
           
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">

            <!-- /.col -->
             
                <div class="col-xs-12 col-md-12 col-lg-12  invoice-col">
                    <div class="col-xs-12 col-md-12 col-lg-12 ">
                    {{-- <img src="http://pluspng.com/img-png/free-shipping-png-free-shipping-truck-icon-png-delivery-free-shipping-image-360-512.png"
                        class="img-responsive" width="150" /> --}}
                    {!! QrCode::size(150)->generate($order->order_id); !!}
                    </div>
                    <div class="col-xs-12 col-md-12 col-lg-12 ">
                        <b>Order #{{$order->order_id}}</b><br>
                        
                        <b>رقم التتبع:</b> {{$order->tracking_id}}<br>
                     </div>
                </div>
                
                 
          
            <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
                
             <table>
  <tr>
    <th>اسم المتجر</th>
    <th> {{$order->user->store_name}}</th>
   
  </tr>
   <tr>
    <th>رقم الجوال</th>
    <th>{{ $order->sender_phone }}</th>
    
  </tr>
   <tr>
    <th>العنوان</th>
    <th>{{ $order->sender_address }}</th>
    
  </tr>
     <tr>
    <th>الرقم المرجعى</th>
    <th>{{$order->reference_number}}</th>
  </tr>
   <tr>
    <th>محتوى الطلب</th>
    <th>{{$order->order_contents}}</th>
    
  </tr>
     <tr>
    <th>عدد القطع</th>
    <th>  {{$order->number_count}}</th>
    
  </tr>
</table>
            </div>
         
            <!-- /.col -->
            <div class="col-xs-12 col-md-6 col-lg-6 invoice-col">
               
               <table>
  <tr>
    <th>اسم العميل</th>
    <th> {{$order->receved_name}}</th>
   
  </tr>
   <tr>
    <th>رقم الجوال</th>
    <th>{{ $order->receved_phone }}</th>
    
  </tr>
   <tr>
    <th>المدينة</th>
    <th>{{! empty($order->recevedCity) ? $order->recevedCity->title : ''}}</th>
    
  </tr>
     <tr>
    <th>العنوان</th>
    <th>{{$order->receved_address}}</th>
  </tr>
   <tr>
    <th>تفاصيل العنوان</th>
    <th>{{$order->receved_address_2}}</th>
    
  </tr>
     <tr>
    <th>مبلغ الدفع عند الاستلام</th>
    <th>  {{$order->amount}}</th>
    
  </tr>
  @if($order->payment_method!=NULL)
  <tr>
    <th>طريقة الدفع</th>
    <th> 
        @if($order->payment_method==1)
        كاش
        @elseif($order->payment_method==2)
        شبكة
        @endif
      </th>
  </tr>
  @endif
  @if($order->real_image_confirm!=NULL)
                    <tr>
                        <th>صوره الطلب بعد التسليم</th>
                        <th>
                            <img src="{{asset('storage/'.$order->real_image_confirm)}}" />

                        </th>
                    </tr>
                    @endif
</table>
            </div>

            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
                    Print</a>
                <button type="button" class="btn btn-warning pull-center printhidden" data-toggle="modal"
                    data-target="#send-notification">
                    <i class="fa fa-bell"></i>
                    Send Notifiction for Client
                </button>
                <a class="btn btn-info pull-right printhidden" href="{{route('supervisororders.index',['work_type'=>$order->work_type])}}"><i
                        class="fa fa-reply-all"></i> Back to Orders</a>
            </div>

        </div>

    </section>
    <!-- /.content -->
    <div class="modal fade" id="send-notification">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Send Notifiction</h4>
                </div>
                <form action="{{route('notifications.store')}}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                            @error('title')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Message</label>
                            <textarea rows="3" class="form-control" name="message" placeholder="message" required></textarea>

                        </div>
                        <input type="hidden" name="notification_from" value="{{Auth()->user()->id}}">
                        <input type="hidden" name="notification_to" value="{{$order->user_id}}">
                        <input type="hidden" name="notification_type" value="order">
                        <input type="hidden" name="notification_to_type" value="client">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('order.Close')</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div><!-- /.content-wrapper -->
@endsection

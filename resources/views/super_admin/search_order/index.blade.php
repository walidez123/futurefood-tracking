@extends('layouts.master')
@section('pageTitle', 'بحث الطلبات')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  <!-- @include('layouts._header-index', ['title' => 'شركة', 'iconClass' => 'fa-users', 'addUrl' => route('companies.create'), 'multiLang' => 'false']) -->
  

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
    
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
            <form action="{{route('search_order.index')}}" method="GET">
            <div class="col-lg-4">
                                  <label>@lang('order.order_id')</label>
                                  <input type="text" name="order_id" value="{{(isset($order_id))? $order_id : ''}}" class="form-control" >
                              </div>
                              
                              <!-- <div class="col-lg-4">
                                  <label>@lang('order.from_date')</label>
                                  <input type="date" name="from" value="{{(isset($from))? $from : ''}}" class="form-control" >
                              </div> -->
                              <!-- <div class="col-lg-4">
                                  <div class="form-group ">
                                      <label for="to">@lang('order.to_date') </label>
                                      <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control" >
                                  </div>
                              </div> -->
                             
                              <div class="col-lg-4">
                                  <div class="form-group ">
                                     
                                      <label></label>
                                      <!-- <input type="submit" class="btn btn-block btn-primary"  value="فلتر"/> -->
                                      <button type="submit" class="btn btn-block btn-primary" name="action" value="filter">@lang('admin_message.filter')</button>
                                      <!-- <button type="submit" style="" class=" btn-block btn-danger btn"  name="action" value="export">Export To Excel</button> -->
                                  </div>
                              </div>
                          </form>
          </div><!-- /.box-header -->
          <div class="box-body">
            @if(isset($order))
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>رقم الطلب</th>
                  <th>الشركة</th>
                  <th> أسم العميل</th>
                  <th> حالة الطلب</th>
                  <th>مفعل </th>
                  <th>تفاصيل </th>

                </tr>
              </thead>
              <tbody>
                <td>{{$order->order_id}}</td>
                <td>{{ !empty($order->company) ? $order->company->store_name : '' }}</td>

                <td>{{ !empty($order->user) ? $order->user->store_name : '' }}</td>
                <td>{{ !empty($order->status) ? $order->status->trans('title') : '' }} <br>
                {{ $order->updated_at }}</td>
              
                <td>
                  @if ($order->trashed()) 
                  تم مسح الطلب
                  @else
                  طلب متفعل

                  @endif


                </td>
                <td>
                <a href="{{ route('search_order.show', $order->id) }}" title="View"
                 class="btn btn-sm btn-warning" style="margin: 2px;"><i
                     class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span>
                 </a>
                </td>


              </tbody>
              <tfoot>
                <tr>
                <!-- <th>#</th> -->
                  <th>رقم الطلب</th>
                  <th>الشركة</th>
                  <th> أسم العميل</th>
                  <th> حالة الطلب</th>
                  <th>مفعل</th>
                  <th>تفاصيل</th>

                </tr>
              </tfoot>
            </table>
            @else
            <h3>لا يوجد طلب </h3>


            @endif
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
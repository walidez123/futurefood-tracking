@extends('layouts.master')
@section('pageTitle', 'تقارير الشركات الشهرية')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  
  @include('layouts._header-form', ['title' => 'الشركة', 'type' => 'عرض', 'iconClass' => 'fa-users', 'url' =>
    route('monthly-reports.index'), 'multiLang' => 'false'])
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
            
            <h3>التقارير الشهرية لشركة  {{ $company->store_name }}</h3><br>
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
                <div class="info-box  bg-gr1">
                    <span class="info-box-icon  elevation-1"><i class="fa-solid  fa-user"></i></span>
                    <div class="info-box-content">
                    <span class="info-box-text"> العملاء</span>
                    <span class="info-box-number">{{count($usersCount)}}</span>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
              <!-- small box -->
               <div class="info-box  bg-red">
                  <span class="info-box-icon  elevation-1"><i class="fa-solid fa-truck"></i></span>
                  <div class="info-box-content">
                  <span class="info-box-text"> عدد الطلبات الشهرية</span>
                  <span class="info-box-number">{{count($ordersCount)}}</span>  
                </div>
              </div>
            </div>   
            <div class="col-xs-4">
              <table class=" table table-bordered table-striped ">
                <tr>
                  <th>{{ trans('admin_message.all_debtor') }}</th>
                  <td>{{ $count_debtor }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin_message.order_debtor') }}</th>
                    <td>{{ $count_order_debtor }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin_message.all_creditor') }}</th>
                    <td>{{ $count_creditor }}</td>
                </tr>
                <tr>
                    <th>{{ trans('admin_message.order_creditor') }}</th>
                    <td>{{ $count_order_creditor }}</td>
                </tr>
              </table>
          </div> 
      </div>    
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
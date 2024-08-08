@extends('layouts.master')
@section('pageTitle', 'طلبات الشركة ')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{$company->name}} 
    </h1>
 
  </section>

  <!-- Main content -->
  <section class="content">
  

      
     
  
       <div class="col-xs-12" style="background: #fff;">
           
     <ul class="nav nav-tabs" style="
    background: #fff;
    font-weight: bold;
    margin: 15px;
    margin-bottom: 3px;">
    <li class="active"><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu1">@lang('app.Today')</a></li>
    <li><a style="color: #000;
    padding-right: 25px;"  data-toggle="tab" href="#menu2">@lang('app.All')</a></li>
    <li><a style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu3">أمس</a></li>
    <li><a  style="color: #000;
    padding-right: 25px;" data-toggle="tab" href="#menu4">أخر 30 يوم</a></li>
  </ul>

  <div class="tab-content">
       <div id="menu1" class="tab-pane fade in active">
           
                  <?php $today = (new \Carbon\Carbon)->today(); ?>
                      <div class="col-sm-4 col-md-2 ">
                         
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; height: 150px;">
                               <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000" href="">
                              <h4 class="text-center" >
                              {{\App\Models\Order::where('company_id', $company->id)->whereDate('updated_at', $today)->count()}}

                              </h4>
                              <p class="text-center" >طلب</p>

                              </a>
                          </div>
                      </div>
              </div>
               <div id="menu2" class="tab-pane fade in ">
                  <div class="col-sm-4 col-md-2 ">
                      <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px;     height: 150px;">
                          <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                          <a style="color:#000" href="">
                          <h4 class="text-center" >

                              {{$orders->count()}}
                          </h4>
                          <p class="text-center" >طلب</p>

                          </a>
                      </div>
                  </div>
              </div>
              <div id="menu3" class="tab-pane fade in">
                  <?php $yesterday = (new \Carbon\Carbon)->yesterday(); ?>
                      <div class="col-sm-4 col-md-2 ">
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important;padding:10px; ">
                              <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000" href="">
                              <h4 class="text-center" >

                                  {{\App\Models\Order::where('company_id', $company->id)->whereDate('updated_at', $yesterday)->count()}}

                              </h4>
                              <p class="text-center" >طلب</p>

                              </a>
                          </div>
                      </div>
              </div>
              <div id="menu4" class="tab-pane fade in">
                  <?php $month = (new \Carbon\Carbon)->subMonth()->submonths(1); ?>
                      <div class="col-sm-4 col-md-2 ">
                          <div class="small-box  bg-gray box_status" style="    height: 120px !important; padding:10px; ">
                              <div class="icon">
                                  <i class="fa fa-shopping-bag"></i>
                              </div>
                              <a style="color:#000"  href="">
                              <h4 class="text-center"  >
                                  {{\App\Models\Order::where('company_id', $company->id)->whereDate('updated_at', '>', $month)->count()}}

                              </h4>
                              <p class="text-center" >طلب</p>

                              </a>
                          </div>
                      </div>
              </div>
  </div>
 <div>
  </section>
  <!-- /.content -->
</div>
@endsection


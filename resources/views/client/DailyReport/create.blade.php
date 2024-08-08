@extends('layouts.master')
@section('pageTitle', 'الطلبات')
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

 
<style>
    .paging_simple_numbers {
    display: none !important;
}
</style>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
 
                <div class="tab-content">
                    <div class="active tab-pane" id="filter1">
                        <div class="row text-center">
                            <form action="{{route('DailyReport.store')}}" method="post">
                            @csrf

                                <div class="col-lg-3">
                                    <label>المناديب</label>
                                    <select class="form-control select2" id="delegate_id" name="delegate_id">
                                        <option value="">أختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option     value="{{$delegate->id}}">{{$delegate->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                               



                                <div class="col-lg-3">
                                    <label>العملاء</label>
                                    <select id="client_id" class="form-control select2" name="client_id">
                                    

                                    </select>
                                </div>
                             
                                
                              
                                <div class="col-lg-2">
                                    <label>التاريخ</label>
                                    <input type="date" name="date" value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label>الطلبات المستلمة</label>
                                    <input type="number" name="Recipient" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الطلبات المتسلمة</label>
                                    <input type="number" name="Received" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الطلبات المسترجعة</label>
                                    <input type="number" name="Returned" value="0" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label> المبالغ المتحصلة</label>
                                    <input type="text"  name="total" value="0" class="form-control" >
                                </div>
                             
                           

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>أرسال</label>
                                        <input type="submit" class="btn btn-block btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                  
                   
 
                </div>
              
        </div><!-- /.col -->
      </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
  $(document).ready(function() {

    $(function () {
         $('.select2').select2()
});
} );




@endsection

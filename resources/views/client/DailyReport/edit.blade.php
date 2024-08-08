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
                            <form action="{{route('DailyReport.update', $Daily_report->id)}}" method="post">
                            @csrf
                        @method('PUT')
                                <div class="col-lg-3">
                                    <label>المناديب</label>
                                    <select class="form-control select2" id="delegate_id" name="delegate_id">
                                        <option value="">أختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                        @if($Daily_report->delegate_id==$delegate->id)
                                            <option selected    value="{{$delegate->id}}">{{$delegate->name}}</option>
                                        @else
                                        <option     value="{{$delegate->id}}">{{$delegate->name}}</option>


                                        @endif
                                        @endforeach

                                    </select>
                                </div>
                               



                                <div class="col-lg-3">
                                    <label>العملاء</label>
                                    <select id="client_id" class="form-control select2" name="client_id">
                                        <option selected value="{{$client->id}}">{{$client->store_name}}</option>
                                    

                                    </select>
                                </div>
                             
                                
                              
                                <div class="col-lg-2">
                                    <label>التاريخ</label>
                                    <input type="date" name="date" value="{{$Daily_report->date}}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label>الطلبات المستلمة</label>
                                    <input type="number" name="Recipient" value="{{$Daily_report->Recipient}}" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الطلبات المتسلمة</label>
                                    <input type="number" name="Received" value="{{$Daily_report->Received}}" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الطلبات المسترجعة</label>
                                    <input type="number" name="Returned" value="{{$Daily_report->Returned}}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label> المبالغ المتحصلة</label>
                                    <input type="text"  name="total" value="{{$Daily_report->total}}" class="form-control" >
                                </div>
                             
                           

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>تعديل</label>
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

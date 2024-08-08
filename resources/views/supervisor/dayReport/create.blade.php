@extends('layouts.master')
@section('pageTitle', trans('order.orders'))
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
                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                        {{ Session::get('error')}}
                        </div>
                        @endif
                            <form action="{{route('supervisor_DayReport.store')}}" method="post">
                            @csrf

                                <div class="col-lg-3">
                                    <label>@lang('order.delegates')</label>
                                    <select required class="form-control select2" id="delegate_id" name="delegate_id">
                                        <option value=""> @lang('order.select_delegate')</option>
                                        @foreach ($delegates as $delegate)
                                            <option value="{{$delegate->id}}">{{$delegate->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-lg-3">
                                    <label>@lang('report.clients')</label>
                                    @error('client_id')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <select  id="client_id" class="form-control select2" name="client_id">
                                        
                                    </select>
                                </div>
                            
                                <div class="col-lg-2">
                                    <label>@lang('report.date')</label>
                                    <input type="date" name="date" value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    
                                    <label>@lang('report.received_orders') </label>
                                    <input type="number" name="Recipient" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>@lang('report.delivered_orders') </label>
                                    <input type="number" name="Received" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>@lang('report.returned_orders')</label>
                                    <input type="number" name="Returned" value="0" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label>@lang('report.amounts_collected')  </label>
                                    <input type="text"  name="total" value="0" class="form-control" >
                                </div>
                             
                           

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>@lang('order.submit')</label>
                                        <input type="submit" value="@lang('order.submit')" class="btn btn-block btn-primary" />
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#delegate_id').change(function () {
            var delegateId = $(this).val();

            $.ajax({
                url: '/fetch-clients', 
                method: 'GET',
                data: {delegate_id: delegateId},
                success: function (data) {
                    $('#client_id').empty();

                    $.each(data.clients, function (index, client) {
                        $('#client_id').append('<option value="' + client.id + '">' + client.store_name + '</option>');
                    });
                },
                error: function (error) {
                    console.error('Error fetching clients:', error);
                }
            });
        });
    });
</script>
<script>
  $(document).ready(function() {

    $(function () {
         $('.select2').select2()
});
} );




@endsection

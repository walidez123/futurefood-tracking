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
                            @if(Session::has('error'))
<div class="alert alert-danger">
  {{ Session::get('error')}}
</div>
@endif
                            <form action="{{route('DayReport.store')}}" method="post">
                            @csrf

                               @if(count($clients)>1) 
                                <div class="col-lg-3">
                                    <label>@lang('app.Clients')</label>
                                    <select class="form-control select2" name="client_id">
                                        <option value="">@lang('app.select') @lang('app.Client')</option>
                                        @foreach ($clients as $client)
                                        @if($client->user !== null)

                                            <option     value="{{$client->client_id}}">{{$client->user->name}} | {{$client->user->store_name}}</option>
                                        @endif
                                        @endforeach

                             

                                    </select>
                                </div>
                                @elseif(count($clients)==1)
                                <input type="hidden" value="{{$clients[0]->client_id}}" name="client_id">


                                @endif
                                
                              
                                <!--<div class="col-lg-2">-->
                                <!--    <label>التاريخ</label>-->
                                    <input type="hidden" name="date" value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control" >
                                <!--</div>-->

                                <div class="col-lg-2">
                                    <label>@lang('app.Recipient')</label>
                                    <input type="number" name="Recipient" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label> @lang('app.Received') </label>
                                    <input type="number" name="Received" value="0" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>@lang('app.Returned')</label>
                                    <input type="number" name="Returned" value="0" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <label>@lang('app.The_amount_received')</label>
                                    <input type="text"  name="total" value="0.0" class="form-control" >
                                </div>
                             
                           

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>@lang('app.send')</label>
                                        <input type="submit" class="btn btn-block btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                   
 
                </div>
            

                
               
              
                
                    
            </div><!-- /.box -->
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


</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js" type="text/javascript"></script>

@endsection

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
    @include('layouts._header-index', ['title' => __('app.Report'), 'iconClass' => 'fa-store', 'addUrl' =>
    route('DayReport.create'), 'multiLang' => 'false'])




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

                                <form action="{{route('DayReport.index')}}" method="get">
                                    <input type="hidden" name="type" value="0">
                                    @if(count($clients)>1) 

                                    <div class="col-lg-3">
                                        <label>@lang('app.Clients')</label>
                                        <select id="client_id" class="form-control select2" name="client_id">

                                            <option value="">@lang('app.select') @lang('app.Client')</option>
                                            @foreach($clients as $singleclient)
    @if($singleclient->user !== null)
        <option value="{{$singleclient->user->id}}" {{ isset($client_id) && $client_id == $singleclient->user->id ? 'selected' : '' }}>
            {{$singleclient->user->store_name}}
        </option>
    @endif
@endforeach


                                        </select>
                                    </div>
                                @elseif(count($clients)==1)
                                <input type="hidden" value="{{$clients[0]->client_id}}" name="client_id">


                                @endif



                                    <div class="col-lg-2">
                                    <label> @lang('app.from')</label>
                                        <input type="date" name="from"
                                            value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                    <label> @lang('app.to')</label>
                                        <input type="date" name="to" value="{{(isset($to))? $to :  date('Y-m-d ') }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group ">
                                        <label> @lang('app.filter')</label>
                                            <input type="submit" value=" @lang('app.filter')
                                        " class="btn btn-block btn-primary" />
                                        </div>
                                    </div>
                                </form>
                            </div>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <table id="example1" class="table table-bordered table-striped table-hover data_table table-fixed-header responsive no-wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> @lang('app.Report_ID') </th>
                                <th>@lang('app.Client')</th>
                                <th>@lang('app.Recipient')</th>
                                <th>@lang('app.Received')</th>
                                <th>@lang('app.Returned')</th>
                                <th>@lang('app.The_amount_received')</th>
                                <th> @lang('app.date')</th>
                                <!--<th>العمليات</th>-->


                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1 ?>
                            @foreach ($reports as $report)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$report->id}}</td>
                                <td>{{$report->client->store_name}}</td>
                                <td>{{$report->Recipient}}</td>
                                <td>{{$report->Received}}</td>
                                <td>{{$report->Returned}}</td>
                                <td>{{$report->total}}</td>
                                <td>{{$report->date}}</td>
                                <td>
                                <!--<a href="{{route('DayReport.edit', $report->id)}}" title="View" class="btn btn-sm btn-info"-->
                                <!--               style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span>-->
                                <!--            </a>-->
                                <!--</td>-->




                            </tr>
                            <?php $count++ ?>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                            <th>@lang('app.total')</th>
                  <th>-----</th>

                  <th>------</th>
                  <th> {{$reports->sum('Recipient')}}</th>
                  <th> {{$reports->sum('Received')}} </th>
                  <th> {{$reports->sum('Returned')}}</th>
                  <th>  {{$reports->sum('total')}}</th>
                  <th>  ------</th>
                  <th>--------</th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->






        </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
 
</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script
    src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
    type="text/javascript"></script>
 <script> 
      $(document).ready(function() {
    $('#example1').DataTable( {
        //   "language": {
        //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
        // },

        retrieve: true,
        fixedColumns:   true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
         pageLength : 50,
          scrollX: true,
             dom: 'lBfrtip',
   
              buttons: [
           {
               extend: 'print',
               footer: false,
                header: false,   
                title: "RUN SHEET",
                text: "RUN SHEET",
                exportOptions: {
                     stripHtml : false,
                    columns: [0,1,2,3,4,5,6]
                },
                "columnDefs": [
                { "width": "20%", "targets":6 }
              ]
               
              
           },
           
          
           {
               extend: 'excelHtml5',
               footer: false,
               
               exportOptions: {
                    columns: [0,6,7,8,9,10,11,12,13,14,15,16,17,18,19]
                }
           }         
        ],
 
        } );

    } );
</script>

@endsection
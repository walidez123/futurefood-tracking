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


  <!-- @include('layouts._header-index', ['title' => 'تقرير', 'iconClass' => 'fa-store', 'addUrl' => route('DailyReport.create'), 'multiLang' => 'false']) -->

  

 
<style>
    /*div#example1_paginate{*/
    /*    display:block!important;*/
    /*}*/
    .paging_simple_numbers {
    display: block !important;
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
                            <form  method="get">
                              <input type="hidden" name="type" value="0">

                                <div class="col-lg-3">
                                    <label>المناديب</label>
                                    <select class="form-control select2" id="delegate_id" name="delegate_id">
                                        <option value="">أختر المندوب</option>
                                        @foreach ($delegates as $delegate)
                                            <option   {{(isset($delegate_id) && ($delegate_id == $delegate->id))? 'selected' : ''}}     value="{{$delegate->id}}">{{$delegate->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                               



                            
                             
                                
                              
                                <div class="col-lg-2">
                                    <label>من</label>
                                    <input  type="date" name="from" value="{{(isset($from))? $from :  date('Y-m-d ') }}" class="form-control" >
                                </div>
                                <div class="col-lg-2">
                                    <label>الى</label>
                                    <input  type="date" name="to" value="{{(isset($to))? $to :  date('Y-m-d ') }}" class="form-control" >
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>@lang('admin_message.search')</label>
                                        <input formaction="{{route('reportsClient.index')}}" type="submit" value="بحث
                                        " class="btn btn-block btn-primary" />
                                    </div>
                             </div>
                             <div class="col-lg-2">
                                    <div class="form-group ">
                                        <label>تحميل ملف الإكسيل</label>
                                        <input formaction="{{route('reportsClient.export')}}" type="submit" value="excel
                                        " class="btn btn-block btn-primary" />
                                    </div>
                             </div>
                             </form>

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
                  <th>الكود الوظيفى</th>
                  <th>المندوب</th>
                  <th>المدينة</th>

                  <th> طلبات المستلمة</th>
                  <th> طلبات تم تسليمها</th>
                  <th>الطلبات المسترجعة</th>
                  <th> المبلغ المتحصل</th>
                  <th>  التاريخ</th>



                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($reports as $report)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$report->delegate->code}}</td>

                  <td>{{$report->delegate->name}}</td>
                  <td>{{$report->delegate->city->title}}</td>


                  <td>{{$report->Recipient}}</td>
                  <td>{{$report->Received}}</td>
                  <td>{{$report->Returned}}</td>
                  <td>{{$report->total}}</td>
                  <td>{{$report->date}}</td>
              


        
                </tr>
                <?php $count++ ?>
                @endforeach
                <tr>
                <th>الإجمالى</th>
                  <th>-----</th>
                  <th>-----</th>
                  <th>-----</th>


                  <th> {{$reports->sum('Recipient')}}</th>
                  <th> {{$reports->sum('Received')}} </th>
                  <th> {{$reports->sum('Returned')}}</th>
                  <th>  {{$reports->sum('total')}}</th>
                  <th>  ------</th>
                </tr>

                </tr>

              </tbody>
              <tfoot>
                <tr>
                <th>#</th>
                  <th>الكود الوظيفى</th>
                  <th>المندوب</th>
                  <th>المدينة</th>

                  <th> طلبات المستلمة</th>
                  <th> طلبات تم تسليمها</th>
                  <th>الطلبات المسترجعة</th>
                  <th> المبلغ المتحصل</th>
                  <th>  التاريخ</th>
                </tr>
              </tfoot>
            </table>


          </div><!-- /.box-body -->
                  {!! $reports->appends($_GET)->links() !!}

          

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
<script>
    
    $(document).ready(function() {
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
            $('#passordersId').val(arr )
        });
        $(".ordersId").on('change',function(){
            var arr = [];
            $('input:checkbox:checked').each(function () {
                arr.push($(this).val());
            });
          
            $('#ordersId').val(arr )
            
            $('#passordersId').val(arr )
            
            
        });
        $(function () {
             $('.select2').select2()
        });
    });
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
     "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": true,
                "searchable": false
            },
            {
                "targets": [ 2 ],
                "visible": true
            },
             {
                "targets": [ 3 ],
                "visible": true
            },
             {
                "targets": [ 4 ],
                "visible": true
            }, {
                "targets": [ 5],
                "visible": true
            }
            , {
                "targets": [ 6],
                "visible": true
            }
        ],
              buttons: [
           {
               extend: 'print',
               footer: true,
                header: true,   
                title: "RUN SHEET",
                text: "RUN SHEET",
                exportOptions: {
                     stripHtml : false,
                    columns: [0,1,2,3,4,5,6,7]
                },
                "columnDefs": [
                { "width": "20%", "targets":6 }
              ]
               
              
           },
          
           {
               extend: 'excelHtml5',
               footer: true,
               columns: [0,1,2,3,4,5,6]

               
             
           }         
        ],
 
        } );

    } );
</script>

@endsection

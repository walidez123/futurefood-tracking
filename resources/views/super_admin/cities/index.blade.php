@extends('layouts.master')
@section('pageTitle', 'المدن')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
 
 


  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>الأختصار</th>


                  <th>المدينة</th>
                  <th>المدينة بالعربى</th>

                  <th>(longitude) خط الطول</th>
                  <th>(latitude)خط العرض</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($cities as $city)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{$city->abbreviation}}</td>


                  <td>{{$city->title}}</td>
                  <td>{{$city->title_ar}}</td>

                  <td>{{$city->longitude}}</td>
                  <td>{{$city->latitude}}</td>
                  <td>
                    @if (in_array('edit_city', $permissionsTitle))
                     <a href="{{route('cities.edit', $city->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>   
                    @endif
                    
                      @if (in_array('delete_city', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('cities.destroy', $city->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> حذف
                          </button>
                        </form>  
                      @endif
                      @if (in_array('edit_city', $permissionsTitle))
                     <a href="{{route('neighborhoods.city', $city->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">الأحياء</span></a>   
                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <th>#</th>
                <th>الأختصار</th>


                  <th>المدينة</th>
                  <th>المدينة بالعربى</th>

                  <th>(longitude) خط الطول</th>
                  <th>(latitude)خط العرض</th>
                  <th>العمليات</th>
                </tr>
              </tfoot>
            </table>

            <!-- paginate nav  -->
            <nav>
                        <ul class="pager">
                          {{ $cities->appends($_GET)->links() }}
                        </ul>

                      </nav> 
            
         

          </div><!-- /.box-body -->
 
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')

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
             
              buttons: 
              [
           {
               extend: 'print',
               footer: false,
                header: false,   
                title: "RUN SHEET",
                text: "RUN SHEET",
                exportOptions: {
                     stripHtml : false,
                },
                "columnDefs": [
                { "width": "100%", "targets":3 }
              ]
               
              
           },
           
          
           {
               extend: 'excelHtml5',
               footer: false,
               
             
           }         
        ],
 
        } );

    } );
</script>
@endsection

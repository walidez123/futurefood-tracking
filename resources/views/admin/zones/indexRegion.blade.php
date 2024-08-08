@extends('layouts.master')
@section('pageTitle',__("admin_message.Neighborhood Tilrs"))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@if (in_array('add_RegionZone', $permissionsTitle))

@include('layouts._header-index', ['title' =>__("admin_message.Neighborhood Tilrs"), 'iconClass' => 'fa-users', 'addUrl' => route('RegionZone.create'), 'multiLang' => 'false'])
@endif
 


  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>

                  <th>{{ __('admin_message.Zone')}} {{ __('admin_message.English')}}</th>
                  <th>{{ __('admin_message.Zone')}} {{ __('admin_message.Arabic')}}</th>
                  <th>{{ __('admin_message.Action')}}</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if ($zones->currentPage() == 1) {
                        $count = 1;
                    } else {
                        $count = ($zonesboxs->currentPage() - 1) * 25 + 1;
                    }
                ?> 
                @foreach ($zones as $zone)
                <tr>
                  <td>{{$count}}</td>

                  <td>{{$zone->title}}</td>
                  <td>{{$zone->title_ar}}</td>

                  <td>
                    @if (in_array('edit_RegionZone', $permissionsTitle))
                     <a href="{{route('RegionZone.edit', $zone->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.Edit')}}</span></a>   
                    @endif
                    
                      @if (in_array('delete_RegionZone', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('RegionZone.destroy', $zone->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('admin_message.Delete')}}
                          </button>
                        </form>  
                      @endif
                    
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <th>#</th>

                <th>{{ __('admin_message.Zone')}} {{ __('admin_message.English')}}</th>
                  <th>{{ __('admin_message.Zone')}} {{ __('admin_message.Arabic')}}</th>

                  <th>{{ __('admin_message.Action')}}</th>
                </tr>
              </tfoot>
            </table>

            <!-- paginate nav  -->
            <nav>
                        <ul class="pager">
                          {{ $zones->appends($_GET)->links() }}
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

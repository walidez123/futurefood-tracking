@extends('layouts.master')
@section('pageTitle', 'الأحياء')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


 

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

                  <th>الحى</th>
                  <th>المدينة</th>

               
                  <th>(longitude) خط الطول</th>
                  <th>(latitude)خط العرض</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($neighborhoods as $neighborhood)
                <tr>
                  <td>{{$count}}</td>

                  <td>{{$neighborhood->title}}</td>
                  <td>{{$neighborhood->city->title}}</td>

                  <td>{{$neighborhood->longitude}}</td>
                  <td>{{$neighborhood->latitude}}</td>
                  <td>
                    @if (in_array('edit_neighborhood', $permissionsTitle))
                     <a href="{{route('neighborhoods.edit', $neighborhood->id)}}" title="Edit" class="btn btn-sm btn-primary"
                      style="margin: 2px;"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">تعديل</span></a>   
                    @endif
                    
                      @if (in_array('delete_neighborhood', $permissionsTitle))
                      <form class="pull-right" style="display: inline;" action="{{route('neighborhoods.destroy', $neighborhood->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> حذف
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

                  <th>الحى</th>
                  <th>المدينة</th>

               
                  <th>(longitude) خط الطول</th>
                  <th>(latitude)خط العرض</th>
                  <th>العمليات</th>
                </tr>
              </tfoot>
            </table>
            
         

          </div><!-- /.box-body -->
 
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
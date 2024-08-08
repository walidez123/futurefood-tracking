@extends('layouts.master')
@section('pageTitle', 'sliders')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'Slider', 'iconClass' => 'fa-window-restore', 'addUrl' =>
  route('sliders.create'), 'multiLang' => 'false'])

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
                  <th>Image</th>
                  <th>title</th>
                  <th>Date Created </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($sliders as $slider)
               
                <tr>
                  <th>{{$count}}</th>
                  <td class=""><img src="{{asset('storage/'.$slider->image)}}" class="img-responsive " alt="User Image"
                      width="80"></td>

                  <td class="en ">{{$slider->title_en}}</td>
                  <td class="ar ">{{$slider->title_ar}}</td>
                  <td>{{$slider->dateFormatted()}}</td>
                  <td>
                        
                    <a href="{{route('sliders.edit', $slider->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                    
                      <form class="pull-right" style="display: inline;" action="{{route('sliders.destroy', $slider->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>  
                      
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>title</th>
                  <th>Date Created </th>
                  <th>Action</th>
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
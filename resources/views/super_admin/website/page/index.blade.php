@extends('layouts.master')
@section('pageTitle', 'pages')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => 'page', 'iconClass' => 'fa fa-file-text', 'addUrl' =>
  route('pages.create'), 'multiLang' => 'false'])

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
                  <th>title</th>
                  <th>image</th>
                  <th>status</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1 ?>
                @foreach ($pages as $page)
               
                <tr>
                  <th>{{$count}}</th>
                  <td class="en ">{{$page->title_en}}</td>
                  <td class="ar ">{{$page->title_ar}}</td>
                  <td>
                      @if ($page->image)
                      <img src="{{asset('storage/'.$page->image)}}" height="75" width="120">
                      @endif
                  </td>
                  <td>{{$page->status}}</td>
                  <td>{{$page->dateFormatted()}}</td>
                  <td>
                        
                    <a href="{{route('pages.edit', $page->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Edit</span></a>
                    
                  
                        <form class="pull-right" style="display: inline;" action="{{route('pages.destroy', $page->id)}}" method="POST">
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
                    <th>title</th>
                    <th>image</th>
                    <th>status</th>
                    <th>Created at</th>
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
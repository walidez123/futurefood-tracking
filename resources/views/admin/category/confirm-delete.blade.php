@extends('layouts.master')
@section('pageTitle', {{trans('order.Delete category')}})
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => {{trans('order.category')}}, 'type' => 'Delete', 'iconClass' => 'fa fa-th', 'url' =>
  route('categories.index'), 'multiLang' => 'false'])


  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('categories.destroy', $id)}}" method="POST">
        @csrf
        @method('DELETE')
        <div class="col-md-6 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 class="box-title"> {{trans('order.Confirm Delete category')}}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">{{trans('order.Select Other Category for migrate posts to this category')}}</label>
                    <select class="form-control mdb-select md-form" name="category_id" required>
                      @foreach ($categories as $category)
                      <option value="{{$category->id}}">{{$category->title_en}} | {{$category->title_ar}}</option>
                      @endforeach
                    </select>
                  </div>
              <div class=" footer">
                <button type="submit" class="btn btn-sm btn-danger"><i
                  class="fa fa-trash" onclick="return confirm('Do you want Delete This Record ?');"></i>{{trans('order.Delete')}}</button>
                  <a style="float:right" href="{{route('categories.index')}}" title="{{trans('order.Edit')}}" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                    class="fa fa-reply"></i> <span class="hidden-xs hidden-sm">{{trans('order.Delete')}}</span></a>
              </div>
            </div>
          </div>
        </div>
      </form> <!-- /.row -->
    </div>
  </section>

</div><!-- /.content-wrapper -->
@endsection
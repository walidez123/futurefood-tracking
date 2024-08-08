@extends('layouts.master')
@section('pageTitle', 'Add service')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'Service', 'type' => 'Add', 'iconClass' => 'fa fa-first-order', 'url' =>
  route('services.index'), 'multiLang' => 'false'])


  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('services.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 class="box-title"> Add Service</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <div class="form-group">
                  <div class="form-group" style="margin-top: 15px;">
                      <label>Image</label>
                      <input type="file" name="image" accept=".png, .jpg, .jpeg"  required>
                      @error('image')
                      <span class="invalid-feedback text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                      @enderror

                  </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">title En</label>
                <label for="exampleInputEmail1" class="ar">title Ar</label>
                <input type="text" name="title_en" class="form-control en" id="exampleInputEmail1" placeholder="title ">
                <input type="text" name="title_ar" class="form-control ar" id="exampleInputEmail1"
                  placeholder="العنوان ">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">details En</label>
                <label for="exampleInputEmail1" class="ar">details Ar</label>
                <textarea class="form-control en" name="details_en" id="exampleInputEmail1"></textarea>
                <textarea class="form-control ar" name="details_ar" id="exampleInputEmail1"></textarea>
              </div>
              <div class=" footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form> <!-- /.row -->
    </div>
  </section>

</div><!-- /.content-wrapper -->
@endsection

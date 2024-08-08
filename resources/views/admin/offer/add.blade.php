@extends('layouts.master')
@section('pageTitle', 'Add Package')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'Package', 'type' => 'Add', 'iconClass' => 'fa-map-marker', 'url' =>
  route('Packages.index'), 'multiLang' => 'flase'])


  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('Packages.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">


        <div class="col-md-12 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 class="box-title"> Add Package</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
            
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">title En</label>
                <label for="exampleInputEmail1" class="ar">title Ar</label>
                <input type="text" name="title_en" class="form-control en" id="exampleInputEmail1" placeholder="title ">
                <input type="text" name="title_ar" class="form-control ar" id="exampleInputEmail1"
                  placeholder="العنوان ">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en"> Number of Days </label>
                <input type="number" name="num_days" class="form-control ar" id="exampleInputEmail1">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">Price</label>
                <input type="text" name="price" class="form-control en" id="exampleInputEmail1" placeholder="title ">
                 
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en"> Area</label>
                <input type="text" name="area" class="form-control en" id="exampleInputEmail1" placeholder="title ">
          
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">publish </label>
                <select class="form-control" name="publish" required>
                  <option value="1">published</option>
                  <option value="0">unpublished</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">details En</label>
                <label for="exampleInputEmail1" class="ar">details Ar</label>
                <textarea class="form-control en textarea wysiwyg" name="description_en" id="exampleInputEmail1"></textarea>
                <textarea class="form-control ar textarea wysiwyg" name="description_ar" id="exampleInputEmail1"></textarea>
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
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>



@endsection
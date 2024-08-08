@extends('layouts.master')
@section('pageTitle', 'Edit Package')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include('layouts._header-form', ['title' => 'Package', 'type' => 'Edit', 'iconClass' => 'fa fa-first-order', 'url' =>
  route('Packages.index'), 'multiLang' => 'false'])

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <form role="form" action="{{route('Packages.update', $offer->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12 col-xs-12">
          <!-- general form elements -->
          <div class="box box-primary" style="padding: 10px;">
            <div class="box-header with-border">
              <h3 class="box-title"> Edit Package</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
               
           
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">title En</label>
                <label for="exampleInputEmail1" class="ar">title Ar</label>
                <input type="text" name="title_en" value="{{$offer->title_en}}" class="form-control en"
                  id="exampleInputEmail1" placeholder="title ">
                <input type="text" name="title_ar" value="{{$offer->title_ar}}" class="form-control ar"
                  id="exampleInputEmail1" placeholder="العنوان ">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en"> Number of Days </label>
                <input type="number" value="{{$offer->num_days}}" name="num_days" class="form-control ar" id="exampleInputEmail1">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">Price</label>
                <input type="text" value="{{$offer->price}}" name="price" class="form-control en" id="exampleInputEmail1" placeholder="title ">
                 
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en"> Area</label>
                <input type="text" value="{{$offer->area}}" name="area" class="form-control en" id="exampleInputEmail1" placeholder="title ">
          
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">publish </label>
                <select class="form-control" name="publish" required>
                  <option {{($offer->publish == '1')? 'selected' : ''}} value="1">published</option>
                  <option {{($offer->publish == '0')? 'selected' : ''}} value="0">unpublished</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1" class="en">details En</label>
                <label for="exampleInputEmail1" class="ar">details Ar</label>
                <textarea class="form-control en textarea wysiwyg" name="description_en"
                  id="exampleInputEmail1">{{$offer->description_en}}</textarea>
                <textarea class="form-control ar textarea wysiwyg" name="description_ar"
                  id="exampleInputEmail1">{{$offer->description_ar}}</textarea>
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
<!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
@endsection
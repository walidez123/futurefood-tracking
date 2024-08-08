@extends('layouts.master')
@section('pageTitle', 'Edit testimoinal')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'testimoinals', 'type' => 'Edit', 'iconClass' => 'fa-window-restore', 'url' =>
    route('testimoinals.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
            <div class="row">
              
              <form role="form" action="{{route('testimoinals.update', $slider->id)}}" method="POST" enctype="multipart/form-data">
              @csrf
            @method('PUT')
              <div class="col-md-12 col-xs-12">
                <!-- general form elements -->
                <div class="box box-primary" style="padding: 10px;">
                  <div class="box-header with-border">
                    <h3 class="box-title"> Edit testimoinal</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-group">
                        <div class=" image">
                                <img src="{{asset('storage/'.$slider->image)}}" class="img-responsive" alt="User Image" width="130">
                             </div>
                           <div class="form-group" style="margin-top: 15px;"> 
                                  <label for="exampleInputFile">Image</label>
                                  <input type="file" name="image" id="exampleInputFile">
                                  @error('image')
                                      <span class="invalid-feedback text-danger" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                 
                           </div>            
                          </div>
                    <div class="box-body">
                          <div class="form-group">
                                  <label for="exampleInputEmail1" class="en">title</label>                            
                                  <input type="text" name="title" class="form-control en" value="{{$slider->title}}" id="exampleInputEmail1" placeholder="title " >
                          </div>
                          <div class="form-group">
                                  <label for="exampleInputEmail1" class="en">title Arabic</label>                            
                                  <input type="text" name="title_ar" class="form-control en" value="{{$slider->title_ar}}" id="exampleInputEmail1" placeholder="title " >
                          </div>
                  
                          <div class="form-group">
                  <label for="exampleInputEmail1">description</label>
                  <textarea type="url" class="form-control" name="description" id="exampleInputEmail1" placeholder="description">{{$slider->description}}</textarea>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">description Arabic</label>
                  <textarea type="url" class="form-control" name="description_ar" id="exampleInputEmail1" placeholder="description">{{$slider->description_ar}}</textarea>
                </div>
                      
                      
                    
                        <div class=" footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div> 
                       </form> <!-- /.row -->
                    </div>
                </div><!-- /.box -->
              </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
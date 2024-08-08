@extends('layouts.master')
 
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">  
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    <!-- Main content -->
    <section class="content">
<div class="col-md-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="nav-tabs-custom">
                    <form  enctype="multipart/form-data"  action="{{route('notificationFCM.store')}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;">
                        @csrf

                    <div class="tab-content" style="padding-top: 10px;">
                        <div class="tab-pane active" id="bank">

                                 <div class="col-xs-12 form-group">
                                    <label for="" class="control-label"> المناديب</label>

                                    <div class="">
                                        <select multiple name="delegate[]" class="form-control select2" id="">
                                        <option  value="">أختر مندوب</option>
                                        <option  value="all"> كل المناديب</option>


                                            @foreach($delegates as $delegate)
                                            <option  value="{{$delegate->id}}">{{$delegate->name}}</option>
                                            @endforeach
                                        </select>
                                       
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname" class="control-label"> العنوان </label>

                                    <div class="">
                                        <input type="text" name="title" class="form-control" id="fullname"
                                            placeholder=" عنوان الأشعار" required>
                                        @error('title')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname" class="control-label"> الرسالة </label>

                                    <div class="">
                                        <textarea type="text" name="message" class="form-control" id="fullname"
                                            placeholder="  الرسالة" ></textarea>
                                        @error('title')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
             
                    <!-- /.tab-content -->
                          <div class=" footer col-lg-12">
                                <button type="submit" class="btn btn-primary">إرسال</button>
                            </div>
                     </form>
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
 
 
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>

@endsection
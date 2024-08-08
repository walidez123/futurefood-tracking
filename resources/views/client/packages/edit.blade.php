@extends('layouts.master')
@section('pageTitle', 'Edit Client')
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
    @include('layouts._header-form', ['title' =>  __('app.address'), 'type' => __('app.edit'), 'iconClass' => 'fa-map-marker', 'url' =>
    route('clinet_packages.index',['id'=>$User_package->user_id]), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
            <div class="row">

                <form action="{{route('clinet_packages.update',$User_package->id)}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" >
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">

                            <!-- form start -->
                            

                            <div class="box-body">
                                    <div class="form-group">
                                    <label for="firstname" class="control-label">الباكدج *</label>

                                    <div class="">
                                        <input disabled type="text" name="" value="{{ $User_package->package->trans('title') }}" class="form-control" id="fullname"
                                            placeholder="" required>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="control-label">فعال *</label>
                                    <div class="">
                                        <select id="" class="form-control select2" name="active" required>
                                            <option {{($User_package->active == 1) ? 'selected' : ''}} value="1">فعال</option>
                                            <option {{($User_package->active == 0) ? 'selected' : ''}} value="0">غير فعال</option>


                                        </select>
                                        @error('active')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                 
                                <div class="form-group">
                                    <label for="phone" class="control-label">عدد الأيام</label>

                                    <div class="">
                                        <input type="text" name="num_days" value="{{$User_package->num_days }}" class="form-control" id="phone" placeholder="phone">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="firstname" class="control-label">السعر</label>

                                    <div class="">
                                        <input type="text" name="price" value="{{ $User_package->price }}" class="form-control locatinId" id="longitude"
                                             required>
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                                                <div class="form-group">
                                                                <label for="firstname" class="control-label"> المساحة</label>

                                    <div class="">
                                        <input type="text" name="area" value="{{ $User_package->area }}" class="form-control locatinId" id="latitude"
                                            required>
                                        @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-6 form-group">
                    <label for="website" class="control-label">تاريخ بداية الباقة</label>

                    <div class="">
                        <input type="date" value="{{$User_package->start_date}}" name="start_date" class="form-control" id="area">
                    </div>
                </div>


                            </div>
                        </div><!-- /.box -->
                    </div>

            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            </div>
            </form> <!-- /.row -->
                     
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

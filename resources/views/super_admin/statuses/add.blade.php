@extends('layouts.master')
@section('pageTitle', __('admin_message.status'))
@section('css')
<link rel="stylesheet"
    href="{{asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('admin_message.status'), 'type' =>__('admin_message.Add'), 'iconClass' => 'fa-bookmark', 'url' =>
    route('defult_status.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('defult_status.store')}}" method="POST">
                @csrf


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__('admin_message.Add New Status')}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group col-md-6">
                                <label for="name">{{__('admin_message.Title')}} {{__('admin_message.English')}}</label>
                                <input required type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Title')}} {{__('admin_message.English')}}">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="name">{{__('admin_message.Title')}} {{__('admin_message.Arabic')}}</label>
                                <input required type="text" class="form-control" name="title_ar" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Title')}} {{__('admin_message.Arabic')}}">
                                @error('title_ar')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="otp_send_code">{{__('admin_message.Send OTP to customer')}}</label>
                                <select required name="otp_send_code" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="send_image">{{__('admin_message.Send Image to customer')}}</label>
                                <select required name="send_image" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="delegate_appear">{{__('admin_message.appear')}} {{__('admin_message.Delegate')}}</label>
                                <select name="delegate_appear" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="delegate_appear">{{__('admin_message.appear')}} {{__('admin_message.Client')}}</label>
                                <select name="client_appear" class="form-control">
                                    <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>
                            



                            <div class="form-group col-md-6">
                                <label for="restaurant_appear">{{__('admin_message.appear')}} {{__('admin_message.restaurant')}}</label>
                                <select name="restaurant_appear" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>
                           

                            <div class="form-group col-md-6">
                                <label for="shop_appear">{{__('admin_message.appear')}} {{__('admin_message.shop')}}</label>
                                <select name="shop_appear" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>
                        

                            <div class="form-group col-md-6">
                                <label for="storehouse_appear">{{__('admin_message.appear')}} {{__('admin_message.storehouse')}}</label>
                                <select name="storehouse_appear" class="form-control">
                                <option value="1">{{__('admin_message.Yes')}}</option>
                                    <option value="0">{{__('admin_message.No')}}</option>
                                </select>
                            </div>

                        

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">{{__('admin_message.Notes')}}</label>
                                <textarea name="description" class="form-control" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Notes')}}"></textarea>
                            </div>





                            <div class=" footer">
                                <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
</script>
<script>
$(function() {
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()


})
</script>
@endsection
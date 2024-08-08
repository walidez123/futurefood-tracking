@extends('layouts.master')
@section('pageTitle', __('admin_message.status'))
@section('css')
    <link rel="stylesheet"
        href="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => __('admin_message.status'),
            'type' => __('admin_message.Add'),
            'iconClass' => 'fa-bookmark',
            'url' => route('statuses.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form action="{{ route('statuses.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ Auth()->user()->company_id }}">


                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> {{ __('admin_message.Add New Status') }}</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <div class="box-body">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('admin_message.Title') }}
                                        {{ __('admin_message.English') }}</label>
                                    <input required type="text" class="form-control" name="title"
                                        id="exampleInputEmail1"
                                        placeholder="{{ __('admin_message.Title') }} {{ __('admin_message.English') }}">
                                    @error('title')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('admin_message.Title') }}
                                        {{ __('admin_message.Arabic') }}</label>
                                    <input required type="text" class="form-control" name="title_ar"
                                        id="exampleInputEmail1"
                                        placeholder="{{ __('admin_message.Title') }} {{ __('admin_message.Arabic') }}">
                                    @error('title_ar')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="otp_send_code">{{ __('admin_message.Send OTP to customer') }}</label>
                                    <select id="otp_send_code" required name="otp_send_code" class="form-control">
                                        <option value="0">{{ __('admin_message.No') }}</option>

                                        <option value="1">{{ __('admin_message.Yes') }}</option>
                                    </select>
                                </div>
                                <!--  -->
                                <div style="display: none;" class="form-group col-md-6 otp_status_send">
                                    <label for="otp_send_code"> @lang('admin_message.send in status')</label>
                                    <select name="otp_status_send" class="form-control">
                                        <option value="">{{ __('admin_message.select') }}</option>
                                        <option value="all">{{ __('admin_message.all') }}</option>
                                        <option value="cc">{{ __('admin_message.Paid') }}</option>
                                        <option value="cod">{{ __('admin_message.UnPaid') }}</option>
                                    </select>
                                </div>
                                <!--  -->
                                <div class="form-group col-md-6">
                                    <label for="send_image">{{ __('admin_message.Send Image to customer') }}</label>
                                    <select required name="send_image" class="form-control">
                                        <option value="1">{{ __('admin_message.Yes') }}</option>
                                        <option value="0">{{ __('admin_message.No') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="delegate_appear">{{ __('admin_message.appear') }}
                                        {{ __('admin_message.Delegate') }}</label>
                                    <select name="delegate_appear" class="form-control">
                                        <option value="1">{{ __('admin_message.Yes') }}</option>
                                        <option value="0">{{ __('admin_message.No') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="delegate_appear">{{ __('admin_message.appear') }}
                                        {{ __('admin_message.Client') }}</label>
                                    <select name="client_appear" class="form-control">
                                        <option value="1">{{ __('admin_message.Yes') }}</option>
                                        <option value="0">{{ __('admin_message.No') }}</option>
                                    </select>
                                </div>



                                @if (in_array(2, $user_type))
                                    <div class="form-group col-md-6">
                                        <label for="restaurant_appear">{{ __('admin_message.appear') }}
                                            {{ __('admin_message.restaurant') }}</label>
                                        <select name="restaurant_appear" class="form-control">
                                            <option value="1">{{ __('admin_message.Yes') }}</option>
                                            <option value="0">{{ __('admin_message.No') }}</option>
                                        </select>
                                    </div>
                                @endif
                                @if (in_array(1, $user_type))
                                    <div class="form-group col-md-6">
                                        <label for="shop_appear">{{ __('admin_message.appear') }}
                                            {{ __('admin_message.shop') }}</label>
                                        <select name="shop_appear" class="form-control">
                                            <option value="1">{{ __('admin_message.Yes') }}</option>
                                            <option value="0">{{ __('admin_message.No') }}</option>
                                        </select>
                                    </div>
                                @endif
                                @if (in_array(3, $user_type))
                                    <div class="form-group col-md-6">
                                        <label for="storehouse_appear">{{ __('admin_message.appear') }}
                                            {{ __('admin_message.storehouse') }}</label>
                                        <select name="storehouse_appear" class="form-control">
                                            <option value="1">{{ __('admin_message.Yes') }}</option>
                                            <option value="0">{{ __('admin_message.No') }}</option>
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label for="storehouse_appear">{{ __('admin_message.priority') }}</label>
                                    <input type="number" value="{{ $sort }}" class="form-control" name="sort"
                                        id="exampleInputEmail1">
                                    @error('sort')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">{{ __('admin_message.Notes') }}</label>
                                    <textarea name="description" class="form-control" id="exampleInputEmail1"
                                        placeholder="{{ __('admin_message.Notes') }}"></textarea>
                                </div>





                                <div class=" footer">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('admin_message.save') }}</button>
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
    <script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script>
         $(document).ready(function() {
        $('#otp_send_code').on('change', function() {

            var demovalue = $(this).val();
            if (demovalue == 1) {
                $(".otp_status_send").show();


            } else if (demovalue == 0) {
                $(".otp_status_send").hide();

                $("#show" + 1).hide();

            }

        });
    });
    </script>
@endsection

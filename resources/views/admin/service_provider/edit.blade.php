@extends('layouts.master')
@section('pageTitle', __('admin_message.Service provider'))
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => __('admin_message.Service provider'),
            'type' => 'Add',
            'iconClass' => 'fa-users',
            'url' => route('service_provider.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form action="{{ route('service_provider.update', $user->id) }}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-7 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ __('admin_message.Edit') }}
                                    {{ __('admin_message.Service provider') }}
                                </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="work">{{ __('admin_message.work type') }}<span>*</span></label>
                                    <select multiple name="works[]" class="form-control select2 service_provider_cost_type"
                                        required>
                                        <option value="">{{ __('admin_message.select_work_type') }}</option>
                                        <option {{ in_array(1, $works) ? 'selected' : '' }} value="1">
                                            {{ __('admin_message.Clients') }}</option>
                                        <option {{ in_array(2, $works) ? 'selected' : '' }} value="2">
                                            {{ __('admin_message.restaurants') }}</option>
                                        <option {{ in_array(4, $works) ? 'selected' : '' }} value="4">
                                            {{ __('fulfillment.fulfillment') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="firstname" class="control-label"> {{ __('admin_message.Full Name') }}
                                        *</label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="full name" value="{{ $user->name }}" required>
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label">{{ __('admin_message.Email') }} *</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="Email" value="{{ $user->email }}" required>
                                        @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">{{ __('admin_message.Phone') }}</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            value="{{ $user->phone }}"
                                            placeholder="{{ __('admin_message.phoneMessage') }}">
                                        @error('phone')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname"
                                        class="control-label">{{ __('admin_message.Show External Reports') }}</label>
                                    <div class="">
                                        <select id="" class="form-control " name="show_report" required>
                                            <option {{ $user->show_report == 1 ? 'selected' : '' }} value="1">
                                                {{ __('admin_message.Yes') }} </option>
                                            <option {{ $user->show_report == 0 ? 'selected' : '' }} value="0">
                                                {{ __('admin_message.No') }} </option>
                                        </select>
                                        @error('show_report')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Accounting -->
                                <div style="display: none;" class="form-group Accounting_service_provider_1">
                                    <label for="accounting_last_mile"
                                        class="control-label">{{ __('admin_message.accounting_last_mile') }}</label>

                                    <div class="">
                                        <input type="number" step="any"
                                            value="{{ !is_null($user->ServiceProviderCost) ? $user->ServiceProviderCost->cost_last_mile : 0 }}"
                                            name="cost_last_mile" class="form-control" id="" placeholder="">
                                        @error('cost_last_mile')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!--  -->
                                <div style="display: none;" class="form-group Accounting_service_provider_2">
                                    <label for="accounting_restaurant"
                                        class="control-label">{{ __('admin_message.accounting_restaurant') }}</label>

                                    <div class="">
                                        <input type="number" step="any"
                                            value="{{ !is_null($user->ServiceProviderCost) ? $user->ServiceProviderCost->cost_restaurant : 0 }}"
                                            name="cost_restaurant" class="form-control" id="" placeholder="">
                                        @error('cost_restaurant')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!--  -->
                                <div style="display: none;" class="form-group Accounting_service_provider_4">
                                    <label for="accounting_fulfillment"
                                        class="control-label">{{ __('admin_message.accounting_fulfillment') }}</label>

                                    <div class="">
                                        <input type="number"
                                            value="{{ !is_null($user->ServiceProviderCost) ? $user->ServiceProviderCost->cost_fulfillment : 0 }}"
                                            step="any" name="cost_fulfillment" class="form-control" id=""
                                            placeholder="">
                                        @error('cost_fulfillment')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <h4><i class="fa fa-key"></i> {{ __('admin_message.password') }} </h4>
                                <div class="form-group">
                                    <label for="password" class="control-label">{{ __('admin_message.password') }}
                                        *</label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="{{ __('admin_message.passwordMassage') }}">
                                        @error('password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm"
                                        class="control-label">{{ __('admin_message.confirm password') }} *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="Confirm password" name="password_confirmation">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-5 text-center">
                        <div class="box box-primary">
                            <div class="box-body">
                                <div class="form-group">
                                    <div class=" image">
                                        @if ($user->avatar == 'avatar/avatar.png' || $user->avatar == null)
                                            <img class="img-circle" src="{{ asset('storage/' . $webSetting->logo) }}"
                                                width="130">
                                        @else
                                            <img src="{{ asset('storage/' . $user->avatar) }}" class="img-circle"
                                                alt="User Image" width="130">
                                        @endif

                                    </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">{{ __('admin_message.personal photo') }}</label>
                                        <input name="avatar" type="file" id="exampleInputFile">
                                        @error('avatar')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>



                        </div><!-- /.box -->
                    </div>
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">{{ __('admin_message.save') }}</button>
            </div>
            </form> <!-- /.row -->
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

@endsection

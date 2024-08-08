@extends('layouts.master')
@section('pageTitle', trans('admin_message.User'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => trans('admin_message.User'),
            'type' => trans('admin_message.add'),
            'iconClass' => 'fa-users',
            'url' => route('users.index'),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form action="{{ route('users.store') }}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-7 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> @lang('admin_message.add')</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="firstname" class="control-label">{{ __('admin_message.Full Name') }}
                                        *</label>

                                    <div class="">
                                        <input value="{{ old('name') }}" type="text" name="name"
                                            class="form-control" id="fullname"
                                            placeholder="{{ __('admin_message.Full Name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label">@lang('user.Email') *</label>

                                    <div class="">
                                        <input value="{{ old('email') }}" type="email" name="email"
                                            class="form-control" id="inputEmail" placeholder="@lang('user.Email')" required>
                                        @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">@lang('user.Phone')</label>

                                    <div class="">
                                        <input value="{{ old('phone') }}" type="text" name="phone"
                                            class="form-control" id="phone" placeholder="@lang('user.Phone')">
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="control-label">@lang('user.Role') *</label>
                                    <div class="">
                                        <select class="form-control" name="role_id" required>
                                            <option value="">@lang('user.Select Role')</option>
                                            @foreach ($roles as $role)
                                                <option {{ old('role_id') == $role->id ? 'selected' : '' }}
                                                    value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endforeach

                                        </select>
                                        @error('role_id')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- <h4><i class="fa fa-key"></i> Password Area</h4> -->
                                <div class="form-group">
                                    <label for="password" class="control-label">{{ __('admin_message.password') }}
                                        *</label>

                                    <div class="">
                                        <input value="{{ old('password') }}" type="password" name="password"
                                            class="form-control" id="password"
                                            placeholder="{{ __('admin_message.passwordMassage') }}" required>
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
                                            placeholder="{{ __('admin_message.confirm password') }}"
                                            name="password_confirmation" required>
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
                                        <img src="{{ asset('storage/avatar/avatar.png') }}" class="img-circle"
                                            alt="User Image" width="130">
                                    </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">@lang('user.Avatar')</label>
                                        <input name="avatar" type="file" id="exampleInputFile">

                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box -->
                    </div>
            </div>
            <div class=" footer">
                <input type="hidden" name="user_type" value="admin">
                <button type="submit" class="btn btn-primary">@lang('user.add')</button>
            </div>
            </form> <!-- /.row -->
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

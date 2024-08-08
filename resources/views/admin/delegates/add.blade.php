@extends('layouts.master')
@section('pageTitle', __('admin_message.Add Delegete'))
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

        <!-- Main content -->
        <section class="content">
            <div class="row">

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


                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#Main" data-toggle="tab" aria-expanded="true"><i
                                    class="fa fa-shop"></i>{{ __('admin_message.Main information') }}</a></li>
                        <li class=""><a href="#Registration" data-toggle="tab" aria-expanded="false"><i
                                    class="fa fa-shop"></i>{{ __('admin_message.Registration data') }}</a></li>
                        <li class=""><a href="#JobData" data-toggle="tab" aria-expanded="false"><i
                                    class="fa fa-shop"></i>
                                {{ __('admin_message.Job data') }}</a></li>
                        <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false"><i
                                    class="fa fa-bookmark"></i>{{ __('admin_message.Official documents') }}</a></li>
                        .
                        </li>
                    </ul>
                    <form action="{{ route('delegates.store') }}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;" enctype="multipart/form-data">
                        @csrf
                        <!-- general form elements -->

                        <div class="tab-content" style="padding-top: 10px;">
                            <div class="tab-pane active" id="Main">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname" class="control-label">{{ __('admin_message.Work Type') }}
                                                *</label>
                                            <div class="">
                                                <select multiple id="Delegate_work_type" class="form-control select2"
                                                    name="works[]" required>
                                                    <option value="">{{ __('admin_message.Select') }}
                                                        {{ __('admin_message.Work Type') }}</option>
                                                    @if (in_array(1, $user_type))
                                                    @if(isset($type) && $type==1)
                                                        <option selected value="1">{{ __('admin_message.Clients') }}</option>
                                                    @else
                                                    <option value="1">{{ __('admin_message.Clients') }}</option>

                                                    @endif
                                                    @endif
                                                    @if (in_array(2, $user_type))
                                                    @if(isset($type) && $type==2)

                                                        <option selected value="2">{{ __('admin_message.restaurants') }}
                                                        </option>
                                                    @else

                                                    <option  value="2">{{ __('admin_message.restaurants') }}
                                                        </option>

                                                    @endif
                                                    @endif
                                                    @if (in_array(4, $user_type))
                                                    @if(isset($type) && $type==4)

                                                        <option selected value="4">{{ __('fulfillment.fulfillment') }}</option>
                                                    @else
                                                    <option value="4">{{ __('fulfillment.fulfillment') }}</option>


                                                    @endif
                                                    @endif


                                                </select>
                                                @error('works')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname"
                                            class="control-label">{{ __('admin_message.Functional code') }}*</label>

                                        <div class="">
                                            <input type="text" value="{{ $code }}" name="code"
                                                class="form-control" id="fullname"
                                                placeholder="{{ __('admin_message.Functional code') }}" required>
                                            @error('code')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone"
                                            class="control-label">{{ __('admin_message.Residency_number') }}</label>

                                        <div class="">
                                            <input value="{{ old('Residency_number') }}" type="number"
                                                name="Residency_number" class="form-control" id="Residency_number"
                                                placeholder="{{ __('admin_message.Residency_number') }}" required>
                                            @error('Residency_number')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="firstname"
                                            class="control-label">{{ __('admin_message.Full Name') }}*</label>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname" class="control-label">{{ __('admin_message.City') }}
                                            *</label>
                                        <div class="">
                                            <select id="city_id" class="form-control select2" name="city_id" required>
                                                <option value="">{{ __('admin_message.Select city') }}</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->trans('title') }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname"
                                            class="control-label">{{ __('admin_message.neighborhood') }}</label>
                                        <div class="">
                                            <select id="neighborhood_id" class="form-control select2" name="region_id">
                                            </select>
                                            @error('neighborhood')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Registration">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="phone"
                                            class="control-label">{{ __('admin_message.Phone') }}*</label>

                                        <div class="">
                                            <input value="{{ old('phone') }}" required type="text" name="phone"
                                                required class="form-control" id="phone"
                                                placeholder="{{ __('admin_message.phoneMessage') }}">
                                            @error('phone')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="email" class="control-label"> {{ __('admin_message.Email') }}
                                        </label>

                                        <div class="">
                                            <input value="{{ old('email') }}" type="email" name="email"
                                                class="form-control" id="inputEmail"
                                                placeholder="{{ __('admin_message.Email') }}">
                                            @error('email')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="password"
                                            class="control-label">{{ __('admin_message.password') }}*</label>

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
                                </div>
                                <div class="col-md-6">
                                    <h4 style="visibility: hidden;"> </h4>
                                    <h4> </h4>


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
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="JobData">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="control-label"> {{ __('admin_message.Supervisor') }}
                                        </label>

                                        <div class="">
                                            <select multiple name="manger_name[]" id="manger_name"
                                                class="form-control select2">
                                                <option value="">{{ __('admin_message.Select') }}
                                                    {{ __('admin_message.Supervisor') }}</option>
                                                @foreach ($supervisors as $supervisor)
                                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('manger_name')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password"
                                            class="control-label">{{ __('admin_message.Service provider') }}
                                        </label>

                                        <div class="">
                                            <select name="service_provider" id="service_provider"
                                                class="form-control select2">
                                                <option value="">{{ __('admin_message.Select') }}
                                                    {{ __('admin_message.Service provider') }} </option>
                                                @foreach ($service_providers as $service_provider)
                                                    <option value="{{ $service_provider->id }}">
                                                        {{ $service_provider->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('service_provider')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname"
                                            class="control-label">{{ __('admin_message.Clients') }}</label>
                                        <div class="">
                                            <select multiple id="delegate_clients" class="form-control select2"
                                                name="client[]">
                                                <option value="">{{ __('admin_message.Select') }}
                                                    {{ __('admin_message.Client') }} </option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->store_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('client')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname"
                                            class="control-label">{{ __('admin_message.Show External Reports') }}</label>
                                        <div class="">
                                            <select id="" class="form-control " name="show_report">
                                                <option value="1"> {{ __('admin_message.Yes') }} </option>
                                                <option value="0"> {{ __('admin_message.No') }} </option>
                                            </select>
                                            @error('show_report')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"
                                            class="control-label">{{ __('admin_message.work type') }}</label>

                                        <div class="">
                                            <select id="work_type" name="work_type" class="form-control select2"
                                                required>
                                                <option value="1">{{ __('admin_message.Full time') }}</option>
                                                <option value="2">{{ __('admin_message.Part time') }}</option>
                                                <option value="3"> {{ __('admin_message.By Order') }}</option>

                                            </select>
                                            @error('work_type')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label for="email" class="control-label"> </label>

                                        <input
                                            placeholder="{{ __('admin_message.Enter the amount required for one order') }}"
                                            class="" name="payment" type="text" id="payment"
                                            hidden="hidden" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="control-label">
                                            {{ __('admin_message.Date of hiring') }}
                                        </label>

                                        <div class="">
                                            <input value="{{ old('date') }}" type="date" name="date"
                                                class="form-control" id="date">
                                            @error('date')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_name" class="control-label">{{ __('admin_message.bank name') }}
                                        </label>

                                        <div class="">
                                            <input value="{{ old('bank_name') }}" type="text" name="bank_name"
                                                class="form-control" id="bank_name">
                                            @error('bank_name')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bank_account_number"
                                            class="control-label">{{ __('admin_message.bank account number') }}
                                        </label>

                                        <div class="">
                                            <input value="{{ old('bank_account_number') }}" type="text"
                                                name="bank_account_number" class="form-control" id="bank_account_number">
                                            @error('bank_account_number')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lastname"
                                            class="control-label">{{ __('admin_message.vehicle') }}</label>
                                        <div class="">
                                            <select id="vehicle_id" name="vehicle_id" class="form-control select2">
                                                <option value="0">{{ __('admin_message.Select') }}
                                                    {{ __('admin_message.vehicle') }}</option>

                                                @foreach ($Vehicles as $Vehicle)
                                                    <option value="{{ $Vehicle->id }}">
                                                        {{ $Vehicle->type_en }}-{{ $Vehicle->vehicle_number_en }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('vehicle_id')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="documents">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class=" image">
                                            <img src="{{ asset('storage/' . $webSetting->logo) }}" class="img-circle"
                                                alt="User Image" width="130">
                                        </div>
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label for="exampleInputFile">{{ __('admin_message.personal photo') }}</label>
                                            <input name="avatar" type="file" id="">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class=" image">
                                            <img src="{{ asset('storage/' . $webSetting->logo) }}" class="img-circle"
                                                alt="User Image" width="130">
                                        </div>
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label for="exampleInputFile">{{ __('admin_message.license photo') }} </label>
                                            <input name="license_photo" type="file" id="">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class=" image">
                                            <img src="{{ asset('storage/' . $webSetting->logo) }}" class="img-circle"
                                                alt="User Image" width="130">
                                        </div>
                                        <div class="form-group" style="margin-top: 15px;">
                                            <label for="exampleInputFile"> {{ __('admin_message.residence photo') }}
                                            </label>
                                            <input name="residence_photo" type="file" id="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" footer">
                                <input type="hidden" name="user_type" value="delegate">
                                <button type="submit" class="btn btn-primary">{{ __('admin_message.save') }}</button>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                </div>
                </form>
                <!-- /.row -->
        </section>

        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection

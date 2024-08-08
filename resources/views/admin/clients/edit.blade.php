@extends('layouts.master')

@if ($client->work == 1)
    @section('pageTitle', __('admin_message.Clients') . '' . __('admin_message.Edit'))
@elseif($client->work == 2)
    @section('pageTitle', __('admin_message.restaurants') . '' . __('admin_message.Edit'))
@elseif($client->work == 3)
    @section('pageTitle', __('admin_message.Warehouses') . '' . __('admin_message.Edit'))
@elseif($client->work == 4)
    @section('pageTitle', __('fulfillment.fulfillment') . '' . __('admin_message.Edit'))
@endif

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if ($client->work == 1)
            @include('layouts._header-form', [
                'title' => __('admin_message.Clients'),
                'type' => __('admin_message.Edit'),
                'iconClass' => 'fa-shop',
                'url' => route('clients.index'),
                'multiLang' => 'false',
            ])
        @elseif($client->work == 2)
            @include('layouts._header-form', [
                'title' => __('admin_message.restaurants'),
                'type' => __('admin_message.Edit'),
                'iconClass' => 'fa-utensils',
                'url' => route('clients.index'),
                'multiLang' => 'false',
            ])
        @elseif($client->work == 3)
            @include('layouts._header-form', [
                'title' => __('admin_message.Warehouses'),
                'type' => __('admin_message.Edit'),
                'iconClass' => 'fa-warehouse',
                'url' => route('clients.index'),
                'multiLang' => 'false',
            ])
        @elseif($client->work == 4)
            @include('layouts._header-form', [
                'title' => __('fulfillment.fulfillment_client'),
                'type' => __('admin_message.Edit'),
                'iconClass' => 'fa-warehouse',
                'url' => route('clients.index'),
                'multiLang' => 'false',
            ])
        @endif


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
                <div class="col-md-10 col-md-offset-1">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#member" data-toggle="tab"><i class="fa fa-shop"></i>
                                    {{ __('admin_message.Main information') }}

                                </a></li>
                            <li class=""><a href="#register" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-usd"></i>{{ __('admin_message.Registration data') }}</a></li>
                            <li><a href="#bank" data-toggle="tab"><i
                                        class="fa fa-money-bill"></i>{{ __('admin_message.Payments') }}</a></li>
                            <li><a href="#setting" data-toggle="tab"><i class="fa fa-usd"></i>
                                    {{ __('admin_message.Financial accounts') }}</a></li>
                            <li><a href="#statuses" data-toggle="tab"><i
                                        class="fa fa-bookmark"></i>{{ __('admin_message.Settings') }}
                                    {{ __('admin_message.statuses') }}</a>
                            </li>
                            <li><a href="#files" data-toggle="tab"><i class="fa fa-file"></i>
                                    {{ __('admin_message.Official documents') }}</a>
                            </li>
                        </ul>

                        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="box  col-md-12"
                            style="border: 0px; padding:10px;" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="tab-content col-xs-12">

                                <div class="active tab-pane col-xs-12" id="member">

                                    <input type="hidden" value="{{ $client->work }}" name="work">
                                    <input type="hidden" min="0" value="15" name="tax" class="form-control"
                                        placeholder="Tax">
                                    <div class="col-xs-12 form-group">
                                        <label for="store name" class="control-label">
                                            @if ($client->work == 1)
                                                *{{ __('admin_message.Clients') }}
                                            @elseif($client->work == 2)
                                                * {{ __('admin_message.restaurants') }}
                                            @elseif($client->work == 3)
                                                * {{ __('admin_message.Warehouses') }}
                                            @elseif($client->work == 4)
                                                * {{ __('fulfillment.fulfillment_client_name') }}
                                            @endif

                                        </label>

                                        <div class="">
                                            <input type="text" name="store_name" class="form-control" id="store name"
                                                placeholder="" value="{{ $client->store_name }}" required>
                                            @error('store_name')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-12 form-group">
                                        <label for="firstname"
                                            class="control-label">{{ __('admin_message.manger name') }}*</label>

                                        <div class="">
                                            <input type="text" name="name" class="form-control" id="fullname"
                                                placeholder="{{ __('admin_message.manger name') }}"
                                                value="{{ $client->name }}" required>
                                            @error('name')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xs-12 form-group">
                                        <label for=""
                                            class="control-label">{{ __('admin_message.Tax Number') }}</label>

                                        <div class="">
                                            <input value="{{ $client->tax_Number }}" type="text" min="0"
                                                class="form-control" name="tax_Number"
                                                placeholder="{{ __('admin_message.Tax_number_message') }}">
                                            @error('tax_Number')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-xs-12 form-group">
                                        <label for="website"
                                            class="control-label">{{ __('admin_message.website url') }}</label>

                                        <div class="">
                                            <input type="text" name="website" class="form-control" id="website"
                                                value="{{ $client->website }}"
                                                placeholder="{{ __('admin_message.website url') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label for="lastname" class="control-label">{{ __('admin_message.City') }}
                                            *</label>
                                        <div class="">
                                            <select class="form-control select2" name="city_id" required>
                                                <option value="">{{ __('admin_message.Select') }}
                                                    {{ __('admin_message.City') }}
                                                </option>
                                                @foreach ($cities as $city)
                                                    <option {{ $client->city_id == $city->id ? 'selected' : '' }}
                                                        value="{{ $city->id }}">
                                                        {{ $city->trans('title') }}</option>
                                                @endforeach

                                            </select>
                                            @error('city_id')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-12 form-group">
                                        <label for="num_branches"
                                            class="control-label">{{ __('admin_message.Number of Branches') }}</label>

                                        <div class="">
                                            <input value="{{ $client->num_branches }}" id="num_branches" type="number"
                                                class="form-control" placeholder="" name="num_branches">
                                        </div>
                                    </div>

                                </div>
                                <!-- /.tab-pane -->
                                <!-- start tab -->
                                <div class=" tab-pane col-xs-12" id="register">



                                    <div class="col-xs-12 form-group">
                                        <label for="phone"
                                            class="control-label">{{ __('admin_message.Phone') }}</label>

                                        <div class="">
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                value="{{ $client->phone }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label for="email" class="control-label">{{ __('admin_message.Email') }}
                                            *</label>

                                        <div class="">
                                            <input type="email" name="email" class="form-control" id="inputEmail"
                                                placeholder="{{ __('admin_message.Email') }}"
                                                value="{{ $client->email }}" required>
                                            @error('email')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <h4><i class="fa fa-key"></i> {{ __('admin_message.password') }} </h4>
                                    <div class="col-xs-12 form-group">
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

                                    <div class="col-xs-12 form-group">
                                        <label for="password-confirm"
                                            class="control-label">{{ __('admin_message.confirm password') }} *</label>

                                        <div class="">
                                            <input id="password-confirm" type="password" class="form-control"
                                                placeholder="{{ __('admin_message.confirm password') }}"
                                                name="password_confirmation">
                                        </div>
                                    </div>

                                </div>



                                <!-- end tab -->

                                <div class=" tab-pane col-xs-12" id="bank">

                                    <div class="col-xs-12 form-group">
                                        <label for="firstname"
                                            class="control-label">{{ __('admin_message.Payment period') }}</label>

                                        <div class="">
                                            <select name="Payment_period
                                   "
                                                class="form-control select2" required>

                                                <option {{ $client->Payment_period == 1 ? 'selected' : '' }}
                                                    value="1">
                                                    {{ __('admin_message.daily') }}</option>
                                                <option {{ $client->Payment_period == 2 ? 'selected' : '' }}
                                                    value="2">
                                                    {{ __('admin_message.weekly') }}</option>
                                                <option {{ $client->Payment_period == 3 ? 'selected' : '' }}
                                                    value="3">
                                                    {{ __('admin_message.Monthly') }}</option>

                                            </select>

                                            @error('work')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-12 form-group">
                                        <label for=""
                                            class="control-label">{{ __('admin_message.bank name') }}</label>

                                        <div class="">
                                            <input type="text" name="bank_name" class="form-control" 
                                                value="{{ $client->bank_name }}"
                                                placeholder="{{ __('admin_message.bank name') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label for=""
                                            class="control-label">{{ __('admin_message.bank account number') }}</label>

                                        <div class="">
                                            <input type="text" name="bank_account_number" class="form-control"
                                                 value="{{ $client->bank_account_number }}"
                                                placeholder="{{ __('admin_message.bank account number') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label for=""
                                            class="control-label">{{ __('admin_message.Iban') }}</label>

                                        <div class="">
                                            <input type="text" name="bank_swift" class="form-control" 
                                                value="{{ $client->bank_swift }}"
                                                placeholder="{{ __('admin_message.Iban') }}">
                                        </div>
                                    </div>


                                </div>

                                <div class=" tab-pane col-xs-12" id="setting">
                                    @if ($client->work == 4)
                                        <div class="col-xs-12 col-lg-12 form-group">
                                            <label for=""
                                                class="control-label">{{ __('fulfillment.package_cost') }}</label>

                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.receive_palette') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->receive_palette }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="receive_palette"
                                                    placeholder="{{ __('fulfillment.receive_palette') }}">
                                                @error('receive_palette')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-lg-3 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.store_palette') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->store_palette }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="store_palette"
                                                    placeholder="{{ __('fulfillment.store_palette') }}">
                                                @error('store_palette')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-3 form-group">
                                            <label for="" class="control-label">{{__('admin_message.dailyMonthly')}}</label>
                                            <div class="">
                                                <select id="pallet_subscription_type" class="form-control select2" name="pallet_subscription_type">
                                                    <option {{($client->userCost->pallet_subscription_type == 'daily') ? 'selected' : ''}} value="daily">{{__('admin_message.daily')}}</option>
                                                    <option {{($client->userCost->pallet_subscription_type == 'monthly') ? 'selected' : ''}} value="monthly">{{__('admin_message.monthly')}}</option>
                                                </select>
                                                @error('receive_palette')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.sort_by_sku') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->sort_by_suku }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="sort_by_suku"
                                                    placeholder="{{ __('fulfillment.sort_by_sku') }}">
                                                @error('sort_by_suku')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.pick_process_package') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->pick_process_package }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="pick_process_package"
                                                    placeholder="{{ __('fulfillment.pick_process_package') }}">
                                                @error('pick_process_package')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.print_waybill') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->print_waybill }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="print_waybill"
                                                    placeholder="{{ __('fulfillment.print_waybill') }}">
                                                @error('print_waybill')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.sort_by_city') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->sort_by_city }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="sort_by_city"
                                                    placeholder="{{ __('fulfillment.sort_by_city') }}">
                                                @error('sort_by_city')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.store_return_shipment') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->store_return_shipment }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="store_return_shipment"
                                                    placeholder="{{ __('fulfillment.store_return_shipment') }}">
                                                @error('store_return_shipment')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">
                                                {{ __('fulfillment.reprocess_return_shipment') }}</label>

                                            <div class="">
                                                <input required value="{{ $client->userCost->reprocess_return_shipment }}"
                                                    type="number" step="any" min="0" class="form-control"
                                                    name="reprocess_return_shipment"
                                                    placeholder="{{ __('fulfillment.reprocess_return_shipment') }}">
                                                @error('reprocess_return_shipment')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if ($client->work == 1 || $client->work == 4)
                                        <!-- select -->
                                        <div class="col-xs-12 col-lg-12 form-group">
                                            @if ($client->work == 4)
                                                <label for=""
                                                    class="control-label">{{ __('admin_message.Cost calculation method ful') }}</label>
                                            @else<label for=""
                                                    class="control-label">{{ __('admin_message.Cost calculation method') }}</label>
                                            @endif

                                            <div class="">
                                                <select id="cost_type" class="form-control" name="cost_type" required>
                                                    <option value="0">{{ __('admin_message.Select') }}
                                                        {{ __('admin_message.Cost calculation method') }} </option>

                                                    <option {{ $client->cost_type == 1 ? 'selected' : '' }}
                                                        value="1">
                                                        {{ __('admin_message.Account inside and outside the city') }}
                                                    </option>
                                                    <option {{ $client->cost_type == 2 ? 'selected' : '' }}
                                                        value="2">
                                                        {{ __('admin_message.Account inside and outside the tier') }}
                                                    </option>


                                                </select>
                                                @error('cost_type')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- select -->
                                        <!-- zone -->
                                        @if ($client->cost_type == 2)
                                        @else
                                        @endif
                                        <div style="display:{{ $client->cost_type == 1 ? 'none' : 'block' }}"
                                            id="show2" class="city">
                                            @include('admin.clients.accounts.zone_edit')
                                        </div>
                                        <!-- end zone -->
                                        <!-- start city -->

                                        <div style="display:{{ $client->cost_type == 2 ? 'none' : 'block' }}"
                                            id="show1" class="city">
                                            @include('admin.clients.accounts.city_edit')
                                        </div>


                                        <!--endcity  -->
                                    @else
                                        @include('admin.clients.accounts.resturant_edit')


                                    @endif




                                    <!--  -->


                                </div>
                                <div class=" tab-pane col-xs-12" id="statuses">


                                    @include('admin.clients.accounts.status_edit')


                                </div>

                                <div class=" tab-pane col-xs-12" id="files">
                                    {{-- @if ($client->provider == null) --}}

                                    <div class="col-xs-6 form-group">
                                        @if ($client->avatar != null)
                                            <a href="{{ asset('storage/' . $client->avatar) }}"><img
                                                    style="height: 50px;width:50px"
                                                    src="{{ asset('storage/' . $client->avatar) }}" alt=""></a>
                                        @endif

                                        <label for="Tax_certificate" class="control-label">
                                            {{ __('admin_message.personal photo') }}</label>
                                        <div class="">
                                            <input type="file" name="avatar" >

                                            @error('avatar')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- @endif --}}
                                    <div class="col-xs-6 form-group">
                                        @if ($client->Tax_certificate != null)
                                            <a href="{{ asset('storage/' . $client->Tax_certificate) }}"><img
                                                    style="height: 50px;width:50px"
                                                    src="{{ asset('storage/' . $client->Tax_certificate) }}"
                                                    alt=""></a>
                                        @endif

                                        <label for="Tax_certificate"
                                            class="control-label">{{ __('admin_message.Tax_certificate') }} </label>
                                        <div class="">
                                            <input type="file" name="Tax_certificate" >

                                            @error('Tax_certificate')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-6 form-group">
                                        @if ($client->signed_contract != null)
                                            <a href="{{ asset('storage/' . $client->signed_contract) }}"><img
                                                    style="height: 50px;width:50px"
                                                    src="{{ asset('storage/' . $client->signed_contract) }}"
                                                    alt=""></a>
                                        @endif

                                        <label for="signed_contract"
                                            class="control-label">{{ __('admin_message.signed contract') }} </label>
                                        <div class="">
                                            <input type="file" name="signed_contract" >

                                            @error('signed_contract')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-6 form-group">
                                        @if ($client->commercial_register != null)
                                            <a href="{{ asset('storage/' . $client->commercial_register) }}"><img
                                                    style="height: 50px;width:50px"
                                                    src="{{ asset('storage/' . $client->commercial_register) }}"
                                                    alt=""></a>
                                        @endif
                                        <label for="commercial_register"
                                            class="control-label">{{ __('admin_message.commercial_register') }} </label>
                                        <div class="">
                                            <input type="file" name="commercial_register" >

                                            @error('commercial_register')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" footer">
                                <button type="submit" class="btn btn-primary">{{ __('admin_message.Edit') }}</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection

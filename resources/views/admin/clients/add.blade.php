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
            
            <div class="nav-tabs-custom">
                <form enctype="multipart/form-data" action="{{route('clients.store')}}" method="POST"
                    class="box  col-md-12" style="border: 0px; padding:10px;">
                    @csrf
                    <input type="hidden" min="0" value="15" name="tax" class="form-control" placeholder="Tax">
                    <input type="hidden" value="{{$work}}" name="work">
                    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i
                                class="fa fa-shop"></i>{{__("admin_message.Main information")}}</a></li>
                    <li class=""><a href="#setting" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-user"></i>{{__("admin_message.Registration data")}}</a></li>
                    <li class=""><a href="#statuses" data-toggle="tab" aria-expanded="false"><i class="fa fa-money-bill"></i>{{__("admin_message.Payments")}}</a></li>
                    <li class=""><a href="#address" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-usd"></i> {{__("admin_message.Financial accounts")}} </a></li>
                    <li class=""><a href="#status12" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-bookmark"></i>{{__("admin_message.Settings")}} {{__("admin_message.statuses")}} </a></li>
                    <li><a href="#provider" data-toggle="tab"><i class="fa fa-file"></i> {{__("admin_message.Official documents")}}</a>
                    </li>
                </ul>
                <div class="tab-content" style="padding-top: 10px;">
                    <div class="tab-pane active" id="bank">
                        <div class="col-xs-12 form-group">
                            <label for="store name" class="control-label">
                                
                                @if($work==2)
                                *  {{ __('admin_message.restaurants')}}
                                @else
                                *  اسم المتجر
                               
                                @endif
                            </label>
                            <div class="">
                                <input type="text" value="{{ old('store_name') }}" name="store_name"
                                    class="form-control" id="store name" placeholder="" required>
                                @error('store_name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label for="firstname" class="control-label"> * {{__('admin_message.manger name')}}</label>

                            <div class="">
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                                    id="fullname" placeholder="{{__('admin_message.manger name')}}" required>
                                @error('name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 form-group">
                            <label for="" class="control-label">{{__('admin_message.Tax Number')}}</label>

                            <div class="">
                                <input type="text" value="{{ old('tax_Number') }}"  class="form-control"
                                    name="tax_Number" placeholder="{{__('admin_message.Tax_number_message')}}">
                                @error('tax_Number')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label for="website" class="control-label">{{__('admin_message.website url')}}</label>
                            <div class="">
                                <input type="text" value="{{ old('website') }}" name="website" class="form-control"
                                    id="website" placeholder="{{__('admin_message.website url')}}">
                                    @error('website')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label for="lastname" class="control-label"> * {{__('admin_message.City')}}</label>
                            <div class="">
                                <select value="{{ old('city_id') }}" class="form-control select2" name="city_id"
                                    required>
                                    <option value="">{{__('admin_message.Select')}} {{__('admin_message.City')}}</option>
                                    @foreach ($cities as $city)
                                    <option  {{(old('city_id') == $city->id) ? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
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
                            <label for="num_branches" class="control-label">{{__('admin_message.Number of Branches')}} </label>

                            <div class="">
                                <input value="{{ old('num_branches') }}" id="num_branches" type="number"
                                    class="form-control" placeholder="" name="num_branches">
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="setting">
                        <div class="col-xs-12 form-group">
                            <label for="phone" class="control-label">{{__('admin_message.Phone')}} *</label>
                            <div class="">
                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control"
                                    id="phone" placeholder="" required>
                                    @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label for="email" class="control-label"> {{__('admin_message.Email')}}</label>
                            <div class="">
                                <input value="{{ old('email') }}" type="email" name="email" class="form-control"
                                    id="inputEmail" placeholder="{{__('admin_message.Email')}}" >
                                @error('email')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 form-group">
                            <label for="password" class="control-label">{{__('admin_message.password')}}*</label>

                            <div class="">
                                <input value="{{ old('password') }}" type="password" name="password"
                                    class="form-control" id="password" placeholder="{{__('admin_message.passwordMassage')}}" required>
                                @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 form-group">
                        <label class="control-label">{{__('admin_message.confirm password')}} *</label>

                            <div class="">
                                <input value="{{ old('password') }}" id="password-confirm" type="password"
                                    class="form-control" placeholder="{{__('admin_message.confirm password')}}" name="password_confirmation"
                                    required>
                                    @error('password_confirmation')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="statuses">

                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="firstname" class="control-label">{{__('admin_message.Payment period')}}</label>
                            <div class=" ">
                                <select name="Payment_period" class="form-control " required>
                                    <option value="1">{{__('admin_message.daily')}}</option>
                                    <option value="2">{{__('admin_message.weekly')}}</option>
                                    <option value="3">{{__('admin_message.Monthly')}}</option>

                                </select>

                                @error('Payment_period')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__('admin_message.bank name')}}</label>

                            <div class="">
                                <input value="{{ old('bank_name') }}" type="text" min="0" class="form-control"
                                    name="bank_name" placeholder="{{__('admin_message.bank name')}}">
                                @error('bank_name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__('admin_message.bank account number')}}</label>

                            <div class="">
                                <input type="text" value="{{ old('bank_account_number') }}"
                                    name="bank_account_number" class="form-control"  value=""
                                    placeholder="{{__('admin_message.bank account number')}} ">
                                @error('bank_account_number')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('admin_message.Iban')}}</label>

                            <div class="">
                                <input value="{{ old('bank_swift') }}" type="text" min="0" class="form-control"
                                    name="bank_swift" placeholder="{{__('admin_message.Iban')}}">
                                @error('bank_swift')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div class="tab-pane" id="address">
                        @if($work==4)
                        <div class="col-xs-12 col-lg-12 form-group">
                            <label for="" class="control-label">{{__('fulfillment.package_cost')}}</label>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.receive_palette')}}</label>
                            <div class="">
                                <input required value="{{ old('receive_palette') }}" type="number" step="any"  min="0" class="form-control"
                                    name="receive_palette" placeholder="{{__('fulfillment.receive_palette')}}">
                                @error('receive_palette')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-lg-3 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.store_palette')}}</label>

                            <div class="">
                                <input required value="{{ old('store_palette') }}" type="number" step="any" min="0" class="form-control"
                                    name="store_palette" placeholder="{{__('fulfillment.store_palette')}}">
                                @error('store_palette')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-6 col-lg-3 form-group">
                            <label for="pallet_subscription_type" class="control-label">{{__('admin_message.dailyMonthly')}}</label>
                            <div class="">
                                <select id="pallet_subscription_type" class="form-control select2" name="pallet_subscription_type">
                                    <option value="daily">{{__('admin_message.daily')}}</option>
                                    <option value="monthly">{{__('admin_message.monthly')}}</option>
                                </select>
                                @error('receive_palette')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.sort_by_sku')}}</label>

                            <div class="">
                                <input required value="{{ old('sort_by_suku') }}" type="number" step="any" min="0" class="form-control"
                                    name="sort_by_suku" placeholder="{{__('fulfillment.sort_by_sku')}}">
                                @error('sort_by_suku')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.pick_process_package')}}</label>

                            <div class="">
                                <input required value="{{ old('pick_process_package') }}" type="number" step="any" min="0" class="form-control"
                                    name="pick_process_package" placeholder="{{__('fulfillment.pick_process_package')}}">
                                @error('pick_process_package')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.print_waybill')}}</label>

                            <div class="">
                                <input required value="{{ old('print_waybill') }}" type="number" step="any" min="0" class="form-control"
                                    name="print_waybill" placeholder="{{__('fulfillment.print_waybill')}}">
                                @error('print_waybill')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.sort_by_city')}}</label>

                            <div class="">
                                <input required value="{{ old('sort_by_city') }}" type="number" step="any" min="0" class="form-control"
                                    name="sort_by_city" placeholder="{{__('fulfillment.sort_by_city')}}">
                                @error('sort_by_city')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.store_return_shipment')}}</label>

                            <div class="">
                                <input required value="{{ old('store_return_shipment') }}" type="number" step="any" min="0" class="form-control"
                                    name="store_return_shipment" placeholder="{{__('fulfillment.store_return_shipment')}}">
                                @error('store_return_shipment')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('fulfillment.reprocess_return_shipment')}}</label>

                            <div class="">
                                <input required value="{{ old('reprocess_return_shipment') }}" type="number" step="any" min="0" class="form-control"
                                    name="reprocess_return_shipment" placeholder="{{__('fulfillment.reprocess_return_shipment')}}">
                                @error('reprocess_return_shipment')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        @if($work==1 || $work==4 )
                        <!-- select -->
                        <div class="col-xs-12 col-lg-12 form-group">
                            @if($work==4)
                            <label for="" class="control-label">{{__('admin_message.Cost calculation method ful')}}</label>
                            @else<label for="" class="control-label">{{__('admin_message.Cost calculation method')}}</label>@endif
                            <div class="">
                                <select id="cost_type"  class="form-control"
                                    name="cost_type"  required>
                                    <option value="0">{{__('admin_message.Select')}} {{__('admin_message.Cost calculation method')}} </option>
                                    <option value="1"> {{__('admin_message.Account inside and outside the city')}} </option>
                                    <option value="2">{{__('admin_message.Account inside and outside the tier')}} </option>
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
                        
                            <div style="display:none;" id="show2" class="">
                                @include('admin.clients.accounts.zone')
                            </div>
                       
                        
                        <!-- end zone -->
                        <!-- start city -->

                        @if($work==4)
                            <div style="display:none;" id="show1" class="">
                                @include('admin.clients.accounts.fulfillment_city')
                            </div>
                        @else
                            <div style="display:none;" id="show1" class="">
                                @include('admin.clients.accounts.city')
                            </div>
                        @endif

                    </div>
                    <!--endcity  -->

                    @else
                    @include('admin.clients.accounts.resturant')
                    @endif
                </div>

                <div class="tab-pane" id="status12">
                    @include('admin.clients.accounts.status')

                </div>

                <div class="tab-pane" id="provider">
                    <div class="col-xs-12 col-lg-6 form-group">
                        <label for="Tax_certificate" class="control-label"> {{__('admin_message.logo')}} </label>
                        <div class="">
                            <input type="file" name="avatar" >

                            @error('avatar')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6 form-group">
                        <label for="Tax_certificate" class="control-label"> {{__('admin_message.Tax_certificate')}}</label>
                        <div class="">
                            <input type="file" name="Tax_certificate">

                            @error('Tax_certificate')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6 form-group">
                        <label for="signed_contract" class="control-label"> {{__('admin_message.signed contract')}} </label>
                        <div class="">
                            <input type="file" name="signed_contract" >
                            @error('signed_contract')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6 form-group">
                        <label for="commercial_register" class="control-label"> {{__('admin_message.commercial_register')}} </label>
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
            <!-- /.tab-content -->
            <div class=" footer col-lg-12">
                <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
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
@endsection
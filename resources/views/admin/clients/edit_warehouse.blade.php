@extends('layouts.master')
@if($client->work==1)
    @section('pageTitle',__('admin_message.Clients') .''.__('admin_message.Edit'))
@elseif($client->work==2)
    @section('pageTitle',__('admin_message.restaurants') .''.__('admin_message.Edit'))
@elseif($client->work==3)
    @section('pageTitle', __('admin_message.Warehouses').''.__('admin_message.Edit'))
@endif
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
<style>
.select2-container {
    width: 100% !important;
}
</style>
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @if($client->work==1)

    @include('layouts._header-form', ['title' =>__('admin_message.Clients'), 'type' =>__('admin_message.Edit'),
    'iconClass' => 'fa-shop', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @elseif($client->work==2)

    @include('layouts._header-form', ['title' =>__('admin_message.restaurants'), 'type' =>__('admin_message.Edit'),
    'iconClass' => 'fa-utensils', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @elseif($client->work==3)

    @include('layouts._header-form', ['title' =>__('admin_message.Warehouses'), 'type' =>__('admin_message.Edit'),
    'iconClass' => 'fa-warehouse', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
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
                                {{__("admin_message.Main information")}}

                            </a></li>
                        <li class=""><a href="#register" data-toggle="tab" aria-expanded="false"><i
                                    class="fa fa-usd"></i>{{__("admin_message.Registration data")}}</a></li>
                        <li><a href="#bank" data-toggle="tab"><i
                                    class="fa fa-money-bill"></i>{{__("admin_message.Payments")}}</a></li>
                                    <li class=""><a href="#setting1" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-usd"></i>{{__("admin_message.Financial accounts")}}</a></li>
                            <li class=""><a href="#status_setting" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-usd"></i>{{__("admin_message.Settings")}} {{__("admin_message.statuses")}}</a></li>
                 
                        </li>
                        <li><a href="#files" data-toggle="tab"><i class="fa fa-file"></i>
                                {{__("admin_message.Official documents")}}</a>
                        </li>

                        <!--  -->




                    </ul>

                    <form action="{{route('clients.update', $client->id)}}" method="POST" class="box  col-md-12"
                        style="border: 0px; padding:10px;" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="tab-content col-xs-12">

                            <div class="active tab-pane col-xs-12" id="member">

                                <input type="hidden" value="{{$client->work}}" name="work">
                                <input type="hidden" min="0" value="15" name="tax" class="form-control"
                                    placeholder="Tax">



                                <div class="col-xs-12 form-group">
                                    <label for="store name" class="control-label">
                                        @if($client->work==1)

                                        *{{ __('admin_message.Clients')}}
                                        @elseif($client->work==2)
                                        * {{ __('admin_message.restaurants')}}

                                        @elseif($client->work==3)
                                        * {{ __('admin_message.Warehouses')}}

                                        @endif

                                    </label>

                                    <div class="">
                                        <input type="text" name="store_name" class="form-control" id="store name"
                                            placeholder="" value="{{$client->store_name}}" required>
                                        @error('store_name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="firstname"
                                        class="control-label">{{__('admin_message.manger name')}}*</label>

                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="{{__('admin_message.manger name')}}" value="{{$client->name}}"
                                            required>
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
                                        <input value="{{$client->tax_Number}}" type="text" min="0" class="form-control"
                                            name="tax_Number" placeholder="{{__('admin_message.Tax_number_message')}}">
                                        @error('tax_Number')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xs-12 form-group">
                                    <label for="website"
                                        class="control-label">{{__('admin_message.website url')}}</label>

                                    <div class="">
                                        <input type="text" name="website" class="form-control" id="website"
                                            value="{{$client->website}}"
                                            placeholder="{{__('admin_message.website url')}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="lastname" class="control-label">{{__('admin_message.City')}} *</label>
                                    <div class="">
                                        <select class="form-control select2" name="city_id" required>
                                            <option value="">{{__('admin_message.Select')}} {{__('admin_message.City')}}
                                            </option>
                                            @foreach ($cities as $city)
                                            <option {{($client->city_id == $city->id) ? 'selected' : ''}}
                                                value="{{$city->id}}">
                                                {{$city->trans('title')}}</option>
                                            @endforeach

                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="col-xs-12 form-group">
                                    <label for="num_branches"
                                        class="control-label">{{__('admin_message.Number of Branches')}}</label>

                                    <div class="">
                                        <input value="{{$client->num_branches}}" id="num_branches" type="number"
                                            class="form-control" placeholder="" name="num_branches">
                                    </div>
                                </div> -->

                            </div>
                            <!-- /.tab-pane -->
                            <!-- start tab -->
                            <div class=" tab-pane col-xs-12" id="register">



                                <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label">{{__('admin_message.Phone')}}</label>

                                    <div class="">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            value="{{$client->phone}}"
                                            placeholder="{{__('admin_message.phoneMessage')}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label">{{__('admin_message.Email')}} *</label>

                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                            placeholder="{{__('admin_message.Email')}}" value="{{$client->email}}"
                                            required>
                                        @error('email')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <h4><i class="fa fa-key"></i> {{__('admin_message.password')}} </h4>
                                <div class="col-xs-12 form-group">
                                    <label for="password" class="control-label">{{__('admin_message.password')}}
                                        *</label>

                                    <div class="">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="{{__('admin_message.passwordMassage')}}">
                                        @error('password')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="password-confirm"
                                        class="control-label">{{__('admin_message.confirm password')}} *</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                            placeholder="{{__('admin_message.confirm password')}}"
                                            name="password_confirmation">
                                    </div>
                                </div>

                            </div>



                            <!-- end tab -->

                            <div class=" tab-pane col-xs-12" id="bank">

                                <div class="col-xs-12 form-group">
                                    <label for="firstname"
                                        class="control-label">{{__('admin_message.Payment period')}}</label>

                                    <div class="">
                                        <select name="Payment_period
                                   " class="form-control select2" required>

                                            <option {{($client->Payment_period == 1) ? 'selected' : ''}} value="1">
                                                {{__('admin_message.daily')}}</option>
                                            <option {{($client->Payment_period == 2) ? 'selected' : ''}} value="2">
                                                {{__('admin_message.weekly')}}</option>
                                            <option {{($client->Payment_period == 3) ? 'selected' : ''}} value="3">
                                                {{__('admin_message.Monthly')}}</option>

                                        </select>

                                        @error('work')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">{{__('admin_message.bank name')}}</label>

                                    <div class="">
                                        <input type="text" name="bank_name" class="form-control" id=""
                                            value="{{$client->bank_name}}"
                                            placeholder="{{__('admin_message.bank name')}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for=""
                                        class="control-label">{{__('admin_message.bank account number')}}</label>

                                    <div class="">
                                        <input type="text" name="bank_account_number" class="form-control" id=""
                                            value="{{$client->bank_account_number}}"
                                            placeholder="{{__('admin_message.bank account number')}}">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">{{__('admin_message.Iban')}}</label>

                                    <div class="">
                                        <input type="text" name="bank_swift" class="form-control" id=""
                                            value="{{$client->bank_swift}}" placeholder="{{__('admin_message.Iban')}}">
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="setting1">
                                @include('admin.clients.accounts.warehouse_edit')
                            </div>
                            <div class="tab-pane" id="status_setting">
                            @include('admin.clients.accounts.warehouse_status_edit')
                            </div>
                           

                            <div class=" tab-pane col-xs-12" id="files">
                                @if($client->provider==NULL)

                                <div class="col-xs-6 form-group">
                                    @if($client->avatar !=NULL)
                                    <a href="{{asset('storage/'.$client->avatar)}}"><img style="height: 50px;width:50px"
                                            src="{{asset('storage/'.$client->avatar)}}" alt=""></a>
                                    @endif

                                    <label for="Tax_certificate" class="control-label">
                                        {{__('admin_message.personal photo')}}</label>
                                    <div class="">
                                        <input type="file" name="avatar" id="">

                                        @error('avatar')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                @endif
                                <div class="col-xs-6 form-group">
                                    @if($client->Tax_certificate !=NULL)
                                    <a href="{{asset('storage/'.$client->Tax_certificate)}}"><img
                                            style="height: 50px;width:50px"
                                            src="{{asset('storage/'.$client->Tax_certificate)}}" alt=""></a>
                                    @endif

                                    <label for="Tax_certificate"
                                        class="control-label">{{__('admin_message.Tax_certificate')}} </label>
                                    <div class="">
                                        <input type="file" name="Tax_certificate" id="">

                                        @error('Tax_certificate')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-6 form-group">
                                    @if($client->commercial_register !=NULL)
                                    <a href="{{asset('storage/'.$client->commercial_register)}}"><img
                                            style="height: 50px;width:50px"
                                            src="{{asset('storage/'.$client->commercial_register)}}" alt=""></a>


                                    @endif
                                    <label for="commercial_register"
                                        class="control-label">{{__('admin_message.commercial_register')}} </label>
                                    <div class="">
                                        <input type="file" name="commercial_register" id="">

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
                            <button type="submit" class="btn btn-primary">{{__('admin_message.Edit')}}</button>
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
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@endsection
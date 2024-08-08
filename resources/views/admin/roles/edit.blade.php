@extends('layouts.master')
@section('pageTitle',__('admin_message.Edit').''. __('permissions.role'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => __('permissions.role'), 'type' =>__('admin_message.Edit'), 'iconClass'
    => 'fa-lock', 'url' =>
    route('roles.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('roles.update', $role->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__('admin_message.Edit')}} {{__('permissions.role')}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">{{__('admin_message.Name')}}</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Name')}}" value="{{$role->title}}" required>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{__('admin_message.Title')}}</th>
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i>{{__('admin_message.View')}}
                                        </th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> {{__('admin_message.add')}}
                                        </th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> {{__('admin_message.Edit')}}
                                        </th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i>
                                            {{__('admin_message.Delete')}} </th>
                                        <!-- <th> <i class="fa fa-qrcode" aria-hidden="true"></i> QRCode </th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>{{__('admin_message.Admin Permissions')}}</h4> <input
                                                    type="checkbox" id="checkAll"> {{__('admin_message.Select All')}}

                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.status') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="1"
                                                {{(in_array('1', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="2"
                                                {{(in_array('2', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="3"
                                                {{(in_array('3', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="4"
                                                {{(in_array('4', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('app.partners_statuses') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="234"
                                                {{(in_array('234', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="235"
                                                {{(in_array('235', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="236"
                                                {{(in_array('236', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.cities') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="5"
                                                {{(in_array('5', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="6"
                                                {{(in_array('6', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="7"
                                                {{(in_array('7', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="8"
                                                {{(in_array('8', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.neighborhoods') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="71"
                                                {{(in_array('71', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="72"
                                                {{(in_array('72', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="73"
                                                {{(in_array('73', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="74"
                                                {{(in_array('74', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>{{ __('permissions.stores') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="9"
                                                {{(in_array('9', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="10"
                                                {{(in_array('10', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="11"
                                                {{(in_array('11', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="12"
                                                {{(in_array('12', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))

                                    <tr>
                                        <td>{{ __('permissions.restaurants') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="75"
                                                {{(in_array('75', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="76"
                                                {{(in_array('76', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="77"
                                                {{(in_array('77', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="78"
                                                {{(in_array('78', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))

                                    <tr>
                                        <td>{{ __('permissions.warehouse_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="150"
                                                {{(in_array('150', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="151"
                                                {{(in_array('151', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="152"
                                                {{(in_array('152', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="153"
                                                {{(in_array('153', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif

                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.fulfillment_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="207"
                                                {{(in_array('207', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="208"
                                                {{(in_array('208', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="209"
                                                {{(in_array('209', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="210"
                                                {{(in_array('210', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td>{{ __('permissions.api_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="154"
                                                {{(in_array('154', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="155"
                                                {{(in_array('155', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="156"
                                                {{(in_array('156', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.api_fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="200"
                                                {{(in_array('200', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="201"
                                                {{(in_array('201', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="202"
                                                {{(in_array('202', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('permissions.addresses') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="163"
                                                {{(in_array('163', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="164"
                                                {{(in_array('164', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="165"
                                                {{(in_array('165', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="166"
                                                {{(in_array('166', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(3, $user_type))

                                    <tr>
                                        <td>{{ __('permissions.Warehouse customer packages') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="167"
                                                {{(in_array('167', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="168"
                                                {{(in_array('168', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="169"
                                                {{(in_array('169', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="170"
                                                {{(in_array('170', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{__('admin_message.Customer evaluation')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="67"
                                                {{(in_array('67', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="68"
                                                {{(in_array('68', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="69"
                                                {{(in_array('69', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="70"
                                                {{(in_array('70', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(1, $user_type)|| in_array(2, $user_type) || in_array(4, $user_type))
                                    <tr>
                                        <td> {{__('admin_message.Watch the delegates')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="17"
                                                {{(in_array('17', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="18"
                                                {{(in_array('18', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="19"
                                                {{(in_array('19', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="20"
                                                {{(in_array('20', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    <!-- @if (in_array(2, $user_type))
                                    <tr>
                                        <td>مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="79"
                                                {{(in_array('79', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="80"
                                                {{(in_array('80', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="81"
                                                {{(in_array('81', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="82"
                                                {{(in_array('82', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif -->
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>{{ __('admin_message.Wallet Clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="13"
                                                {{(in_array('13', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="14"
                                                {{(in_array('14', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="15"
                                                {{(in_array('15', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="16"
                                                {{(in_array('16', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet Restaurants') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="91"
                                                {{(in_array('91', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="92"
                                                {{(in_array('92', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="93"
                                                {{(in_array('93', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="94"
                                                {{(in_array('94', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet Warehouse Clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="175"
                                                {{(in_array('175', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="176"
                                                {{(in_array('176', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="177"
                                                {{(in_array('177', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="178"
                                                {{(in_array('178', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="218"
                                                {{(in_array('218', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="219"
                                                {{(in_array('219', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="220"
                                                {{(in_array('220', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="221"
                                                {{(in_array('221', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(1, $user_type)|| in_array(2, $user_type) ||in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet Delegates') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="95"
                                                {{(in_array('95', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="96"
                                                {{(in_array('96', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="97"
                                                {{(in_array('97', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="98"
                                                {{(in_array('98', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif

                                    @if (in_array(2, $user_type) || in_array(1, $user_type))

                                    <tr>
                                        <td>{{ __('admin_message.Wallet service providers') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="179"
                                                {{(in_array('179', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="180"
                                                {{(in_array('180', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="181"
                                                {{(in_array('181', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="182"
                                                {{(in_array('182', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('admin_message.Invoices') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="83"
                                                {{(in_array('83', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="84"
                                                {{(in_array('84', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="85"
                                                {{(in_array('85', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="86"
                                                {{(in_array('86', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <!-- scan order permission -->
                                    @if(in_array(1,$user_type))

                                    <tr>
                                        <td> {{  __('admin_message.scan') }} {{  __('admin_message.Customer Orders') }}
                                        </td>
                                        <td><input type="checkbox" name="permissions[]" value="244" {{(in_array('244', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{  __('admin_message.scan') }}
                                            {{  __('admin_message.Customer restaurant') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="245" {{(in_array('245', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(3,$user_type))

                                    <tr>
                                        <td>{{  __('admin_message.scan') }} {{  __('admin_message.warehouse orders') }}
                                        </td>
                                        <td><input type="checkbox" name="permissions[]" value="246" {{(in_array('246', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td>{{  __('admin_message.scan') }} {{  __('admin_message.Fulfilmant orders') }}
                                        </td>
                                        <td><input type="checkbox" name="permissions[]" value="247" {{(in_array('247', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif


                                    <!-- scan order permission -->
                                    @if(in_array(1,$user_type))
                                    <tr>
                                        <td> {{ __('admin_message.Last Mile Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="237"
                                                {{(in_array('237', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Restaurant  Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="238"
                                                {{(in_array('238', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Fulfillment Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="239"
                                                {{(in_array('239', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(1,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Last Mile Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="240"
                                                {{(in_array('240', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Restaurant Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="241"
                                                {{(in_array('241', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Fulfillment Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="242"
                                                {{(in_array('242', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>

                                    @endif
                                    <tr>
                                        <td> {{ __('admin_message.Cod Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="243"
                                                {{(in_array('243', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.External Reports') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="103"
                                                {{(in_array('103', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="104"
                                                {{(in_array('104', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="105"
                                                {{(in_array('105', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="106"
                                                {{(in_array('106', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(1, $user_type))
                                    <tr>
                                        <td>{{__('admin_message.Customer requests sales') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="21"
                                                {{(in_array('21', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="136"
                                                {{(in_array('136', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="137"
                                                {{(in_array('137', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="23"
                                                {{(in_array('23', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.Pickup requests client') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="138"
                                                {{(in_array('138', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="139"
                                                {{(in_array('139', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="140"
                                                {{(in_array('140', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="141"
                                                {{(in_array('141', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))
                                    <tr>
                                        <td> {{ __('admin_message.Customer restaurant sales') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="87"
                                                {{(in_array('87', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="88"
                                                {{(in_array('88', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="89"
                                                {{(in_array('89', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="90"
                                                {{(in_array('90', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))
                                    <!-- <tr>
                                        <td>{{ __('permissions.warehouse_orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="203"></td>
                                        <td><input type="checkbox" name="permissions[]" value="204"></td>
                                        <td><input type="checkbox" name="perissions[]" value="205"></td>
                                        <td><input type="checkbox" name="permissions[]" value="206"></td>
                                    </tr> -->
                                    <tr>
                                        <td> {{ __('admin_message.Pickup requests warehouse') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="226"
                                                {{(in_array('226', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="227"
                                                {{(in_array('227', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="228"
                                                {{(in_array('228', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="229"
                                                {{(in_array('229', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.fulfillment_orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="203"
                                                {{(in_array('203', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="204"
                                                {{(in_array('204', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="205"
                                                {{(in_array('205', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="206"
                                                {{(in_array('206', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.Pickup requests fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="230"
                                                {{(in_array('230', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="231"
                                                {{(in_array('231', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="232"
                                                {{(in_array('232', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="233"
                                                {{(in_array('233', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>طلبات المرتجعة المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="142"
                                                {{(in_array('142', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="143"
                                                {{(in_array('143', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="144"
                                                {{(in_array('144', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="145"
                                                {{(in_array('145', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))

                                    <tr>
                                        <td>طلبات المرتجعة المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="146"
                                                {{(in_array('146', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="147"
                                                {{(in_array('147', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="148"
                                                {{(in_array('148', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="149"
                                                {{(in_array('149', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                                <tr>
                                                <td>طلبات المرتجعة الفلفيمنت</td>
                                                <td><input type="checkbox" name="permissions[]" value="250"
                                                        {{ in_array('250', $arrPermissions) ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="permissions[]" value="251"
                                                        {{ in_array('251', $arrPermissions) ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="permissions[]" value="252"
                                                        {{ in_array('252', $arrPermissions) ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="permissions[]" value="253"
                                                        {{ in_array('253', $arrPermissions) ? 'checked' : '' }}></td>
                                                </tr>
                                @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td>تغير الحالة الطلب</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('157', $arrPermissions)) ? 'checked' : ''}} value="157">
                                        </td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> تحويل الطلب الى مندوب</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('22', $arrPermissions)) ? 'checked' : ''}} value="22"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> تحويل الطلب الى مزود خدمة</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('158', $arrPermissions)) ? 'checked' : ''}} value="158">
                                        </td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td>تاريخ الطلب</td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('159', $arrPermissions)) ? 'checked' : ''}} value="159">
                                        </td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> OTP طلب</td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('160', $arrPermissions)) ? 'checked' : ''}} value="160">
                                        </td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('161', $arrPermissions)) ? 'checked' : ''}} value="161">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>إرسال تقيم للعميل عبر الواتس أب</td>
                                        <td><input type="checkbox" name="permissions[]"
                                                {{(in_array('162', $arrPermissions)) ? 'checked' : ''}} value="162">
                                        </td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>طلب الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="24"
                                                {{(in_array('24', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="25"
                                                {{(in_array('25', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td>تتبع المناديب</td>
                                        <td><input type="checkbox" name="permissions[]" value="26"
                                                {{(in_array('26', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>المركبات</td>
                                        <td><input type="checkbox" name="permissions[]" value="171"
                                                {{(in_array('171', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="172"
                                                {{(in_array('172', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="173"
                                                {{(in_array('173', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="174"
                                                {{(in_array('174', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td> قواعد تعيين المناديب</td>
                                        <td><input type="checkbox" name="permissions[]" value="184"
                                                {{(in_array('184', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="185"
                                                {{(in_array('185', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="186"
                                                {{(in_array('186', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="187"
                                                {{(in_array('187', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('admin_message.Rules for Appointing service provider') }}</td>
                                        <td><input type="checkbox"
                                                {{(in_array('222', $arrPermissions)) ? 'checked' : ''}}
                                                name="permissions[]" value="222"></td>
                                        <td><input type="checkbox"
                                                {{(in_array('223', $arrPermissions)) ? 'checked' : ''}}
                                                name="permissions[]" value="223"></td>
                                        <td><input type="checkbox"
                                                {{(in_array('224', $arrPermissions)) ? 'checked' : ''}}
                                                name="permissions[]" value="224"></td>
                                        <td><input type="checkbox"
                                                {{(in_array('225', $arrPermissions)) ? 'checked' : ''}}
                                                name="permissions[]" value="225"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(1, $user_type))
                                    <tr>
                                        <td>طبقات المدن</td>
                                        <td><input type="checkbox" name="permissions[]" value="188"
                                                {{(in_array('188', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="189"
                                                {{(in_array('189', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="190"
                                                {{(in_array('190', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="191"
                                                {{(in_array('191', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td> مناطق الأحياء</td>
                                        <td><input type="checkbox" name="permissions[]" value="192"
                                                {{(in_array('192', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="193"
                                                {{(in_array('193', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="194"
                                                {{(in_array('194', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="195"
                                                {{(in_array('195', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>

                                    <tr>
                                        <td>فروع الشركة</td>
                                        <td><input type="checkbox" name="permissions[]" value="60"
                                                {{(in_array('60', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="61"
                                                {{(in_array('61', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="62"
                                                {{(in_array('62', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="63"
                                                {{(in_array('63', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>




                                    @endif

                                    <tr>
                                        <td>إعدادات الأدمن</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="27"
                                                {{(in_array('27', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>الصلاحيات</td>
                                        <td><input type="checkbox" name="permissions[]" value="28"
                                                {{(in_array('28', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="29"
                                                {{(in_array('29', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="30"
                                                {{(in_array('30', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="31"
                                                {{(in_array('31', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المستخدمين</td>
                                        <td><input type="checkbox" name="permissions[]" value="32"
                                                {{(in_array('32', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="33"
                                                {{(in_array('33', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="34"
                                                {{(in_array('34', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="35"
                                                {{(in_array('35', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>المشرفين</td>
                                        <td><input type="checkbox" name="permissions[]" value="107" c
                                                {{(in_array('107', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="108"
                                                {{(in_array('108', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="109"
                                                {{(in_array('109', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="110"
                                                {{(in_array('110', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>مزودين الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="111"
                                                {{(in_array('111', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="112"
                                                {{(in_array('112', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="113"
                                                {{(in_array('113', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="114"
                                                {{(in_array('114', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>فروع المستودع</td>
                                        <td><input type="checkbox" name="permissions[]" value="119"
                                                {{(in_array('110', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="120"
                                                {{(in_array('120', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="121"
                                                {{(in_array('121', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="122"
                                                {{(in_array('122', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>

                                    <tr>
                                        <td>المنتجات / البضائع</td>
                                        <td><input type="checkbox" name="permissions[]" value="123"
                                                {{(in_array('123', $arrPermissions)) ? 'checked' : ''}}></td>
                                         <td><input type="checkbox" name="permissions[]" value="124"
                                                {{(in_array('124', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="125"
                                                {{(in_array('125', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="126"
                                                {{(in_array('126', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="183"
                                                {{(in_array('183', $arrPermissions)) ? 'checked' : ''}}>QR code</td>


                                    </tr>
                                    <tr>
                                                <td>المنتجات التالفة </td>
                                                <td><input type="checkbox" name="permissions[]" value="248"  {{ in_array('248', $arrPermissions) ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="permissions[]" value="249"  {{ in_array('249', $arrPermissions) ? 'checked' : '' }}></td>
                                                <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                                <td><input type="checkbox" name="permissions[]" value="254"  {{ in_array('254', $arrPermissions) ? 'checked' : '' }}></td>
                                            </tr>
                                    <tr>
                                        <td> الأحجام</td>
                                        <td><input type="checkbox" name="permissions[]" value="127"
                                                {{(in_array('127', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="128"
                                                {{(in_array('128', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="129"
                                                {{(in_array('129', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="130"
                                                {{(in_array('130', $arrPermissions)) ? 'checked' : ''}}></td>

                                    </tr>
                                    <tr>
                                        <td>{{__('admin_message.boxs')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="214"
                                                {{(in_array('214', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="215"
                                                {{(in_array('215', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="216"
                                                {{(in_array('216', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="217"
                                                {{(in_array('217', $arrPermissions)) ? 'checked' : ''}}></td>

                                    </tr>
                                    <tr>
                                        <td> طباعة QR</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                        <td><input type="checkbox" name="permissions[]" value="131"
                                                {{(in_array('131', $arrPermissions)) ? 'checked' : ''}}>QR code</td>

                                    </tr>
                                    <tr>
                                        <td> الباقات</td>
                                        <td><input type="checkbox" name="permissions[]" value="132"
                                                {{(in_array('132', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="133"
                                                {{(in_array('133', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="134"
                                                {{(in_array('134', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="135"
                                                {{(in_array('135', $arrPermissions)) ? 'checked' : ''}}></td>

                                    </tr>
                                    <tr>
                                        <td>التصنيفات</td>
                                        <td><input type="checkbox" name="permissions[]" value="48"
                                                {{(in_array('48', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="49"
                                                {{(in_array('49', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="50"
                                                {{(in_array('50', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="51"
                                                {{(in_array('51', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('admin_message.Packaging goods/cartons')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="211"
                                                {{(in_array('211', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="212"
                                                {{(in_array('212', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="213"
                                                {{(in_array('213', $arrPermissions)) ? 'checked' : ''}}></td>


                                    </tr>
                                    @endif


                                    <!-- <tr>
                                        <std colspan="5">
                                            <center>
                                                <h4>Website Permissions</h4>
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Slider</td>
                                        <td><input type="checkbox" name="permissions[]" value="36" {{(in_array('36', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="37" {{(in_array('37', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="38" {{(in_array('38', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="39" {{(in_array('39', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td><input type="checkbox" name="permissions[]" value="40" {{(in_array('40', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="41" {{(in_array('41', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="42" {{(in_array('42', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="43" {{(in_array('43', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Posts</td>
                                        <td><input type="checkbox" name="permissions[]" value="44" {{(in_array('44', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="45" {{(in_array('45', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="46" {{(in_array('46', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="47" {{(in_array('47', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td><input type="checkbox" name="permissions[]" value="48" {{(in_array('48', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="49" {{(in_array('49', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="50" {{(in_array('50', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="51" {{(in_array('51', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td><input type="checkbox" name="permissions[]" value="52" {{(in_array('52', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="53" {{(in_array('53', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="54" {{(in_array('54', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="55" {{(in_array('55', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                      <tr>
                                        <td>Services</td>
                                        <td><input type="checkbox" name="permissions[]" value="115" {{(in_array('115', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="116" {{(in_array('116', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="117" {{(in_array('117', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="118" {{(in_array('118', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Waht We Do</td>
                                        <td><input type="checkbox" name="permissions[]" value="56" {{(in_array('56', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="57" {{(in_array('57', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="58" {{(in_array('58', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="59" {{(in_array('59', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input type="checkbox" name="permissions[]" value="60" {{(in_array('60', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="61" {{(in_array('61', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="62" {{(in_array('62', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="permissions[]" value="63" {{(in_array('63', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Us</td>
                                        <td><input type="checkbox" name="permissions[]" value="64" {{(in_array('64', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="65" {{(in_array('65', $arrPermissions)) ? 'checked' : ''}}></td>
                                    </tr>
                                    <tr>
                                        <td>Website Setting</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="66" {{(in_array('66', $arrPermissions)) ? 'checked' : ''}}></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr> -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('admin_message.Title')}}</th>
                                        <th> <i class="fa fa-eye" aria-hidden="true"></i>{{__('admin_message.View')}}
                                        </th>
                                        <th> <i class="fa fa-plus" aria-hidden="true"></i> {{__('admin_message.add')}}
                                        </th>
                                        <th> <i class="fa fa-edit" aria-hidden="true"></i> {{__('admin_message.Edit')}}
                                        </th>
                                        <th> <i class="fa fa-trash" aria-hidden="true"></i>
                                            {{__('admin_message.Delete')}} </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script>
$("#checkAll").click(function() {

    $('input:checkbox').not(this).prop('checked', this.checked);

});
</script>
@endsection
@extends('layouts.master')
@section('pageTitle',__('permissions.Add').''. __('permissions.role'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('permissions.role'), 'type' =>__('admin_message.Add'), 'iconClass' =>
    'fa-lock', 'url' =>
    route('roles.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('roles.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{__('admin_message.Add')}} {{__('permissions.role')}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">{{__('admin_message.Name')}}</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="{{__('admin_message.Name')}}" required>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('permissions.title') }}</th>
                                        <th><i class="fa fa-eye" aria-hidden="true"></i> {{ __('permissions.view') }}
                                        </th>
                                        <th><i class="fa fa-plus" aria-hidden="true"></i> {{ __('permissions.add') }}
                                        </th>
                                        <th><i class="fa fa-edit" aria-hidden="true"></i> {{ __('permissions.edit') }}
                                        </th>
                                        <th><i class="fa fa-trash" aria-hidden="true"></i>
                                            {{ __('permissions.delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>{{ __('permissions.admin_permissions') }}</h4> <input
                                                    type="checkbox" id="checkAll">{{ __('permissions.select_all') }}
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.status') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="1"></td>
                                        <td><input type="checkbox" name="permissions[]" value="2"></td>
                                        <td><input type="checkbox" name="permissions[]" value="3"></td>
                                        <td><input type="checkbox" name="permissions[]" value="4"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('app.partners_statuses') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="234"></td>
                                        <td><input type="checkbox" name="permissions[]" value="235"></td>
                                        <td><input type="checkbox" name="permissions[]" value="236"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.cities') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="5"></td>
                                        <td><input type="checkbox" name="permissions[]" value="6"></td>
                                        <td><input type="checkbox" name="permissions[]" value="7"></td>
                                        <td><input type="checkbox" name="permissions[]" value="8"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('permissions.neighborhoods') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="71"></td>
                                        <td><input type="checkbox" name="permissions[]" value="72"></td>
                                        <td><input type="checkbox" name="permissions[]" value="73"></td>
                                        <td><input type="checkbox" name="permissions[]" value="74"></td>
                                    </tr>
                                    @if (in_array(1, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.stores') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="9"></td>
                                        <td><input type="checkbox" name="permissions[]" value="10"></td>
                                        <td><input type="checkbox" name="permissions[]" value="11"></td>
                                        <td><input type="checkbox" name="permissions[]" value="12"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.restaurants') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="75"></td>
                                        <td><input type="checkbox" name="permissions[]" value="76"></td>
                                        <td><input type="checkbox" name="permissions[]" value="77"></td>
                                        <td><input type="checkbox" name="permissions[]" value="78"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.warehouse_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="150"></td>
                                        <td><input type="checkbox" name="permissions[]" value="151"></td>
                                        <td><input type="checkbox" name="permissions[]" value="152"></td>
                                        <td><input type="checkbox" name="permissions[]" value="153"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.fulfillment_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="207"></td>
                                        <td><input type="checkbox" name="permissions[]" value="208"></td>
                                        <td><input type="checkbox" name="permissions[]" value="209"></td>
                                        <td><input type="checkbox" name="permissions[]" value="210"></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('permissions.api_clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="154"></td>
                                        <td><input type="checkbox" name="permissions[]" value="155"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="156"></td>
                                    </tr>
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.api_fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="200"></td>
                                        <td><input type="checkbox" name="permissions[]" value="201"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="202"></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('permissions.addresses') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="163"></td>
                                        <td><input type="checkbox" name="permissions[]" value="164"></td>
                                        <td><input type="checkbox" name="permissions[]" value="165"></td>
                                        <td><input type="checkbox" name="permissions[]" value="166"></td>
                                    </tr>
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.Warehouse customer packages') }}</td>

                                        <td><input type="checkbox" name="permissions[]" value="167"></td>
                                        <td><input type="checkbox" name="permissions[]" value="168"></td>
                                        <td><input type="checkbox" name="permissions[]" value="169"></td>
                                        <td><input type="checkbox" name="permissions[]" value="170"></td>
                                    </tr>
                                    @endif
                                    {{-- @if (in_array(4, $user_type))
                                    <tr>
                                        <td> باكدجات فلفمينت</td>
                                        <td><input type="checkbox" name="permissions[]" value=""></td>
                                        <td><input type="checkbox" name="permissions[]" value=""></td>
                                        <td><input type="checkbox" name="permissions[]" value=""></td>
                                        <td><input type="checkbox" name="permissions[]" value=""></td>
                                    </tr>
                                    @endif --}}
                                    <tr>
                                        <td>{{__('admin_message.Customer evaluation')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="67"></td>
                                        <td><input type="checkbox" name="permissions[]" value="68"></td>
                                        <td><input type="checkbox" name="permissions[]" value="69"></td>
                                        <td><input type="checkbox" name="permissions[]" value="70"></td>
                                    </tr>
                                    @if (in_array(1, $user_type)|| in_array(2, $user_type) ||in_array(4, $user_type))
                                    <tr>
                                        <td> {{__('admin_message.Watch the delegates')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="17"></td>
                                        <td><input type="checkbox" name="permissions[]" value="18"></td>
                                        <td><input type="checkbox" name="permissions[]" value="19"></td>
                                        <td><input type="checkbox" name="permissions[]" value="20"></td>
                                    </tr>
                                    @endif
                                    <!-- @if (in_array(2, $user_type))
                                    <tr>
                                        <td>مناديب المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="79"></td>
                                        <td><input type="checkbox" name="permissions[]" value="80"></td>
                                        <td><input type="checkbox" name="permissions[]" value="81"></td>
                                        <td><input type="checkbox" name="permissions[]" value="82"></td>
                                    </tr>
                                    @endif -->
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>{{ __('admin_message.Wallet Clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="13"></td>
                                        <td><input type="checkbox" name="permissions[]" value="14"></td>
                                        <td><input type="checkbox" name="permissions[]" value="15"></td>
                                        <td><input type="checkbox" name="permissions[]" value="16"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet Restaurants') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="91"></td>
                                        <td><input type="checkbox" name="permissions[]" value="92"></td>
                                        <td><input type="checkbox" name="permissions[]" value="93"></td>
                                        <td><input type="checkbox" name="permissions[]" value="94"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(3, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet Warehouse Clients') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="175"></td>
                                        <td><input type="checkbox" name="permissions[]" value="176"></td>
                                        <td><input type="checkbox" name="permissions[]" value="177"></td>
                                        <td><input type="checkbox" name="permissions[]" value="178"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="218"></td>
                                        <td><input type="checkbox" name="permissions[]" value="219"></td>
                                        <td><input type="checkbox" name="permissions[]" value="220"></td>
                                        <td><input type="checkbox" name="permissions[]" value="221"></td>
                                    </tr>
                                    @endif

                                    @if (in_array(1, $user_type)|| in_array(2, $user_type) ||in_array(4, $user_type))

                                    <tr>
                                        <td>{{ __('admin_message.Wallet Delegates') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="95"></td>
                                        <td><input type="checkbox" name="permissions[]" value="96"></td>
                                        <td><input type="checkbox" name="permissions[]" value="97"></td>
                                        <td><input type="checkbox" name="permissions[]" value="98"></td>
                                    </tr>
                                    @endif

                                    @if (in_array(2, $user_type) || in_array(1, $user_type))
                                    <tr>
                                        <td>{{ __('admin_message.Wallet service providers') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="179"></td>
                                        <td><input type="checkbox" name="permissions[]" value="180"></td>
                                        <td><input type="checkbox" name="permissions[]" value="181"></td>
                                        <td><input type="checkbox" name="permissions[]" value="182"></td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('admin_message.Invoices') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="83"></td>
                                        <td><input type="checkbox" name="permissions[]" value="84"></td>
                                        <td><input type="checkbox" name="permissions[]" value="85"></td>
                                        <td><input type="checkbox" name="permissions[]" value="86"></td>
                                    </tr>
                                    <!-- scan order permission -->
                                    @if(in_array(1,$user_type))

                                    <tr>
                                        <td> {{  __('admin_message.scan') }} {{  __('admin_message.Customer Orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="244"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{  __('admin_message.scan') }} {{  __('admin_message.Customer restaurant') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="245"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(3,$user_type))

                                    <tr>
                                        <td>{{  __('admin_message.scan') }} {{  __('admin_message.warehouse orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="246"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td>{{  __('admin_message.scan') }} {{  __('admin_message.Fulfilmant orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="247"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif


                                    <!-- scan order permission -->
                                    @if(in_array(1,$user_type))
                                    <tr>
                                        <td> {{ __('admin_message.Last Mile Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="237"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Restaurant  Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="238"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Fulfillment Orders Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="239"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(1,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Last Mile Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="240"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(2,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Restaurant Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="241"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    @if(in_array(4,$user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Fulfillment Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="242"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    @endif
                                    <tr>
                                        <td> {{ __('admin_message.Cod Accounting Report') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="243"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.External Reports') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="103"></td>
                                        <td><input type="checkbox" name="permissions[]" value="104"></td>
                                        <td><input type="checkbox" name="permissions[]" value="105"></td>
                                        <td><input type="checkbox" name="permissions[]" value="106"></td>
                                    </tr>
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>{{__('admin_message.Customer requests sales') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="21"></td>
                                        <td><input type="checkbox" name="permissions[]" value="136"></td>
                                        <td><input type="checkbox" name="permissions[]" value="137"></td>
                                        <td><input type="checkbox" name="permissions[]" value="23"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.Pickup requests client') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="138"></td>
                                        <td><input type="checkbox" name="permissions[]" value="139"></td>
                                        <td><input type="checkbox" name="permissions[]" value="140"></td>
                                        <td><input type="checkbox" name="permissions[]" value="141"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))

                                    <tr>
                                        <td> {{ __('admin_message.Customer restaurant sales') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="87"></td>
                                        <td><input type="checkbox" name="permissions[]" value="88"></td>
                                        <td><input type="checkbox" name="permissions[]" value="89"></td>
                                        <td><input type="checkbox" name="permissions[]" value="90"></td>
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
                                        <td><input type="checkbox" name="permissions[]" value="226"></td>
                                        <td><input type="checkbox" name="permissions[]" value="227"></td>
                                        <td><input type="checkbox" name="permissions[]" value="228"></td>
                                        <td><input type="checkbox" name="permissions[]" value="229"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))
                                    <tr>
                                        <td>{{ __('permissions.fulfillment_orders') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="203"></td>
                                        <td><input type="checkbox" name="permissions[]" value="204"></td>
                                        <td><input type="checkbox" name="perissions[]" value="205"></td>
                                        <td><input type="checkbox" name="permissions[]" value="206"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('admin_message.Pickup requests fulfillment') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="230"></td>
                                        <td><input type="checkbox" name="permissions[]" value="231"></td>
                                        <td><input type="checkbox" name="permissions[]" value="232"></td>
                                        <td><input type="checkbox" name="permissions[]" value="233"></td>
                                    </tr>
                                    @endif
                                    <!--  -->
                                    @if (in_array(1, $user_type))

                                    <tr>
                                        <td>طلبات المرتجعة المتاجر</td>
                                        <td><input type="checkbox" name="permissions[]" value="142"></td>
                                        <td><input type="checkbox" name="permissions[]" value="143"></td>
                                        <td><input type="checkbox" name="permissions[]" value="144"></td>
                                        <td><input type="checkbox" name="permissions[]" value="145"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type))

                                    <tr>
                                        <td>طلبات المرتجعة المطاعم</td>
                                        <td><input type="checkbox" name="permissions[]" value="146"></td>
                                        <td><input type="checkbox" name="permissions[]" value="147"></td>
                                        <td><input type="checkbox" name="permissions[]" value="148"></td>
                                        <td><input type="checkbox" name="permissions[]" value="149"></td>
                                    </tr>
                                    @endif
                                    @if (in_array(4, $user_type))

<tr>
    <td>طلبات المرتجعة الفلفيمنت</td>
    <td><input type="checkbox" name="permissions[]" value="250"></td>
    <td><input type="checkbox" name="permissions[]" value="251"></td>
    <td><input type="checkbox" name="permissions[]" value="252"></td>
    <td><input type="checkbox" name="permissions[]" value="253"></td>
</tr>
@endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td>تغير الحالة الطلب</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="157"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> تحويل الطلب الى مندوب</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="22"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> تحويل الطلب الى مزود خدمة</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="158"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td>تاريخ الطلب</td>
                                        <td><input type="checkbox" name="permissions[]" value="159"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    @if (in_array(2, $user_type)||in_array(1, $user_type) || in_array(4, $user_type))

                                    <tr>
                                        <td> OTP طلب</td>
                                        <td><input type="checkbox" name="permissions[]" value="160"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="161"></td>
                                    </tr>
                                    <tr>
                                        <td>إرسال تقيم للعميل عبر الواتس أب</td>
                                        <td><input type="checkbox" name="permissions[]" value="162"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    @endif
                                    <!--  -->
                                    <tr>
                                        <td>طلب الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="24"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="25"></td>
                                    </tr>
                                    @if (in_array(2, $user_type)||in_array(1, $user_type)||in_array(4, $user_type))
                                    <tr>
                                        <td>تتبع المناديب</td>
                                        <td><input type="checkbox" name="permissions[]" value="26"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                    </tr>
                                    <tr>
                                        <td>المركبات</td>
                                        <td><input type="checkbox" name="permissions[]" value="171"></td>
                                        <td><input type="checkbox" name="permissions[]" value="172"></td>
                                        <td><input type="checkbox" name="permissions[]" value="173"></td>
                                        <td><input type="checkbox" name="permissions[]" value="174"></td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('admin_message.Rules for Appointing Delegates') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="184"></td>
                                        <td><input type="checkbox" name="permissions[]" value="185"></td>
                                        <td><input type="checkbox" name="permissions[]" value="186"></td>
                                        <td><input type="checkbox" name="permissions[]" value="187"></td>
                                    </tr>
                                    <!--  -->
                                    <tr>
                                        <td> {{ __('admin_message.Rules for Appointing service provider') }}</td>
                                        <td><input type="checkbox" name="permissions[]" value="222"></td>
                                        <td><input type="checkbox" name="permissions[]" value="223"></td>
                                        <td><input type="checkbox" name="permissions[]" value="224"></td>
                                        <td><input type="checkbox" name="permissions[]" value="225"></td>
                                    </tr>




                                    <!--  -->
                                    @endif
                                    <!--  -->
                                    @if (in_array(1, $user_type))
                                    <tr>
                                        <td>طبقات المدن</td>
                                        <td><input type="checkbox" name="permissions[]" value="188"></td>
                                        <td><input type="checkbox" name="permissions[]" value="189"></td>
                                        <td><input type="checkbox" name="permissions[]" value="190"></td>
                                        <td><input type="checkbox" name="permissions[]" value="191"></td>
                                    </tr>
                                    <tr>
                                        <td> مناطق الأحياء</td>
                                        <td><input type="checkbox" name="permissions[]" value="192"></td>
                                        <td><input type="checkbox" name="permissions[]" value="193"></td>
                                        <td><input type="checkbox" name="permissions[]" value="194"></td>
                                        <td><input type="checkbox" name="permissions[]" value="195"></td>
                                    </tr>

                                    <tr>
                                        <td>فروع الشركة</td>
                                        <td><input type="checkbox" name="permissions[]" value="60"></td>
                                        <td><input type="checkbox" name="permissions[]" value="61"></td>
                                        <td><input type="checkbox" name="permissions[]" value="62"></td>
                                        <td><input type="checkbox" name="permissions[]" value="63"></td>
                                    </tr>
                                    @endif
                                    <!--  -->
                                    <tr>
                                        <td>إعدادات الأدمن</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="27"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>الأدوار</td>
                                        <td><input type="checkbox" name="permissions[]" value="28"></td>
                                        <td><input type="checkbox" name="permissions[]" value="29"></td>
                                        <td><input type="checkbox" name="permissions[]" value="30"></td>
                                        <td><input type="checkbox" name="permissions[]" value="31"></td>
                                    </tr>
                                    <tr>
                                        <td>المستخدمين</td>
                                        <td><input type="checkbox" name="permissions[]" value="32"></td>
                                        <td><input type="checkbox" name="permissions[]" value="33"></td>
                                        <td><input type="checkbox" name="permissions[]" value="34"></td>
                                        <td><input type="checkbox" name="permissions[]" value="35"></td>
                                    </tr>
                                    <tr>
                                        <td>المشرفين</td>
                                        <td><input type="checkbox" name="permissions[]" value="107"></td>
                                        <td><input type="checkbox" name="permissions[]" value="108"></td>
                                        <td><input type="checkbox" name="permissions[]" value="109"></td>
                                        <td><input type="checkbox" name="permissions[]" value="110"></td>
                                    </tr>
                                    <tr>
                                        <td>مزودين الخدمة</td>
                                        <td><input type="checkbox" name="permissions[]" value="111"></td>
                                        <td><input type="checkbox" name="permissions[]" value="112"></td>
                                        <td><input type="checkbox" name="permissions[]" value="113"></td>
                                        <td><input type="checkbox" name="permissions[]" value="114"></td>
                                    </tr>
                                    @if (in_array(3, $user_type)|| in_array(4, $user_type))

                                    <tr>
                                        <td>فروع المستودع</td>
                                        <td><input type="checkbox" name="permissions[]" value="119"></td>
                                        <td><input type="checkbox" name="permissions[]" value="120"></td>
                                        <td><input type="checkbox" name="permissions[]" value="121"></td>
                                        <td><input type="checkbox" name="permissions[]" value="122"></td>
                                    </tr>

                                    <tr>
                                        <td>المنتجات / البضائع</td>
                                        <td><input type="checkbox" name="permissions[]" value="123"></td>
                                        <td><input type="checkbox" name="permissions[]" value="124"></td>
                                        <td><input type="checkbox" name="permissions[]" value="125"></td>
                                        <td><input type="checkbox" name="permissions[]" value="126"></td>
                                        <td><input type="checkbox" name="permissions[]" value="183"></td>



                                    </tr>
                                    <tr>
                                        <td>المنتجات التالفة </td>
                                        <td><input type="checkbox" name="permissions[]" value="248"></td>
                                        <td><input type="checkbox" name="permissions[]" value="249"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="254"></td>
                                    </tr>
                                    <tr>
                                        <td> الأحجام</td>
                                        <td><input type="checkbox" name="permissions[]" value="127"></td>
                                        <td><input type="checkbox" name="permissions[]" value="128"></td>
                                        <td><input type="checkbox" name="permissions[]" value="129"></td>
                                        <td><input type="checkbox" name="permissions[]" value="130"></td>

                                    </tr>
                                    <tr>
                                        <td>{{__('admin_message.boxs')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="214"></td>
                                        <td><input type="checkbox" name="permissions[]" value="215"></td>
                                        <td><input type="checkbox" name="permissions[]" value="216"></td>
                                        <td><input type="checkbox" name="permissions[]" value="217"></td>

                                    </tr>
                                    <tr>
                                        <td> طباعة QR</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>

                                        <td><input type="checkbox" name="permissions[]" value="131"></td>

                                    </tr>
                                    <tr>
                                        <td> الباقات</td>
                                        <td><input type="checkbox" name="permissions[]" value="132"></td>
                                        <td><input type="checkbox" name="permissions[]" value="133"></td>
                                        <td><input type="checkbox" name="permissions[]" value="134"></td>
                                        <td><input type="checkbox" name="permissions[]" value="135"></td>

                                    </tr>
                                    <tr>
                                        <td>التصنيفات</td>
                                        <td><input type="checkbox" name="permissions[]" value="48"></td>
                                        <td><input type="checkbox" name="permissions[]" value="49"></td>
                                        <td><input type="checkbox" name="permissions[]" value="50"></td>
                                        <td><input type="checkbox" name="permissions[]" value="51"></td>
                                    </tr>
                                    <tr>
                                        <td>{{__('admin_message.Packaging goods/cartons')}}</td>
                                        <td><input type="checkbox" name="permissions[]" value="211"></td>
                                        <td><input type="checkbox" name="permissions[]" value="212"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="213"></td>


                                    </tr>
                                    @endif
                                    <!-- <tr>
                                        <td colspan="5">
                                            <center>
                                                <h4>صلحيات الموقع</h4>
                                            </center>

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Slider</td>
                                        <td><input type="checkbox" name="permissions[]" value="36"></td>
                                        <td><input type="checkbox" name="permissions[]" value="37"></td>
                                        <td><input type="checkbox" name="permissions[]" value="38"></td>
                                        <td><input type="checkbox" name="permissions[]" value="39"></td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td><input type="checkbox" name="permissions[]" value="40"></td>
                                        <td><input type="checkbox" name="permissions[]" value="41"></td>
                                        <td><input type="checkbox" name="permissions[]" value="42"></td>
                                        <td><input type="checkbox" name="permissions[]" value="43"></td>
                                    </tr>
                                    <tr>
                                        <td>Posts</td>
                                        <td><input type="checkbox" name="permissions[]" value="44"></td>
                                        <td><input type="checkbox" name="permissions[]" value="45"></td>
                                        <td><input type="checkbox" name="permissions[]" value="46"></td>
                                        <td><input type="checkbox" name="permissions[]" value="47"></td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td><input type="checkbox" name="permissions[]" value="48"></td>
                                        <td><input type="checkbox" name="permissions[]" value="49"></td>
                                        <td><input type="checkbox" name="permissions[]" value="50"></td>
                                        <td><input type="checkbox" name="permissions[]" value="51"></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td><input type="checkbox" name="permissions[]" value="52"></td>
                                        <td><input type="checkbox" name="permissions[]" value="53"></td>
                                        <td><input type="checkbox" name="permissions[]" value="54"></td>
                                        <td><input type="checkbox" name="permissions[]" value="55"></td>
                                    </tr>
                                        <tr>
                                        <td>Partner</td>
                                        <td><input type="checkbox" name="permissions[]" value="115"></td>
                                        <td><input type="checkbox" name="permissions[]" value="116"></td>
                                        <td><input type="checkbox" name="permissions[]" value="117"></td>
                                        <td><input type="checkbox" name="permissions[]" value="118"></td>
                                    </tr>
                                    <tr>
                                        <td>Waht We Do</td>
                                        <td><input type="checkbox" name="permissions[]" value="56"></td>
                                        <td><input type="checkbox" name="permissions[]" value="57"></td>
                                        <td><input type="checkbox" name="permissions[]" value="58"></td>
                                        <td><input type="checkbox" name="permissions[]" value="59"></td>
                                    </tr>
                                    <tr>
                                        <td>Branches</td>
                                        <td><input type="checkbox" name="permissions[]" value="60"></td>
                                        <td><input type="checkbox" name="permissions[]" value="61"></td>
                                        <td><input type="checkbox" name="permissions[]" value="62"></td>
                                        <td><input type="checkbox" name="permissions[]" value="63"></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Us</td>
                                        <td><input type="checkbox" name="permissions[]" value="64"></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="65"></td>
                                    </tr>
                                    <tr>
                                        <td>Website Setting</td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><i class="fa fa-ban" aria-hidden="true"></i></td>
                                        <td><input type="checkbox" name="permissions[]" value="66"></td>
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
@extends('layouts.master')
@if($client->work==1)

@section('pageTitle', 'تفاصيل المتجر')
@elseif($client->work==2)
@section('pageTitle', 'تفاصيل المطعم')
@elseif($client->work==3)
@section('pageTitle', 'تفاصيل المستودع')



@endif
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @if($client->work==1)

    @include('layouts._header-form', ['title' => 'المتجر', 'type' => 'عرض', 'iconClass' => 'fa-store', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @elseif($client->work==2)
    @include('layouts._header-form', ['title' => 'المطعم', 'type' => 'عرض', 'iconClass' => 'fa-store', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])
    @elseif($client->work==3)
    @include('layouts._header-form', ['title' => 'مستودع', 'type' => 'عرض', 'iconClass' => 'fa-store', 'url' =>
    route('clients.index'), 'multiLang' => 'false'])

    @endif

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    @if($client->provider!=NULL)

                  <td><img class="img-circle" src="{{$client->avatar}}" height="75" width="75"></td>
                  @elseif($client->avatar==NULL||$client->avatar=="avatar/avatar.png")
                  <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>

                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$client->avatar)}}" height="75" width="75"></td>


                  @endif

                        <h3 class="profile-username text-center">{{$client->name}}</h3>

                        <p class="text-muted text-center">{{$client->store_name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b> الرقم الضريبى </b>

                                <a class="">{{$client->tax_Number}}</a>

                            </li>
                            <li class="list-group-item">
                                <b> رقم الجوال </b>

                                <a class="">{{$client->phone}}</a>

                            </li>
                            <li class="list-group-item">
                                <b>الموقع </b> <a class="pull-left">{{$client->website}}</a>
                            </li>
                            <br>
                            <li class="list-group-item">
                                <b>البريد الإلكترونى </b> <a class="pull-left">{{$client->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>المدينة</b> <a
                                    class="pull-left">{{ is_null($client->city) ? '' : $client->city->title }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>عدد الفروع</b> <a class="pull-left">{{ $client->num_branches }}</a>
                            </li>
                            <li class="list-group-item">
                                <b> فترة الدفع</b> <a class="pull-left">
                                    @if($client->Payment_period=1)
                                    يومى
                                    @elseif($client->Payment_period=2)
                                    أسبوعى
                                    @elseif($client->Payment_period=3)
                                    شهرى
                                    @endif


                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.col -->

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#bank" data-toggle="tab"><i class="fa fa-usd"></i> معلومات البنك
                            </a></li>
                        <li><a href="#setting" data-toggle="tab"><i class="fas fa-shipping-fast"></i> معلومات الشحن</a></li>
                        <li><a href="#statuses" data-toggle="tab"><i class="fa fa-bookmark"></i> إعدادات الحالات</a>
                        </li>
                        <li><a href="#files" data-toggle="tab"><i class="fa fa-bookmark"></i> المرفقات</a>
                        </li>
                        <li><a href="#address" data-toggle="tab"><i class="fa fa-bookmark"></i> الفروع</a></li>
                        <li><a href="#balance" data-toggle="tab"><i class="fa fa-bookmark"></i> المحفظة</a></li>


                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="bank">
                            <p class="lead"><span class="h3">أسم البنك:</span> {{$client->bank_name}}</p>
                            <p class="lead"><span class="h3">رقم الحساب:</span> {{$client->bank_account_number}}
                            </p>
                            <p class="lead"><span class="h3">الأيبان:</span> {{$client->bank_swift}}</p>
                        </div>
                        <!-- /.tab-pane -->
                        <div class=" tab-pane" id="setting">
                            <p class="lead"><span class="h3">سعر الشحن داخل المدينة:</span>
                                {{$appSetting->currency.' '.$client->cost_inside_city}}</p>
                            <!--<p class="lead"><span class="h3">Cost Outside City:</span> {{$appSetting->currency.' '.$client->cost_outside_city}}</p>-->
                            <!--<p class="lead"><span class="h3">Cost For Reshipping In the Same City:</span> {{$appSetting->currency.' '.$client->cost_reshipping}}</p>-->
                            <!--<p class="lead"><span class="h3">Cost For Reshipping Outside City:</span> {{$appSetting->currency.' '.$client->cost_reshipping_out_city}}</p>-->


                            <!--<p class="lead"><span class="h3">fees for (cash on delivery in the same city):</span> {{$appSetting->currency.' '.$client->fees_cash_on_delivery}}</p>-->
                            <!--<p class="lead"><span class="h3">fees for (cash on delivery Outside City):</span> {{$appSetting->currency.' '.$client->fees_cash_on_delivery_out_city}}</p>-->
                            <p class="lead"><span class="h3">الضريبة:</span> {{$client->tax}}%</p>

                            <!--<p class="lead"><span class="h3" ><span>  Collect Orders Fees : </span> {{$appSetting->currency.' '.$client->pickup_fees}}</p>-->

                            <!--<p class="lead"><span class="h3" ><span>  Standard Weight Fees : </span> {{$appSetting->currency.' '.$client->standard_weight}}</p>-->

                            <!--<p class="lead"><span class="h3" ><span>  Over Weight Price : </span> {{$appSetting->currency.' '.$client->overweight_price}}</p>-->

                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="statuses">
                            <!--@if(App\Models\Status::where('id', $client->default_status_id)->first())-->

                            <!--<p class="lead"><span class="h3">status after saving an order:</span> {{App\Models\Status::where('id', $client->default_status_id)->first()->title}}</p>-->
                            <!--@endif-->
                            @if(App\Models\Status::where('id', $client->cost_calc_status_id)->first())


                            <p class="lead"><span class="h3">start to calculate shipping cost from this status :</span>
                                {{App\Models\Status::where('id', $client->cost_calc_status_id)->first()->title}} </p>
                            @endif

                            <!--  @if(App\Models\Status::where('id', $client->calc_cash_on_delivery_status_id)->first())-->

                            <!--  <p class="lead"><span class="h3">start to calculate fees for (cash on delivery) from this status :</span> {{App\Models\Status::where('id', $client->calc_cash_on_delivery_status_id)->first()->title}} </p>-->
                            <!--  @endif-->

                            <!--  @if(App\Models\Status::where('id', $client->cost_reshipping_calc_status_id)->first())-->

                            <!--  <p class="lead"><span class="h3">start to calculate reshipping cost from this status :</span> {{App\Models\Status::where('id', $client->cost_reshipping_calc_status_id)->first()->title}} </p>-->
                            <!--  @endif-->

                            <!--  @if(App\Models\Status::where('id', $client->available_edit_status)->first())-->

                            <!--  <p class="lead"><span class="h3">available edit and update order in this status :</span> {{App\Models\Status::where('id', $client->available_edit_status)->first()->title}} </p>-->
                            <!--  @endif-->
                            <!--  @if(App\Models\Status::where('id', $client->available_delete_status)->first())-->

                            <!--  <p class="lead"><span class="h3">available delete order in this status :</span> {{App\Models\Status::where('id', $client->available_delete_status)->first()->title}} </p>-->
                            <!--  @endif-->
                            <!--  @if(App\Models\Status::where('id', $client->available_overweight_status)->first())-->


                            <!--  <p class="lead"><span class="h3">overweight price calculate in this status :</span> {{App\Models\Status::where('id', $client->available_overweight_status)->first() ? App\Models\Status::where('id', $client->available_overweight_status)->first()->title : '' }} </p>-->
                            <!-- @endif-->
                            <!--  @if(App\Models\Status::where('id', $client->available_collect_order_status)->first())-->

                            <!-- <p class="lead"><span class="h3">Collect Orders Price calculate in this status :</span> {{App\Models\Status::where('id', $client->available_collect_order_status)->first() ? App\Models\Status::where('id', $client->available_collect_order_status)->first()->title : '' }} </p>-->
                            <!--@endif-->

                        </div>
                        <div class="tab-pane" id="files">
                            @if($client->logo !=NULL)
                           
                            <p class="lead"><span class="h3"> اللوجو :</span><a download
                                    href="{{asset('storage/'.$client->logo)}}">تحميل</a></p>
                            @endif

                            @if($client->signed_contract !=NULL)
                            <p class="lead"><span class="h3">  {{__('admin_message.signed contract')}} :</span><a download
                                    href="{{asset('storage/'.$client->signed_contract)}}">تحميل</a></p>
                            @endif
                            
                            @if($client->commercial_register !=NULL)
                            
                            <p class="lead"><span class="h3"> السجل التجارى:</span><a download
                                    href="{{asset('storage/'.$client->commercial_register)}}">تحميل</a></p>
                            @endif
                            @if($client->commercial_register !=NULL)
                            <p class="lead"><span class="h3"> الشهادة الضريبة:</span> <a download
                                    href="{{asset('storage/'.$client->commercial_register)}}">تحميل</a>
                                @endif
                            </p>
                        </div>
                        <div class="tab-pane" id="address">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>city</th>
                                        <th>phone</th>
                                        <th>address</th>
                                        <th>details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1 ?>
                                    @foreach ($addresses as $address)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{$address->city?->title}}</td>
                                        <td>{{$address->phone}} </td>
                                        <td>{{$address->address}}</td>
                                        <td>{{$address->description}}</td>
                                    </tr>
                                    <?php $count++ ?>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                        <div class=" tab-pane" id="balance">
                            <button type="button" class="btn btn-info pull-center" data-toggle="modal"
                                data-target="#add-money">
                                <i class="fa-solid fa-money-bill"></i>
                                Deposit
                            </button>
                            <button type="button" class="btn btn-danger pull-center" data-toggle="modal"
                                data-target="#Withdraw">
                                <i class="fa-solid fa-money-bill"></i>
                                Withdraw
                            </button>
                            <!--  -->
                            <table class=" table table-bordered table-striped ">
                                <tr>
                                    <th>All Debtor</th>
                                    <td>{{$count_debtor}}</td>
                                </tr>
                                <tr>
                                    <th>Order Debtor</th>
                                    <td>{{$count_order_debtor}}</td>
                                </tr>
                                <tr>
                                    <th>All Creditor</th>
                                    <td>{{$count_creditor}}</td>
                                </tr>
                                <tr>
                                    <th>Order Creditor</th>
                                    <td>{{$count_order_creditor}}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="add-money">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Money To Client Account</h4>
            <form action="{{route('transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="debtor">

                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{$client->id}}">

                        @error('user_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Amount</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('order.Close')</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- withdrow -->
<div class="modal fade" id="Withdraw">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Money To Client Account</h4>
            <form action="{{route('transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="creditor">
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{$client->id}}">

                        @error('user_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Amount</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('order.Close')</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

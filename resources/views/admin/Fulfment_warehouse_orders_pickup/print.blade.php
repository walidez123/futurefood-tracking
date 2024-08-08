@extends('layouts.master')
@section('pageTitle', 'Order : #')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => __('app.order', ['attribute' => '']),
            'type' => __('app.view'),
            'iconClass' => 'fa-truck',
            'url' => route('orders.index'),
            'multiLang' => 'false',
        ])
        <style>
            .page-logo {
                width: 250px;
                height: 100px;
                display: none;
            }

            table {
                font-family: Arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 25px;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: right;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }

            span.h4 {
                float: right;
                height: 60px;
            }

            @media print {

                .page-header,
                .main-footer,
                .printhidden,
                #send-notification {
                    display: none;
                }

                .page-logo {
                    display: block;
                }

                table {
                    width: 100%;
                }
            }

            text {
                text-align: center;
            }

            .invoice-col {
                width: 10cm;
                height: 15Cm;


                font-size: 12px
            }

            .border {
                border: 1px solid #000
            }
        </style>


        <div class="row no-print ">
            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
                    @lang('app.print')</a>
            </div>
        </div>

        @if (!empty($orders) && count($orders) > 0)
            @foreach ($orders as $order)
                <section class="invoice">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-lg-12 invoice-col ">
                                <div class="col-xs-12 col-md-12 col-lg-12 border"
                                    style="height: 70px; padding: 5px; display: flex; align-items: center;">
                                    <img src="{{ asset('storage/' . $order->user->company->logo) }}" class="img-responsive"
                                        width="50" style="margin-right: 10px;">
                               </div>
                                
                                <div class="col-xs-12 col-md-12 col-lg-12 text-center border"
                                    style="height: 30px; padding:5px">
                                    order number : {{ $order->order_id }}
                                </div>
                                

                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 25px;padding:5px">
                                    Client Info
                                </div>
                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 90px;padding:5px">
                                    @if ($order->reference_number != null)
                                        @lang('admin_message.reference_number'): {{ $order->reference_number }}
                                    @endif
                                    <br>
                                    @lang('admin_message.client_name'): {{ $order->user->store_name }}
                                    <br>
                                    @lang('order.phone'): {{ $order->user->phone }} <br>
                                    @lang('order.address'):{{ !empty($order->address) ? $order->address->address : '' }} <br>

                                </div>
                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 25px;padding:5px">
                                    {{-- RECIVER INFO --}}
                                </div>

                                <div class="col-xs-12 col-md-12 col-lg-12 border" style="height: 90px;padding:5px">
                                    @lang('goods.warehouse_branch') : {{ $order->warehouse->trans('title') }} <br>
                                    {{ __('admin_message.Storage types') }} : {{ $order->storage_types == 1 ? __('admin_message.pallet') : __('admin_message.Carton') }}<br>
                                    {{ __('admin_message.Sizes') }} : {{ !empty($order->size) ? $order->size->trans('name') : '' }}<br>
                                    {{ __('admin_message.Delivery Service') }} : {{ $order->delivery_service == 1 ? __('admin_message.Yes') : __('admin_message.No') }}
                                </div>

                                <div class="col-xs-12 col-md-12 col-lg-12 text-center border"
                                    style="height: auto; padding:5px;width:100%">

                                    {{ __('admin_message.Tracking Number') }} :
                                    <br> {{ $order->tracking_id }}
                                </div>


                                <div class="col-xs-12 col-md-12 col-lg-12 text-center border"
                                    style="height: auto; padding:5px;width:100%">

                                    @if($order->pickup_orders_good)
                                        @foreach($order->pickup_orders_good as $good) 
                                        <div class="col-xs-6 col-lg-6 col-md-6 "> {{ __("goods.skus")}} : {{$good->good->SKUS}} ({{$good->number}}) pices  <br>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                           
                        </div>

                    </div>
            </div>
        </div>
    </section>
    @endforeach
    @endif
</div><!-- /.content-wrapper -->
@endsection

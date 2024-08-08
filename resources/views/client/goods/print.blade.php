@extends('layouts.master')
@section('pageTitle', 'Order : #' . $Good->id)
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => trans('goods.product'),
            'type' => trans('goods.print'),
            'iconClass' => 'fa-truck',
            'url' => route('goods.index'),
            'multiLang' => 'false',
        ])
        <!-- Main content -->
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

        <section class="invoice">

            <div class="row invoice-info">

                <!-- /.col -->

                <div class="col-xs-12 col-md-12 col-lg-12  invoice-col">
                    <div class="col-xs-12 col-md-12 col-lg-12 ">
                             <table>
                                <tr>
                             <th>{{__('goods.photo')}}</th>
                              @if($Good->image=="avatar/avatar.png" || $Good->image==NULL)
                                <td><img class="" src="{{asset('storage/'.$webSetting->logo)}}" height="75"
                                        width="100"></td>

                                @else
                                <td><img class="" src="{{asset('storage/'.$Good->image)}}" height="75"
                                        width=""></td>

                                @endif
                                </tr>
                                <tr>
                                <th>@lang('goods.name')</th>

                                <td>{{$Good->trans('title')}}</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.skus')</th>

                                <td>{{$Good->SKUS}}</td>

                                </tr>


        </table>



                    </div>
                </div>
            </div>

        </section>
        <div class="row no-print">

            <div class="col-xs-12">
                <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
                    طباعة</a>
            </div>
        </div>
        <!-- /.content -->

        <!-- /.modal-dialog -->
    </div>
    </div><!-- /.content-wrapper -->
@endsection

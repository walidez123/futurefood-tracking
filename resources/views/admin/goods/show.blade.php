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
            'type' => trans('goods.show'),
            'iconClass' => 'fa-truck',
            'url' => route('goods.index'),
            'multiLang' => 'false',
        ])
        <!-- Main content -->
        <style>
            .page-logo {
                display: none;
            }

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 25px
            }

            td,
            th {
                border: 1px solid #dddddd;
                text-align: RIGHT;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }

            span.h4 {
                float: right;
                highet: 60px;
            }

            @media print {
                .page-header {
                    display: none;
                }

                .page-logo {
                    display: block;
                }




                span.h4 {
                    float: right;
                    highet: 60px;
                }


                @page {
                    size: auto;
                    /* auto is the initial value */
                    margin: 0;
                    /* this affects the margin in the printer settings */
                }

                .main-footer {
                    display: none;
                }

                .printhidden {
                    display: none;
                }
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
                                <th>@lang('goods.client_name')</th>
                                <td>@if($Good->client){{$Good->client->store_name}} @else --  @endif</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.skus')</th>

                                <td>{{$Good->SKUS}}</td>

                                </tr>

                               
                                <tr>
                                <th>@lang('goods.category')</th>

                                <td>                                    {{ is_null($Good->category) ? '' : $Good->category->trans('title') }}
</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.description')</th>

                                <td>{!!$Good->trans('description')!!}</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.length')</th>

                                <td>{{$Good->length}}</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.width')</th>

                                <td>{{$Good->width}}</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.height')</th>

                                <td>{{$Good->height}}</td>

                                </tr>
                                <tr>
                                <th>@lang('goods.expire_date_exit')</th>

                                <td>{{$Good->has_expire_date==1 ? __('admin_message.Yes') : __('admin_message.No')  }}
                                 </td>

                                </tr>
                                @if($Good->has_expire_date==1 )
                                <tr>
                                <th>@lang('goods.expire_date')</th>

                                <td>{{$Good->has_expire_date==1 ? $Good->expire_date : ''  }}
                                 </td>

                                </tr>
                                @endif



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

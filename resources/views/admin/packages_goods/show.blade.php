@extends('layouts.master')
@section('pageTitle', __('admin_message.Packaging goods/cartons'))
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
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin_message.Client name')</th>
                                        <th>@lang('admin_message.Warehouse Name')</th>
                                        <th>@lang('goods.Goods')</th>
                                        <th>@lang('admin_message.number')</th>
                                        <th>@lang('admin_message.order')</th>
                                        <th>@lang('admin_message.Date')</th>


                                        <!-- <th>@lang('admin_message.')</th> -->

                                        <th>@lang('app.control')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($Packages_historys->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($Packages_historys->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($Packages_historys as $Packages_history)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $packages_good->client->name }}</td>

                                            <td>{{ $packages_good->warehouse->trans('title') }}</td>

                                            <th>{{!empty( $packages_good->good) ? $packages_good->good->trans('title') : ''}}</th>
                                            <th>{{ $Packages_history->number }}</th>
                                            <th>
                                                @if ($Packages_history->order != null)
                                                    <a href="{{ route('client-orders.show', $Packages_history->order->id) }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer">{{ $Packages_history->order->order_id }}</a>
                                                @endif
                                                @if ($Packages_history->Pickup_order != null)
                                                    <a href="{{ route('client_orders_pickup.show', $Packages_history->Pickup_order->id) }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer">{{ $Packages_history->Pickup_order->order_id }}</a>
                                                @endif
                                                
                                            </th>
                                            <th>{{ $Packages_history->created_at }}</th>


                                            <th>
                                                @if($Packages_history->type==1)
                                            {{__('admin_message.addition')  }}
                                            @elseif($Packages_history->type==2)
                                           {{ __('admin_message.pulls up')}}
                                           
                                           @elseif($Packages_history->type==3)
                                           {{ __('admin_message.restocking to the warehouse')}}
                                           @elseif($Packages_history->type==4)
                                           {{ __('admin_message.pulls up damage goods')}}

                                           @endif

                                            </th>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin_message.Client name')</th>
                                        <th>@lang('admin_message.Warehouse Name')</th>
                                        <th>@lang('goods.Goods')</th>
                                        <th>@lang('admin_message.number')</th>
                                        <th>@lang('admin_message.order')</th>
                                        <th>@lang('admin_message.Date')</th>
                                        <!-- <th>@lang('admin_message.')</th> -->

                                        <th>@lang('app.control')</th>

                                        <!-- <th>@lang('app.control')</th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                        {{ $Packages_historys->appends(Request::query())->links() }}
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

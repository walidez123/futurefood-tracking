@extends('layouts.master')
@section('pageTitle', __('admin_message.Packaging goods/cartons'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <div class="row text-center" style="padding:12px">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form action="{{route('packages_good.product_search')}}" method="GET">
                            <input type="hidden" name="type" value="ship">

                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label for="to">{{__('admin_message.Warehouse Branches')}}</label>
                                    <select id="warhouse_id" value="" class="form-control select2" name="warhouse_id">
                                        <option value="">{{__('admin_message.Select')}}
                                            {{__('admin_message.Warehouse Branches')}}</option>
                                        @foreach ($warehouse_branchs as $warhouse)
                                        <option {{ isset($warehouse_branch) && $warehouse_branch==$warhouse->id ?
                                            'selected' : '' }} value="{{$warhouse->id}}">{{$warhouse->trans('title')}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label for="to">@lang('goods.Goods') (@lang('goods.name') /
                                        @lang('goods.skus'))</label>
                                        <select id="goods" value="" class="form-control select2" name="goods">
                                            <option value="">{{__('admin_message.Select')}}
                                                {{__('goods.name')}}</option>
                                            @foreach ($goods as $good)
                                            
                                                <option {{ isset($single_good) && $single_good==$good->id ?
                                                 'selected' : '' }} value="{{$good->id}}">{{$good->trans('title')}} | {{$good->SKUS}}
                                                </option>
                                            @endforeach
    
                                        </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">

                                    <label>@lang('order.from_date')</label>
                                    <input type="date" name="from" value="{{(isset($from))? $from : ''}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label for="to">@lang('order.to_date')</label>
                                    <input type="date" name="to" value="{{(isset($to))? $to : ''}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>@lang('admin_message.search')</label>
                                    <input type="submit" class="btn btn-block btn-primary"
                                        value="@lang('admin_message.filter')" />
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        @if(isset($totalGoodsCount))
                        <label>العدد الموجود في المستودع :  {{ $totalGoodsCount }}</label></br></br>
                    </br>@endif
                        <table id="example1" class="table table-bordered table-striped" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('goods.product_name')</th>
                                    <th>@lang('admin_message.number')</th>
                                    <th>@lang('app.Shelf_num')</th>
                                    <th>@lang('goods.date')</th>
                                    <th>@lang('goods.expire_date')</th>
                                    <th>@lang('admin_message.Warehouse Name')</th>
                                    <th>@lang('app.control')</th>



                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($packages_goods))
                                <?php 
        if($packages_goods->currentPage()==1){
            $count = 1; 

        }else{
            $count=(($packages_goods->currentPage()-1)*25)+1;
        }
        ?>
                                @foreach ($packages_goods as $packages_good)
                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{!empty( $packages_good->good) ? $packages_good->good->trans('title') : ''}}|
                                                {{!empty( $packages_good->good) ? $packages_good->good->SKUS : ''}}</td>
                                    <th>{{$packages_good->number}}</th>
                                    <th>{{$packages_good->package->title}}</th>
                                    <td>{{ \Carbon\Carbon::parse($packages_good->created_at)->format('Y-m-d') }}</td>
                                    <td> @if($packages_good->expiration_date !=NULL)
                                   <span style="color: red;"> {{$packages_good->expiration_date ? $packages_good->expiration_date : '' }}</span>
                                    @endif
                                </td>
                                    <td>{{$packages_good->warehouse!=NULL ? $packages_good->warehouse->trans('title'):''}}</td>
                                    <td>   <a href="{{ route('packages_goods_client.show', $packages_good->id) }}" title="View"
                      class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span
                        class="hidden-xs hidden-sm">{{ __('admin_message.details') }}</span>
                    </a>
                  </td>

                                    
                                </tr>
                                <?php $count++ ?>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('goods.product_name')</th>
                                    <th>@lang('admin_message.number')</th>
                                    <th>@lang('app.Shelf_num')</th>
                                    <th>@lang('goods.date')</th>
                                    <th>@lang('goods.expire_date')</th>
                                    <th>@lang('admin_message.Warehouse Name')</th>
                                    <th>@lang('app.control')</th>


                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                    @if(isset($packages_goods))
                        {!! $packages_goods->appends($_GET)->links() !!}
                        @endif
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

@endsection
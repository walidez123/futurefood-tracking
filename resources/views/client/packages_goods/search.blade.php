@extends('layouts.master')
@section('pageTitle', 'orders')
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
                        <form action="{{route('packages_good.client_Search')}}" method="GET">
                        <input type="hidden" name="type" value="ship">

                            <div class="col-lg-3">
                            <div class="form-group ">

                                <label>@lang('order.from_date')</label>
                                <input type="date" name="from" value="{{(isset($from))? $from : ''}}"
                                    class="form-control" >
                            </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label for="to">@lang('order.to_date')</label>
                                    <input type="date" name="to" value="{{(isset($to))? $to : ''}}" class="form-control"
                                        >
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
                                @foreach ($packages_goods as $single_good)

                                <tr>
                                    <td>{{$count}}</td>
                                    <td>{{!empty( $single_good->good) ? $single_good->good->trans('title') : ''}}|
                                                {{!empty( $single_good->good) ? $single_good->good->SKUS : ''}}</td>
                                    <th>{{$single_good->number}}</th>
                                    <th>{{$single_good->package->title}}</th>
                                    <td>{{ \Carbon\Carbon::parse($single_good->created_at)->format('Y-m-d') }}</td>
                                    <td> @if($single_good->expiration_date !=NULL)
                                   <span style="color: red;"> {{$single_good->expiration_date ? $single_good->expiration_date : '' }}</span>
                                    @endif
                                </td>
                                    <td>{{$single_good->warehouse!=NULL ? $single_good->warehouse->trans('title'):''}}</td>  
                                    <td>   <a href="{{ route('packages_goods_client.show', $single_good->id) }}" title="View"
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

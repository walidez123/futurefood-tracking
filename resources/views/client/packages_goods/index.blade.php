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
                  <!-- <th>@lang('admin_message.Client name')</th> -->
                  <th>@lang('admin_message.Warehouse Name')</th>
                  <th>@lang('goods.Goods')</th>
                  <th>@lang('admin_message.number')</th>

                  <th>@lang('admin_message.Expiration date')</th>

                  @if($type==1)
                 <th>@lang('app.packages')</th>
                 @else
                 <th>@lang('app.Shelves')</th>


                 @endif

                  <th>@lang('app.control')</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($client_packages_goods as $client_packages_good)
                <tr>
                <td>{{$count}}</td>

                  <td>{{$client_packages_good->warehouse->trans('title')}}</td>
              
                 <th>{{!empty( $client_packages_good->good) ? $client_packages_good->good->trans('title') : ''}}</th>
                 <th>{{$client_packages_good->number}}</th>
                 <th>{{$client_packages_good->expiration_date}}</th>

                 <th>{{$client_packages_good->package->title}}</th>
                 <th>   <a href="{{ route('packages_goods_client.show', $client_packages_good->id) }}" title="View"
                      class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span
                        class="hidden-xs hidden-sm">{{ __('admin_message.details') }}</span>
                    </a>
                  </th>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                <th>#</th>
                  <!-- <th>@lang('admin_message.Client name')</th> -->
                  <th>@lang('admin_message.Warehouse Name')</th>
                  <th>@lang('goods.Goods')</th>
                  <th>@lang('admin_message.number')</th>
                  <th>@lang('admin_message.Expiration date')</th>
                  @if($type==1)
                 <th>@lang('app.packages')</th>
                 @else
                 <th>@lang('app.Shelves')</th>

                 @endif

                  <th>@lang('app.control')</th>
   
                </tr>
              </tfoot>
            </table>

          </div><!-- /.box-body -->
          <!--  -->
          {{ $client_packages_goods->appends(Request::query())->links() }}

        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

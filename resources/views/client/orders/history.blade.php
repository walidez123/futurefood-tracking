@extends('layouts.master')
@section('pageTitle', 'order history')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  @include('layouts._header-index', ['title' => __('app.order', ['attribute' => '']), 'iconClass' => 'fa-map-marker', 'addUrl' => '', 'multiLang' => 'false'])

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
                  <th>@lang('app.status')</th>
                  <th>{{ __("admin_message.user type")}}</th>
                  <th>{{ __("admin_message.Notes")}}</th>
                  <th>@lang('app.date')</th>
                </tr>
              </thead>
              <tbody>
                  <?php $count = 1 ?>
                @foreach ($histories as $history)
                <tr>
                  <td>{{$count}}</td>
                  <td>{{ ! empty($history->status) ? $history->status->trans('title') : '' }}</td>
                  <td>
                    @if(! empty($history->user))
                      @if($history->user->user_type=="client")
                      {{$history->user->store_name}}

                      @elseif($history->user->user_type=="admin" )
                      {{-- @lang('app.Shipping company') --}}
                      {{$history->user->company->store_name}}

                      @elseif($history->user->user_type=="delegate" || $history->user->user_type=="super_admin")
                      {{ ! empty( Auth()->user()->company) ? Auth()->user()->company->store_name : '' }}
                      @endif
                    @endif
                  
                  </td>
                  <td>{{$history->notes}}</td>

                  <td>
                  <!-- <a href="{{route("track.order",['tracking_id'=>$order->tracking_id])}}" target="_blank" rel="noopener noreferrer">  <i class="fa-solid fa-truck"></i> @lang('website.tracking')</a> -->

                    {{$history->dateFormatted('created_at', true)}}</td>

                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                    <th>#</th>
                    <th>@lang('app.status')</th>
                    <th>{{ __("admin_message.user type")}}</th>
                  <th>{{ __("admin_message.Notes")}}</th>
                    <th>@lang('app.date')</th>
                </tr>
              </tfoot>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
        <div class="col-xs-12">
            <a class="btn btn-info" href="{{route('orders.index')}}"><i class="fa fa-reply-all"></i> @lang('app.orders', ['attribute' => ''])</a>
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->
@endsection

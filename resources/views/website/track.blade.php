@extends('website.layouts.master')
@section('pageTitle', __('website.contact_us'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1 class="page-title-heading ar">تتبع الطلب / track order</h1>

                </div><!-- /.breadcrumbs -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->
@if(isset($orderHistory))
<section class="flat-row flat-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h3>@lang('app.order', ['attribute' => __('app.id')]) : <span>{{$orderDetails->order_id}}</span></h3>
                <h3>@lang('app.name', ['attribute' => '']) : <span>{{$orderDetails->receved_name}}</span></h3>
            </div>

            <table class="table table-striped table-bordered col-xs-12" style="margin-top: 20px;">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>@lang('app.status')</th>
                    <th>@lang('app.detials', ['attribute' => ''])</th>
                    <td>التاريخ </td>
                </tr>
                </thead>
                <tbody>
                <?php $count = 1 ?>
                @foreach($orderHistory as $order)
                <tr>
                    <td>{{$count}}</td>
                    <td> {{! empty($order->status) ? $order->status->trans('title') : ''}}</td>
                    <td> {{! empty($order->status) ? $order->status->description : ''}}</td>
                    <td>{{$order->updated_at}}</td>
                </tr>
                <?php $count++ ?>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-contact -->
@elseif(isset($track_num))

    <center>
       <h2 class="text-red"> {{__('not found results for this number')}} : {{$track_num}}</h2>
    </center>
@else
<div class="bi-team-details-contact-form wow fadeInRight">
                                    <form action="{{route('track.order')}}"  method="get">
                                    <!-- @csrf -->

                                    
                                       
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="tracking_id" value="{{ old('tracking_id') }}" size="40"
                                                placeholder="@lang('website.tracking_id')" required>
                                                    @error('tracking_id')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>
                                         
                                       
                                        
                                    
                                            <div class="col-md-12">
                                                <div class="bi-submit-btn">
                                                    <button type="submit" class="button-form-qoute">@lang('website.send')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
					         </div>
@endif
@endsection

@extends('website.layouts.master')
@section('pageTitle', __('website.rate_order'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1 class="page-title-heading ar text-right" style="    text-align: right !important;">قيم الخدمة</h1>

            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->

<section class="flat-row flat-contact" style="    padding: 30px 0;">
    <div class="container">
        <div class="row">
            <form class="col-xs-12 col-md-12" action="{{url('order/rate/'.$order_no.'/'.$mobile.'/')}}" method="POST" accept-charset="utf-8">

                @csrf
                <div class="form-request-qoute" style="padding: 0px 15px;">
                    
                    <div class="flat-wrap-form">
                        <div class="flat-wrap-input">
                            <input type="text" name="order_no" value="{{ $order_no ? $order_no : old('order_no') }}" 
                            readonly aria-invalid="false"  required>
                            
                        </div>
                        <div class="flat-wrap-input">
                            <input type="text" name="name" value="{{ $name ? $name : old('name') }}"  aria-invalid="false"
                                placeholder="@lang('website.name')"  readonly required>
                            @error('name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                   
                        <div class="flat-wrap-input">
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5"  />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="text">1 star</label>
                              </div>
                          </div>
                        <div class="flat-wrap-input">
                            <textarea type="text" name="review" value="{{ old('review') }}" rows="10"
                                placeholder="@lang('website.review')"  required></textarea>
                            @error('review')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div><!-- /.flat-wrap-form -->
                    <p class="center">
                        <button type="submit" class="button-form-qoute">@lang('website.send_request')</button>
                    </p>
                </div><!-- /.form-qoute -->
            </form><!-- /.form -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-contact -->

@endsection

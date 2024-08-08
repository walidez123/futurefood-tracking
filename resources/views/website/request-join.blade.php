@extends('website.layouts.master')
@section('pageTitle', __('website.request_join'))
@section('content')

<!-- Start of breadcrumb section
	============================================= -->
<section id="bi-breadcrumbs" class="bi-bredcrumbs-section position-relative"
    data-background="{{asset('assets_web/img/bg/bread-bg.jpg')}}">
    <div class="background_overlay"></div>
    <div class="container">
        <div class="bi-breadcrumbs-content headline ul-li text-center">
            <h2>@lang('website.joinus')
            </h2>
            <ul>
                <li><a href="{{url('/')}}">@lang('website.home')</a></li>
                <li>@lang('website.joinus')</li>
            </ul>
        </div>
    </div>
</section>
<!-- End of breadcrumb section
	============================================= -->

<section class="flat-request-qoute" style="padding-top: 50px; padding-bottom:50px">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="image">

                    <img src="{{asset('assets_web/img/new_home/about/joinus.jpg')}}" />
                </div>
            </div><!-- /.col-sm-6 -->
            <div class="col-lg-6 col-sm-12">
                <!--  -->
                @if ($errors->any())
            <div class="alert alert-success">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

                <!--  -->
                <form action="{{route('join.store')}}" method="POST" accept-charset="utf-8">
                    @csrf
                    <div class="form-request-qoute">
                        <div class="request-qoute-title">
                            @lang('website.request_join')
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">@lang('website.name')</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" size="40"
                                    aria-invalid="false" placeholder="@lang('website.name')" required>
                                @error('name')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('website.email')</label> <input type="email"
                                    class="form-control" name="email" value="{{ old('email') }}" size="40"
                                    aria-invalid="false" placeholder="@lang('website.email')" required>
                                @error('email')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('website.phone')</label> <input type="text" class="form-control"
                                    name="phone" value="{{ old('phone') }}" size="40"
                                    placeholder="@lang('website.phone')" required>
                                @error('phone')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('website.website')</label> <input type="text"
                                    class="form-control" name="website" value="{{ old('website') }}" size="40"
                                    placeholder="@lang('website.website')">
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('website.store')</label> <input type="text" class="form-control"
                                    name="store" value="{{ old('store') }}" size="40"
                                    placeholder="@lang('website.store')" required>
                                @error('store')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('website.address')</label>

                                <input type="text" class="form-control" name="address" value="{{ old('address') }}"
                                    size="40" placeholder="@lang('website.address')" required>
                                @error('address')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="name">@lang('website.services')</label>
                            <br>

                                @foreach($services as $service )
                                <input type="checkbox" name="services[]" value="{{$service->id}}"  id=""> {{$service->Trans('title')}}

                                @endforeach



                            </div>

                            @if(config('services.recaptcha.key'))
                           <div class="g-recaptcha"
                             data-sitekey="{{config('services.recaptcha.key')}}">
                          </div>
                            @endif

                        </div><!-- /.flat-wrap-form -->
                        <br>

                        <div class=" footer">
                            <button type="submit" class="btn btn-primary">@lang('website.send_request')</button>
                        </div>
                    </div><!-- /.form-qoute -->
                </form><!-- /.form -->
            </div><!-- /.col-sm-6 -->
        </div>
    </div>
</section>
@endsection
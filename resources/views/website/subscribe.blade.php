@extends('website.layouts.master')
@section('pageTitle', __('website.subscribe'))
@section('content')


<!-- Start of breadcrumb section
	============================================= -->
<section id="bi-breadcrumbs" class="bi-bredcrumbs-section position-relative"
    data-background="{{asset('assets_web/img/bg/bread-bg.jpg')}}">
    <div class="background_overlay"></div>
    <div class="container">
        <div class="bi-breadcrumbs-content headline ul-li text-center">
            <h2> @lang('website.subscribe')</h2>
            <ul>
                <li><a href="{{url('/')}}">@lang('website.home')</a></li>
                <li>@lang('website.subscribe')</li>
            </ul>
        </div>
    </div>
</section>
<section class="flat-request-qoute" style="padding-top: 50px; padding-bottom:50px">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="image">

                    <img src="{{asset('assets_web/img/new_home/about/joinus.jpg')}}" />
                </div>
            </div><!-- /.col-sm-6 -->
            <div class="col-lg-6 col-sm-12">

                @if ($errors->any())
                <div class="alert alert-success">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
            </div>
            <form action="{{ route('subscribe.store') }}" method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">@lang('website.service_name')</label>
                        <input class="form-control" type="text" name="service_name" placeholder="Service Or Solution Name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="">@lang('website.company_name')</label>

                        <input class="form-control" type="text" name="company_name" placeholder="Company Name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="">@lang('website.industry')</label>

                        <input class="form-control" type="text" name="industry" placeholder="Industry" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="">@lang('website.user_name')</label>

                        <input class="form-control" type="text" name="user_name" placeholder="Your Name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="">@lang('website.phone_number')</label>

                        <input class="form-control" type="tel" name="phone_number" placeholder="Phone Number" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="">@lang('website.email')</label>

                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="">@lang('website.additional_info')</label>

                                <textarea name="additional_info" placeholder="Additional Information"></textarea>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit">@lang('website.Subscribe')</button>
                                    </div>
                                </div>
            </form>


            @endsection
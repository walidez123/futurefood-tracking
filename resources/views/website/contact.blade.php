@extends('website.layouts.master')
@section('pageTitle', __('website.contact_us'))
@section('content')
 

<!-- Start of breadcrumb section
	============================================= -->
	<section id="bi-breadcrumbs" class="bi-bredcrumbs-section position-relative" data-background="{{asset('assets_web/img/bg/bread-bg.jpg')}}">
		<div class="background_overlay"></div>
		<div class="container">
			<div class="bi-breadcrumbs-content headline ul-li text-center">
				<h2> @lang('website.contact_us')</h2>
				<ul>
					<li><a href="{{url('/')}}">@lang('website.home')</a></li>
					<li>@lang('website.contact_us')</li>
				</ul>
			</div>
		</div>
	</section>	
<!-- Start of breadcrumb section
	============================================= -->
    @if ($errors->any())
            <div class="alert alert-success">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
   

<!-- Start of contact info section
	============================================= -->
	<section id="bi-contact-info" class="bi-contact-info-section inner-page-padding">
		<div class="container">
			<div class="bi-contact-info-content">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6">
						<div class="bi-contact-info-item position-relative">
							<span class="info-bg position-absolute" data-background="{{asset('assets_web/img/bg/ci-bg1.png')}}"></span>
							<div class="inner-icon d-flex justify-content-center align-items-center">
								<img src="{{asset('assets_web/img/icon/ci2.png')}}" alt="">
							</div>
							<div class="inner-text headline pera-content">
								<h3> @lang('website.email')</h3>
								<a href="#"> {{$webSetting->email}}</a>
								 
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="bi-contact-info-item position-relative">
							<span class="info-bg position-absolute" data-background="{{asset('assets_web/img/bg/ci-bg1.png')}}"></span>
							<div class="inner-icon d-flex justify-content-center align-items-center">
								<img src="{{asset('assets_web/img/icon/ci1.png')}}" alt="">
							</div>
							<div class="inner-text headline pera-content">
								<h3> @lang('website.phone')</h3>
								<a href="tel: {{$webSetting->phone}}"> {{$webSetting->phone}}</a>
							 
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="bi-contact-info-item position-relative">
							<span class="info-bg position-absolute" data-background="{{asset('assets_web/img/bg/ci-bg1.png')}}"></span>
							<div class="inner-icon d-flex justify-content-center align-items-center">
								<img src="{{asset('assets_web/img/icon/ci3.png')}}" alt="">
							</div>
							<div class="inner-text headline pera-content">
								<h3>@lang('website.address')</h3>
								<a href="#"> {{$webSetting->Trans('address')}}</a>
								 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
<!-- End of contact info section
	============================================= -->




<!-- Start of contact Form section
	============================================= -->
	<section   class="bi-contact-form-section">
		<div class=" container">
	      <div class="bi-contact-map-content d-flex flex-wrap">
			   
          <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="bi-team-details-contact-title">
                                 <div class="section-subtitle-2-wrap">
                                    <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-1.png')}}" alt="" class="icon-1">
                                    <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-2.png')}}" alt="" class="icon-2">
                                    <h6 class="hero-2-subtitle">@lang('website.contact_us')</h6>
                         
                                    </div>
                                <div class="bi-team-details-contact-form wow fadeInRight">
                                    <form action="{{route('contact.store')}}"  method="post">
                                    @csrf

                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="name" value="{{ old('name') }}" size="40" aria-invalid="false"
                                                placeholder="@lang('website.name')" required>
                                                    @error('name')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <input type="email" name="email" value="{{ old('email') }}" size="40"
                                                aria-invalid="false" placeholder="@lang('website.email')" required>
                                                    @error('email')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="phone" value="{{ old('phone') }}" size="40"
                                                placeholder="@lang('website.phone')" required>
                                                    @error('phone')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                            </div>
                                         
                                            <!-- <div class="col-md-12 col-lg-6">
                                                <input type="text" name="store" value="{{ old('store') }}" size="40"
                                                placeholder="@lang('website.store')" required>
                                                @error('store')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div> -->
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="subject" value="{{ old('subject') }}" size="40"
                                                placeholder="@lang('website.subject')" required>
                                                @error('subject')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <textarea type="text" name="message" value="{{ old('message') }}" size="40"
                                                placeholder="" required>@lang('website.message') </textarea>
                                                @error('message')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="bi-submit-btn">
                                                    <button type="submit" class="button-form-qoute">@lang('website.contact_us')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
					         </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 wow fadeInLeft">
                        <img src="{{asset('assets_web/img/new_home/about/contactus.png')}}" alt="">

                        
                        </div>
                    </div>	 
			 
		   </div>
		</div>
 
</section>		
  



 
@endsection

 
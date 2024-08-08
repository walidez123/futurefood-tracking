@extends('website.layouts.master')
@section('pageTitle', __('website.services'))
@section('content')
 

<!-- Start of breadcrumb section
	============================================= -->
	<section id="bi-breadcrumbs" class="bi-bredcrumbs-section position-relative" data-background="{{asset('assets_web/img/bg/bread-bg.jpg')}}">
		<div class="background_overlay"></div>
		<div class="container">
			<div class="bi-breadcrumbs-content headline ul-li text-center">
				<h2> @lang('website.faqs')</h2>
				<ul>
					<li><a href="{{url('/')}}">@lang('website.home')</a></li>
					<li>@lang('website.faqs')</li>
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
   

<!-- Start of Service Feed section
	============================================= -->
	<section id="bi-service-feed" class="bi-service-feed-section  ">
        
      
		<div class="container">
			<div class="bi-section-title-1 text-center headline pera-content">
                
				<h2 class="headline-title">
                @lang('website.faqs')
				</h2>
			</div>
			<div class="bi-service-feed-content">
				<div class="row justify-content-center ">
                @foreach ($faqs as $i=>$faq)
					<div class="col-lg-4 col-md-12  wow fadeInUp">
						<div class="bi-service-feed-item position-relative" >
							<span class="hover_img position-absolute" data-background="{{asset('assets_web/img/service/ser1.jpg')}}"></span>
							<span class="serial-number position-absolute">0{{$i+1}}</span>
						
							<div class="service-text headline pera-content">
								<h3>{{$faq->Trans('question')}} </h3>
								<p>
                                {!!$faq->Trans('answer')!!}    </p>
 							</div>
						</div>
					</div>
                  @endforeach

                   
                    
				</div>
			</div>
		</div>
	</section>
<!-- End of Service Feed section
	============================================= -->





  



 
@endsection

 
@extends('website.layouts.master')
@section('pageTitle', __('website.home'))
@section('content')





<div id="main">
        <div id="smooth-content" >
               <!-- hero-start -->
            <div class="hpt-hero-2-area">
                    <div class="swiper hpt-hero-2-slider-wrapper">
                        <div class="swiper-container hero_2_slider_active">
                            <div class="swiper-wrapper">
                            <?php $count = 1 ?>
                    @foreach ($sliders as $slider)
                                <!-- single-slider -->
                                <div class="swiper-slide">
                              
                                    <div class="hpt-hero-2-slider-item">

                                        <div class="hero-2-bg-img">
                                        <img src="{{asset('assets_web/img/new_home/bg-shape/hero-2-bg-img-1.png')}}" alt="">
                                           
                                        </div>

                                        <div class="container h1-container">
                                        
                                            <div class="hpt-hero-2-slider-content">
                                                <div class="hero-2-subtitle-wrap " data-animation="fadeInUp" data-duration="1s">
                                                    <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-1.png')}}" alt="" class="icon-1">
                                                    <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-2.png')}}" alt="" class="icon-2">
                                                    <h6 class="hero-2-subtitle">@lang('website.welcome')  {{$webSetting->Trans('title')}}</h6>
                                                </div>
                                                <h1 class="hero-2-title" data-animation="fadeInUp" data-duration="1s" data-delay=".5s"> {{$slider->Trans('title')}}</h1>
                                                <p class="hero-2-pera" data-animation="fadeInUp" data-duration="1s" data-delay=".8s">
                                                {{$slider->Trans('details')}}
                                                  </p>

                                                <!-- hero-btn -->
                                                <div class="hero-2-btn-wrap" data-animation="flipInX" data-duration="1s" data-delay="1s">
                                                    <a class="hpt-btn-3" href="{{$slider->btn_link}}">
                                                    {{$slider->Trans('btn_title')}}
                                                        <span class="icon"><i class="fal fa-chevron-double-right"></i></span>
                                                    </a>

                                                    
                                                </div>
                                            </div>

                                        </div>

                                        <div class="hero-2-img-1">
                                                 <img src="{{asset('storage/'.$slider->image)}}" alt="">

                                        </div>

                                        <span class="hero-2-shape-1"></span>

                                        <div class="hero-2-curcle-position">
                                            <div class="hero-2-curcle">
                                           
                                                <img src=" {{asset('assets_web/img/new_home/bg-shape/hero-2-curcle-1.png')}}" alt="">
                                            </div>
                                        </div>

                                    </div>
                                   


                                </div>  
                                <?php $count++ ?>
                                     @endforeach                       
                            </div>
                        </div>
                    </div>

                    <div class="horo-2-pagination">

                    </div>
                    </div>
                    <!-- hero-end -->
        </div>
</div>
   <!-- about-start -->
   <div class="container">
     <div class="row">
         <div class="col-lg-12 text-center wow fadeIn">
            <img src="{{asset('assets_web/img/new_home/hero/labtop.png')}}" class="img-responsive"/>
         </div>
     </div>
   </div>

<!-- Start of Service Feed section
	============================================= -->
	<section id="bi-service-feed" class="bi-service-feed-section  ">
        
      
		<div class="container">
			<div class="bi-section-title-1 text-center headline pera-content">
                
				<h2 class="headline-title">
                @lang('website.what_we_do')
				</h2>
			</div>
			<div class="bi-service-feed-content">
				<div class="row justify-content-center ">
                @foreach ($whatWeDo as $whatWeDo)
					<div class="col-lg-4 col-md-12  wow fadeInUp">
						<div class="bi-service-feed-item position-relative" >
							<span class="hover_img position-absolute" data-background="{{asset('assets_web/img/service/ser1.jpg')}}"></span>
							<span class="serial-number position-absolute">01</span>
							<div class="service-icon position-relative">
								 <img src="{{asset('storage/'.$whatWeDo->icon_class)}}" class="" />
							</div>
							<div class="service-text headline pera-content">
								<h3>{{$whatWeDo->Trans('title')}} </h3>
								<p>
                                {{$whatWeDo->Trans('details')}}    </p>
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


   <div class="hpt-about-2-area pt-120 pb-160 fix">

 
<div class="container h2-container">
    <div class="row">

       

        <!-- right-content -->
        <div class="  col-lg-6 col-xs-6">
            <div class="hpt-about-2-content">

                <!-- section-title -->
                <div class="hpt-about-2-section-title mb-40">
                    <div class="section-subtitle-2-wrap">
                   
                    
                        <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-1.png')}}" alt="" class="icon-1">
                        <img src="{{asset('assets_web/img/new_home/icon/subtitle-2-icon-2.png')}}" alt="" class="icon-2">
                        <h6 class="hero-2-subtitle">@lang('website.about_us') </h6>
                    </div>
                    <h2 class="scetion-title-2 "> {{$webSetting->Trans('title')}}</h2>
                    <p class="section-pera-2 ">
                    {{$webSetting->Trans('about_description')}}
                  </div>

                <!-- about-feature -->
                <div class="hpt-about-2-feature mb-50">
                    <div class="hpt-about-2-feature-item wow fadeIn" >
                    
                        <img src="{{asset('storage/'.$webSetting->image_vision)}}" alt="" class="icon-2">
                        <div class="icon-wrap">
                            <div class="icon">
                            
                                <img src="{{asset('storage/'.$webSetting->image_vision)}}" alt="">
                            </div>
                        </div>
                        <h4 class="title">{{$webSetting->Trans('title_vision')}}</h4>
                        <p class="text">
                        {{$webSetting->Trans('des_vision')}}                       
                     </p>
                     </div>
                    <div class="hpt-about-2-feature-item wow fadeIn" data-wow-delay=".5s">
                  
                        <img src=" {{asset('storage/'.$webSetting->image_Objectives)}}" alt="" class="icon-2">
                        <div class="icon-wrap">
                            <div class="icon">
                           
                                <img src="{{asset('storage/'.$webSetting->image_Objectives)}}" alt="">
                            </div>
                        </div>
                        <h4 class="title">                        {{$webSetting->Trans('title_Objectives')}}                       
</h4>
                        <p class="text">
                       
                        {{$webSetting->Trans('des_Objectives')}}                       

                        	
                     </div>
                </div>

                <div class="hpt-about-2-btn-wrap wow fadeInRight" data-wow-duration="1s">
                    <a class="hpt-btn-3" href="{{url('about-us')}}">
                    @lang('website.about_us')                         
                    <span class="icon"><i class="fal fa-chevron-double-right"></i></span>
                    </a>
                     
                </div>

            </div>
        </div>
            <!-- left-img -->
            <div class="  col-lg-6 col-xs-6 ">
                        <div class="hpt-about-2-img-wrap wow fadeInLeft" >
                            <div class="about-2-img text-center">
                                <img src="{{asset('storage/'.$webSetting->image)}}" alt="" class="img-responsive">
                            </div>
                        </div>
             </div>

    </div>
</div>
</div>
<!-- about-end -->




<!-- Start of Service Feed section
	============================================= -->
	<section id="bi-service-feed" class="bi-service-feed-section  ">
        
      
		<div class="container">
			<div class="bi-section-title-1 text-center headline pera-content">
                
				<h2 class="headline-title">
                @lang('website.what_we_services')
				</h2>
			</div>
			<div class="bi-service-feed-content">
				<div class="row justify-content-center ">
                @foreach ($services as $i=>$service)
					<div class="col-lg-4 col-md-12  wow fadeInUp">
						<div class="bi-service-feed-item position-relative" >
							<span class="hover_img position-absolute" data-background="{{asset('assets_web/img/service/ser1.jpg')}}"></span>
							<span class="serial-number position-absolute">0{{$i+1}}</span>
							<div class="service-icon position-relative">
								 <img src="{{asset('storage/'.$service->icon_class)}}" class="" />
							</div>
							<div class="service-text headline pera-content">
								<h3>{{$service->Trans('title')}} </h3>
								<p>
                                {{$service->Trans('details')}}    </p>
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
   <!-- Start of Sponsor  section
	============================================= -->
	<section id="bi-sponsor" class="bi-sponsor-section">
		<div class="container">
			<div class="bi-sponsor-content">
				<div class="bi-sponsor-slider swiper-container">
					<div class="swiper-wrapper">
                        @foreach($partners as $partner)
						<div class="swiper-slide">
							<div class="bi-sponsor-item">
								<img src="{{asset('storage/'.$partner->image)}}">
							</div>
						</div>
                        @endforeach
						
					</div>
				</div>
			</div>
		</div>
	</section>	
<!-- End of Sponsor  section
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
                                    <h6 class="hero-2-subtitle">                 @lang('website.request_join')
</h6>
                                    </div>
                                <div class="bi-team-details-contact-form wow fadeInRight">
                                    <form action="sendmail.php" method="post">
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
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="website" value="{{ old('website') }}" size="40"
                                                placeholder="@lang('website.website')">
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="store" value="{{ old('store') }}" size="40"
                                                placeholder="@lang('website.store')" required>
                                                @error('store')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <input type="text" name="address" value="{{ old('address') }}" size="40"
                                                placeholder="@lang('website.address')" required>
                                                @error('address')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="bi-submit-btn">
                                                    <button type="submit" class="button-form-qoute">@lang('website.send_request')</button>
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
 

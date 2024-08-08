@extends('website.layouts.master')
@section('pageTitle', __('website.contact_us'))
@section('content')

<!-- <section id="bi-breadcrumbs" class="bi-bredcrumbs-section position-relative" data-background="{{asset('assets_web/img/bg/bread-bg.jpg')}}">
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
	</section> -->

	<section   class="bi-contact-form-section">
		<div class=" container">
	      <div class="bi-contact-map-content d-flex flex-wrap">
     

          @if(session('error'))
            <div class="alert alert-danger">
                <ul>
                {{ session('error') }}
                </ul>
            </div>
            @endif
               
			   
          <div class="row">
            <form action="{{ route('calculate.route') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="origin">النقطة الأولى (Origin)</label>
                    <input type="text" class="form-control" id="origin" name="origin"
                        placeholder="الرجاء إدخال النقطة الأولى"><br><br>
                </div>
                <div class="form-group">
                    <label for="destination">النقطة الأخيرة (Destination)</label>
                    <input type="text" class="form-control" id="destination" name="destination"
                        placeholder="الرجاء إدخال النقطة الأخيرة"><br><br>
                </div>
                <div class="form-group">
                    <label for="waypoints">المواقع الإضافية (Waypoints)</label>
                    <input type="text" class="form-control" id="waypoints" name="waypoints[]"
                        placeholder="الرجاء إدخال المواقع الإضافية">
                    <small class="form-text text-muted">يرجى تفصيل المواقع بفاصلة ومسافة بين كل موقع، على سبيل المثال: "
                        24.802988,46.756509, 24.8011502,46.7465736"</small>
                    <div style="float: rigt;" class="col-lg-12 ">
                        <button class=" btn-info color" type="button"> <i class="fa fa-solid fa-plus"></i></button>
                    </div>
                    <div class="points-card form-group row">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">حساب المسار</button>
            </form>
        </div>
    </div>


</div>
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>


<script>
$('.color').click(function() {
    $('.points-card').append(
        '<div class="row>' +
        '<div class="form-group"><label for="waypoints">المواقع الإضافية (Waypoints)</label>' +
        '<input type="text" class="form-control" id="waypoints" name="waypoints[]" placeholder="الرجاء إدخال المواقع الإضافية">' +
        '<small class="form-text text-muted">يرجى تفصيل المواقع بفاصلة ومسافة بين كل موقع، على سبيل المثال: "  24.802988,46.756509, 24.8011502,46.7465736"</small>' +
        '</div>'
    );
});
</script>
<script>
$(document).ready(function() {
    // Use event delegation for dynamically generated content
    $(document).on('click', '.remove-condition', function() {
        // Find the closest parent div with class 'row' and remove it
        $(this).closest('div.row').remove();
    });
});
</script>
@endsection
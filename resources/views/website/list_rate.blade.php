@extends('website.layouts.master')
@section('pageTitle', __('website.rate_order'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1 class="page-title-heading ar"style="    text-align: right !important;">تقييم الخدمة</h1>

                </div><!-- /.breadcrumbs -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->

<section class="flat-row flat-contact">
    <div class="container">
        <div class="row">
            

<section class="flat-row flat-imagebox style2  ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
        <div class="row">
            @if(! empty($rates))
            @foreach ($rates as $review)

            <div class="col-md-4">
                <div class="news-post">
                    
                    <div class="entry-post">

                        <div class="clearfix"></div>
                        <div class="entry-title">
                            
                            <h5>{{$review->name}}</h5>
                            <div class="rate">
                                
                                <input type="radio" id="star5" name="rate_{{$review->id}}" value="5" {{ $review->rate == "5" ? 'checked':''}} readonly />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate_{{$review->id}}" value="4"  {{ $review->rate == "4" ? 'checked':''}} readonly />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate_{{$review->id}}" value="3"  {{ $review->rate == "3" ? 'checked':''}} readonly/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate_{{$review->id}}" value="2"  {{ $review->rate == "2" ? 'checked':''}} readonly />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate_{{$review->id}}" value="1"  {{ $review->rate == "1" ? 'checked':''}} readonly/>
                                <label for="star1" title="text">1 star</label>
                              </div>
                        </div>
                        <div class="content-post text-center">
                            <h3>{{$review->review}}</h3>
                           
                        </div>
                    </div>
                </div><!-- /.news-post -->
            </div><!-- /.col-md-4 -->

            @endforeach
            
            {!! $rates->appends($_GET)->links() !!}
            @endif
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-imagebox style2 -->


            
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.flat-contact -->

@endsection

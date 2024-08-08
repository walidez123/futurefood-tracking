@extends('website.layouts.master')
@section('pageTitle', $post->trans('title'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1 class="page-title-heading">{{$post->trans('title')}}</h1>
                    <ul class="trail-items">
                        <li class="trail-item">
                            <a href="{{route('home')}}" title="">@lang('website.home')</a>
                            <span>></span>
                        </li>
                        <li class="trail-end">
                                {{$post->trans('title')}}
                        </li>
                    </ul><!-- /.trail-items -->
                </div><!-- /.breadcrumbs -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->

<section class="main-blog-single page-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="content-area">
                    <div class="post-wrap">
                        <article class="blog-single">
                            <div class="featured-post">
                                <a href="#" title="">
                                    <img src="{{asset('storage/'.$post->image)}}" alt="">
                                </a>
                            </div><!-- /.featured-post -->
                            <div class="content-post">
                                <div class="entry-post">
                                    <ul class="entry-meta">
                                        <li class="post-date">
                                            {{$post->dateFormatted()}}
                                        </li>
                                        <li class="post-categories">
                                            {{$post->category->trans('title')}}
                                        </li>
                                    </ul>
                                    <div class="clearfix">
                                    </div>
                                    <h2 class="entry-title">
                                        {{$post->trans('title')}}
                                    </h2>
                                </div>
                                {!!$post->trans('content')!!}
                            </div><!-- /.content-post -->
                        </article><!-- /.blog-post -->

                    </div><!-- /.post-wrap -->
                </div><!-- /.content-area -->

                <div class="widget-area">
                    <div class="sidebar">
                        {{-- <div class="widget widget-search">
                            <form role="search" method="get" class="search-form" action="#">
                                <label>
                                    <input type="search" class="search-field" placeholder="Search …" value="" name="s">
                                </label>
                                <input type="submit" class="search-submit" value="Search">
                            </form><!-- /.search-form -->
                        </div><!-- /.widget widget-search --> --}}
                        <div class="widget widget-recent">
                            <h4 class="widget-title">@lang('website.latest_posts')</h4>
                            <ul>
                                    @foreach ($latestPosts as $latestPostsRow)
                                    
                                    <li>
                                        <a href="{{route('blog.show', $latestPostsRow->slug)}}" title="">{{$latestPostsRow->trans('title')}}</a>
                                    </li>
                                    @endforeach
                            </ul>
                        </div><!-- /.widget widget-recent -->
                        {{-- <div class="widget widget-recent-news">
                            <h4 class="widget-title">Popular Post</h4>
                            <ul class="recent-news">
                                <li>
                                    <div class="thumb">
                                        <a href="#" title="">
                                            <img src="assets/images/blog/blog-sm-1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="text">
                                        <h5><a href="#" title="">Liberalisation of air cargo industry</a></h5>
                                        <p class="date">May 19, 2017</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#" title="">
                                            <img src="assets/images/blog/blog-sm-2.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="text">
                                        <h5><a href="#" title="">Single solution for shipping process and</a></h5>
                                        <p class="date">May 19, 2017</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#" title="">
                                            <img src="assets/images/blog/blog-sm-3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="text">
                                        <h5><a href="#" title="">Mobile Technology and Transportation</a></h5>
                                        <p class="date">May 19, 2017</p>
                                    </div>
                                </li>
                            </ul><!-- /.recent-news -->
                        </div><!-- /.widget widget-rencent-news -->
                        <div class="widget widget-categories">
                            <h4 class="widget-title">Categories</h4>
                            <ul>
                                <li>
                                    <a href="#" title="">Ocean Freight</a>
                                </li>
                                <li>
                                    <a href="#" title="">Road and Rail Freight</a>
                                </li>
                                <li>
                                    <a href="#" title="">services Air Freight</a>
                                </li>
                                <li>
                                    <a href="#" title="">Warehousing and Distribution</a>
                                </li>
                            </ul>
                        </div><!-- /.widget widget-categories --> --}}
                    </div><!-- /.sidebar -->
                </div><!-- /.widget-area -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.main-blog <-->

@endsection
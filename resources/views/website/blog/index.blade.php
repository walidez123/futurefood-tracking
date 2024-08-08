@extends('website.layouts.master')
@section('pageTitle', __('website.blog'))
@section('content')

<section class="page-title style1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1 class="page-title-heading textright">@lang('website.blog')</h1>
                    <ul class="trail-items">
                        <li class="trail-item">
                            <a href="{{route('home')}}" title="">@lang('website.home')</a>
                            <span>></span>
                        </li>
                        <li class="trail-end">
                                @lang('website.blog')
                        </li>
                    </ul><!-- /.trail-items -->
                </div><!-- /.breadcrumbs -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.page-title style1 -->

<section class="main-blog page-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="content-area">
                    <div class="post-wrap">
                        @foreach ($posts as $post)
                            
                        <article class="blog-post">
                            <div class="featured-post">
                                <a href="{{route('blog.show', $post->slug)}}" title="">
                                    <img src="{{asset('storage/'.$post->image)}}" alt="{{$post->trans('title')}}">
                                </a>
                            </div><!-- /.featured-post -->
                            <div class="content-post">
                                <div class="entry-post">

                                    <div class="clearfix">
                                    </div>
                                    <h2 class="entry-title">
                                        <a href="{{route('blog.show', $post->slug)}}" title="{{$post->trans('title')}}">{{$post->trans('title')}}</a>
                                    </h2>
                                </div>
                                <p>
                                        {{$post->trans('excerpt')}}
                                </p>
                                <div class="button-post">
                                    <a href="{{route('blog.show', $post->slug)}}" title="">@lang('website.read_more')</a>
                                </div>
                            </div><!-- /.content-post -->
                        </article><!-- /.blog-post -->
                        @endforeach
                        <div class="paging-navination">
                            <ul class="flat-pagination">
                                    {{ $posts->links() }}
                            </ul><!-- /.flat-pagination -->
                        </div><!-- /.paging-navigation -->
                    </div><!-- /.post-wrap -->
                </div><!-- /.content-area -->

                <div class="widget-area">
                    <div class="sidebar">

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



                    </div><!-- /.sidebar -->
                </div><!-- /.widget-area -->
            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.main-blog -->

@endsection
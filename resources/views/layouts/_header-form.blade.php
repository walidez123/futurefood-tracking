<section class="content-header">
        <h1>
            <span class="fa {{$iconClass}}"></span>
            {{-- <span class=""></span> --}}
            {{$type.' '.$title}}

        </h1>
        @if ($multiLang == 'true')
        <ul class="language">
                <li><button   class="btn english  active">EN</button></li>
                <li><button class="btn araic">AR</button></li>
            </ul>
        @else
        <ol class="breadcrumb">
                <li><a href="/{{Auth()->user()->user_type}}"><i class="fa fa-dashboard"></i>@lang('app.dashboard')</a></li>
                <li><a href="{{$url}}">{{str_plural($title)}}</a></li>
                <li class="active">{{$type.' '.$title}}</li>
            </ol>
        @endif

    </section>

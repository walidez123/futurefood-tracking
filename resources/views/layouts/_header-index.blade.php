<section class="content-header">
        <h1>
          <span class="fa {{$iconClass}}"></span>
          {{$title}}
          @if ($addUrl)
          <span> <a href="{{$addUrl}}" class="btn btn-success  "><i class="fa fa-plus-circle fa-fw"></i> @lang('app.add') {{$title}} </a></span>
          @endif


        </h1>
        @if ($multiLang == 'true')
         <ul class="language">
                <li><button   class="btn english  ">EN</button></li>
                <li><button class="btn araic active">AR</button></li>
            </ul>
        @else
        <ol class="breadcrumb">
            <li><a href="/{{Auth()->user()->user_type}}"><i class="fa fa-dashboard"></i> @lang('app.dashboard') </a></li>
            <li class="active"><i class="fa {{$iconClass}}"></i> {{$title}}</li>
          </ol>
        @endif

      </section>

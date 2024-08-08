<div class="col-md-3">

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('app.list')</h3>

            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="{{(!Request::exists('readable') ? 'active' : '')}}"><a
                        href="{{route('notifications.index')}}?unread"><i class="fa fa-bell "></i> @lang('app.unread')
                        @if ($notificationsBar->where('is_readed', 0)->count() > 0)
                        <span class="label label-primary pull-right">{{$notificationsBar->where('is_readed', 0)->count()}}</span>
                        @endif
                    </a>
                    </li>


                <li class="{{(Request::exists('readable') ? 'active' : '')}}"><a
                        href="{{route('notifications.index')}}?readable"><i class="fa fa-bell-slash-o "></i> @lang('app.readable')

                    </a>
                </li>


            </ul>
        </div>
        <!-- /.box-body -->
    </div>
</div>

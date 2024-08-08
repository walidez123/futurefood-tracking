@extends('layouts.master')
@section('pageTitle', trans('admin_message.Supervisor'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @if (in_array('add_supervisor', $permissionsTitle))

  @include('layouts._header-index', ['title' => trans('admin_message.Supervisor'), 'iconClass' => 'fa-users', 'addUrl' => route('supervisor.create'), 'multiLang' => 'false'])
@endif
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> </h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>@lang('user.Avatar')</th>
                  <th>@lang('user.Name')</th>
                  <th>@lang('user.Email')</th>
                  <th>@lang('user.Phone')</th>
                  <th>@lang('user.Action')</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    if ($users->currentPage() == 1) {
                        $count = 1;
                    } else {
                        $count = ($users->currentPage() - 1) * 15 + 1;
                    }
                ?>  
                @foreach ($users as $user)
                <tr>
                  <td>{{$count}}</td>
                  @if($user->avatar=="avatar/avatar.png" || $user->avatar==NULL)
                  <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75" width="75"></td>

                  @else
                  <td><img class="img-circle" src="{{asset('storage/'.$user->avatar)}}" height="75" width="75"></td>

                  @endif                  
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>
                    @if (in_array('show_supervisor', $permissionsTitle))
                    <a href="{{route('supervisor.show', $user->id)}}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">@lang('user.Show')</span> </a>
                    @endif
                    @if (in_array('edit_supervisor', $permissionsTitle))
                        
                    <a href="{{route('supervisor.edit', $user->id)}}" title="Edit" class="btn btn-sm btn-primary" style="margin: 2px;"><i
                        class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">@lang('user.Edit')</span></a>
                    @endif
                    @if (in_array('delete_supervisor', $permissionsTitle))
                    <form class="pull-right" style="display: inline;" action="{{route('supervisor.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Do you want Delete This Record ?');">
                          <i class="fa fa-trash" aria-hidden="true"></i> @lang('user.Delete')
                        </button>
                      </form>  
                    @endif
                    
                  </td>
                </tr>
                <?php $count++ ?>
                @endforeach

              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>@lang('user.Avatar')</th>
                  <th>@lang('user.Name')</th>
                  <th>@lang('user.Email')</th>
                  <th>@lang('user.Phone')</th>
                  <th>@lang('user.Action')</th>
                </tr>
              </tfoot>
            </table>
            {{ $users->appends(Request::query())->links() }}
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
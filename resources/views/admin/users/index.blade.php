@extends('layouts.master')
@section('pageTitle', trans('admin_message.Users'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_user', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => trans('admin_message.User'),
                'iconClass' => 'fa-users',
                'addUrl' => route('users.create'),
                'multiLang' => 'false',
            ])
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">

                            <form action="{{ route('users.index') }}" method="GET" class="col-xs-12">

                                <div class="col-lg-3">

                                    <select class="form-control select2" name="role_id">

                                        <option value="">{{ __('user.Select Role') }}</option>


                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="col-lg-2">
                                    <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                        value="{{ __('admin_message.search') }}" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <th>@lang('user.Role')</th>
                            <th>@lang('user.Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($users->currentPage() == 1) {
                            $count = 1;
                        } else {
                            $count = ($users->currentPage() - 1) * 25 + 1;
                        }
                        ?>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $count }}</td>
                                <!--  -->
                                @if ($user->avatar == 'avatar/avatar.png' || $user->avatar == null)
                                    <td><img class="img-circle" src="{{ asset('storage/' . $webSetting->logo) }}"
                                            height="75" width="75"></td>
                                @else
                                    <td><img class="img-circle" src="{{ asset('storage/' . $user->avatar) }}" height="75"
                                            width="75"></td>
                                @endif
                                <!--  -->
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if ($user->role == null)
                                    @else
                                        {{ $user->role->title }}
                                    @endif
                                </td>
                                <td>
                                    <!-- @if (in_array('show_user', $permissionsTitle))
                                        <a href="{{ route('users.show', $user->id) }}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">View</span> </a>
                                        @endif -->
                                    @if (in_array('edit_user', $permissionsTitle))
                                        <a href="{{ route('users.edit', $user->id) }}" title="Edit"
                                            class="btn btn-sm btn-primary" style="margin: 2px;"><i class="fa fa-edit"></i>
                                            <span class="hidden-xs hidden-sm">@lang('user.Edit')</span></a>
                                    @endif
                                    @if (in_array('delete_user', $permissionsTitle))
                                        <form class="pull-right" style="display: inline;"
                                            action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Do you want Delete This Record ?');">
                                                <i class="fa fa-trash" aria-hidden="true"></i> @lang('user.Delete')
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                            <?php $count++; ?>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>@lang('user.Avatar')</th>
                            <th>@lang('user.Name')</th>
                            <th>@lang('user.Email')</th>
                            <th>@lang('user.Phone')</th>
                            <th>@lang('user.Role')</th>
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

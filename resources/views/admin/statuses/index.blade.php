@extends('layouts.master')
@section('pageTitle', __('admin_message.statuses'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection
@section('css')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_status', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => __('admin_message.statuses'),
                'iconClass' => 'fa-bookmark',
                'addUrl' => route('statuses.create'),
                'multiLang' => 'false',
            ])
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
                                        <th>{{ __('admin_message.statuses') }}</th>
                                        <th>{{ __('admin_message.priority') }}</th>


                                        <!-- <th>{{ __('admin_message.Notes') }}</th> -->
                                        <th>{{ __('admin_message.appear') }} {{ __('admin_message.Delegate') }}</th>
                                        <th>{{ __('admin_message.appear') }} {{ __('admin_message.Client') }}</th>
                                        @if (in_array(2, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.restaurant') }}</th>
                                        @endif
                                        @if (in_array(1, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.shop') }}</th>
                                        @endif
                                        @if (in_array(3, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.storehouse') }}
                                            </th>
                                        @endif
                                        @if (in_array(4, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('fulfillment.fulfillment') }} </th>
                                        @endif
                                        <th>{{ __('admin_message.appear') }} {{ __('admin_message.user') }} </th>

                                        <th>{{ __('admin_message.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($statuses_company->currentPage() == 1) {
                                        $count = 1;
                                    } else {
                                        $count = ($statuses_company->currentPage() - 1) * 25 + 1;
                                    }
                                    ?>
                                    @foreach ($statuses_company as $status)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $status->trans('title') }}</td>
                                            <td>{{ $status->sort }}</td>

                                            <!-- <td >{{ $status->description }}</td> -->
                                            <td>
                                                <input data-id="{{ $status->id }}" data-size="mini"
                                                    class="toggle publish"
                                                    {{ $status->delegate_appear == 1 ? 'checked' : '' }}
                                                    {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                    data-onstyle="success" type="checkbox" data-style="ios">
                                            </td>
                                            <td>
                                                <input data-id="{{ $status->id }}" data-size="mini"
                                                    class="toggle client_appear publish"
                                                    {{ $status->client_appear == 1 ? 'checked' : '' }}
                                                    {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                    data-onstyle="success" type="checkbox" data-style="ios">
                                            </td>
                                            @if (in_array(2, $user_type))
                                                <td>

                                                    <input data-id="{{ $status->id }}" data-size="mini"
                                                        class="toggle restaurant_appear"
                                                        {{ $status->restaurant_appear == 1 ? 'checked' : '' }}
                                                        {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                        data-onstyle="success" type="checkbox" data-style="ios">
                                                </td>
                                            @endif
                                            @if (in_array(1, $user_type))
                                                <td>
                                                    <input data-id="{{ $status->id }}" data-size="mini"
                                                        class="toggle shop_appear"
                                                        {{ $status->shop_appear == 1 ? 'checked' : '' }}
                                                        {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                        data-onstyle="success" type="checkbox" data-style="ios">
                                                </td>
                                            @endif
                                            @if (in_array(3, $user_type))
                                                <td>
                                                    <input data-id="{{ $status->id }}" data-size="mini"
                                                        class="toggle storehouse_appear"
                                                        {{ $status->storehouse_appear == 1 ? 'checked' : '' }}
                                                        {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                        data-onstyle="success" type="checkbox" data-style="ios">
                                                </td>
                                            @endif
                                            @if (in_array(4, $user_type))
                                                <td>
                                                    <input data-id="{{ $status->id }}" data-size="mini"
                                                        class="toggle fulfillment_appear"
                                                        {{ $status->fulfillment_appear == 1 ? 'checked' : '' }}
                                                        {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                        data-onstyle="success" type="checkbox" data-style="ios">
                                                </td>
                                            @endif
                                            <td>
                                                <input data-id="{{ $status->id }}" data-size="mini"
                                                    class="toggle user_appear"
                                                    {{ $status->user_appear == 1 ? 'checked' : '' }}
                                                    {{ in_array('edit_status', $permissionsTitle) ? '' : 'disabled' }}
                                                    data-onstyle="success" type="checkbox" data-style="ios">
                                            </td>
                                            <td>
                                                @if ($status->company_id != null)
                                                    @if (in_array('edit_status', $permissionsTitle))
                                                        <a href="{{ route('statuses.edit', $status->id) }}" title="Edit"
                                                            class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                                class="fa fa-edit"></i> <span
                                                                class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span></a>
                                                    @endif
                                                    @if ($status->id == 16 || $status->id == 17 || $status->id == 18 || $status->id == 34)
                                                    @else
                                                        @if (in_array('delete_status', $permissionsTitle))
                                                            <form class="pull-right" style="display: inline;"
                                                                action="{{ route('statuses.destroy', $status->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Do you want Delete This Record ?');">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    {{ __('admin_message.Delete') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endif

                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('admin_message.statuses') }}</th>
                                        <th>{{ __('admin_message.priority') }}</th>

                                        <!-- <th>{{ __('admin_message.Notes') }}</th> -->
                                        <th>{{ __('admin_message.appear') }} {{ __('admin_message.Delegate') }}</th>
                                        <th>{{ __('admin_message.appear') }} {{ __('admin_message.Client') }}</th>
                                        @if (in_array(2, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.restaurant') }}</th>
                                        @endif

                                        @if (in_array(1, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.shop') }}</th>
                                        @endif
                                        @if (in_array(3, $user_type))
                                            <th>{{ __('admin_message.appear') }} {{ __('admin_message.storehouse') }}
                                            </th>
                                        @endif

                                        <th>{{ __('admin_message.Action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <nav>
                                <ul class="pager">
                                    {{ $statuses_company->appends($_GET)->links() }}


                                </ul>

                            </nav>


                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('assets_web/js/status.js') }}"></script>

@endsection

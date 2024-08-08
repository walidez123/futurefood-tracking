@extends('layouts.master')
@section('pageTitle', __('admin_message.Service provider'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_service_provider', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => __('admin_message.Service provider'),
                'iconClass' => 'fa-users',
                'addUrl' => route('service_provider.create'),
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
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                {{ __('admin_message.Search and filter') }} </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <form action="{{ route('service_provider.index') }}" method="GET"
                                                class="col-xs-12">
                                                <div class="col-lg-6">
                                                    <select class="form-control select2" name="type">
                                                        @php
                                                            $options = [
                                                                1 => __('admin_message.Clients'),
                                                                2 => __('admin_message.restaurants'),
                                                                4 => __('fulfillment.fulfillment'), // Assuming you intended to use 3 for fulfillment
                                                            ];
                                                        @endphp

                                                        @foreach ($options as $value => $label)
                                                            @if (in_array($value, $user_type))
                                                                <option value="{{ $value }}">{{ $label }}
                                                                </option>
                                                            @endif
                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">

                                            <div class="col-lg-6">
                                                <input type="submit" class="btn btn-block btn-danger col-lg-6"
                                                    value="{{ __('admin_message.search') }}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <button type="button" class="btn btn-block btn-secondary "
                                                    data-dismiss="modal">{{ __('admin_message.close') }}</button>
                                            </div>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>

                                    <th>{{ __('admin_message.image') }}</th>
                                    <th>{{ __('admin_message.Name') }}</th>
                                    <th>{{ __('admin_message.Email') }}</th>

                                    <th>{{ __('admin_message.Phone') }}</th>
                                    <th>{{ __('admin_message.work type') }}</th>
                                    <th>{{ __('admin_message.Action') }}</th>
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
                                        <td>{{ $count }}</td>
                                        @if ($user->avatar == 'avatar/avatar.png' || $user->avatar == null)
                                            <td><img class="img-circle" src="{{ asset('storage/' . $webSetting->logo) }}"
                                                    height="75" width="75"></td>
                                        @else
                                            <td><img class="img-circle" src="{{ asset('storage/' . $user->avatar) }}"
                                                    height="75" width="75"></td>
                                        @endif
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->phone)
                                                {{ $user->phone }}
                                                <a href="tel:{{ $user->phone }}" style="padding:5px"><i
                                                        class="fa fa-phone fa-1x"></i></a> <a
                                                    href="https://api.whatsapp.com/send?phone={{ $user->phone }}"
                                                    style="padding:5px"><i class="fa-brands fa-whatsapp fa-1x"
                                                        style="color:green"></i></a></th>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($user->user_works as $work)
                                                @if ($work->work == 1)
                                                    {{ __('admin_message.Clients') }}
                                                @elseif($work->work == 2)
                                                    {{ __('admin_message.restaurants') }}
                                                @elseif($work->work == 4)
                                                    {{ __('fulfillment.fulfillment') }}
                                                @endif
                                                /
                                                <!--  -->
                                            @endforeach
                                        </td>

                                        <td>
                                            <!-- @if (in_array('show_service_provider', $permissionsTitle))
    <a href="{{ route('service_provider.show', $user->id) }}" title="View" class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i> <span class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span> </a>
    @endif -->
                                            @if (in_array('edit_service_provider', $permissionsTitle))
                                                <a href="{{ route('service_provider.edit', $user->id) }}" title="Edit"
                                                    class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                        class="fa fa-edit"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span></a>
                                            @endif
                                            @if ($user->provider != 'labaih')
                                                @if (in_array('delete_service_provider', $permissionsTitle))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('service_provider.destroy', $user->id) }}"
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


                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin_message.image') }}</th>
                                    <th>{{ __('admin_message.Name') }}</th>
                                    <th>{{ __('admin_message.Email') }}</th>

                                    <th>{{ __('admin_message.Phone') }}</th>
                                    <th>{{ __('admin_message.work type') }}</th>

                                    <th>{{ __('admin_message.Action') }}</th>
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

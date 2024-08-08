@extends('layouts.master')
@section('pageTitle', __('admin_message.Delegates'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_delegate', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => __('admin_message.Delegates'),
                'iconClass' => 'fa-users',
                'addUrl' => route('delegates.create', ['type' => $type]),
                'multiLang' => 'false',
            ])
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">


                    <div class="box">

                        <div class="box-body">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                {{ __('admin_message.Search and filter') }} </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <form action="{{ route('delegates.index') }}" method="GET" class="col-xs-12">

                                                <div class="col-lg-6">

                                                    <select class="form-control select2" name="type">
                                                        @php
                                                            $options = [
                                                                1 => __('admin_message.Clients'),
                                                                2 => __('admin_message.restaurants'),
                                                                4 => __('fulfillment.fulfillment'), // Assuming you intended to use
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
                                    <th>{{ __('admin_message.Functional code') }}</th>
                                    <th>{{ __('admin_message.Name') }}</th>
                                    <th>{{ __('admin_message.Phone') }}</th>
                                    <th>{{ __('admin_message.City') }}</th>
                                    <th>{{ __('admin_message.vehicle') }}</th>
                                    <th>{{ __('admin_message.Work Type') }}</th>

                                    <th>{{ __('admin_message.Activation') }}</th>

                                    <th>{{ __('admin_message.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($delegates->currentPage() == 1) {
                                    $count = 1;
                                } else {
                                    $count = ($delegates->currentPage() - 1) * 25 + 1;
                                }
                                ?>

                                @foreach ($delegates as $delegate)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        @if ($delegate->avatar == 'avatar/avatar.png' || $delegate->avatar == null)
                                            <td><img class="img-circle" src="{{ asset('storage/' . $webSetting->logo) }}"
                                                    height="75" width="75"></td>
                                        @else
                                            <td><img class="img-circle" src="{{ asset('storage/' . $delegate->avatar) }}"
                                                    height="75" width="75"></td>
                                        @endif
                                        <td>{{ $delegate->code }}</td>

                                        <td>{{ $delegate->name }}</td>
                                        <td>{{ $delegate->phone }} <span><a
                                                    href="https://wa.me/966{{ $delegate->phone }}?text=مرحبا بك {{ $delegate->name }} فى تطبيق فيوتشر 
                                                        رابط التطبيق : https://future-ex.com/admin  
                                                        رقم تسجيل الدخول : {{ $delegate->phone }}
                                                        الباسورد : 12345678"><i
                                                        class="fa-brands fa-whatsapp"></i></a></span></td>
                                        <td>
                                            {{ !empty($delegate->city) ? $delegate->city->trans('title') : '' }}

                                        </td>
                                        <td>
                                            @if (!empty($delegate->vehicle))
                                                {{ $delegate->vehicle->type_en }} -
                                                {{ $delegate->vehicle->vehicle_number_en }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($delegate->Delegate_work != null)
                                                @foreach ($delegate->Delegate_work as $work)
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
                                            @endif
                                        </td>
                                        <td>
                                            @if ($delegate->is_active == 1)
                                                {{ __('admin_message.active') }}
                                            @else
                                                {{ __('admin_message.inactive') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('show_delegate', $permissionsTitle))
                                                <a href="{{ route('delegates.show', $delegate->id) }}" title="View"
                                                    class="btn btn-sm btn-warning" style="margin: 2px;"><i
                                                        class="fa fa-eye"></i>
                                                    <span class="hidden-xs hidden-sm">{{ __('admin_message.View') }}</span>
                                                </a>
                                                <a href="{{ route('delegates.orders', $delegate->id) }}" title="View"
                                                    class="btn btn-sm btn-success" style="margin: 2px;"><i
                                                        class="fa fa-list"></i>
                                                    <span class="hidden-xs hidden-sm">{{ __('admin_message.orders') }}
                                                        <strong>{{ $delegate->ordersDelegate()->count() }}</strong></span>
                                                </a>
                                            @endif
                                            <!--  -->
                                            @if (in_array('show_balance_delegate', $permissionsTitle))
                                                <a href="{{ route('delegates.transactions', $delegate->id) }}"
                                                    title="View" class="btn btn-sm btn-success" style="margin: 2px;">
                                                    <i class="fa-solid fa-dollar"></i> <span
                                                        class="hidden-xs hidden-sm">{{ __('admin_message.Financial') }}</span>
                                                </a>
                                            @endif
                                            <!--  -->
                                            @if (in_array('edit_delegate', $permissionsTitle))
                                                <a href="{{ route('delegates.edit', $delegate->id) }}" title="Edit"
                                                    class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                        class="fa fa-edit"></i>
                                                    <span
                                                        class="hidden-xs hidden-sm">{{ __('admin_message.Edit') }}</span></a>
                                            @endif
                                            @if (in_array('delete_delegate', $permissionsTitle))
                                                <form class="pull-right" style="display: inline;"
                                                    action="{{ route('delegates.destroy', $delegate->id) }}"
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
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin_message.image') }}</th>
                                    <th>{{ __('admin_message.Functional code') }}</th>

                                    <th>{{ __('admin_message.Name') }}</th>
                                    <th>{{ __('admin_message.Phone') }}</th>
                                    <th>{{ __('admin_message.City') }}</th>
                                    <th>{{ __('admin_message.vehicle') }}</th>
                                    <th>{{ __('admin_message.Work Type') }}</th>

                                    <th>{{ __('admin_message.Activation') }}</th>


                                    <th>{{ __('admin_message.Action') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <nav>
                            <ul class="pager">
                                {{ $delegates->appends($_GET)->links() }}
                            </ul>

                        </nav>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
    </div><!-- /.row -->
    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

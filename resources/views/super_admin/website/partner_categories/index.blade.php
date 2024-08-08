@extends('layouts.master')
@section('pageTitle', 'partner categories')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        {{-- @if (in_array('add_partner', $permissionsTitle)) --}}
            @include('layouts._header-index', [
                'title' => 'Partner categories',
                'iconClass' => 'fa-window-restore',
                'addUrl' => route('partner-categories.create'),
                'multiLang' => 'false',
            ])
        {{-- @endif --}}
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
                                        <th>Image</th>
                                        <th>title</th>
                                        <th>details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($partner_categories as $partner)
                                        <tr>
                                            <th>{{ $count }}</th>
                                            <td class=""><img src="{{ asset('storage/' . $partner->image) }}"
                                                    class="img-responsive " alt="User Image" width="80"></td>
                                            <td class=" ">{{ $partner->title }}</td>
                                            <td>{{ $partner->details }}</td>
                                            <td>
                                                {{-- @if (in_array('edit_partner', $permissionsTitle)) --}}
                                                    <a href="{{ route('partner-categories.edit', $partner->id) }}" title="Edit"
                                                        class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                            class="fa fa-edit"></i> <span
                                                            class="hidden-xs hidden-sm">Edit</span></a>
                                                {{-- @endif
                                                @if (in_array('delete_partner', $permissionsTitle)) --}}
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('partner-categories.destroy', $partner->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Do you want Delete This Record ?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                        </button>
                                                    </form>
                                                {{-- @endif --}}
                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>title</th>
                                        <th>details</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

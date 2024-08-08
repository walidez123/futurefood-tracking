@extends('layouts.master')
@section('pageTitle', 'Solutions')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('layouts._header-index', [
            'title' => 'Solutions',
            'iconClass' => 'fa fa-wrench',
            'addUrl' => route('solutions.create'),
            'multiLang' => 'false',
        ])

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
                                        <th>icon</th>
                                        <th>title</th>
                                        <th>title_ar</th>
                                        <th>details </th>
                                        <th>details_ar </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($solutions as $solution)
                                        <tr>
                                            <th>{{ $count }}</th>
                                            <td class="">
                                                @if ($solution->icon_class)
                                                    <img src="{{ asset('storage/' . $solution->icon_class) }}"
                                                        class="img-responsive " alt="User Image" width="80">
                                                @endif
                                            </td>

                                            <td class="en ">{{ $solution->title_en }}</td>
                                            <td class="ar ">{{ $solution->title_ar }}</td>
                                            <td class="en ">{{ $solution->details_en }}</td>
                                            <td class="ar ">{{ $solution->details_ar }}</td>
                                            <td>
                                                {{-- @if (in_array('edit_solution', $permissionsTitle)) --}}
                                                    <a href="{{ route('solutions.edit', $solution->id) }}" title="Edit"
                                                        class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                            class="fa fa-edit"></i> <span
                                                            class="hidden-xs hidden-sm">Edit</span></a>
                                                {{-- @endif
                                                @if (in_array('delete_solution', $permissionsTitle)) --}}
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('solutions.destroy', $solution->id) }}"
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
                                        <th>icon</th>
                                        <th>title</th>
                                        <th>title_ar</th>
                                        <th>details </th>
                                        <th>details_ar </th>
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

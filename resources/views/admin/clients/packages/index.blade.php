@extends('layouts.master')
@section('pageTitle', 'packages')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if (in_array('add_client_packages', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => 'باقات أضافية',
                'iconClass' => 'fa-map-marker',
                'addUrl' => route('clinet_packages.create', ['id' => $id]),
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
                                    <th>الباكدج</th>
                                    <th>عدد الايام</th>
                                    <th>المساحة</th>
                                    <th>السعر</th>
                                    <th>تاريخ بداية الباقة</th>
                                    <th>تاريخ اللإنتهاء </th>  
                                    <th>الأيام المتبقية</th>
                                    <th>فعال</th>
                                    <!-- <th>@lang('app.control')</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($Packages as $Package)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $Package->package->trans('title') }}</td>

                                            <td>{{ $Package->num_days }}</td>
                                            <td>{{ $Package->area }}</td>

                                            <td>
                                                {{ $Package->price }}
                                            </td>
                                            <td>{{ $Package->start_date }}</td>
                                            <td>{{ $Package->end_date }}</td>
                                            <td>
                                                @if ($Package->end_date != null)
                                                    <?php
                                                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $Package->end_date);
                                                    $start = (new \Carbon\Carbon())->today();
                                                    if ($start->isBefore($end)) {
                                                        $days = $end->diffInDays($start); 
                                                    } else {
                                                        $days = 0; // or handle this case as needed
                                                    }
                                                    
                                                    ?> {{ $days }}

@if($days==0)

@if (in_array('edit_client_packages', $permissionsTitle))
<a href="{{ route('clinet_packages.renewal', $Package->id) }}"
    title="Edit" class="btn btn-sm btn-primary"
    style="margin: 2px;"><span
        class="hidden-xs hidden-sm">@lang('admin_message.Package renewal')
</span></a>
@endif
@endif
                                                    
                                                @endif

                                            </td>
                                            <th>
                                                @if ($Package->active == 1)
                                                    فعال
                                                @else
                                                    غير فعال
                                                @endif


                                            <td>
                                                @if (in_array('edit_client_packages', $permissionsTitle))
                                                    <a href="{{ route('clinet_packages.edit', $Package->id) }}"
                                                        title="Edit" class="btn btn-sm btn-primary"
                                                        style="margin: 2px;"><i class="fa fa-edit"></i> <span
                                                            class="hidden-xs hidden-sm">@lang('app.edit')</span></a>
                                                @endif
                                                @if (in_array('delete_client_packages', $permissionsTitle))
                                                    <form style="display: inline;"
                                                        action="{{ route('clinet_packages.destroy', $Package->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Do you want Delete This Record ?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i> @lang('app.delete')
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
                                    <th>الباكدج</th>
                                    <th>عدد الايام</th>
                                    <th>المساحة</th>
                                    <th>السعر</th>
                                    <th>تاريخ بداية الباقة</th>
                                    <th>تاريخ اللإنتهاء </th>  
                                    <th>الأيام المتبقية</th>
                                    <th>فعال</th>
                                    <!-- <th>@lang('app.control')</th> -->
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

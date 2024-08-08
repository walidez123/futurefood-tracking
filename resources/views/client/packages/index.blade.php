@extends('layouts.master')
@section('pageTitle', 'packages')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

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
                                        <!--<th>تاريخ اللإنتهاء </th>   -->
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
                                            <!-- <td>{{ $Package->end_date }}</td> -->

                                            <td>
                                            <td>
                                                @if ($Package->end_date != null)
                                                    <?php
                                                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $Package->end_date);
                                                    $start = \Carbon\Carbon::today();
                                                    $days = $end->diffInDays($start);
                                                    ?>
                                                    {{ $days }}
                                                @endif
                                            </td>
                                            </td>
                                            <th>
                                                @if ($Package->active == 1)
                                                    فعال
                                                @else
                                                    غير فعال
                                                @endif


                                            <td>

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

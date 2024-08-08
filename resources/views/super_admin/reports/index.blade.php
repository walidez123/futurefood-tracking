@extends('layouts.master')
@section('pageTitle', 'الشركات')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        @include('layouts._header-index', [
            'title' => 'تقارير الشركات',
            'iconClass' => 'fa-users',
            'addUrl' => '',
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
                                        <th>logo</th>
                                        <th>اسم الشركة</th>
                                        <th>اسم الشخص المسئول </th>
                                        <th> رقم الجوال</th>
                                        <th>عدد طلبات الشهر </th>
                                        <th> إجمالى الطلبات</th>
                                        <th>طلبات سلة الشهر الحالى </th>
                                        <th>طلبات زد الشهر الحالى </th>
                                        <th>طلبات فوديكس الشهر الحالى </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                      if($companies->currentPage()==1){
                                          $count = 1; 
                  
                                      }else{
                                          $count=(($companies->currentPage()-1)*25)+1;
                                      }
                                  ?>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td><img class="img-circle" src="{{ asset('storage/' . $company->logo) }}"
                                                    height="75" width="75"></td>
                                            <td>{{ $company->store_name }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td>{{ $company->phone }}</td>
                                            <td>
                                                <?php
                                                $now = now();
                                                $startOfMonth = $now->startOfMonth()->toDateString();
                                                $endOfMonth = $now->endOfMonth()->toDateString();
                                                
                                                $orders_count = \App\Models\Order::where('company_id', $company->id)
                                                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                    ->get();
                                                
                                                echo $orders_count->count();
                                                ?>
                                            </td>
                                            <td>
                                                <?php $orders_count = \App\Models\Order::where('company_id', $company->id)->get(); ?>
                                                {{ $orders_count->count() }}
                                            </td>
                                            <td>
                                                @foreach ($company->works as $work)
                                                    @if ($work->work == 1)
                                                        <?php
                                                        
                                                        $orderIds = \App\Models\Order::where('company_id', $company->id)->pluck('id');
                                                        $salla_orders_count = \App\Models\ProviderOrder::whereIn('order_id', $orderIds)
                                                            ->where('provider_name', 'salla')
                                                            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                            ->get();
                                                        ?>
                                                        {{ $salla_orders_count->count() }}
                                                    @else
                                                    @endif
                                                @endforeach


                                            </td>
                                            <td>
                                                @foreach ($company->works as $work)
                                                    @if ($work->work == 1)
                                                        <?php
                                                        $orderIds = \App\Models\Order::where('company_id', $company->id)->pluck('id');
                                                        $zid_orders_count = \App\Models\ProviderOrder::whereIn('order_id', $orderIds)
                                                            ->where('provider_name', 'zid')
                                                            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                            ->get();
                                                        ?>
                                                        {{ $zid_orders_count->count() }}
                                                    @else
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td>
                                                @foreach ($company->works as $work)
                                                    @if ($work->work == 2)
                                                        <?php
                                                        $orderIds = \App\Models\Order::where('company_id', $company->id)->pluck('id');
                                                        $foodics_orders_count = \App\Models\ProviderOrder::whereIn('order_id', $orderIds)
                                                            ->where('provider_name', 'foodics')
                                                            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                            ->get();
                                                        ?>
                                                        {{ $foodics_orders_count->count() }}
                                                    @else
                                                    @endif
                                                @endforeach

                                            </td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>logo</th>
                                        <th>اسم الشركة</th>
                                        <th>اسم الشخص المسئول </th>
                                        <th> رقم الجوال</th>
                                        <th>عدد طلبات الشهر </th>
                                        <th> إجمالى الطلبات</th>
                                        <th>طلبات سلة الشهر الحالى </th>
                                        <th>طلبات زد الشهر الحالى </th>
                                        <th>طلبات فوديكس الشهر الحالى </th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $companies->appends(Request::query())->links() }}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

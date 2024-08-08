@extends('layouts.master')
@section('pageTitle', __('goods.damaged_goods_list'))

@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @if (in_array('add_damaged_orders', $permissionsTitle))
    @include('layouts._header-index', ['title' => trans('admin_message.Damaged Goods'), 'iconClass' => 'fa fa-th',
    'addUrl' =>route('damaged-goods.create'), 'multiLang' => 'false'])
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ __('goods.damaged_goods_list') }}</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="damagedGoodsTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('goods.id') }}</th>
                                                <th>{{ __('goods.client') }}</th>
                                                <th>{{ __('goods.warehouse_branch') }}</th>
                                                <th>{{ __('goods.good') }}</th>
                                                <th>{{ __('goods.warehouse_content') }}</th>
                                                <th>{{ __('goods.status') }}</th>
                                                <th>{{ __('goods.number') }}</th>
                                                <th>{{ __('goods.date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($damagedGoods as $i=>$damagedGood)
                                            <tr>
                                                <td>{{ $i+1}}</td>
                                                <td>{{ $damagedGood->client->name }}</td>
                                                <td>{{ $damagedGood->warehouseBranch->title }}</td>
                                                <td>{{ $damagedGood->goods->trans('title') }}</td>
                                                <td>{{ $damagedGood->warehouseContent->title }}</td>
                                                <td>{{ $damagedGood->goodsStatus->trans('name') }}</td>
                                                <td>{{ $damagedGood->number }}</td>
                                                <td>{{ $damagedGood->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    @if (in_array('delete_damaged_orders', $permissionsTitle))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('damaged-goods.destroy', $damagedGood->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('{{ __('admin_message.message_delete') }}');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                            {{ __('admin_message.Delete') }}
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#damagedGoodsTable').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        pageLength: 20,


        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

<style>
.select2-container {
    display: block !important;
}

.col-lg-6 {
    margin-bottom: 10px;
}
</style>
@endsection
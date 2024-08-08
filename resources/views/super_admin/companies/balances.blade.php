@extends('layouts.master')
@section('pageTitle', trans('balance.Companies Balances'))
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    @include('layouts._header-index', ['title' => trans('balance.Companies Balances'), 'iconClass' => 'fa-dollar-sign',
    'addUrl' => '', 'multiLang' => 'false'])
    <style>
        .paging_simple_numbers {
            display: none !important;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">

                            <button type="button" class="btn btn-info pull-center" data-toggle="modal"
                                data-target="#add-money">
                                <i class="fa-solid fa-dollar-sign"></i>
                                @lang('balance.Deposit')


                            </button>
                            <button type="button" class="btn btn-danger pull-center" data-toggle="modal"
                                data-target="#add-money1">
                                <i class="fa-solid fa-dollar-sign"></i>
                                @lang('balance.withdraw')
                            </button>


                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="data_table  datatable table table-bordered table-striped  ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('balance.Avatar')</th>
                                    <th>@lang('balance.Name')</th>
                                    <th>@lang('balance.Store')</th>
                                    <th>@lang('balance.email')</th>
                                    <th>@lang('balance.phone')</th>
                                    <th>@lang('balance.Balances')</th>
                                    <th>@lang('balance.Debtor')</th>
                                    <th>@lang('balance.Creditor')</th>
                                    <th>@lang('balance.Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1 ?>
                                @foreach ($companies as $company)
                                <tr>
                                    <td>{{$count}}</td>
                                    @if($company->provider==NULL)

                                    <td><img class="img-circle" src="{{asset('storage/'.$company->avatar)}}" height="75"
                                            width="75"></td>
                                    @else
                                    <td><img class="img-circle" src="{{$company->avatar}}" height="75" width="75"></td>


                                    @endif <td>{{$company->name}}</td>
                                    <td>{{$company->store_name}}</td>
                                    <td>{{$company->email}}</td>
                                    <td>{{$company->phone}}</td>
                                    <td>
                                        <?php
                                            $balance = DB::table('company_transactions')->select(array(DB::raw('SUM(debtor - creditor) as total')))
                                            ->where('user_id', $company->id)
                                            ->where('deleted_at', null)
                                            ->first();
                                            $balance = $balance->total;
                                            ?>
                                        {{$balance}} {{($balance) ? $appSetting->currency : ''}}
                                    </td>
                                    <td>{{ $company->count_debtor}}</td>
                                    <td>{{$company->count_creditor}}</td>
                                    <td>
                                        {{-- @if ($balance) --}}
                                        <!--  -->
                                        <h3 class="box-title">
                                            <a href="{{route('companies.transactions', $company->id)}}" title="View"
                                                class="btn btn-sm btn-info" style="margin: 2px;"><i
                                                    class="fa fa-bars"></i> <span
                                                    class="hidden-xs hidden-sm">Transactions</span> </a>
                                        </h3>
                                            <!--  -->
                                            {{-- @endif --}}
                                    </td>
                                </tr>
                                <?php $count++ ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('balance.Avatar')</th>
                                    <th>@lang('balance.Name')</th>
                                    <th>@lang('balance.Store')</th>
                                    <th>@lang('balance.email')</th>
                                    <th>@lang('balance.phone')</th>
                                    <th>@lang('balance.Balances')</th>
                                    <th>@lang('balance.Debtor')</th>
                                    <th>@lang('balance.Creditor')</th>
                                    <th>@lang('balance.Action')</th>
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
<div class="modal fade" id="add-money">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('balance.Add Money To company Account')</h4>
            </div>
            <form action="{{route('companies.transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="debtor">
                    <!-- <div class="form-group">
                        <label  class="control-label">Type *</label>
                        <select style="width:100%" class="form-control select2" name="type" required>
                            <option value="">Select Type</option>
                            <option value="debtor">Deposit</option>
                            <option value="creditor">withdraw</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label">@lang('balance.Companies') *</label>
                        <select style="width:100%" class="form-control select2" name="user_id" required>
                            <option value="">@lang('balance.Select Company')</option>
                            @if(! empty($companies))
                            @foreach ($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}} | {{$company->store_name}}</option>
                            @endforeach
                            @endif

                        </select>
                        @error('user_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('balance.Amount')</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('balance.Description')</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">@lang('balance.Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('balance.Save')</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<div class="modal fade" id="add-money1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('balance.Add Money To Client Account')</h4>
            </div>
            <form action="{{route('companies.transaction.store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="type" value="creditor">
                    <!-- <div class="form-group">
                        <label  class="control-label">Type *</label>
                        <select style="width:100%" class="form-control select2" name="type" required>
                            <option value="">Select Type</option>
                            <option value="debtor">Deposit</option>
                            <option value="creditor">withdraw</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label">@lang('balance.Companies') *</label>
                        <select style="width:100%" class="form-control select2" name="user_id" required>
                            <option value="">@lang('balance.Select Company')</option>
                            @if(! empty($companies))
                            @foreach ($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}} | {{$company->store_name}}</option>
                            @endforeach
                            @endif

                        </select>
                        @error('user_id')
                        <span class="invalid-feedback text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('balance.Amount')</label>
                        <input style="width:100%" type="number" min="1" step="any" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('balance.Description')</label>
                        <textarea style="width:100%" rows="3" name="description" id="description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">@lang('balance.Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('balance.Save')</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
    $(function() {
        $('.select2').select2()
    });

</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            //   "language": {
            //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            // },

            retrieve: true
            , fixedColumns: true
            , dom: 'Bfrtip'
            , direction: "rtl"
            , charset: "utf-8"
            , direction: "ltr"
            , pageLength: 50
            , dom: 'lBfrtip'
            , buttons: [

                'excel', 'print'
            ]
        });
    });

</script>
@endsection
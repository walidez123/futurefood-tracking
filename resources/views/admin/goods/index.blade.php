@extends('layouts.master')
@section('pageTitle', trans('goods.Goods'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @if (in_array('add_goods', $permissionsTitle))
    <div class="tab-content">
        <div class="active tab-pane" id="filter1">
            <div class="row ">
            <div class="col-lg-2 col-xs-12">
                <a type="button" href="{{route('goods.create')}}" class="btn btn-success">{{trans('goods.Goods')}} <i class="fa-solid fa-plus"></i>
                </a>
            </div>
            <div class="col-lg-2 col-xs-12">
                    <button type="button" class="btn btn-primary pull-left" data-toggle="modal"
                        data-target="#exampleModalExcel">
                        @lang('goods.import_good')
                    </button>
            </div>
            <div class="col-lg-2 col-xs-12">
                        <a type="button" href="{{ route('good.download_execl') }}"
                            class="btn btn-success">{{ trans('goods.export_good') }} <i class="fa-solid fa-download"></i>
                        </a>
            </div>
            </div>
        </div>
    </div>
    @endif

<br>
<!-- model for import  -->
<div class="modal fade" id="exampleModalExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> @lang('goods.import_good')</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('goods.import_execl') }}" method="POST" enctype='multipart/form-data'>
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="form-group @if($errors->has('excel')) has-error @endif">
                        <label for="excel-field">File Excel</label>
                        <input type="file" id="excel-field" name="import_file" class="form-control"
                            accept=".xlsx, .xls, .csv" required />
                        @if($errors->has("excel"))
                        <span class="help-block">{{ $errors->first("excel") }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('order.Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('order.Save Upload')</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- end model  -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('goods.photo')}}</th>
                                <th>@lang('goods.name')</th>
                                <th>@lang('goods.client_name')</th>
                                <th>@lang('goods.skus')</th>
                                <th>@lang('goods.category')</th>
                                <th>@lang('goods.description')</th>
                                <th>@lang('goods.length')</th>
                                <th>@lang('goods.width')</th>
                                <th>@lang('goods.height')</th>
                                <th> @lang('goods.expire_date_exit')</th>
                                <th>@lang('goods.Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($goods->currentPage() == 1) {
                                    $count = 1;
                                } else {
                                    $count = ($goods->currentPage() - 1) * 25 + 1;
                                }
                            ?>
                            @foreach ($goods as $good)
                            <tr>
                                <td>{{$count}}</td>
                                @if($good->image=="avatar/avatar.png" || $good->image==NULL)
                                <td><img class="img-circle" src="{{asset('storage/'.$webSetting->logo)}}" height="75"
                                        width="75"></td>

                                @else
                                <td><img class="img-circle" src="{{asset('storage/'.$good->image)}}" height="75"
                                        width="75"></td>

                                @endif
                               
                                
                                <td>{{$good->trans('title')}}</td>
                                <td>@if($good->client){{$good->client->store_name}} @else --  @endif</td>
                                
                                <td>{{$good->SKUS}}</td>
                                <td>
                                    {{ is_null($good->category) ? '' : $good->category->trans('title') }}
                                </td>
                                <td>{!!$good->trans('description')!!}</td>

                                <td>{{$good->length}} @lang('goods.cm')</td>
                                <td>{{$good->width}} @lang('goods.cm')</td>
                                <td> {{$good->height}}@lang('goods.cm')</td>
                                <td>
                                    {{$good->has_expire_date==1 ? __('admin_message.Yes') : __('admin_message.No')  }}
                                </td>



                                <td>
                                    @if (in_array('edit_goods', $permissionsTitle))

                                    <a href="{{route('goods.edit', $good->id)}}" title="Edit"
                                        class="btn btn-sm btn-primary" style="margin: 2px;"><i class="fa fa-edit"></i>
                                        <span class="hidden-xs hidden-sm">@lang('goods.edit')</span></a>
                                    @endif
                                    
                                    @if (in_array('show_goods', $permissionsTitle))

<a href="{{route('goods.show', $good->id)}}" title="View"
    class="btn btn-sm btn-warning" style="margin: 2px;"><i class="fa fa-eye"></i>
    <span class="hidden-xs hidden-sm">@lang('goods.show')</span></a>
@endif
                                    @if (in_array('Qrcode_goods', $permissionsTitle))

                                    <a href="{{route('goods.details', $good->id)}}" title="Edit"
                                        class="btn btn-sm btn-primary" style="margin: 2px;"><i class="fa fa-qrcode"></i>
                                        <span class="hidden-xs hidden-sm">@lang('goods.print')</span></a>
                                    @endif
                                    @if (in_array('Qrcode_goods', $permissionsTitle))

<a href="{{route('goods.Qrcode', $good->id)}}" title="Edit"
    class="btn btn-sm btn-primary" style="margin: 2px;"><i class="fa fa-qrcode"></i>
    <span class="hidden-xs hidden-sm">@lang('goods.generate_qr_code')</span></a>
@endif
                                    @if (in_array('delete_goods', $permissionsTitle))


                                    <form class="pull-right" style="display: inline;"
                                        action="{{route('goods.destroy', $good->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Do you want Delete This Record ?');">
                                            <i class="fa fa-trash" aria-hidden="true"></i> @lang('goods.delete')
                                        </button>
                                    </form>
                                    @endif


                                </td>
                            </tr>
                            <?php $count++ ?>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>{{__('goods.photo')}}</th>

                                <th>@lang('goods.name')</th>
                                <th>@lang('goods.client_name')</th>
                                <th>@lang('goods.skus')</th>
                                <th>@lang('goods.category')</th>

                                <th>@lang('goods.description')</th>
                                <th>@lang('goods.length')</th>
                                <th>@lang('goods.width')</th>
                                <th>@lang('goods.height')</th>
                                <th> @lang('goods.expire_date_exit')</th>

                                <th>@lang('goods.Action')</th>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- paginate nav  -->
                    <nav>
                        <ul class="pager">
                            {{ $goods->appends($_GET)->links() }}
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

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script
    src="https://jquery-datatables-column-filter.googlecode.com/svn/trunk/media/js/jquery.dataTables.columnFilter.js"
    type="text/javascript"></script>
<script>
$(document).ready(function() {
    $('#example1').DataTable({
        //   "language": {
        //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
        // },

        retrieve: true,
        fixedColumns: true,
        dom: 'Bfrtip',
        direction: "rtl",
        charset: "utf-8",
        direction: "ltr",
        pageLength: 50,
        scrollX: true,
        dom: 'lBfrtip',

        buttons: [{
                extend: 'print',
                footer: false,
                header: false,
                title: "RUN SHEET",
                text: "RUN SHEET",
                exportOptions: {
                    stripHtml: false,
                },
                "columnDefs": [{
                    "width": "100%",
                    "targets": 3
                }]


            },


            {
                extend: 'excelHtml5',
                footer: false,


            }
        ],

    });

});
</script>
@endsection
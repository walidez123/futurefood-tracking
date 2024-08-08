@extends('layouts.master')
@section('pageTitle', 'الأحجام')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if (in_array('add_sizes', $permissionsTitle))
            @include('layouts._header-index', [
                'title' => 'الأحجام',
                'iconClass' => 'fa-bookmark',
                'addUrl' => route('sizes.create'),
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
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الأسم</th>
                                        <th>الطول</th>
                                        <th> العرض</th>
                                        <th>الإرتفاع</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if ($Sizes->currentPage() == 1) {
                                            $count = 1;
                                        } else {
                                            $count = ($Sizes->currentPage() - 1) * 25 + 1;
                                        }
                                    ?>
                                    @foreach ($Sizes as $Size)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $Size->trans('name') }}</td>


                                            <td>{{ $Size->length }}</td>
                                            <td>{{ $Size->width }}</td>

                                            <td>{{ $Size->height }}</td>
                                            <td>
                                                @if (in_array('edit_sizes', $permissionsTitle))
                                                    <a href="{{ route('sizes.edit', $Size->id) }}" title="Edit"
                                                        class="btn btn-sm btn-primary" style="margin: 2px;"><i
                                                            class="fa fa-edit"></i> <span
                                                            class="hidden-xs hidden-sm">تعديل</span></a>
                                                @endif
                                                @if (in_array('delete_sizes', $permissionsTitle))
                                                    <form class="pull-right" style="display: inline;"
                                                        action="{{ route('sizes.destroy', $Size->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Do you want Delete This Record ?');">
                                                            <i class="fa fa-trash" aria-hidden="true"></i> حذف
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
                                        <th>الأسم</th>


                                        <th>الطول</th>
                                        <th> العرض</th>

                                        <th>الإرتفاع</th>
                                        <th>العمليات</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <!-- paginate nav  -->
                            <nav>
                                <ul class="pager">
                                    {{ $Sizes->appends($_GET)->links() }}
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

@extends('layouts.master')
@section('pageTitle', trans('app.Today orders'))

@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <style>
  
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">

                    <div class="tab-content">
                    @if(session('success'))
                    <div id="success-alert" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div id="error-alert" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                @if ($errors->any())
                    <div id="error-alert" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    </div>

                    <div class="box">
                        <div class="box-header">

                            <div class="col-sm-12 invoice-col">

                                <div class="col-md-6">
                                    <form action="{{route('confirmed-smb.confirm')}}" method="POST">
                                        <td><input type="hidden" name="order_id[]" value="" id="ordersId"></td>
                                        @method('PUT')
                                        @csrf
                                       
                                        <div class="col-md-4 ">
                                            <input type="submit" class="btn btn-success" value="{{__("admin_message.confirmation")}} {{__("admin_message.orders")}}">

                                        </div>
                                    </form>
                                </div>
                           
                       



                            <!--  -->
                            </div>
                        </div>
                    </div>

                    
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                                 @include('admin.orders.store_smb_table')

                        </div><!-- /.box-body -->

                        {!! $orders->appends($_GET)->links() !!}

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')

<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
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
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);

        var arr = [];
        $('input:checkbox:checked').each(function() {
            arr.push($(this).val());
        });

        $('#ordersId').val(arr)
        $('#passordersId').val(arr)
        $('#serviceordersId').val(arr)
        $('#ordersPolicy').val(arr)


    });
    $(".ordersId").on('change', function() {
        var arr = [];
        $('input:checkbox:checked').each(function() {
            arr.push($(this).val());
        });

        $('#ordersId').val(arr)

        $('#passordersId').val(arr)
        $('#serviceordersId').val(arr)
        $('#ordersPolicy').val(arr)




    });
    $(function() {
        $('.select2').select2()
    });
});
$(document).ready(function() {
    $('#order').DataTable({
      

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
               
            },


            {
                extend: 'excelHtml5',
                footer: false,
            }
        ],

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
  .paging_simple_numbers {
        display: none !important;
    }
</style>
@endsection
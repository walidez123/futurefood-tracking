@extends('layouts.master')
@section('pageTitle', __('admin_message.orders'))

@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="nav-tabs-custom">
                        @if (session('success'))
                            <div id="success-alert" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
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

                        <div class="tab-content">
                            <div class="active tab-pane" id="filter1">
                                <div class="row ">
                                    <div class="row" style="margin-bottom:15px;">
                                        <div class="col-md-12">

                                            <div class="col-lg-3 col-xs-12">
                                                <a href="{{ asset('/storage/website/order_templets.xlsx') }}" download
                                                    class="btn">@lang('order.download_import_file')</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-header">
                                        <form action="{{ url('/admin/place_order_excel') }}" method="POST"
                                            enctype='multipart/form-data'>
                                            @csrf
                                            <div class="col-md-12 col-xs-12">
                                                <!-- general form elements -->
                                                <div class="box box-primary" style="padding: 10px;">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Import orders with excel</h3>
                                                    </div><!-- /.box-header -->
                                                    <!-- form start -->
                                                    <div class="box-body">

                                                        <div class="form-group">
                                                            @if ($work_type == 2)
                                                                <label>{{ __('admin_message.restaurants') }}</label>
                                                            @else
                                                                <label>{{ __('admin_message.Clients') }}</label>
                                                            @endif
                                                            <select class="form-control select2" name="user_id" required>
                                                                @if ($work_type == 1)
                                                                    <option value="">
                                                                        {{ __('admin_message.Choose a store') }}</option>
                                                                    </option>
                                                                @else
                                                                    <option value="">
                                                                        {{ __('admin_message.Choose a restaurant') }}
                                                                    </option>
                                                                @endif
                                                                @foreach ($clients as $client)
                                                                    <option
                                                                        {{ isset($user_id) && $user_id == $client->id ? 'selected' : '' }}
                                                                        value="{{ $client->id }}">{{ $client->name }} |
                                                                        {{ $client->store_name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <div
                                                                class="form-group @if ($errors->has('excel')) has-error @endif">
                                                                <label for="excel-field">File Excel</label>
                                                                <input type="file" id="excel-field" name="import_file"
                                                                    class="form-control" accept=".xlsx, .xls, .csv"
                                                                    required />
                                                                @if ($errors->has('excel'))
                                                                    <span
                                                                        class="help-block">{{ $errors->first('excel') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class=" footer">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form> <!-- /.row -->
                                    </div>

                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    





@endsection

@section('js')

    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script>
        $(function() {
            $('.select2').select2()
        });
    </script>
@endsection

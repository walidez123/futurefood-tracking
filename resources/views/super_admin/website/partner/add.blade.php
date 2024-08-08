@extends('layouts.master')
@section('pageTitle', 'Add partner')
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => 'partner',
            'type' => 'Add',
            'iconClass' => 'fa-window-restore',
            'url' => route('partners.index'),
            'multiLang' => 'false',
        ])


        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form role="form" action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12 col-xs-12">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> Add partner</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-group">

                                <div class="form-group" style="margin-top: 15px;">
                                    <label for="exampleInputFile">Image</label>
                                    <input type="file" name="image" id="exampleInputFile" required>
                                    @error('image')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="lastname" class="control-label">Category</label>
                                    <div class="">
                                        <select id="partner_category_id" class="form-control select2"
                                            name="partner_category_id" required>
                                            <option value="">-- choose a category --
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                            @error('partner_category_id')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="">title </label>
                                    <input type="text" name="title" class="form-control " id="exampleInputEmail1"
                                        placeholder="title ">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="">title Arabic</label>
                                    <input type="text" name="title_ar" class="form-control " id="exampleInputEmail1"
                                        placeholder="title ">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">link button</label>
                                    <input type="url" class="form-control" name="url" id="exampleInputEmail1"
                                        placeholder="url">
                                </div>



                                <div class=" footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                </form> <!-- /.row -->
            </div>
    </div><!-- /.box -->
    </section>

    </div><!-- /.content-wrapper -->
@endsection

@extends('layouts.master')
@section('pageTitle', 'Add City')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'City', 'type' => 'Add', 'iconClass' => 'fa-map-marker', 'url' => route('cities.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('cities.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> ADD NEW City</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="Title">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="longitude">longitude</label>
                                <input type="text" class="form-control" name="longitude" id="exampleInputEmail1" placeholder="longitude">
                            </div>
                            <div class="form-group">
                                <label for="latitude">latitude </label>
                                <input type="text" class="form-control" name="latitude" id="exampleInputPassword1"
                                    placeholder="latitude">
                            </div>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
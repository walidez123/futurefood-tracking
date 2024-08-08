@extends('layouts.master')
@section('pageTitle', ' أضافة province')
@section('nav')
@include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'province', 'type' => 'أضافة', 'iconClass' => 'fa-map-marker', 'url' => route('cities.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{route('provinces.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> أضافة province جديدة </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="title"> الإسم</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                @error('name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div><!-- /.box -->
</div>

<!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
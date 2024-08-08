@extends('layouts.master')
@section('pageTitle', ' أضافة حجم')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'حجم', 'type' => 'أضافة', 'iconClass' => 'fa-map-marker', 'url' => route('sizes.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('sizes.store')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">



                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> أضافة حجم جديد </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"> أسم  {{__('admin_message.English')}}  </label>
                                <input required type="text" class="form-control" name="name_en" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> أسم {{__('admin_message.Arabic')}}  </label>
                                <input required type="text" class="form-control" name="name_ar" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                   
                         
                            <div class="form-group">
                                <label for="longitude">  الطول</label>
                                <input type="text" class="form-control" name="length" id="exampleInputEmail1" placeholder="length">
                            </div>
                            <div class="form-group">
                                <label for="latitude"> العرض</label>
                                <input type="text" class="form-control" name="width" id="exampleInputPassword1"
                                    placeholder="width">
                            </div>
                            <div class="form-group">
                                <label for="latitude"> الإرتفاع</label>
                                <input  type="text" class="form-control" name="height" id="exampleInputPassword1"
                                    placeholder="height">
                            </div>

                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class=" footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
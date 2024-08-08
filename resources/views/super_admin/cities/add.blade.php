@extends('layouts.master')
@section('pageTitle', ' أضافة مدينة')
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => 'مدينة', 'type' => 'أضافة', 'iconClass' => 'fa-map-marker', 'url' => route('cities.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{route('cities.store')}}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">  أضافة مدينة جديدة </h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="abbreviation">أختصار أسم المدينة  </label>
                                <input type="text" class="form-control" name="abbreviation" id="abbreviation" placeholder="enter the abbreviation of city name">
                                @error('abbreviation')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">أسم المدينة باللغه الإنجليزية</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title English">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title_ar">أسم المدينة باللغه العربية</label>
                                <input type="text" class="form-control" name="title_ar" id="title_ar" placeholder="Title Arabic">
                                @error('title_ar')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="longitude">(longitude ) خطوط الطول</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" placeholder="longitude">
                            </div>
                            <div class="form-group">
                                <label for="latitude">(latitude ) خطوط العرض</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" placeholder="latitude">
                            </div>

                            <!-- New Checkboxes -->
                            <div class="form-group">
                            <label>الشركات المشغلة</label><br>
                                <input type="checkbox" name="smb" id="smb" value="1"> SMB<br>
                                <input type="checkbox" name="aymakan" id="aymakan" value="1"> Aymakan<br>
                                <input type="checkbox" name="labiah" id="labiah" value="1"> Labiah<br>
                                <input type="checkbox" name="jandt" id="jandt" value="1"> J&T<br>
                                @error('smb')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span><br>
                                @enderror
                                @error('aymakan')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span><br>
                                @enderror
                                @error('labiah')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span><br>
                                @enderror
                                @error('jandt')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">provinces</label>
                                <select  class="form-control select2" name="province_id" >
                                    @foreach($provinces as $province)
                                    <option value="{{$province->id}}">{{$province->name}}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div>

        </div>
        <div class="footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
        </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

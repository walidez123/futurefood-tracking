@extends('layouts.master')
@section('pageTitle',__('goods.generate_qr_code'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
<style>
.select2-container {
    width: 100% !important;
}
</style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('goods.generate_qr_code'), 'type' =>'', 'iconClass' => 'fa-print', 'url' =>
    route('goods.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('QR.store')}}" method="POST">
                @csrf


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{__('goods.generate_qr_code')}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <div   class="form-group ">
                                <label for="goods" class="control-label"> أختر نوع التشفير </label>

                                <div class="">
                                    <select required value="" class="form-control select2" name="type">
                                        <option value="QRcode"> QRcode</option>
                                        <option value="Barcode">Barcode</option>

                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        <div class="box-body">
                            <div class=" form-group">
                                <label for="goods" class="control-label"> أختر طباعة QR </label>

                                <div class="">
                                    <select id="cost_type" value="" class="form-control select2" name="category_id"
                                        required>
                                        <option value="0">أختر</option>
                                        <option value="1">بضائع</option>
                                        <option value="2"> فروع المستودع</option>


                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div style="display:none;" id="show1"  class="form-group ">
                                <label for="goods" class="control-label"> البضائع </label>

                                <div class="">
                                    <select value="" class="form-control select2" multiple name="good_id[]">
                                        <option value="">أختر البضاعه</option>
                                        @foreach ($goods as $good)
                                        <option value="{{$good->id}}">{{$good->trans('title')}}</option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display:none;" id="show2">
                                <div class=" form-group">
                                    <label for="goods" class="control-label"> فروع المستودع </label>
                                    <div class="">
                                        <select id="warhouse_id" value="" class="form-control select2"
                                            name="warhouse_id">
                                            <option value="">أختر الفرع</option>
                                            @foreach ($warhouse as $warhouse)
                                            <option value="{{$warhouse->id}}">{{$warhouse->trans('title')}}</option>
                                            @endforeach

                                        </select>
                                        @error('warhouse_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label for="goods" class="control-label"> محتويات المستودع</label>
                                    <div class="">
                                        <select id="content_type" value="" class="form-control select2"
                                            name="content_type">
                                            <option value="0">أختر </option>
                                            <option value="1">ستاند</option>
                                            <option value="2">دور</option>
                                            <option value="3">طبلية</option>


                                        </select>
                                        @error('warhouse_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                    <div class=" form-group">
                                        <label for="goods" class="control-label">أختر للطباعة</label>
                                        <div class="">
                                            <select multiple id="type_id"  class="form-control select2" name="type_id[]">
                                            </select>
                                            @error('type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class=" form-group">
                                        <label for="goods" class="control-label">طباعة المحتوى</label>
                                        <div class="">
                                            <input type="checkbox" name="all_content" id=""> yes
                                            <!-- <input type="checkbox" class="form-control" name="all_content" id=""> -->

                                         
                                            @error('type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                    <div class="form-group">
                                        <label for="name"> العدد </label>
                                        <input required type="number" class="form-control" name="number"
                                            id="exampleInputEmail1" placeholder="">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>




                                </div>
                            </div><!-- /.box -->
                        </div>

                    </div>
                    <div class=" footer">
                        <button type="submit" class="btn btn-primary">أنشاء QR</button>
                    </div>
            </form> <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>

@endsection
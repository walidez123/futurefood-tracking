@extends('layouts.master')
@section('pageTitle', trans('goods.Goods'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' =>trans('goods.Goods'), 'type' =>trans('goods.edit'), 'iconClass' => 'fa-map-marker', 'url' => route('goods.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('goods.update', $Good->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title"> @lang('goods.Goods')  @lang('goods.edit') </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                               
                            <div class="box-body">
                            <div class="form-group">
                                <div class=" image">
                                @if($Good->avatar==NULL)
                                <img src="{{asset('storage/'.$webSetting->logo)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @else
                                <img src="{{asset('storage/'.$Good->avatar)}}" class="img-circle" alt="User Image"
                                            width="130">

                                @endif
                               
                                </div>
                                    <div class="form-group" style="margin-top: 15px;">
                                        <label for="exampleInputFile">{{__('goods.photo')}}</label>
                                        <input name="image" type="file" id="exampleInputFile">

                                    </div>
                                </div>
                            <div class="form-group">
                                <label for="name">  @lang('goods.name')   {{__('admin_message.English')}}</label>
                                <input value="{{$Good->title_en}}" required type="text" class="form-control" name="title_en" id="exampleInputEmail1"
                                    placeholder="">
                                @error('title_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">  @lang('goods.name')   {{__('admin_message.Arabic')}}</label>
                                <input value="{{$Good->title_ar}}" required type="text" class="form-control" name="title_ar" id="exampleInputEmail1"
                                    placeholder="">
                                @error('title_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                                <div class="form-group">
                                <label for="name"> @lang('goods.skus')</label>
                                <input required value="{{$Good->SKUS}}" type="text" class="form-control" name="SKUS" id="exampleInputEmail1"
                                    placeholder="">
                                @error('SKUS')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class=" form-group">
                                <label for="goods" class="control-label"> @lang('goods.category') </label>

                                <div class="">
                                    <select  value="" class="form-control select2"
                                        name="category_id" >
                                        <option value="">@lang('admin_message.select') @lang('goods.category')</option>
                                        @foreach ($Categories as $Category)
                                        <option {{($Good->category_id == $Category->id) ? 'selected' : ''}} value="{{$Category->id}}">{{$Category->trans('title')}}</option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             <!-- new dimensions -->
                         
                             <div class="form-group">
                                <label for="name">@lang('goods.length')    </label>
                                <input  type="number" class="form-control"  value="{{$Good->length}}"  step="0.01" name="length" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> @lang('goods.width')    </label>
                                <input  type="number" class="form-control" value="{{$Good->width}}" step="0.01" name="width" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('width')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> @lang('goods.height')    </label>
                                <input  type="number" value="{{$Good->height}}" class="form-control" step="0.01" name="height" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="expire_date"> @lang('goods.expire_date') </label>
                                <div class="form-check">
                                    <input class="form-check-input" {{$Good->has_expire_date == 1 ? 'checked' : ''}} name="has_expire_date" value="1" type="checkbox"
                                        id="expire_checkbox">
                                    <label class="form-check-label" for="expire_checkbox">
                                        @lang('goods.expire_date_exit')
                                    </label>
                                </div>

                            </div>




                            <!-- end -->
                            <div class="form-group">
                                <label for="longitude">  @lang('goods.description') {{__('admin_message.English')}}</label>
                                <textarea type="text" class="textarea wysiwyg" name="description_en" id="exampleInputEmail1" placeholder="">{!!$Good->description_en!!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="longitude">  @lang('goods.description') {{__('admin_message.Arabic')}}</label>
                                <textarea type="text" class="textarea wysiwyg" name="description_ar" id="exampleInputEmail1" placeholder="">{!!$Good->description_ar!!}</textarea>
                            </div>
                   
                         
                        

                        </div>
                        </div><!-- /.box -->
                    </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">@lang('admin_message.save')</button>
            </div>
            </form> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{ asset('assets/wysiwyg-editor/js/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/wysiwyg-editor/wysiwyg-editor.js') }}"></script>
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        $('.select2').select2()
    });
</script>
@endsection
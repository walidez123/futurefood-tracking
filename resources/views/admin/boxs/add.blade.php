@extends('layouts.master')
@section('pageTitle', trans('admin_message.boxs'))
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' => trans('admin_message.boxs'), 'type' => trans('goods.add'), 'iconClass' => 'fa-solid fa-box', 'url' => route('boxs.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('boxs.store')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">


                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> @lang('goods.add')  @lang('admin_message.boxs')</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"> @lang('goods.name')  {{__('admin_message.English')}} </label>
                                <input required type="text" class="form-control" name="name_en" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">  @lang('goods.name')  {{__('admin_message.Arabic')}} </label>
                                <input required type="text" class="form-control" name="name_ar" id="exampleInputEmail1"
                                    placeholder="">
                                @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            
                            <div class="form-group">
                                <label for="name">  @lang('admin_message.box number')   </label>
                                <input required type="text" class="form-control" name="box_number" id="exampleInputEmail1"
                                    placeholder="">
                                @error('box_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                          
                            <!-- new dimensions -->
                         
                            <div class="form-group">
                                <label for="name">@lang('goods.length')    </label>
                                <input  type="number" class="form-control" step="0.01" name="length" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> @lang('goods.width')    </label>
                                <input  type="number" class="form-control" step="0.01" name="width" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('width')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name"> @lang('goods.height')    </label>
                                <input  type="number" class="form-control" step="0.01" name="height" id="exampleInputEmail1"
                                    placeholder="@lang('goods.cm')">
                                @error('height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>




                            <!-- end -->

                            <div class="form-group">
                                <label for="longitude">  @lang('goods.description') {{__('admin_message.English')}}</label>
                                <textarea type="text" class="textarea wysiwyg" name="description_en" id="exampleInputEmail1" placeholder=""></textarea>
                            </div>
                   
                         
                            <div class="form-group">
                                <label for="longitude">  @lang('goods.description') {{__('admin_message.Arabic')}}</label>
                                <textarea type="text" class="textarea wysiwyg" name="description_ar" id="exampleInputEmail1" placeholder=""></textarea>
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
@endsection
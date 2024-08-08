@extends('layouts.master')
@section('pageTitle',__("admin_message.Tier") .' '.__("admin_message.Edit") )
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
<style>

.select2-container {
    width: 100% !important;}
    </style>

@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', ['title' =>__("admin_message.Tier"), 'type' =>__("admin_message.Edit"), 'iconClass' => 'fa-map-marker', 'url' => route('CityZone.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('CityZone.update', $zone->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                   
                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__("admin_message.Edit")}} {{__("admin_message.Tier")}}</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                        
                   
                        <div class="box-body">
                            <div class="form-group">
                            <label for="name">{{ __('admin_message.Tier')}} {{ __('admin_message.English')}}   </label>
                                <input  value="{{$zone->title}}" type="text" class="form-control" name="title" id="exampleInputEmail1"
                                    placeholder="{{ __('admin_message.Tier')}} {{ __('admin_message.English')}}">
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('admin_message.Tier')}} {{ __('admin_message.Arabic')}}   </label>
                                <input  value="{{$zone->title_ar}}" type="text" class="form-control" name="title_ar" id="exampleInputEmail1"
                                    placeholder="{{ __('admin_message.Tier')}} {{ __('admin_message.Arabic')}} ">
                                @error('title_ar')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="name">{{__('admin_message.City')}}</label>
                                <select   multiple class="form-control select2" name="city[]" >
                                    @foreach($cities as $city)
                                    @php  $id=$city->id;  @endphp
                                    <option {{(in_array($id, $arrZones)) ? 'selected' : ''}}   value="{{$city->id}}">{{$city->trans('title')}}</option>
                                    @endforeach
                                </select>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                         

                        </div>
                    </div><!-- /.box -->
                </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
            </div>
            </form> <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection
@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>
@endsection
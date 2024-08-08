@extends('layouts.master')
@section('pageTitle',__('admin_message.Edit')." ". __('admin_message.Neighborhood Tilrs'))
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
        @include('layouts._header-form', ['title' => __('admin_message.Neighborhood Tilrs'), 'type' =>__('admin_message.Edit'), 'iconClass' => 'fa-map-marker', 'url' => route('RegionZone.index'), 'multiLang' => 'false'])
    
        <!-- Main content -->
        <section class="content">
            <div class="row">
    
                <form action="{{route('RegionZone.update', $zone->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="" id="zone_id" value="{{$zone->id}}">
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{__("admin_message.Edit")}} {{ __('admin_message.Neighborhood Tilrs')}} </h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
    
                            <div class="box-body">
                                <div class="form-group">
                                <label for="name">{{ __('admin_message.Title')}} {{ __('admin_message.Tier')}} {{ __('admin_message.English')}}   </label>
                                    <input type="text" class="form-control" value="{{$zone->title}}" name="title" id="exampleInputEmail1"
                                        placeholder="{{ __('admin_message.Title')}} {{ __('admin_message.Tier')}} {{ __('admin_message.English')}}">
                                    @error('title')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label for="name">{{ __('admin_message.Title')}} {{ __('admin_message.Tier')}} {{ __('admin_message.Arabic')}}   </label>
                                    <input type="text" class="form-control" value="{{$zone->title_ar}}" name="title_ar" id="exampleInputEmail1"
                                        placeholder="{{ __('admin_message.Title')}} {{ __('admin_message.Tier')}} {{ __('admin_message.Arabic')}}">
                                    @error('title_ar')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label for="name">{{__('admin_message.City')}}</label>
                                <select  class="form-control select2" name="city_id" id="city_id_edit" >
                                <option value="">{{__('admin_message.Select')}} {{__('admin_message.City')}}</option>

                                    @foreach($cities as $city)
                                    @if($zone->city_id==$city->id)
                                    <option selected value="{{$city->id}}">{{$city->trans('title')}}</option>
                                    @else
                                    <option  value="{{$city->id}}">{{$city->trans('title')}}</option>


                                    @endif



                                    @endforeach
                                </select>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                <label for="name">{{ __('admin_message.neighborhood')}}</label>
                                <select multiple  class="form-control select2" name="neighborhood_id[]" id="neighborhood_id_edit">
                                    @foreach($regions as $region)
                                    @php  $id=$region->id;  @endphp

                                    <option  {{(in_array($id, $arrZones)) ? 'selected' : ''}}  value="{{$region->id}}">{{$region->trans('title')}}</option>





                                    @endforeach
                                </select>
                                @error('title')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                    
                        </div><!-- /.box -->
                    </div>
    
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">{{ __('admin_message.save')}}</button>
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
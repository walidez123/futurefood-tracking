@extends('layouts.master')
@section('pageTitle',__('admin_message.Warehouse Branches'))
@section('css')
<link rel="stylesheet" href="{{asset('assets/bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('nav')
@include(auth()->user()->user_type.'.layouts._nav')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts._header-form', ['title' =>__('admin_message.Warehouse Branches'), 'type' => __('app.edit'), 'iconClass' => 'fa-map-marker', 'url' =>
    route('warehouse_branches.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
            <div class="row">

                <form action="{{route('warehouse_branches.update', $branch->id.'')}}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;" >
                    @csrf
                    @method('PUT')
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                        <!-- work type -->
                          <!--  -->
                          <div class="form-group">
                                <label for="firstname" class="control-label"> {{__('admin_message.Work Type')}}*</label>

                                <div class="">
                                <select id="cost_type" class="form-control select2" name="work" required>
                                            <option  value="">{{__('admin_message.Select')}} {{__('admin_message.Work Type')}}</option>
                                            @if (in_array(3, $user_type))

                                            <option {{($branch->work ==1) ? 'selected' : ''}}  value="1">{{__('admin_message.Warehouses')}}</option>
                                            @endif
                                            @if (in_array(4, $user_type))

                                            <option {{($branch->work ==2) ? 'selected' : ''}} value="2">{{__('fulfillment.fulfillment')}}</option>
                                            @endif
                                            @if (in_array(4, $user_type) && in_array(3, $user_type))

                                            <option {{($branch->work ==3) ? 'selected' : ''}} value="3">{{__('admin_message.Warehouses')}} & {{__('fulfillment.fulfillment')}}</option>
                                            @endif
                                        </select>
                                        @error('work')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>



                            <!--  -->



                        <!-- end work type -->

                            <!-- form start -->
                            

                            <div class="box-body">
                                    <div class="form-group">
                                    <label for="firstname" class="control-label">@lang('app.title')  {{__('admin_message.English')}} *</label>

                                    <div class="">
                                        <input type="text" name="title" value="{{ $branch->title }}" class="form-control" id="fullname"
                                            placeholder="full name" required>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="firstname" class="control-label">@lang('app.title')  {{__('admin_message.Arabic')}}*</label>

                                <div class="">
                                    <input type="text" name="title_ar" value="{{ $branch->title_ar }}" class="form-control"
                                         required>
                                    @error('title_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="lastname" class="control-label">@lang('app.city') *</label>
                                    <div class="">
                                        <select id="city_id" class="form-control select2" name="city_id" required>
                                            <option value="">@lang('app.select', ['attribute' => __('app.city')])</option>
                                            @foreach ($cities as $city)
                                            <option {{($branch->city_id == $city->id) ? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
                                            @endforeach

                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                              
                       


                                <div class="form-group">
                                    <label for="phone" class="control-label">@lang('app.area')</label>

                                    <div class="">
                                        <input type="text" name="area" value="{{$branch->area }}" class="form-control" id="phone" placeholder="area">
                                        @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="firstname" class="control-label">(longitude) خطوط الطول</label>

                                    <div class="">
                                        <input type="text" name="longitude" value="{{ $branch->longitude }}" class="form-control locatinId" id="longitude"
                                            placeholder="longitude" required>
                                        @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                                                <div class="form-group">
                                                                <label for="firstname" class="control-label">(latitude) خطوط العرض</label>

                                    <div class="">
                                        <input type="text" name="latitude" value="{{ $branch->latitude }}" class="form-control locatinId" id="latitude"
                                            placeholder="latitude" required>
                                        @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="mapCanv" style="width:100%;height:400px"></div>


                            </div>
                        </div><!-- /.box -->
                    </div>

            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            </div>
            </form> <!-- /.row -->
                     
        </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection

@section('js')
<script src="{{asset('assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
$(function () {
         $('.select2').select2()
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_maps.key')}}&language=ar"></script>
    <script type="text/javascript">
        let map, marker;

        function initialise() {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById("latitude").value = <?= $branch->latitude ?>;
                document.getElementById("longitude").value = <?= $branch->longitude ?>;
                var latitude =  <?= $branch->latitude ?>;

                var longitude =  <?= $branch->longitude ?>;
                console.log(position.coords)
                var mapCanvas = document.getElementById("mapCanv");

                var myCenter = new google.maps.LatLng(latitude, longitude);
                var mapOptions = {
                    center: myCenter,
                    zoom: 14
                };
                map = new google.maps.Map(mapCanvas, mapOptions);
                marker = new google.maps.Marker({
                    position: myCenter,
                    draggable: true,
                });
                marker.setMap(map);
                geocodePosition(marker.getPosition());
                new google.maps.event.addListener(marker, 'dragend', function() {

                    geocodePosition(marker.getPosition());
                    $("#latitude").val(this.getPosition().lat());
                    $("#longitude").val(this.getPosition().lng());

                });

            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
            //var geoloccontrol = new klokantech.GeolocationControl(map, 20);

        }
        $(".locatinId").bind('change paste keyup', function() {
            var latitude = document.getElementById("latitude").value;

            var longitude = document.getElementById("longitude").value;
            var latLng = new google.maps.LatLng(latitude, longitude);
            map.setCenter(latLng);
            marker.setPosition(latLng);

        })
        google.maps.event.addDomListener(window, 'load', initialise);


        function geocodePosition(pos) {
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: pos

            }, function(responses) {
                if (responses && responses.length > 0) {
                    $("#address_ar-field").val(responses[0].formatted_address);
                }
            });
        }
    </script>

@endsection

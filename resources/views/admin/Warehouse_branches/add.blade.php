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
    @include('layouts._header-form', ['title' =>__('admin_message.Warehouse Branches'), 'type' => __('app.add'), 'iconClass' => 'fa-map-marker', 'url' =>
    route('warehouse_branches.index'), 'multiLang' => 'false'])

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <form action="{{route('warehouse_branches.store')}}" method="POST" class="box  col-md-12"
                style="border: 0px; padding:10px;" >
                @csrf
                <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">

                <div class="col-md-12 ">
                    <!-- general form elements -->
                    <div class="box box-primary" style="padding: 10px;">

                        <!-- form start -->

                        <div class="box-body">
                            <!--  -->
                            <div class="form-group">
                                <label for="firstname" class="control-label"> {{__('admin_message.Work Type')}}*</label>

                                <div class="">
                                <select id="cost_type" class="form-control select2" name="work" required>
                                            <option  value="">{{__('admin_message.Select')}} {{__('admin_message.Work Type')}}</option>
                                            @if (in_array(3, $user_type))

                                            <option {{(old('work') ==1) ? 'selected' : ''}}  value="1">{{__('admin_message.Warehouses')}}</option>
                                            @endif
                                            @if (in_array(4, $user_type))

                                            <option {{(old('work') ==2) ? 'selected' : ''}} value="2">{{__('fulfillment.fulfillment')}}</option>
                                            @endif
                                            @if (in_array(4, $user_type) && in_array(3, $user_type))

                                            <option {{(old('work') ==3) ? 'selected' : ''}} value="3">{{__('admin_message.Warehouses')}} & {{__('fulfillment.fulfillment')}}</option>
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
                               <div class="form-group">
                                <label for="firstname" class="control-label">@lang('app.title') {{__('admin_message.English')}} *</label>

                                <div class="">
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                         required>
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
                                    <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-control"
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
                                        <option {{(old('city_id') ==$city->id) ? 'selected' : ''}} value="{{$city->id}}">{{$city->trans('title')}}</option>
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
                                <label for="email" class="control-label">@lang('app.area', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="area" type="text" value="{{old('area')}}" class="form-control" id="inputEmail" required>
                                    @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                             <!--  -->
                             @if(old('work')==1 || old('work')==3)
                             <div id="show1">

                             @else
                             <div id="show1"   style="display: none;">

                             @endif
                             <h3>@lang('app.Warehouse details') :</h3>
                             <div class="form-group">
                                <label for="email" class="control-label">@lang('app.stand number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="stands" type="text" value="{{old('stands')}}" class="form-control" id="inputEmail" >
                                    @error('stands')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.floor number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="floors" type="text" value="{{old('floors')}}" class="form-control" id="inputEmail" >
                                    @error('floors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.package number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="packages" type="text" value="{{old('packages')}}" class="form-control" id="inputEmail" >
                                    @error('packages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            <!-- show fulfillment -->
                            @if(old('work')==2 || old('work')==3)
                             <div id="show2">

                             @else
                             <div id="show2"   style="display: none;">

                             @endif                            <h3>@lang('app.Fulfillment details') :</h3>
                             <div class="form-group">
                                <label for="email" class="control-label">@lang('app.stand number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="fulfillment_stands" value="{{old('fulfillment_stands')}}" type="text" class="form-control" id="inputEmail" >
                                    @error('fulfillment_stands')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.floor number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="fulfillment_floors" value="{{old('fulfillment_floors')}}" type="text" class="form-control" id="inputEmail" >
                                    @error('fulfillment_floors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">@lang('app.Shelves number', ['attribute' => '']) </label>

                                <div class="">
                                    <input  name="fulfillment_packages" type="text"  value="{{old('fulfillment_packages')}}" class="form-control" id="inputEmail" >
                                    @error('fulfillment_packages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            </div>






                             <!--  -->
                            <div class="form-group">
                            <label for="firstname" class="control-label">(longitude) خطوط الطول</label>

                                    <div class="">
                                        <input type="text" name="longitude" id="longitude"  value="{{old('longitude')}}" class="form-control locatinId" id="fullname"
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
                                        <input type="text" name="latitude" id="latitude" value="{{old('latitudes')}}" class="form-control locatinId" id="fullname"
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
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
                var latitude = position.coords.latitude;

                var longitude = position.coords.longitude;
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

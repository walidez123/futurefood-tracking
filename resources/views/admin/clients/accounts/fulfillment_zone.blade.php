@foreach($zones as $zone)
<label style="color: crimson;" for="" class="control-label">{{__("admin_message.Enter account values for tier")}} {{$zone->trans('title')}} </label>
<hr>
<input type="hidden" name="zone_id[]" value="{{$zone->id}}">
<div class="row">
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__("admin_message.Delivery cost inside")}} {{$zone->trans('title')}}</label>
    <div class="">
        <input  type="number" step="any" min="0" class="form-control" name="cost_inside_zone[]"
            placeholder="{{__('admin_message.Delivery cost inside')}} {{$zone->trans('title')}}" >
        @error('cost_inside_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.Delivery cost outside')}} {{$zone->trans('title')}} </label>

    <div class="">
        <input  type="number" step="any" min="0" class="form-control"
            name="cost_outside_zone[]" placeholder="{{__('admin_message.Delivery cost outside')}} {{$zone->trans('title')}}" >
        @error('cost_outside_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.Reshipping cost inside')}} {{$zone->trans('title')}} </label>
    <div class="">
        <input  type="number" step="any" min="0" name="cost_reshipping_zone[]" class="form-control"
            placeholder="{{__('admin_message.Reshipping cost inside')}} {{$zone->trans('title')}}">
        @error('cost_reshipping_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.Reshipping cost outside')}} {{$zone->trans('title')}}</label>
    <div class="">
        <input  type="number" step="any" min="0" name="cost_reshipping_out_zone[]"
            class="form-control" placeholder="{{__('admin_message.Reshipping cost outside')}} {{$zone->trans('title')}}">
        @error('cost_reshipping_out_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label"> {{__('admin_message.fees cost delivery inside')}} {{$zone->trans('title')}}</label>

    <div class="">
        <input value="" type="number"  step="any"min="0" name="fees_cash_on_delivery_zone[]"
            class="form-control" placeholder=" {{__('admin_message.fees cost delivery inside')}} {{$zone->trans('title')}}"  >
        @error('fees_cash_on_delivery_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label"> *{{__('admin_message.fees cost delivery outside')}} {{$zone->trans('title')}}</label>

    <div class="">
        <input  type="number" step="any" min="0"
            name="fees_cash_on_delivery_out_zone[]" class="form-control"
            placeholder="{{__('admin_message.fees cost delivery outside')}} {{$zone->trans('title')}}" >
        @error('fees_cash_on_delivery_out_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.fees pickup')}}</label>

    <div class="">
        <input  type="number" step="any" min="0" class="form-control" name="pickup_fees_zone[]"
            placeholder="{{__('admin_message.fees pickup')}}" >
        @error('pickup_fees_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.over weight per kilo inside')}} {{$zone->trans('title')}}</label>

    <div class="">
        <input  type="number" step="any" min="0" class="form-control"
            name="over_weight_per_kilo_zone[]" placeholder="{{__('admin_message.over weight per kilo inside')}} {{$zone->trans('title')}}" >
        @error('over_weight_per_kilo_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.over weight per kilo outside')}} {{$zone->trans('title')}}</label>

    <div class="">
        <input  type="number" step="any" min="0" class="form-control"
            name="over_weight_per_kilo_outside_zone[]" placeholder="{{__('admin_message.over weight per kilo inside')}} {{$zone->trans('title')}}" >
        @error('over_weight_per_kilo_outside_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.standard weight inside')}} {{$zone->trans('title')}}</label>
    <div class="">
        <input  type="number" step="any" min="0" class="form-control" name="standard_weight_zone[]"
            placeholder="{{__('admin_message.standard weight inside')}}  {{$zone->trans('title')}}" >
        @error('standard_weight_zone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 col-lg-6 form-group">
    <label for="" class="control-label">{{__('admin_message.standard weight outside')}} {{$zone->trans('title')}}</label>
    <div class="">
        <input  type="number" step="any" min="0" class="form-control"
            name="standard_weight_outside_zone[]" placeholder="{{__('admin_message.standard weight outside')}} {{$zone->trans('title')}}" >
        @error('standard_weight_outside')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
</div>
@endforeach
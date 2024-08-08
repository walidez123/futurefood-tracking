<div class="row">

@if (in_array(2, $user_type))

<div class="col-md-6">

<div class="form-group">
    <label for="exampleInputEmail1">{{ __('admin_message.Determine pick up status for restaurants') }} (pickup)</label>
    <select class="form-control" name="status_pickup_res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->status_pickup_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('default_status_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif

@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status of the returned order for restaurants') }}</label>
    <select class="form-control" name="status_return_res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->status_return_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('default_status_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif

@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the condition in which it is useful to create returns for restaurants') }}</label>
    <select class="form-control" name="status_can_return_res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->status_can_return_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('default_status_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif

@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, after which it is not useful to change the status for restaurants') }}</label>
    <select class="form-control" name="status_res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->status_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif

<!-- new -->
@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, after save order for restaurants') }}</label>
    <select class="form-control" name="default_status_id_Res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->default_status_id_Res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif
<!--  -->
@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, calculate cost  order for restaurants') }}</label>
    <select class="form-control" name="cost_calc_status_Res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->cost_calc_status_Res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif
@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, calculate fees for delivery for restaurants') }}</label>
    <select class="form-control" name="calc_cash_delivery_status_Res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->calc_cash_delivery_status_Res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif

@if (in_array(2, $user_type))
<div class="col-md-6">

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, calculate cost for reshipping for restaurants') }}</label>
    <select class="form-control" name="cost_reshipping_status_Res" >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $user->cost_reshipping_status_Res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
            {{ $status->trans('title') }}</option>
        @endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
</div>
@endif
</div>
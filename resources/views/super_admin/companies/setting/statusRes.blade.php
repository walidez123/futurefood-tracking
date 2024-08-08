@if (in_array(2, $setiing_type))

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status of the returned order for restaurants') }}</label>
    <select class="form-control" name="status_return_res" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $setiing->status_return_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
@endif
@if (in_array(2, $setiing_type))


<div class="form-group">
    <label for="exampleInputEmail1">{{ __('admin_message.Determine pick up status for restaurants') }}</label>
    <select class="form-control" name="status_pickup_res" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $setiing->status_pickup_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
@endif
@if (in_array(2, $setiing_type))

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the condition in which it is useful to create returns for restaurants') }}</label>
    <select class="form-control" name="status_can_return_res" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $setiing->status_can_return_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
@endif

@if (in_array(2, $setiing_type))

<div class="form-group">
    <label
        for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, after which it is not useful to change the status for restaurants') }}</label>
    <select class="form-control" name="status_res" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if ($status->restaurant_appear == 1)
        <option {{ $setiing->status_res == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
@endif
@if(in_array(2,$setiing_type))
<div class="form-group">
    <label for="exampleInputEmail1"> تحديد حالة التى ينفع لا ينفع تغير الحالة بعدها
        للمطاعم</label>
    <select class="form-control" name="status_res" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
        </option>
        @foreach ($Status as $status)
        @if($status->restaurant_appear==1)

        <option {{($setiing->status_res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
            {{$status->trans('title')}}</option>@endif
        @endforeach


    </select>
    @error('status_res')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
@endif
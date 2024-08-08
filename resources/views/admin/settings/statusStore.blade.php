<div class="row">
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{ __('admin_message.Determine pick up status for stores') }} (pickup)</label>
        <select class="form-control" name="status_pickup">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->status_pickup == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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

<!--  -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label
            for="exampleInputEmail1">{{ __('admin_message.Determine the status of the returned order for stores') }}</label>
        <select class="form-control" name="status_return_shop">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->status_return_shop == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label
            for="exampleInputEmail1">{{ __('admin_message.Determine the condition in which it is useful to create a return for stores') }}</label>
        <select class="form-control" name="status_can_return_shop">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->status_can_return_shop == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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

@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label
            for="exampleInputEmail1">{{ __('admin_message.Determine the status in which it is useful, after which it is not useful to change the status for the stores') }}</label>
        <select class="form-control" name="status_shop">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->status_shop == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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

@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.Save order status')}} {{__('admin_message.Client')}}</label>
        <select class="form-control" name="default_status_id_store">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
                <div class="col-md-6">
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->default_status_id_store == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
<!-- 2 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.update order status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="edit_status_id_store">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->edit_status_id_store == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
<!-- 3 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.Delete order status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="delete_status_id_store">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->delete_status_id_store == $status->id ? 'selected' : '' }} value="{{ $status->id }}">
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
<!-- 4 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.Delivery cost is calculated based on the status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="cost_calc_status_inside_city">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->cost_calc_status_inside_city == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
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
<!-- 5 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.Delivery cost is calculated based on the status outside')}}
            {{__('admin_message.City')}} {{__('admin_message.Client')}}</label>
        <select class="form-control" name="cost_calc_status_outside_city">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->cost_calc_status_outside_city == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
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

<!-- 6 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label
            for="exampleInputEmail1">{{__('admin_message.Delivery cost Fees from customer is calculated based on the status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="calc_cash_delivery_fees_status_store">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->calc_cash_delivery_fees_status_store == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
                {{ $status->trans('title') }}</option>
            @endif
            @endforeach


        </select>
        @error('calc_cash_delivery_fees_status_store')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif

<!-- 7 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label
            for="exampleInputEmail1">{{__('admin_message.Delivery cost reshipping  from customer is calculated based on the status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="cost_reshipping_status_store">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->cost_reshipping_status_store == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
                {{ $status->trans('title') }}</option>
            @endif
            @endforeach


        </select>
        @error('cost_reshipping_status_store')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif
<!-- 8 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.overweight price (In City)calculate in this status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="overweight_status_inside_city">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->overweight_status_inside_city == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
                {{ $status->trans('title') }}</option>
            @endif
            @endforeach


        </select>
        @error('overweight_status_inside_city')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif
<!-- 9 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.overweight price (out City)calculate in this status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="overweight_status_outside_city">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->overweight_status_outside_city == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
                {{ $status->trans('title') }}</option>
            @endif
            @endforeach


        </select>
        @error('overweight_status_outside_city')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif
<!-- 10 -->
@if (in_array(1, $user_type))
<div class="col-md-6">

    <div class="form-group">
        <label for="exampleInputEmail1">{{__('admin_message.Collect Orders from customer in this status')}}
            {{__('admin_message.Client')}}</label>
        <select class="form-control" name="available_collect_order_status">
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}
            </option>
            @foreach ($Status as $status)
            @if ($status->shop_appear == 1)
            <option {{ $user->available_collect_order_status == $status->id ? 'selected' : '' }}
                value="{{ $status->id }}">
                {{ $status->trans('title') }}</option>
            @endif
            @endforeach


        </select>
        @error('available_collect_order_status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endif
</div>
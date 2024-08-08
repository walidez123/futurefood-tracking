@if($client->work==1 )

<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label"> {{__('admin_message.Save order status')}}</label>

    <div class="">
        <select class="form-control" name="default_status_id" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($client->work==1 || $client->work==4 )
                @if($status->shop_appear==1)
                    <option {{($client->default_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                        {{$status->trans('title')}}</option>
                @elseif($status->fulfillment_appear==1)
                <option {{($client->default_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                    {{$status->trans('title')}}</option>@endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($client->default_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option> @endif
            @endif
            
            @endforeach
        </select>
        @error('default_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>


<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label">{{__('admin_message.Delivery cost is calculated based on the status')}}
        *</label>

    <div class="">
        <select class="form-control" name="cost_calc_status_id" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($client->work==1 )
            @if($status->shop_appear==1)

            <option {{($client->cost_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option>@endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($client->cost_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option> @endif


            @endif
            @endforeach

        </select>
        @error('cost_calc_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 form-group">
    <label for="lastname"
        class="control-label">*{{__('admin_message.Delivery cost is calculated based on the status outside')}}</label>

    <div class="">
        <select class="form-control" name="cost_calc_status_id_outside" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($client->work==1)
            @if($status->shop_appear==1)

            <option {{($client->cost_calc_status_id_outside == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option>@endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($client->cost_calc_status_id_outside == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option> @endif


            @endif
            @endforeach

        </select>
        @error('cost_calc_status_id_outside')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 form-group">
    <label for="lastname"
        class="control-label">{{__('admin_message.Delivery cost Fees from customer is calculated based on the status')}}</label>

    <div class="">
        <select class="form-control" name="calc_cash_on_delivery_status_id" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($client->work==1)
            @if($status->shop_appear==1)

            <option {{($client->calc_cash_on_delivery_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option>@endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($client->calc_cash_on_delivery_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                 {{$status->trans('title')}}</option> @endif


            @endif
            @endforeach

        </select>
        @error('calc_cash_on_delivery_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label">
        *{{__('admin_message.Delivery cost reshipping  from customer is calculated based on the status')}}</label>
    <div class="">
        <div class="">
            <select class="form-control" name="cost_reshipping_calc_status_id" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->cost_reshipping_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>@endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->cost_reshipping_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option> @endif

                @endif
                @endforeach

            </select>
            @error('cost_reshipping_calc_status_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">{{ __('admin_message.update order status') }}</label>
    
        <div class="">
            <select class="form-control" name="available_edit_status" required>
                <option value="">{{ __('admin_message.Select') }} {{ __('admin_message.status') }}</option>
                @foreach ($statuses as $status)
                    @php
                        $oldValue = old('available_edit_status', $client->default_status_id);
                        $isSelected = ($oldValue == $status->id) ? 'selected' : '';
                    @endphp
    
                    @if ($client->work == 1 && $status->shop_appear == 1)
                        <option {{ $isSelected }} value="{{ $status->id }}">
                            {{ $status->trans('title') }}
                        </option>
                    @elseif ($client->work == 4 && $status->fulfillment_appear == 1)
                        <option {{ $isSelected }} value="{{ $status->id }}">
                            {{ $status->trans('title') }}
                        </option>
                    @elseif ($client->work == 2 && $status->restaurant_appear == 1)
                        <option {{ $isSelected }} value="{{ $status->id }}">
                            {{ $status->trans('title') }}
                        </option>
                    @endif
                @endforeach
            </select>
    
            @error('available_edit_status')
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label"> {{__('admin_message.Delete order status')}}</label>

        <div class="">
            <select class="form-control" name="available_delete_status" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->available_delete_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>@endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->available_delete_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option> @endif


                @endif
                @endforeach

            </select>
            @error('available_delete_status')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">
            {{__('admin_message.overweight price (In City)calculate in this status')}}</label>

        <div class="">
            <select class="form-control" name="available_overweight_status" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->available_overweight_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>@endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->available_overweight_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option> @endif


                @endif
                @endforeach

            </select>
            @error('available_overweight_status')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">
            {{__('admin_message.overweight price (out City)calculate in this status')}}</label>

        <div class="">
            <select class="form-control" name="available_overweight_status_outside" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->available_overweight_status_outside == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>@endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->available_overweight_status_outside == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option> @endif


                @endif
                @endforeach

            </select>
            @error('available_overweight_status_outside')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>



    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">
            {{__('admin_message.Collect Orders from customer in this status')}}</label>

        <div class="">
            <select class="form-control" name="available_collect_order_status" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->available_collect_order_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>@endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->available_collect_order_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option> @endif


                @endif
                @endforeach

            </select>
            @error('available_collect_order_status')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
@elseif($client->work==4)
    @include('admin.clients.accounts.fulfillment_status_edit')
@else
    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">{{__('admin_message.Save order status')}}</label>
        <div class="">
            <select class="form-control" name="default_status_id" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($status->restaurant_appear==1)
                <option {{($client->default_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>
                @endif
                @endforeach

            </select>
            @error('default_status_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <!-- available_edit_status -->
    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">{{__('admin_message.Edit & Delete order status')}}</label>
        <div class="">
            <select class="form-control" name="available_edit_status" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($status->restaurant_appear==1)
                <option {{($client->available_edit_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>
                @endif
                @endforeach

            </select>
            @error('available_edit_status')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>



    <!-- edit & delete for resturant -->
    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label"> *
            {{__('admin_message.Delivery cost is calculated based on the status')}}</label>
        <div class="">
            <select class="form-control" name="cost_calc_status_id" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->cost_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>
                @endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->cost_calc_status_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                     {{$status->trans('title')}}</option>
                @endif


                @endif
                @endforeach

            </select>
            @error('cost_calc_status_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">
            {{__('admin_message.Delivery cost Fees from customer is calculated based on the status')}}</label>
        <div class="">
            <select class="form-control" name="calc_cash_on_delivery_status_id" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->calc_cash_on_delivery_status_id == $status->id) ? 'selected' : ''}}
                    value="{{$status->id}}"> {{$status->trans('title')}}</option>
                @endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->calc_cash_on_delivery_status_id == $status->id) ? 'selected' : ''}}
                    value="{{$status->id}}"> {{$status->trans('title')}}</option>
                @endif


                @endif
                @endforeach

            </select>
            @error('calc_cash_on_delivery_status_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-xs-12 form-group">
        <label for="lastname" class="control-label">
            *{{__('admin_message.Delivery cost reshipping  from customer is calculated based on the status')}}</label>
        <div class="">
            <select class="form-control" name="cost_reshipping_calc_status_id" required>
                <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($client->work==1)
                @if($status->shop_appear==1)

                <option {{($client->cost_reshipping_calc_status_id == $status->id) ? 'selected' : ''}}
                    value="{{$status->id}}"> {{$status->trans('title')}}</option>
                @endif
                @else
                @if($status->restaurant_appear==1)

                <option {{($client->cost_reshipping_calc_status_id == $status->id) ? 'selected' : ''}}
                    value="{{$status->id}}"> {{$status->trans('title')}}</option>
                @endif


                @endif
                @endforeach

            </select>
            @error('calc_cash_on_delivery_status_id')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>



    @endif
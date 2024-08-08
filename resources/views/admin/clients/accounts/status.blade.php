@if($work==1)
<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label">* {{__('admin_message.Save order status')}}</label>
    <div class="">
        <select class="form-control" name="default_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==1)
                    @if($status->shop_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
              
                @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                
                @else
                    @if($status->restaurant_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
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
    <label for="lastname" class="control-label"> {{__('admin_message.update order status')}}</label>
        <div class="">
            <select class="form-control" name="available_edit_status" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)
                @if($work==1)
                @if($status->shop_appear==1)
    
                <option {{($companySetting->edit_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif
                @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @else
                @if($status->restaurant_appear==1)
    
                <option {{($companySetting->edit_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif
    
    
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
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->delete_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->delete_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif


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
        
    <label for="lastname" class="control-label"> {{__('admin_message.Collect Orders from customer in this status')}}</label>

<div class="">
    <select class="form-control" name="available_collect_order_status" required>
    <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
        @foreach ($statuses as $status)
        @if($work==1)
        @if($status->shop_appear==1)

        <option {{($companySetting->available_collect_order_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>@endif
        @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
        @else
        @if($status->restaurant_appear==1)

        <option {{($companySetting->available_collect_order_status == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option> @endif


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
<div class="col-xs-12 form-group">
<label for="lastname" class="control-label"> {{__('admin_message.overweight price (In City)calculate in this status')}}</label>

    <div class="">
        <select class="form-control" name="available_overweight_status" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->overweight_status_inside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>@endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->overweight_status_inside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option> @endif


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
<label for="lastname" class="control-label"> {{__('admin_message.overweight price (out City)calculate in this status')}}</label>

    <div class="">
        <select class="form-control" name="available_overweight_status_outside" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option  {{($companySetting->overweight_status_outside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>@endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option  {{($companySetting->overweight_status_outside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option> @endif


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
<label for="lastname" class="control-label">{{__('admin_message.order cost status inside city')}}</label>

    <div class="">
        <select class="form-control" name="calc_cash_on_delivery_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->calc_cash_delivery_fees_status_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->calc_cash_delivery_fees_status_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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
<label for="lastname" class="control-label">*{{__('admin_message.Delivery cost is calculated based on the status outside')}}</label>

    <div class="">
        <select class="form-control" name="cost_calc_status_id_outside" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->cost_calc_status_outside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>

                @endif
                @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->cost_calc_status_outside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>

         @endif


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


<!--  -->
<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label">*{{__('admin_message.Delivery cost is calculated based on the status')}}</label>
    <div class="">
        <select class="form-control" name="cost_calc_status_id" required>
            <option  value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->cost_calc_status_inside_city == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option value="{{$status->id}}">{{$status->trans('title')}}</option>
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
         *{{__('admin_message.Delivery cost reshipping  from customer is calculated based on the status')}}</label>
    <div class="">
        <select class="form-control" name="cost_reshipping_calc_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->cost_reshipping_status_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->cost_reshipping_status_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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

@elseif($work==4)
    @include('admin.clients.accounts.fulfillment_status')
@else
<div class="col-xs-12 form-group">
    <label for="lastname" class="control-label">{{__('admin_message.Save order status')}}</label>
    <div class="">
        <select class="form-control" name="default_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->default_status_id_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->default_status_id_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif


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
                <option {{($companySetting->default_status_id_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
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
    <label for="lastname" class="control-label"> * {{__('admin_message.Delivery cost is calculated based on the status')}}</label>
    <div class="">
        <select class="form-control" name="cost_calc_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->cost_calc_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->cost_calc_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->calc_cash_delivery_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)

            <option {{($companySetting->calc_cash_delivery_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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
        <select class="form-control" name="cost_reshipping_calc_status_id" required >
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
            @if($work==1)
            @if($status->shop_appear==1)

            <option {{($companySetting->cost_reshipping_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
            @endif
            @elseif($work==4)
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
            @else
            @if($status->restaurant_appear==1)


            <option {{($companySetting->cost_reshipping_status_Res == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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
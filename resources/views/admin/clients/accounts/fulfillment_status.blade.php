
<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('admin_message.Save order status')}}</label>
    <div class="">
        <select class="form-control" name="default_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label"> {{__('admin_message.update order status')}}</label>
        <div class="">
            <select class="form-control" name="available_edit_status" required>
            <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
                @foreach ($statuses as $status)              
                    @if($status->fulfillment_appear==1)
                    <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
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
<div class="col-xs-6 form-group">
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
<div class="col-xs-6 form-group">
        
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
<div class="col-xs-6 form-group">
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

<div class="col-xs-6 form-group">
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

<div class="col-xs-6 form-group">
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
    

<div class="col-xs-6 form-group">
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
<div class="col-xs-6 form-group">
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


<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">
         *{{__('admin_message.Delivery cost reshipping  from customer is calculated based on the status')}}</label>
    <div class="">
        <select class="form-control" name="cost_reshipping_calc_status_id" required >
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


<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.sort_by_sku')}}</label>
    <div class="">
        <select class="form-control" name="sort_by_skus_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('sort_by_skus_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.pick_process_package')}}</label>
    <div class="">
        <select class="form-control" name="pick_process_package_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('pick_process_package_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.print_waybill')}}</label>
    <div class="">
        <select class="form-control" name="print_waybill_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('print_waybill_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.sort_by_city')}}</label>
    <div class="">
        <select class="form-control" name="sort_by_city_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('sort_by_city_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.store_return_shipment')}}</label>
    <div class="">
        <select class="form-control" name="store_return_shipment_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('store_return_shipment_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('fulfillment.reprocess_return_shipment')}}</label>
    <div class="">
        <select class="form-control" name="reprocess_return_shipment_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option {{($companySetting->default_status_id_store == $status->id) ? 'selected' : ''}} value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('reprocess_return_shipment_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<!-- new status by shereen -->
<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('admin_message.Shortage of order quantity from stock')}}</label>
    <div class="">
        <select class="form-control" name="shortage_order_quantity_f_stock" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option  value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('shortage_order_quantity_f_stock')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<!-- new status by shereen -->
<div class="col-xs-6 form-group">
    <label for="lastname" class="control-label">* {{__('admin_message.Add quantity to stock when restocking')}}</label>
    <div class="">
        <select class="form-control" name="restocking_order_quantity_to_stock" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($work==4)
                    @if($status->fulfillment_appear==1)
                        <option  value="{{$status->id}}">{{$status->trans('title')}}</option>
                    @endif
                @endif       
            @endforeach

        </select>
        @error('restocking_order_quantity_to_stock')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
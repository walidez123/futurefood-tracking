<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.pallet in') }} </label>

    <div class="">
        <input value="{{$client->userCost->pallet_in}}" type="number" required step="0.1"  name="pallet_in" class="form-control" id="phone" placeholder="{{ __('admin_message.pallet in') }}">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.pallet out') }} </label>

    <div class="">
        <input value="{{$client->userCost->pallet_out}}" type="number" step="0.1" name="pallet_out" class="form-control" id="phone" placeholder="{{ __('admin_message.pallet out') }} ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.packging pallet') }} </label>

    <div class="">
        <input value="{{$client->userCost->packging_pallet}}" type="number" step="0.1" name="packging_pallet" class="form-control" id="phone" placeholder=" ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.segregation pallet') }} </label>

    <div class="">
        <input value="{{$client->userCost->segregation_pallet}}" type="number" step="0.1" name="segregation_pallet" class="form-control" id="phone" placeholder="Space ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.palletization') }} </label>

    <div class="">
        <input value="{{$client->userCost->palletization}}" type="number" step="0.1" name="palletization" class="form-control" id="phone" placeholder="Space ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.wooden pallet') }} </label>

    <div class="">
        <input value="{{$client->userCost->wooden_pallet}}" type="number" step="0.1" name="wooden_pallet" class="form-control" id="phone" placeholder="Space ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.return/restock pallet') }} </label>

    <div class="">
        <input value="{{$client->userCost->return_pallet}}" type="number" step="0.1" name="return_pallet" class="form-control" id="phone" placeholder="Space ">
    </div>
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.Pallet shipping') }} </label>

    <div class="">
        <input value="{{$client->userCost->pallet_shipping}}" type="number" step="0.1" name="pallet_shipping" class="form-control" id="phone" placeholder="Space ">
    </div>
</div>
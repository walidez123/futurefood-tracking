<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.pallet in') }} {{ __('admin_message.when status') }}</label>

    <select class="form-control" name="pallet_in_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->pallet_in_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('pallet_in_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.pallet out') }} {{ __('admin_message.when status') }}</label>

    <select class="form-control" name="pallet_out_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->pallet_out_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('pallet_out_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.packging pallet') }} {{ __('admin_message.when status') }}</label>
    <select  class="form-control" name="packging_pallet_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->packging_pallet_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('packging_pallet_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.segregation pallet') }}  {{ __('admin_message.when status') }}</label>

    <select  class="form-control" name="segregation_pallet_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->segregation_pallet_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('segregation_pallet_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.palletization') }} {{ __('admin_message.when status') }}</label>


    <select  class="form-control" name="palletization_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->palletization_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('palletization_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.wooden pallet') }} {{ __('admin_message.when status') }}</label>

    <select  class="form-control" name="wooden_pallet_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->wooden_pallet_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('wooden_pallet_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.return/restock pallet') }} {{ __('admin_message.when status') }} </label>

    <select  class="form-control" name="return_pallet_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->return_pallet_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('return_pallet_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
<div class="col-xs-12 form-group">
    <label for="phone" class="control-label"> {{ __('admin_message.Pallet shipping') }}  {{ __('admin_message.when status') }} </label>

    <select  class="form-control" name="pallet_shipping_status_id" required>
        <option value="">{{__('admin_message.Select')}} {{__('admin_message.status')}}</option>
            @foreach ($statuses as $status)
                @if($status->storehouse_appear==1)
                    <option {{($client->userStatus->pallet_shipping_status_id == $status->id) ? 'selected' : ''}}  value="{{$status->id}}">{{$status->trans('title')}}</option>
                @endif          
            @endforeach
        </select>
        @error('pallet_shipping_status_id')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
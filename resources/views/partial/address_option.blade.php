{{-- map or link select option  --}}
<div class="form-group">
    <label for="firstname" class="control-label">@lang('app.address') *</label>
    <select name="map_or_link" class="form-control" id="map_or_link" required>

        <option selected>@lang('address.select_option')</option>
        <option value="map">@lang('address.google_map')</option>
        <option value="link">@lang('address.address_link')</option>
    </select>
</div>
<div id="module-map" class="module">
    <div class="form-group">
        <label for="firstname" class="control-label">@lang('address.longitude')</label>
        <div class="">
            <input type="text" name="longitude" id="longitude" value="" class="form-control locatinId" id="fullname"
                placeholder="longitude" >
            @error('longitude')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">@lang('address.latitude')</label>
        <div class="">
            <input type="text" name="latitude" id="latitude" value="" class="form-control locatinId" id="fullname"
                placeholder="latitude" >
            @error('latitude')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div id="mapCanv" style="width:100%;height:400px"></div>
</div>
<div id="module-link" class="module">
    <div class="form-group">
        <label for="link" class="control-label">@lang('address.link')  </label>
        <div class="">
            <input type="text" name="link" id="link" value="" class="form-control locatinId" 
                placeholder="@lang('address.link')" >
            @error('link')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
{{-- end --}}
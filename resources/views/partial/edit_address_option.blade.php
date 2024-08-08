
{{-- {{ dd($address) }} --}}

{{-- map or link select option --}}
<label for="firstname" class="control-label">@lang('app.address') *</label>
<select class="form-control select2" name="map_or_link" id="map_or_link" required>

    <option value="" disabled selected hidden>@lang('address.select_option')</option>
    <option value="map" {{ old('map_or_link', $address->map_or_link) == "map" ? 'selected' : '' }}>@lang('address.google_map')</option>
    <option value="link" {{ old('map_or_link', $address->map_or_link) == "link" ? 'selected' : '' }}>@lang('address.address_link')</option>
</select>

<div id="module-map" class="module">
    <div class="form-group">
        <label for="firstname" class="control-label">@lang('address.longitude')</label>
        <div>
            <input type="text" name="longitude" id="longitude" value="{{$address->longitude }}" class="form-control locatinId" placeholder="longitude" >
            @error('longitude')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="latitude" class="control-label">@lang('address.latitude')</label>
        <div>
            <input type="text" name="latitude" id="latitude" value="{{$address->latitude }}" class="form-control locatinId" placeholder="latitude" >
            @error('longitude')
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
        <label for="link" class="control-label">@lang('address.link')</label>
        <div>
            <input type="text" name="link" id="link" value="{{$address->link }}" class="form-control locatinId" placeholder="@lang('address.link')" >
            @error('link')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
{{-- end --}}

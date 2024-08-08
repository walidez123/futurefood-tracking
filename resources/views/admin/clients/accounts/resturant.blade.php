
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__("admin_message.Delivery Cost")}}</label>
                            <div class="">
                                <input value="{{ old('cost_inside_city') }}" type="number" step="any" min="0" class="form-control"
                                    name="cost_inside_city" placeholder="{{__('admin_message.Delivery Cost')}}" required>
                                @error('cost_inside_city')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__('admin_message.Additional kilo price')}} </label>

                            <div class="">
                                <input value="{{ old('additional_kilo_price') }}" type="number" step="any" min="0"
                                    name="additional_kilo_price" class="form-control"
                                    placeholder="{{__('admin_message.Additional kilo price')}}" required>
                                @error('additional_kilo_price')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label"> {{__('admin_message.Kilo number')}}</label>

                            <div class="">
                                <input value="{{ old('kilos_number') }}" type="number" step="any" min="0"
                                    name="kilos_number" class="form-control"
                                    placeholder="{{__('admin_message.Kilo number')}}" required>
                                @error('kilos_number')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__("admin_message.fees cost on delivery")}}</label>

                            <div class="">
                                <input value="{{ old('fees_cash_on_delivery') }}" type="number" step="any" min="0"
                                    name="fees_cash_on_delivery" class="form-control"
                                    placeholder="{{__('admin_message.fees cost on delivery')}}" required>
                                @error('fees_cash_on_delivery')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                            <label for="" class="control-label">{{__("admin_message.fees cost on reshipping")}}</label>

                            <div class="">
                                <input value="{{ old('cost_reshipping') }}" type="number" step="any" min="0"
                                    name="cost_reshipping" class="form-control"
                                    placeholder="{{__('admin_message.fees cost on reshipping')}} " required>
                                @error('cost_reshipping')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
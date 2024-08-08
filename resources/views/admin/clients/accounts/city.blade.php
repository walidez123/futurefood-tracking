<div class="col-xs-12 col-lg-6 form-group">
                             <label for="" class="control-label">{{__("admin_message.Delivery cost inside")}} {{__("admin_message.City")}}</label>
                             <div class="">
                                     <input value="{{ old('cost_inside_city') }}" type="number" step="any" min="0" class="form-control" name="cost_inside_city"
                                                    placeholder="{{__('admin_message.Delivery cost inside')}} {{__('admin_message.City')}}" >
                                                    @error('cost_inside_city')
                                    <span class="invalid-feedback text-danger" role="alert">
                                     <strong>{{ $message }}</strong>
                                      </span>
                                   @enderror
                              </div>
                        </div>
                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label"> {{__('admin_message.Delivery cost outside')}}</label>
        
                                            <div class="">
                                                <input value="{{ old('cost_outside_city') }}" type="number" step="any" min="0" class="form-control" name="cost_outside_city"
                                                    placeholder="{{__('admin_message.Delivery cost outside')}}" >
                                                    @error('cost_outside_city')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                               </div>
                               <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.Reshipping cost inside')}} {{__('admin_message.City')}}</label>
                                            <div class="">
                                                <input value="{{ old('cost_reshipping') }}" type="number" step="any" min="0" name="cost_reshipping" class="form-control"
                                                    placeholder="{{__('admin_message.Reshipping cost inside')}} {{__('admin_message.City')}}">
                                                    @error('cost_reshipping')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                </div> 
                                <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.Reshipping cost outside')}} {{__('admin_message.City')}}</label>
                                            <div class="">
                                                <input value="{{ old('cost_reshipping_out_city') }}" type="number" step="any" min="0" name="cost_reshipping_out_city" class="form-control"
                                                    placeholder="{{__('admin_message.Reshipping cost outside')}} {{__('admin_message.City')}}">
                                                    @error('cost_reshipping_out_city')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                </div> 
                                <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label"> {{__('admin_message.fees cost delivery inside')}} {{__('admin_message.City')}}</label>
        
                                            <div class="">
                                                <input value="{{ old('fees_cash_on_delivery') }}" type="number" step="any" min="0" name="fees_cash_on_delivery" class="form-control"
                                                    placeholder="{{__('admin_message.fees cost delivery inside')}} {{__('admin_message.City')}}" >
                                                    @error('fees_cash_on_delivery')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                 </div> 
                                 <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.fees cost delivery outside')}} {{__('admin_message.City')}}</label>
        
                                            <div class="">
                                                <input value="{{ old('fees_cash_on_delivery_out_city') }}" type="number" step="any" min="0" name="fees_cash_on_delivery_out_city" class="form-control"
                                                    placeholder="{{__('admin_message.fees cost delivery outside')}} {{__('admin_message.City')}}" >
                                                    @error('fees_cash_on_delivery')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                   </div> 
                                   <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.fees pickup')}}   </label>
        
                                            <div class="">
                                                <input value="{{old('pickup_fees')}}" type="number" step="any" min="0" class="form-control" name="pickup_fees"
                                                    placeholder="{{__('admin_message.fees pickup')}}" >
                                                    @error('pickup_fees')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.over weight per kilo inside')}} {{__('admin_message.City')}}</label>
        
                                            <div class="">
                                                <input value="{{ old('over_weight_per_kilo') }}" type="number" step="any" min="0" class="form-control" name="over_weight_per_kilo"
                                                    placeholder="{{__('admin_message.over weight per kilo inside')}} {{__('admin_message.City')}}" >
                                                    @error('over_weight_per_kilo')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.over weight per kilo outside')}} {{__('admin_message.City')}}</label>
        
                                            <div class="">
                                                <input value="{{ old('over_weight_per_kilo_outside') }}" type="number" step="any" min="0" class="form-control" name="over_weight_per_kilo_outside"
                                                    placeholder="{{__('admin_message.over weight per kilo outside')}} {{__('admin_message.City')}}" >
                                                    @error('over_weight_per_kilo_outside')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.standard weight inside')}} {{__('admin_message.City')}}   </label>
                                            <div class="">
                                                <input value="{{ old('standard_weight') }}" type="number" step="any" min="0" class="form-control" name="standard_weight"
                                                    placeholder="{{__('admin_message.standard weight inside')}} {{__('admin_message.City')}}" >
                                                    @error('standard_weight')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xs-12 col-lg-6 form-group">
                                            <label for="" class="control-label">{{__('admin_message.standard weight outside')}} </label>
                                            <div class="">
                                                <input value="{{ old('standard_weight_outside') }}" type="number" step="any" min="0" class="form-control" name="standard_weight_outside"
                                                    placeholder="{{__('admin_message.standard weight outside')}}" >
                                                    @error('standard_weight_outside')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
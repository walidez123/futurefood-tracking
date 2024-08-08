<form action="{{route('partners_statuses.store')}}" method="POST">
    @csrf
    <input type="hidden" name="company_id" value="{{Auth()->user()->company_id}}">
    <input type="hidden" name="provider_name" value="smb">
    <div class="col-md-12 ">
        <!-- general form elements -->
        <div class="box box-primary" style="padding: 10px;">
            
            <div class="box-header with-border">
                <h3 class="box-title">حالات SMB</h3>
            </div><!-- /.box-header -->
            <!-- form start -->

            <div class="box-body">
            @if($smb_statuses)
            <div class="col-md-2">
                <label for="new_order_id">{{ __('app.new_order') }}</label>
                <select id="new_order_id" class="form-control select2" name="new_order_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->new_order_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('new_order_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="assigned_id">{{ __('app.assigned') }}</label>
                <select id="assigned_id" class="form-control select2" name="assigned_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->assigned_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('assigned_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="en_route_id">{{ __('app.en_route') }}</label>
                <select id="en_route_id" class="form-control select2" name="en_route_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->en_route_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('en_route_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="delayed_id">تأجيل</label>
                <select id="delayed_id" class="form-control select2" name="delayed_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->delayed_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('delayed_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="delivered_id">مرتجع</label>
                <select id="delivered_id" class="form-control select2" name="returned_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->returned_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('delivered_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="closed_id">{{ __('app.closed') }}</label>
                <select id="closed_id" class="form-control select2" name="closed_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->closed_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('closed_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="delivered_id">{{ __('app.delivered') }}</label>
                <select id="delivered_id" class="form-control select2" name="delivered_id">
                    @foreach ($statuses as $status)
                        <option {{($smb_statuses->delivered_id == $status->id) ? 'selected' : ''}} value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('delivered_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class=" footer">
                <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
            </div>
            @else
                <div class="col-md-2">
                    <label for="new_order_id">{{ __('app.new_order') }}</label>
                    <select id="new_order_id" class="form-control select2" name="new_order_id">
                        <option value="">
                            {{ __('admin_message.Choose a status') }}
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('new_order_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="assigned_id">{{ __('app.assigned') }}</label>
                    <select id="assigned_id" class="form-control select2" name="assigned_id">
                        <option value="">
                            {{ __('admin_message.Choose a status') }}
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="en_route_id">{{ __('app.en_route') }}</label>
                    <select id="en_route_id" class="form-control select2" name="en_route_id">
                        <option value="">
                            {{ __('admin_message.Choose a status') }}
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('en_route_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="delayed_id">{{ __('app.delay') }}</label>
                    <select id="delayed_id" class="form-control select2" name="delayed_id">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('delayed_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-2">
                <label for="delivered_id">مرتجع</label>
                <select id="delivered_id" class="form-control select2" name="returned_id">
                    @foreach ($statuses as $status)
                        <option  value="{{$status->id}}">
                            {{$status->trans('title')}}</option>
                    @endforeach
                </select>
                @error('delivered_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
                <div class="col-md-2">
                    <label for="closed_id">{{ __('app.closed') }}</label>
                    <select id="closed_id" class="form-control select2" name="closed_id">
                        <option value="">
                            {{ __('admin_message.Choose a status') }}
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('closed_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label for="delivered_id">{{ __('app.delivered') }}</label>
                    <select id="delivered_id" class="form-control select2" name="delivered_id">
                        <option value="">
                            {{ __('admin_message.Choose a status') }}
                        </option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->trans('title') }}
                            </option>
                        @endforeach
                    </select>
                    @error('delivered_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class=" footer">
                    <button type="submit" class="btn btn-primary">{{__('admin_message.save')}}</button>
                </div>
            @endif
        </div>
    </div><!-- /.box -->
</div>
</form> <!-- /.row -->
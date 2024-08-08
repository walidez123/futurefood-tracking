@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="nav-tabs-custom">
                    <form enctype="multipart/form-data" action="{{ route('clients.store') }}" method="POST"
                        class="box  col-md-12" style="border: 0px; padding:10px;">
                        @csrf
                        <input type="hidden" min="0" value="15" name="tax" class="form-control"
                            placeholder="Tax">
                        <input type="hidden" value="{{ $work }}" name="work">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#bank" data-toggle="tab" aria-expanded="true"><i
                                        class="fa fa-shop"></i>{{ __('admin_message.Main information') }}</a></li>
                            <li class=""><a href="#setting" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-user"></i>{{ __('admin_message.Registration data') }}</a></li>
                            <li class=""><a href="#statuses" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-money-bill"></i>{{ __('admin_message.Payments') }}</a></li>

                                        <li class=""><a href="#setting1" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-usd"></i>{{__("admin_message.Financial accounts")}}</a></li>
                            <li class=""><a href="#status_setting" data-toggle="tab" aria-expanded="false"><i
                                        class="fa fa-usd"></i>{{__("admin_message.Settings")}} {{__("admin_message.statuses")}}</a></li>

                            <li><a href="#provider" data-toggle="tab"><i class="fa fa-file"></i>
                                    {{ __('admin_message.Official documents') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" style="padding-top: 10px;">
                            <div class="tab-pane active" id="bank">
                                <div class="col-xs-12 form-group">
                                    <label for="store name" class="control-label">
                                        @if ($work == 1)
                                            *{{ __('admin_message.Clients') }}
                                        @elseif($work == 2)
                                            * {{ __('admin_message.restaurants') }}
                                        @elseif($work == 3)
                                            * {{ __('admin_message.Warehouses') }}
                                        @endif

                                    </label>

                                    <div class="">
                                        <input type="text" value="{{ old('store_name') }}" name="store_name"
                                            class="form-control" id="store name" placeholder="" required>
                                        @error('store_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="firstname" class="control-label"> *
                                        {{ __('admin_message.manger name') }}</label>

                                    <div class="">
                                        <input type="text" value="{{ old('name') }}" name="name"
                                            class="form-control" id="fullname"
                                            placeholder="{{ __('admin_message.manger name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for=""
                                        class="control-label">{{ __('admin_message.Tax Number') }}</label>

                                    <div class="">
                                        <input type="text" value="{{ old('tax_Number') }}" min="0"
                                            class="form-control" name="tax_Number"
                                            placeholder="{{ __('admin_message.Tax_number_message') }}">
                                        @error('tax_Number')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="website"
                                        class="control-label">{{ __('admin_message.website url') }}</label>
                                    <div class="">
                                        <input type="text" value="{{ old('website') }}" name="website"
                                            class="form-control" id="website"
                                            placeholder="{{ __('admin_message.website url') }}">
                                        @error('website')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="lastname" class="control-label"> * {{ __('admin_message.City') }}</label>
                                    <div class="">
                                        <select value="{{ old('city_id') }}" class="form-control select2" name="city_id"
                                            required>
                                            <option value="">{{ __('admin_message.Select') }}
                                                {{ __('admin_message.City') }}</option>
                                            @foreach ($cities as $city)
                                                <option {{(old('city_id') == $city->id) ? 'selected' : ''}} value="{{ $city->id }}">{{ $city->trans('title') }}</option>
                                            @endforeach

                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="" class="control-label">{{ __('admin_message.package') }}</label>

                                    <div class="">
                                        <select value="{{ old('offer_id') }}" class="form-control select2"
                                            id="offer_id" name="offer_id" required>
                                            <option value="">{{ __('admin_message.Select') }}
                                                {{ __('admin_message.package') }}</option>
                                            @foreach ($offers as $offer)
                                                <option {{(old('offer_id') == $offer->id) ? 'selected' : ''}} value="{{ $offer->id }}"
                                                    data-num_days="{{ $offer->num_days }}"
                                                    data-price="{{ $offer->price }}" data-area="{{ $offer->area }}">
                                                    {{ $offer->trans('title') }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('offer_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for=""
                                        class="control-label">{{ __('admin_message.Number of days in the package') }}</label>

                                    <div class="">
                                        <input type="number" value="{{ old('num_day') }}" name="num_day"
                                            class="form-control" id="num_days">
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="website" class="control-label">{{ __('admin_message.Price') }}</label>

                                    <div class="">
                                        <input type="text" value="{{ old('price') }}" name="price"
                                            class="form-control" id="price">
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="website" class="control-label">{{ __('admin_message.Area') }}</label>

                                    <div class="">
                                        <input type="text" value="{{ old('area') }}" name="area"
                                            class="form-control" id="area">
                                    </div>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label for="website"
                                        class="control-label">{{ __('admin_message.Start Date') }}</label>

                                    <div class="">
                                        <input type="date" value="{{ date('Y-m-d') }}" name="start_date"
                                            class="form-control" id="area">
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="setting">
                                <div class="col-xs-12 form-group">
                                    <label for="phone" class="control-label">{{ __('admin_message.Phone') }}</label>

                                    <div class="">
                                        <input value="{{ old('phone') }}" type="text" name="phone"
                                            class="form-control" id="phone"
                                            placeholder="{{ __('admin_message.phoneMessage') }}">
                                        @error('phone')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group">
                                    <label for="email" class="control-label">* {{ __('admin_message.Email') }}</label>

                                    <div class="">
                                        <input value="{{ old('email') }}" type="email" name="email"
                                            class="form-control" id="inputEmail"
                                            placeholder="{{ __('admin_message.Email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label for="password"
                                        class="control-label">{{ __('admin_message.password') }}</label>

                                    <div class="">
                                        <input value="{{ old('password') }}" type="password" name="password"
                                            class="form-control" id="password"
                                            placeholder="{{ __('admin_message.passwordMassage') }}" required>
                                        @error('password')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 form-group">
                                    <label class="control-label">{{ __('admin_message.confirm password') }} *</label>

                                    <div class="">
                                        <input value="{{ old('password') }}" id="password-confirm" type="password"
                                            class="form-control" placeholder="{{ __('admin_message.confirm password') }}"
                                            name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="statuses">

                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for="firstname"
                                        class="control-label">{{ __('admin_message.Payment period') }}</label>
                                    <div class=" ">
                                        <select name="Payment_period" class="form-control " required>
                                            <option {{(old('Payment_period') == 1) ? 'selected' : ''}} value="1">{{ __('admin_message.daily') }}</option>
                                            <option {{(old('Payment_period') == 2) ? 'selected' : ''}} value="2">{{ __('admin_message.weekly') }}</option>
                                            <option {{(old('Payment_period') == 3) ? 'selected' : ''}} value="3">{{ __('admin_message.Monthly') }}</option>

                                        </select>

                                        @error('Payment_period')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for=""
                                        class="control-label">{{ __('admin_message.bank name') }}</label>

                                    <div class="">
                                        <input value="{{ old('bank_name') }}" type="text" min="0"
                                            class="form-control" name="bank_name"
                                            placeholder="{{ __('admin_message.bank name') }}">
                                        @error('bank_name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for=""
                                        class="control-label">{{ __('admin_message.bank account number') }}</label>

                                    <div class="">
                                        <input type="text" value="{{ old('bank_account_number') }}"
                                            name="bank_account_number" class="form-control" id=""
                                            placeholder="{{ __('admin_message.bank account number') }} ">
                                        @error('bank_account_number')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for="" class="control-label"> {{ __('admin_message.Iban') }}</label>

                                    <div class="">
                                        <input value="{{ old('bank_swift') }}" type="text" min="0"
                                            class="form-control" name="bank_swift"
                                            placeholder="{{ __('admin_message.Iban') }}">
                                        @error('bank_swift')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="tab-pane" id="setting1">
                            @include('admin.clients.accounts.warehouse_add')

                                


                            </div>
                            <div class="tab-pane" id="status_setting">
                            @include('admin.clients.accounts.warehouse_status_add')
                            </div>


                            <div class="tab-pane" id="provider">
                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for="Tax_certificate" class="control-label">
                                        {{ __('admin_message.personal photo') }} </label>
                                    <div class="">
                                        <input type="file" name="avatar" id="">

                                        @error('avatar')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for="Tax_certificate" class="control-label">
                                        {{ __('admin_message.Tax_certificate') }}</label>
                                    <div class="">
                                        <input type="file" name="Tax_certificate" id="">

                                        @error('Tax_certificate')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xs-12 col-lg-6 form-group">
                                    <label for="commercial_register" class="control-label">
                                        {{ __('admin_message.commercial_register') }} </label>
                                    <div class="">
                                        <input type="file" name="commercial_register" id="">

                                        @error('commercial_register')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.tab-content -->
                        <div class=" footer col-lg-12">
                            <button type="submit" class="btn btn-primary">{{ __('admin_message.save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.nav-tabs-custom -->
            </div>


        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(() => {
            var selected = $("#offer_id").find('option:selected');
            var num_days = selected.data('num_days');
            var price = selected.data('price');
            var area = selected.data('area');

            $('#num_days').val(num_days);
            $('#price').val(price);
            $('#area').val(area);
        });
        $('#offer_id').on('change', function() {
            var selected = $(this).find('option:selected');
            var num_days = selected.data('num_days');
            var price = selected.data('price');
            var area = selected.data('area');

            $('#num_days').val(num_days);
            $('#price').val(price);
            $('#area').val(area);
        });

        $(function() {
            $('.select2').select2()
        });
        var today = new Date();
        var tomorrow = new Date(new Date().getTime());

        // Set values
        $("#date").val(getFormattedDate(today));
        $("#date").val(getFormattedDate(tomorrow));
        $("#date").val(getFormattedDate(anydate));

        // Get date formatted as YYYY-MM-DD
        function getFormattedDate(date) {
            return date.getFullYear() +
                "-" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "-" +
                ("0" + date.getDate()).slice(-2);
        }
    </script>
@endsection

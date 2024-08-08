@extends('layouts.master')
@section('pageTitle', 'Package')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts._header-form', [
            'title' => 'باقة أضافية',
            'type' => __('app.add'),
            'iconClass' => 'fa-map-marker',
            'url' => route('clinet_packages.index', ['id' => $id]),
            'multiLang' => 'false',
        ])

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <form action="{{ route('clinet_packages.store') }}" method="POST" class="box  col-md-12"
                    style="border: 0px; padding:10px;">
                    @csrf
                    <input type="hidden" name="user_id" value={{ $id }}>

                    <div class="col-xs-12 form-group">
                        <label for="" class="control-label"> الباقة</label>

                        <div class="">
                            <select value="{{ old('package_id') }}" class="form-control select2" id="offer_id"
                                name="package_id" required>
                                <option value="">أختر الباقة</option>
                                @foreach ($packages as $offer)
                                    <option value="{{ $offer->id }}" data-num_days="{{ $offer->num_days }}"
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
                    <div class="col-xs-4 form-group">
                        <label for="" class="control-label"> عدد أيام الباكدج</label>

                        <div class="">
                            <input type="number" value="{{ old('num_day') }}" name="num_days" class="form-control"
                                id="num_days">
                        </div>
                    </div>
                    <div class="col-xs-4 form-group">
                        <label for="website" class="control-label">السعر</label>

                        <div class="">
                            <input type="text" value="{{ old('price') }}" name="price" class="form-control"
                                id="price">
                        </div>
                    </div>
                    <div class="col-xs-4 form-group">
                        <label for="website" class="control-label">المساحة</label>

                        <div class="">
                            <input type="text" value="{{ old('area') }}" name="area" class="form-control"
                                id="area">
                        </div>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label for="website" class="control-label">تاريخ بداية الباقة</label>

                        <div class="">
                            <input type="date" value="{{ date('Y-m-d') }}" name="start_date" class="form-control"
                                id="area">
                        </div>
                    </div>
                    <div class="col-xs-6 form-group">
                        <label for="lastname" class="control-label">فعال *</label>
                        <div class="">
                            <select id="" class="form-control select2" name="active" required>
                                <option value="1">فعال</option>
                                <option value="0">غير فعال</option>


                            </select>
                            @error('active')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
            </div>


            <div class=" footer">
                <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            </div>
            </form> <!-- /.row -->
        </section>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
@endsection

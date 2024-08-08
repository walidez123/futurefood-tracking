@extends('layouts.master')
@section('pageTitle',  __('admin_message.Add a new rule'))
@section('nav')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        {{-- @include('layouts._header-form', [
            'title' => '{{__("admin_message.rule")}}',
            'type' => '{{__("admin_message.Add")}}',
            'iconClass' => 'fa-map-marker',
            'url' => route('AssignOrdersRule.index'),
            'multiLang' => 'false',
        ]) --}}
        <!-- Main content -->
        <section class="content">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="formRuls" action="{{ route('AssignOrdersRule.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ Auth()->user()->company_id }}">
                    <input type="hidden" name="conditionsArray" id="conditionsArrayInput">
                    <div class="col-md-12 ">
                        <!-- general form elements -->
                        <div class="box box-primary" style="padding: 10px;">
                            <h3 class="box-title">{{ __('admin_message.Add a new rule') }}</h3>
                            <div class="box-body" style="overflow-x: auto !important">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('admin_message.Designation name') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="designation_name"
                                            id="exampleInputEmail1" required
                                            placeholder="{{ __('admin_message.Designation name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">{{ __('admin_message.details') }}<span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control" name="details" required
                                            id="exampleInputEmail1" placeholder="{{ __('admin_message.details') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin_message.status') }}<span
                                                style="color: red">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="1">{{ __('admin_message.active') }}</option>
                                            <option value="0">{{ __('admin_message.not active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max">{{ __('admin_message.Maximum order limit') }}</label>
                                        <input type="number" name="max" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_type">{{ __('admin_message.Type of Request') }}<span
                                                style="color: red">*</span></label>
                                        <select name="work_type" class="form-control work_id"  id="work_type" required>
                                            <option value="">{{ __('admin_message.Choose a type') }}</option>
                                            @if(in_array(1,$user_type))

                                            <option value="1">{{ __('admin_message.Client') }}</option>
                                            @endif
                                            @if(in_array(2,$user_type))

                                            <option value="2">{{ __('admin_message.restaurant') }}</option>
                                            @endif
                                            @if(in_array(4,$user_type))
                                            <option  value="4">{{ __('fulfillment.fulfillment') }}</option>  
                                            @endif                                    
                                         </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delegate_id">{{ __('admin_message.Choose a Delegate') }}<span
                                                style="color: red">*</span></label>
                                        <select required class="form-control select2" id="delegate_id" name="delegate_id"
                                            required>
                                            <option value="">{{ __('admin_message.Choose a Delegate') }}
                                            </option>
                                            @foreach ($delegates as $delegate)
                                                <option value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <fieldset class="box-body overflow-auto border rounded p-3 bg-white"
                        style="margin-left: 22px; margin-right: 22px;">
                        <h4 style="display: contents">{{__('admin_message.Add conditions')}}</h4>
                        <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;padding-top: 5px">
                            <div class="col-md-1">
                                <label for="cod">{{ __('admin_message.COD') }}</label>
                                <select name="cod" class="form-control">
                                    <option value="">
                                        {{ __('admin_message.Choose payment status') }}</option>
                                    <option value="1">{{ __('admin_message.paid') }}</option>
                                    <option value="0">{{ __('admin_message.UnPaid') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="client_id">{{ __('admin_message.Client') }}</label>
                                <select id="client_assign" class="form-control select2  client_assign" name="client_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a client') }}
                                    </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- add branche  -->

                            <div class="col-md-2">
                                <label for="address_assign_id">{{ __('admin_message.addresses') }}</label>
                                <select id="" class="form-control select2 address_assign_id" name="address_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a addresses') }}
                                    </option>
                                  
                                </select>
                            </div>



                            <!-- end branche -->
                            <div class="col-md-2">
                                <label for="city_from">{{ __('admin_message.From the city') }}</label>
                                <select id="city_from" name="city_from" class="form-control select2">
                                    <option value="">{{ __('admin_message.Choose a city') }}
                                    </option>
                                    @foreach ($cites as $city)
                                        <option value="{{ $city->id }}">{{ $city->trans('title') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="city_to">{{ __('admin_message.To the city') }}</label>
                                <select id="city_to" name="city_to" class="form-control select2">
                                    <option value="">{{ __('admin_message.Choose a city') }}
                                    </option>
                                    @foreach ($cites as $city)
                                        <option value="{{ $city->id }}">{{ $city->trans('title') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="region_from">{{ __('admin_message.From the neighborhood') }}</label>
                                <select id="region_from" name="region_from" class="form-control select2">
                                    <option value="">
                                        {{ __('admin_message.Choose a neighborhood') }}</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->trans('title') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="region_to">{{ __('admin_message.To the neighborhood') }}</label>
                                <select id="region_to" name="region_to" class="form-control select2">
                                    <option value="">
                                        {{ __('admin_message.Choose a neighborhood') }}</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->trans('title') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1" style="margin-top: 22px">
                                <button id="addCondition" type="button" class="btn btn-success">{{__("admin_message.add")}}</button>
                            </div>
                        </div>
                        <div id="parentTable" style="display: none !important;margin-top:100px">
                            <h3 class="text-danger" style=""> {{__("admin_message.show condition")}}
                            </h3>
                            <table id="conditionsTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin_message.COD') }}</th>
                                        <th scope="col">{{ __('admin_message.Client') }}</th>
                                        <th scope="col">{{ __('admin_message.addresses') }}</th>
                                        <th scope="col">{{ __('admin_message.From the city') }}</th>
                                        <th scope="col">{{ __('admin_message.To the city') }}</th>
                                        <th scope="col">{{ __('admin_message.From the neighborhood') }}</th>
                                        <th scope="col">{{ __('admin_message.To the neighborhood') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    <div class="col-md-6">
                        <div style="display: flex;width: 100%;">
                            <button id="submit-button" type="submit" class="btn btn-info"
                                style="margin-left: 15px;margin-right: 15px">{{ __('admin_message.Add a sub-rule') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    {{-- <script>
        $(function() {
            $('.select2').select2()
        });
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            var orderRulesDetails = [];

            $("#addCondition").on("click", function() {
                var cod = $("select[name='cod']").val();
                var cod_text = $("select[name='cod'] option:selected").text();
                var client_id = $("#client_assign").val();
                var client_text = $('#client_assign option:selected').text();
                var address_id = $(".address_assign_id").val();
                var address_text = $(".address_assign_id option:selected").text();                
                var city_from = $("select[name='city_from']").val();
                var city_from_text = $('#city_from option:selected').text();
                var city_to = $("select[name='city_to']").val();
                var city_to_text = $('#city_to option:selected').text();
                var region_from = $("select[name='region_from']").val();
                var region_from_text = $('#region_from option:selected').text();
                var region_to = $("select[name='region_to']").val();
                var region_to_text = $('#region_to option:selected').text();

                var condition_text = {
                    cod_text: cod_text,
                    client_text: client_text,
                    address_text: address_text,

                    city_from_text: city_from_text,
                    city_to_text: city_to_text,
                    region_from_text: region_from_text,
                    region_to_text: region_to_text,
                };
                var condition = {
                    cod: cod,
                    client_id: client_id,
                    address_id: address_id,


                    city_from: city_from,
                    city_to: city_to,
                    region_from: region_from,
                    region_to: region_to
                };
                orderRulesDetails.push(condition);
                clearFormFields();
                appendDataToTable(condition_text);

                function clearFormFields() {
                    $("select[name='cod']").val("");
                    $("#client_assign").val("");
                    $("#address_assign_id").val("");

                    $("select[name='city_from']").val("");
                    $("select[name='city_to']").val("");
                    $("select[name='region_from']").val("");
                    $("select[name='region_to']").val("");
                }
            });
            $("#submit-button").click(function() {
                var designation_name = $("input[name='designation_name']").val();
                var details = $("input[name='details']").val();
                var status = $("select[name='status']").val();
                var max = $("input[name='max']").val();
                var work_type = $("select[name='work_type']").val();
                var delegate_id = $("#delegate_id").val();
                var ruleData = {
                    designation_name: designation_name,
                    details: details,
                    status: status,
                    max: max,
                    work_type: work_type,
                    delegate_id: delegate_id
                };
                var mergedObject = {
                    orderRulesDetails: orderRulesDetails,
                    orderRules: ruleData,
                };
                $("#conditionsArrayInput").val(JSON.stringify(mergedObject));
                $("#formRuls").submit();
            });

            function appendDataToTable(data) {
                $("#parentTable").show();
                var newRow = $("<tr>");
                newRow.append("<td>" + data.cod_text + "</td>");
                newRow.append("<td>" + data.client_id == "اختر العميل" ? "-" : data.client_text + "</td>");

                newRow.append("<td>" + data.address_text  + "</td>");

                newRow.append("<td>" + data.city_from_text + "</td>");
                newRow.append("<td>" + data.city_to_text + "</td>");
                newRow.append("<td>" + data.region_from_text + "</td>");
                newRow.append("<td>" + data.region_to_text + "</td>");
                newRow.append("<td><button class='btn btn-danger remove-condition fa fa-x'></button></td>");
                $("#conditionsTable tbody").append(newRow);
                $("#conditionsTable").on("click", ".remove-condition", function() {
                    $(this).closest("tr").remove();
                });
            }
        });
    </script>
@endsection

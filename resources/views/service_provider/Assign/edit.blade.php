@extends('layouts.master')
@section('pageTitle', __('admin_message.edit rule'))
@section('nav')
    @include(auth()->user()->user_type . '.layouts._nav')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
                <form id="formRuls" action="{{ route('order_rule_provider.update', $Orders_rules->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="conditionsArray" id="conditionsArrayInput">
                    <input type="hidden" name="orders_rules_id" id="orders_rules_id" value="{{ $Orders_rules->id }}">
                    <div class="col-md-12">
                        <div class="box box-primary" style="padding: 10px;">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ __('admin_message.edit rule') }}</h3>
                            </div>
                            <div class="box-body" style="overflow-x: auto !important">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="designation_name">{{ __('admin_message.Designation name') }}</label>
                                        <input type="text" class="form-control" value="{{ $Orders_rules->title }}"
                                            name="designation_name" id="exampleInputEmail1"
                                            placeholder="{{ __('admin_message.Designation name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="details">{{ __('admin_message.details') }}</label>
                                        <input type="text" class="form-control" value="{{ $Orders_rules->details }}"
                                            name="details" id="exampleInputEmail1"
                                            placeholder="{{ __('admin_message.details') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin_message.status') }}</label>
                                        <select name="status" class="form-control">
                                            <option {{ $Orders_rules->status == 1 ? 'selected' : '' }} value="1">
                                                {{ __('admin_message.active') }}</option>
                                            <option {{ $Orders_rules->status == 0 ? 'selected' : '' }} value="0">
                                                {{ __('admin_message.not active') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max">{{ __('admin_message.Maximum order limit') }}</label>
                                        <input type="number" name="max" class="form-control"
                                            value="{{ $Orders_rules->max }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">{{ __('admin_message.Type of Request') }}</label>
                                        <select name="work_type" class="form-control" id="work_type">
                                            <option value="">{{ __('admin_message.Choose a type') }}</option>
                                            <option {{ $Orders_rules->work_type == "client" ? 'selected' : '' }} value="client">
                                                {{ __('admin_message.Client') }}</option>
                                            <option {{ $Orders_rules->work_type == "restaurant" ? 'selected' : '' }} value="restaurant">
                                                {{ __('admin_message.restaurant') }}</option>
                                            <option {{ $Orders_rules->work_type == "branch" ? 'selected' : '' }} value="branch">
                                                {{ __('admin_message.branch') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delegate_id">{{ __('admin_message.Choose a Delegate') }}</label>
                                        <select class="form-control select2" id="delegate_id" name="delegate_id">
                                            <option value="">{{ __('admin_message.Choose a Delegate') }}
                                            </option>
                                            @foreach ($delegates as $delegate)
                                                <option {{ $Orders_rules->delegate_id == $delegate->id ? 'selected' : '' }}
                                                    value="{{ $delegate->id }}">{{ $delegate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box -->
                    </div>
                    <fieldset class="box-body overflow-auto border rounded p-3 bg-white"
                        style="margin-left: 22px; margin-right: 22px;">
                        <h4 style="display: contents">اضافة شروط التعيين</h4>
                        <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;padding-top: 5px">
                            <div class="col-md-1">
                                <label for="cod">{{ __('admin_message.COD') }}</label>
                                <select name="cod" class="form-control">
                                    <option value="">
                                        {{ __('admin_message.Choose payment status') }}</option>
                                    <option value="1">
                                        {{ __('admin_message.paid') }}</option>
                                    <option value="0">
                                        {{ __('admin_message.UnPaid') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="client_id">{{ __('admin_message.Client') }}</label>
                                <select id="client_id" class="form-control select2" name="client_id">
                                    <option value="">
                                        {{ __('admin_message.Choose a client') }}
                                    </option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="city_from">{{ __('admin_message.From the city') }}</label>
                                <select id="city_from" name="city_from" class="form-control select2">
                                    <option value="">{{ __('admin_message.Choose a city') }}
                                    </option>
                                    @foreach ($cites as $city)
                                        <option value="{{ $city->id }}">{{ $city->title }}
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
                                        <option value="{{ $city->id }}">{{ $city->title }}
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
                                        <option value="{{ $region->id }}">{{ $region->title }}
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
                                        <option value="{{ $region->id }}">{{ $region->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1" style="margin-top: 22px">
                                <button id="addCondition" type="button" class="btn btn-success">add</button>
                            </div>
                        </div>
                        <div id="parentTable" style="margin-top:80px">
                            <h3 class="text-danger" style="border-top: 1px solid #80808042;padding-top: 12px;">عرض الشروط
                            </h3>
                            <table id="conditionsTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('admin_message.COD') }}</th>
                                        <th scope="col">{{ __('admin_message.Client') }}</th>
                                        <th scope="col">{{ __('admin_message.From the city') }}</th>
                                        <th scope="col">{{ __('admin_message.To the city') }}</th>
                                        <th scope="col">{{ __('admin_message.From the neighborhood') }}</th>
                                        <th scope="col">{{ __('admin_message.To the neighborhood') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Orders_rules->order_rules_details as $details)
                                        <tr>
                                            <td>{{ $details->cod == 0 ? __('admin_message.UnPaid') : __('admin_message.paid') }}
                                            </td>
                                            <td>{{ $details->client_id ? $details->customer->name : '-' }}</td>
                                            <td>{{ $details->city_from ? $details->city_from_rel->title : '-' }}</td>
                                            <td>{{ $details->city_to ? $details->city_from_rel->title : '-' }}</td>
                                            <td>{{ $details->region_from ? $details->region_from_rel->title : '-' }}</td>
                                            <td>{{ $details->region_to ? $details->region_to_rel->title : '-' }}</td>
                                            <td>
                                                <form id="deleteForm{{$details->id}}" action="{{ route('service_provider.delete_orders_rule_details', $details->id) }}" method="post" style="display: none;">
                                                </form>
                                                <form id="deleteForm{{$details->id}}" class="pull-right" style="display: inline;" action="{{route('service_provider.delete_orders_rule_details', $details->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                      onclick="return confirm('Do you want Delete This Record ?');">
                                                      <i class="fa fa-trash" aria-hidden="true"></i> مسح
                                                    </button>
                                                  </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
    <script>
        $(function() {
            $('.select2').select2()
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            var orderRulesDetails = [];

            $("#addCondition").on("click", function() {
                var cod = $("select[name='cod']").val();
                var cod_text = $("select[name='cod'] option:selected").text();
                var client_id = $("#client_id").val();
                var client_text = $('#client_id option:selected').text();
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
                    city_from_text: city_from_text,
                    city_to_text: city_to_text,
                    region_from_text: region_from_text,
                    region_to_text: region_to_text,
                };
                var condition = {
                    cod: cod,
                    client_id: client_id,
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
                    $("#client_id").val("");
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
                var orders_rules_id = $("#orders_rules_id").val();
                var ruleData = {
                    designation_name: designation_name,
                    details: details,
                    status: status,
                    max: max,
                    work_type: work_type,
                    delegate_id: delegate_id,
                    orders_rules_id: orders_rules_id
                };
                var mergedObject = {
                    orderRulesDetails: orderRulesDetails,
                    orderRules: ruleData,
                };
                $("#conditionsArrayInput").val(JSON.stringify(mergedObject));
                $("#formRuls").submit();
            });

            function appendDataToTable(data) {
                var newRow = $("<tr>");
                newRow.append("<td>" + data.cod_text + "</td>");
                newRow.append("<td>" + data.client_id == "اختر العميل" ? "-" : data.client_text + "</td>");
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
    <script>
        function confirmAndDelete(id) {
            if (confirm('Do you want to delete this record?')) {
                // Use AJAX to submit the form without redirecting
                var form = document.getElementById('deleteForm' + id);

                if (form) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', form.getAttribute('action'), true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.setRequestHeader('X-CSRF-Token', form.querySelector('input[name="_token"]').value);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                        }
                    };
                    xhr.send(new FormData(form));
                } else {
                    console.error('Form not found');
                }
            }
        }
    </script>
@endsection

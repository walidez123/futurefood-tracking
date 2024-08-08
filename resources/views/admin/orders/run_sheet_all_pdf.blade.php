<!DOCTYPE html>
<html lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <title>Run sheet</title>
    <style>
        @media print {

            .printhidden {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h2,
        h3 {
            margin: 0 0 10px 0;
        }

        .header,
        .footer {
            text-align: center;
            margin: 10px 0;
        }

        .customer-details {
            margin-bottom: 20px;
        }

        .order-details {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details,
        .order-details th,
        .order-details td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <a onclick="window.print()" target="_blank" class="btn btn-default printhidden"><i class="fa fa-print"></i>
        @lang('admin_message.Print') </a>

    <div class="container">
        <h6 style="float: left;"> @php
            $dateTime = \Carbon\Carbon::now();
            $meridiem = $dateTime->format('A') === 'AM' ? 'ص' : 'م';
            $time = $dateTime->format('h:i');
            $date = $dateTime->format('Y/m/d');
        @endphp

            {{ "{$date} {$time} {$meridiem}" }}</h6>

        <div class="header">
            <h6>{{ Auth()->user()->company_setting->title }} - Driver load</h6>
            <div class="row" style="background-color: gainsboro;">
                <div class="col-md-4">
                    <img class="img" src="{{ asset('storage/' . Auth()->user()->company_setting->logo) }}" height="75" width="75">
                </div>
                <div class="col-md-4">
                    <h4>Distributer Shipment List</h4>
                </div>
                <div class="col-md-4">
                    <h4> {{ \Carbon\Carbon::now()->format('d/m/Y h:i A') }}</h4>
                </div>
            </div>
            <hr>
            <!--   -->
            <div class="row">
                <div class="col-md-4">
                    <label> user name: </label>
                    {{ Auth()->user()->name }}

                </div>
                <div class="col-md-4">
                    {!! DNS1D::getBarcodeSVG('test', 'C128') !!}


                </div>
                <div class="col-md-4">
                    <label> Driver Code: </label>
                    @if ($delegate != null)
                        {{ $delegate->code }}
                    @endif
                    <br>
                    <label> Driver ID: </label>
                    @if ($delegate != null)
                        {{ $delegate->id }}
                    @endif

                </div>
                <div class="col-md-4">
                    <label> Station: </label>
                </div>

                <div class="col-md-4">
                    <label> Driver Name: </label>
                    @if ($delegate != null)
                        {{ $delegate->name }};
                    @endif
                </div>
                <div class="col-md-4">
                    <label> Route: </label>
                </div>
            </div>
            <br>
            <table class="order-details">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Shipment Customer Name Phone No City Address</th>
                        <th>Store Name number of pieces creation date</th>
                        <th style="width: 150px;">Note
                        </th>
                        <th>Signature</th>
                        <th>FEES</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sum=0;      @endphp
                    @foreach ($orders as $i => $order)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $order->reference_number }} <br>{{ $order->receved_name }} <br>
                                {{ $order->receved_phone }}

                                @if ($order->recevedCity != null)
                                    <br> {{ $order->recevedCity->trans('title') }}
                                @endif
                                @if ($order->region != null)
                                    <br> {{ $order->region->trans('title') }}
                                @endif

                                <br> {{ $order->receved_address }}
                            </td>
                            <td>{{ $order->user->store_name }} <br>{{ $order->number_count }} pieces<br>
                                {{ $order->created_at }}</td>
                            <td></td>
                            <td></td>
                            <td>
                                @if ($order->amount_paid == 1)
                                    0.0 SAR
                                @else
                                    @php $sum=$sum+$order->amount;   @endphp
                                    {{ $order->amount }} SAR
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <!-- Add more products as needed -->
                </tbody>
            </table>
            <!--  -->
            <br>
            <br>
            <label> summary </label>
            <br>
            <br>
            <table class="order-details">
                <tbody>
                    <tr>
                        <td>Count Of Shipment: {{ count($orders) }}
                            <br>Total amount:{{ $sum }} SAR
                        </td>
                        <td>Distributor</td>
                        <td>Team leader </td>
                    </tr>
                    <!-- Add more products as needed -->
                </tbody>
            </table>
            <div class="footer">
                <p>Thank you for your business!</p>
            </div>
        </div>
    </div>
</body>
</html>

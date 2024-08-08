<!DOCTYPE html>
<html lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>logistic</title>
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('invoice/themify.css') }}">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <style type="text/css">
        body {
            direction: rtl;
            font-family: Rubik, sans-serif;
            display: block;
            color: #000248;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div style="">
        <caption>فاتورة رقم{{ $InvoceNum }} <br>
        </caption>
    </div>
    <form action="{{ route('report.store') }}" method="post">

        <button style="float: left;" type="submit" value="حفظ">حفظ الفاتورة </button>

        @csrf

        <input type="hidden" name="start_date" value="{{ $from }}">
        <input type="hidden" name="end_date" value="{{ $to }}">
        <input type="hidden" name="client_id" value="{{ $user->id }}">
        <input type="hidden" name="InvoceNum" value="{{ $InvoceNum }}">




        @if (count($orders) > 0)

            <table style="width: 100%;">
                <caption>الفاتورة المبدئية
                </caption>
                <tr>
                    <th>
                    <td>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                رقم الحساب :{{ $user->id }} </span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                أسم العميل :{{ $user->name }} </span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                العنوان :{{ $user->address }} </span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                رقم الحساب البنكى :{{ $user->bank_account_number }} </span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                الرقم الضريبى :{{ $user->tax_Number }}</span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                العملة :{{ $appSetting->currency }}</span>
                        </address>
                    </td>
                    </th>
                    <th>
                    <td>
                        <center>
                            <img width="200px" src="{{ asset('storage/' . $webSetting->logo) }}" alt="logo">

                        </center>

                    </td>
                    </th>
                    <th>
                    <td>


                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                رقم الحساب البنكى :{{ $user->bank_account_number }} </span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                الرقم الضريبى :{{ $user->tax_Number }}</span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                رقم الفاتورة :{{ $InvoceNum }}</span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                تاريخ الفاتورة :{{ now() }}</span>
                        </address>
                        <address style="color: #52526C;opacity: 0.8; margin-top: 10px; font-style:normal;">
                            <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                الإيميل للدعم :{{ $appSetting->email }}</span>
                        </address>
                    </td>

                    </th>
                </tr>
                <tr></tr>
            </table>
            <table style="width: 100%;">

                <tr>
                    <th>
                        رقم
                    </th>
                    <th>
                        رقم الطلب
                    </th>
                    <th>
                        رقم البوليصة
                    </th>
                    <th>
                        تاريخ التوصيل
                    </th>
                    <th>المصدر</th>
                    <th>الواجهة</th>
                    @if ($user->work == 1)
                        <th>
                            الوزن
                        </th>
                        <th>
                            عدد القطع
                        </th>
                    @endif

                    <th>نوع الخدمة</th>
                    <th>
                        قيمة التحصيل
                    </th>
                    <th>
                        رسوم التحصيل
                    </th>
                    <th>قيمة الإرجاع</th>
                    <th>مجموع التوصيل</th>
                    <th>total</th>

                    <th>
                        الضريبة
                    </th>
                    <th>
                        الإجمالى
                    </th>

                </tr>
                @php
                    $total = 0;
                    $Glopaltotal = 0;
                    $tax = 0;
                    $shippingCost = 0;
                    $allreturnCost = 0;
                    $allcostfess = 0;
                @endphp
                @foreach ($orders as $i => $order)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->tracking_id }}</td>
                        @if ($user->work == 1)
                            <td>{{ $order->pickup_date }}</td>
                        @else
                            <td>{{ $order->updated_at }}</td>
                        @endif

                        <td>
                            @if ($order->address != null)
                                {{ $order->address->city->trans('title') }}
                            @endif
                        </td>
                        <td>{{ $order->recevedCity->trans('title') }}</td>
                        @if ($user->work == 1)
                            <td>{{ $order->order_weight }}</td>
                            <td>{{ $order->number_count }}</td>
                        @endif



                        @if ($order->amount_paid == 1)
                            <td>CC / Delivered</td>
                            <td>0</td>
                            <td>
                                @php$costfees = 0;
                                    $allcostfess += $costfees;
                                @endphp
                                {{ $costfees }}
                            </td>
                        @else
                            <td>COD / Delivered</td>
                            <td>{{ $order->amount }}</td>
                            <td>
                                <?php
                                $transaction = $order->ClientTransactions()->where('transaction_type_id', 3)->get();
                                $costfees = $transaction->sum('creditor');
                                $allcostfess += $costfees;
                                
                                ?>

                                {{ $costfees }}
                            </td>
                        @endif
                        <td>
                            @if ($order->is_returned == 0)
                                @php$costReturn = 0;
                                    $allreturnCost += $costReturn;
                                @endphp

                                0
                            @else
                                @php
                                    $transaction = $order->ClientTransactions()->where('transaction_type_id', 2)->get();
                                    $costReturn = $transaction->sum('creditor');
                                    $allreturnCost += $costReturn;
                                @endphp
                            @endif
                        </td>
                        <td>
                            @php
                                $transaction = $order->ClientTransactions()->where('transaction_type_id', 1)->get();
                                $cost = $transaction->sum('creditor');
                                $shippingCost += $cost;

                            @endphp
                            {{ $cost }}
                        </td>
                        <td>
                            @php $total = $cost + $costReturn + $costfees; @endphp
                            {{ $total }}

                        </td>
                        <td>
                            <!-- {{ ($cost * $order->user->tax) / 100 }}
            @php   @endphp  -->
                        </td>
                        <td>
                            @if ($order->amount_paid == 1)
                                {{ $total }}
                            @else
                                {{ $order->amount + $total }}
                            @endif
                        </td>

                        @php
                            $tax += ($cost * $order->user->tax) / 100;
                            if ($order->amount_paid == 1) {
                                $Glopaltotal += $total;
                            } else {
                                $Glopaltotal += $order->amount + $total;
                            }
                        @endphp

                    </tr>
                @endforeach




            </table>
            <table style="float: left;">
                <tr>
                    <th> رسوم التحصيل</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>رسوم التحصيل</td>
                    <td>{{ $allcostfess }}</td>
                </tr>
                <tr>
                    <th> رسوم الإرجاع</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>رسوم الإرجاع</td>
                    <td>{{ $allreturnCost }}</td>
                </tr>
                <tr>
                    <th> تكلفة توصيل الشحنات</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>تكلفة التوصيل</td>
                    <td>{{ $shippingCost }}</td>
                </tr>
                <tr>
                    <th> نسبة الضريبة</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>نسبة الضريبة</td>
                    <td>{{ $user->tax }}%</td>
                </tr>
                <tr>
                    <th> إجمالى الضريبة </th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>إجمالى الضريبة</td>
                    <td>{{ $tax }}</td>
                </tr>
                <tr>
                    <th> إجمالى الفاتورة بعد الضريبة</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <td>إجمالى المبلغ</td>
                    <td>{{ $Glopaltotal }}</td>
                </tr>
                <tr>
                    <th> إجمالى المبلغ الواجب تحويلة</th>
                    <th>القيمة</th>
                </tr>
                <tr>
                    <th>إجمالى التحصيلات</th>
                    <th>{{ $Glopaltotal }}</th>
                </tr>




            </table>
            <input type="hidden" name="allcostfess" value="{{ $allcostfess }}">
            <input type="hidden" name="allreturnCost" value="{{ $allreturnCost }}">

            <input type="hidden" name="shippingCost" value="{{ $shippingCost }}">
            <input type="hidden" name="tax" value="{{ $user->tax }}">
            <input type="hidden" name="totaltax" value="{{ $tax }}">
            <input type="hidden" name="Glopaltotal" value="{{ $Glopaltotal }}">
        @else
            <h1>لا توجد طلبات </h1>


        @endif

    </form>

</body>

</html>

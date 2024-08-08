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
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>فاتورة الضريبة</title>
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('invoice/themify.css') }}">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <style type="text/css">
        body {
            font-family: Rubik, sans-serif;
            display: block;
            color: #000248;
        }
    </style>
</head>

<body>
    <table style="width:1160px;margin:0 auto;">
        <tbody>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td>
                                    <img width="200px" src="{{ asset('storage/' . $webSetting->logo) }}" alt="logo">
                                    <address
                                        style="color: #52526C;opacity: 0.8; width: 40%; margin-top: 10px; font-style:normal;">
                                        <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                            {{ $webSetting->title_ar }}</span>
                                    </address>
                                </td>
                                <td style="color: #52526C;opacity: 0.8; text-align:end;">
                                    <span
                                        style="display:block; line-height: 1.5; font-size:22px; font-weight:1000;">الفاتورة
                                        الضريبة</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">الأسم
                                        : {{ $webSetting->title_ar }}</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">الرقم
                                        الضريبى: {{ $webSetting->tax_Number }}</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">العنوان
                                        :{{ $webSetting->address_ar }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="padding: 28px 0; display:block;border-top: 1px solid rgba(82, 82, 108, 0.3);">
                                <!--  -->
                                <td Style="width:63%;"><span
                                        style="color: #52526C;opacity: 0.8; font-size: 16px; font-weight: 500;">
                                        @if (!empty($invoice))
                                            @php
                                                $amount = $invoice->Glopaltotal;
                                                $dataToEncode = [
                                                    [1, $client->name],
                                                    [2, $client->tax_Number ?? '-'],
                                                    [3, date('d-m-Y H:i A', strtotime($invoice->updated_at))],
                                                    [
                                                        4,
                                                        filter_var(
                                                            $amount,
                                                            FILTER_SANITIZE_NUMBER_FLOAT,
                                                            FILTER_FLAG_ALLOW_FRACTION,
                                                        ),
                                                    ],
                                                    [
                                                        5,
                                                        filter_var(
                                                            $client->tax,
                                                            FILTER_SANITIZE_NUMBER_FLOAT,
                                                            FILTER_FLAG_ALLOW_FRACTION,
                                                        ),
                                                    ],
                                                ];

                                                $__TLV = __getTLV($dataToEncode);
                                                $QR = base64_encode($__TLV);
                                            @endphp
                                            {{ QrCode::generate($QR) }}
                                        @endif
                                </td>



                                <!--  -->
                                <td style="color: #52526C;opacity: 0.8; text-align:end;">

                                    <span style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">
                                        التفاصيل
                                        :فاتورة تاريخ من {{ $invoice->start_date }} to {{ $invoice->end_date }}</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">الرقم
                                        الضريبى
                                        : {{ $client->tax_Number }}</span>

                                </td>
                                <td style="color: #52526C;opacity: 0.8; text-align:end;">
                                    <span style="display:block; line-height: 1.5; font-size:22px; font-weight:1000;">رقم
                                        الفاتورة :{{ $invoice->InvoceNum }}
                                    </span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">تاريخ
                                        الفاتورة
                                        : {{ $invoice->created_at }}</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">العميل
                                        : {{ $client->store_name }}</span>
                                    <span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">العنوان
                                        :{{ $client->addresses[0]->address }}</span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table
                        style="width: 100%;border-collapse: separate;border-spacing: 0;border: 1px solid rgba(82, 82, 108, 0.1);direction:rtl">
                        <thead>
                            <tr
                                style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">المنتجات</span></th>
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">التفاصيل</span></th>
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">الكمية</span></th>
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">الضريبة %</span></th>
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">قيمة الضريبة</span></th>
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">القيمة</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                style="background-color: rgba(245, 246, 249, 1);box-shadow: 0px 1px 0px 0px rgba(82, 82, 108, 0.15);">
                                <td style="padding: 18px 15px;display:flex;align-items: center;gap: 10px;">
                                    <ul style="padding: 0;margin: 0;list-style: none;">
                                        <li>
                                            <h4 style="font-weight:400; margin:4px 0px; font-size: 18px;">
                                                @if ($client->work == 1)
                                                    شحنات طرود ناقل
                                                @else
                                                    شحنات طلبات ناقل
                                                @endif
                                            </h4>
                                        </li>
                                    </ul>
                                </td>
                                <td style="padding: 18px 15px;"><span style="font-size: 18px;">شحنات ناجحة</span></td>
                                <td style="padding: 18px 15px; width: 12%;"> <span
                                        style="font-size: 18px;">{{ count($invoice->Invoice_order) }}</span>
                                </td>
                                <td style="padding: 18px 15px; width: 12%;"> <span
                                        style="font-size: 18px;">{{ $client->tax }}%</span></td>
                                <td style="padding: 18px 15px; width: 10%;"> <span
                                        style="font-size: 18px;">{{ $invoice->totaltax }}</span>
                                </td>
                                <td style="padding: 18px 15px;"><span
                                        style="font-size: 18px;">{{ $invoice->Glopaltotal }}</span></td>
                            </tr>



                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="float: right;">
                        <caption>معلومات الدفع </caption>
                        <tfoot>
                            <tr>
                                <td style="padding: 5px 0;text-align: left;padding-top: 15px;"><span
                                        style="font-size: 18px;">{{ $client->bank_name }}</span></td>
                                <td style="padding: 5px 24px 5px 0; padding-top: 15px; text-align: end;"> <span
                                        style="color: #52526C; font-size: 18px; font-weight: 400;"><span
                                            style="margin-left: 8px; font-size: 18px;">:</span>حسابنا عبر بنك </span>
                                </td>

                            </tr>
                            <tr>
                                <td style="padding: 5px 0;text-align: left;padding-top: 0;"><span
                                        style="font-size: 18px;">{{ $client->bank_account_number }}</span></td>
                                <td style="padding: 5px 24px 5px 0; text-align: end;"> <span
                                        style="color: #52526C; font-size: 18px; font-weight: 400;"><span
                                            style="margin-left: 8px; font-size: 18px;">:</span>أسم الحساب </span></td>

                            </tr>
                            <tr>
                                <td style="padding: 5px 0;text-align: left;padding-top: 0;"><span
                                        style="font-size: 18px;">{{ $client->bank_swift }}</span></td>
                                <td style="padding: 5px 24px 5px 0; text-align: end;"> <span
                                        style="color: #52526C; font-size: 18px; font-weight: 400;"><span
                                            style="margin-left: 8px; font-size: 18px;">:</span>الأيبان
                                    </span></td>

                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>

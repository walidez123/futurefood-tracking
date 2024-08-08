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
    <link rel="stylesheet" type="text/css" href="{{asset('invoice/themify.css')}}">
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
                                    <img src="{{asset('$appSetting->logo')}}" alt="logo">
                                    <address
                                        style="color: #52526C;opacity: 0.8; width: 40%; margin-top: 10px; font-style:normal;">
                                        <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                        المملكة العربية السعوديه</span></address>
                                          <address
                                        style="color: #52526C;opacity: 0.8; width: 40%; margin-top: 10px; font-style:normal;">
                                        <span style="font-size: 18px; line-height: 1.5; font-weight: 500;">
                                         الرقم الضريبى :{{$client->tax_Number}}</span></add
                                </td>
                                <td style="color: #52526C;opacity: 0.8; text-align:end;"><span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">البريد الإلكترونى
                                        : {{$appSetting->email}}</span><span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">الموقع:
                                        https://logistic.futuretech-co.com/</span><span
                                        style="display:block; line-height: 1.5; font-size:18px; font-weight:500;">رقم التواصل
                                         : {{$appSetting->phone}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;">
                        <tbody>
                            <tr
                                style="display:flex;justify-content:space-between;border-top: 1px solid rgba(82, 82, 108, 0.3);border-bottom: 1px solid rgba(82, 82, 108, 0.3);padding: 25px 0;">
                                <td style="display:flex;align-items:center; gap: 6px;"> <span
                                        style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">رقم الفاتورة
                                        .</span>
                                    <h4 style="margin:0;font-weight:400; font-size: 18px;">{{$order->order_id}}</h4>
                                </td>
                                <td style="display:flex;align-items:center; gap: 6px;"> <span
                                        style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">التاريخ :
                                    </span>
                                    <h4 style="margin:0;font-weight:400; font-size: 18px;">{{$order->updated_at}}</h4>
                                </td>
                                <td style="display:flex;align-items:center; gap: 6px;"> <span
                                        style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">حالة الدفع
                                         :</span>
                                    <h4
                                        style="margin:0;font-weight:400; font-size: 18px;padding:6px 18px; background-color:rgba(84, 186, 74, 0.1);color:#54BA4A; border-radius: 5px;">
                                        {{$order->status->title}}</h4>
                                </td>
                                <td style="display:flex;align-items:center; gap: 6px;"> <span
                                        style="color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 500;">المبلغ
                                         :</span>
                                    <h4 style="margin:0;font-weight:500; font-size: 18px;"> {{(($order->amount*$client->tax)/100)+$order->amount}} ر.س</h4>
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
                            <tr style="padding: 28px 0; display:block;">
                                <td Style="width:63%;"><span
                                        style="color: #52526C;opacity: 0.8; font-size: 16px; font-weight: 500;">عنوان المرسل اليه
                                        </span>
                                    <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 18px;"> {{$order->receved_name}}
                                    </h4><span
                                        style="width: 54%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">
                                        {{$order->recevedCity->title}} - {{$order->receved_address}} | {{$order->receved_address_2}}</span><span
                                        style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">رقم الجوال
                                        : {{$order->receved_phone}}</span>
                                </td>
                                <td><span
                                        style="color: #52526C;opacity: 0.8;font-size: 16px; font-weight: 500;">عنوان الراسل 
                                        </span>
                                    <h4 style="font-weight:400; margin: 12px 0 6px 0; font-size: 18px;">{{$client->name}}
                                        </h4><span
                                        style="width: 95%; display:block; line-height: 1.5; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">
                                        {{$order->senderCity->title}} - {{$order->sender_address}} | {{$order->sender_address_2}} </span><span
                                        style="line-height:2.6; color: #52526C;opacity: 0.8; font-size: 18px; font-weight: 400;">رقم الجوال
                                        : {{$order->sender_phone}} </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table
                        style="width: 100%;border-collapse: separate;border-spacing: 0;border: 1px solid rgba(82, 82, 108, 0.1)">
                        <thead>
                            <tr
                                style="background: #7366FF;border-radius: 8px;overflow: hidden;box-shadow: 0px 10.9412px 10.9412px rgba(82, 77, 141, 0.04), 0px 9.51387px 7.6111px rgba(82, 77, 141, 0.06), 0px 5.05275px 4.0422px rgba(82, 77, 141, 0.0484671);border-radius: 5.47059px;">
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">الطلب</span></th>
                               
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">السعر</span></th>
                                
                               
                                <th style="padding: 18px 15px;text-align: right"><span
                                        style="color: #fff; font-size: 18px;">تاريخ الأستلام</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                style="background-color: rgba(245, 246, 249, 1);box-shadow: 0px 1px 0px 0px rgba(82, 82, 108, 0.15);">
                                <td style="padding: 18px 15px;display:flex;align-items: center;gap: 10px;"><span
                                        style="width: 54px; height: 51px; background-color:#F5F6F9; display: flex; justify-content: center;align-items: center; border-radius: 5px;"></span>
                                    <ul style="padding: 0;margin: 0;list-style: none;">
                                        <li>
                                            <h4 style="font-weight:400; margin:4px 0px; font-size: 18px;">{{$order->order_contents}}
                                            </h4>
                                        </li>
                                    </ul>
                                </td>
                                <td style="padding: 18px 15px; width: 12%;"> <span style="font-size: 18px;">{{$order->amount}} ر.س</span>
                                </td>
                               
                                <td style="padding: 18px 15px; width: 10%;"> <span style="font-size: 18px;">{{$order->pickup_date}}</span>
                                </td>
                            </tr>
                        
                          
                      
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="float: right;">
                        <tfoot>
                             <tr>
                                <td style="padding: 5px 24px 5px 0; padding-top: 15px; text-align: end;"> <span
                                        style="color: #52526C; font-size: 18px; font-weight: 400;">المبلغ </span><span
                                        style="margin-left: 8px; font-size: 18px;">:</span></td>
                                <td style="padding: 5px 0;text-align: left;padding-top: 15px;"><span
                                        style="font-size: 18px;">{{$order->amount}} ر.س</span></td>
                            </tr> 
                            <tr>
                            <td style="padding: 5px 0;text-align: left;padding-top: 0;"><span
                                        style="font-size: 18px;"> :الضريبة (0%)</span></td>
                                <td style="padding: 5px 24px 5px 0; text-align: end;"> <span
                                        style="color: #52526C; font-size: 18px; font-weight: 400;" >{{$client->tax}} % </span><span
                                        style="margin-left: 8px; font-size: 18px;"></span></td>
                             
                            </tr>
                         
                            <tr>
                            <td style="padding: 12px 24px 22px 0;;text-align: left"><span
                                        style="font-weight: 500; font-size: 20px; color: rgba(115, 102, 255, 1);"> إجمالى المبلغ :</span>
                                </td>
                                <td style="padding: 12px 24px 22px 0;"> <span
                                        style="font-weight: 600; font-size: 20px; color: rgba(0, 2, 72, 1);">
                                      {{(($order->amount*$client->tax)/100)+$order->amount}} ر.س</span><span style="margin-left: 8px;"></span></td>
                               
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            <tr>
                <td> <span
                        style="display:block;background: rgba(82, 82, 108, 0.3);height: 1px;width: 100%;margin-bottom:24px;"></span>
                </td>
            </tr>
            <tr>
              
                <td> <span style="display: flex; justify-content: end; gap: 15px;">
                            <a style="background: rgba(115, 102, 255, 1); color:rgba(255, 255, 255, 1);border-radius: 10px;padding: 18px 27px;font-size: 16px;font-weight: 600;outline: 0;border: 0; text-decoration: none;"
                            href="#!" onclick="window.print();">طباعة</a>
                          @if(!empty($order))

                    @php
                    $amount= (($order->amount*$client->tax)/100)+$order->amount;
                    $dataToEncode = [
                    [1, $order->receved_name],
                    [2, $client->tax_Number ?? '-'],
                    [3, date('d-m-Y H:i A', strtotime($order->updated_at))],
                    [4, (filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ) ],
                    [5, (filter_var($client->tax, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ) ]
                    ];

                    $__TLV = __getTLV($dataToEncode);
                    $QR = base64_encode($__TLV);
                    @endphp
                            {{ QrCode::generate($QR)}}
                    @endif
                    </span>
                </td>

            </tr>
        </tbody>
    </table>
</body>

</html>
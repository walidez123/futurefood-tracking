<html lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">


</head>

<body>
    <table>
        <tr>
            <th> Order Number </th>
        </tr>
        @foreach ($pdforder as $order)
            <tr>
                <td>
                    {{ $order->order_id }}

                </td>
            </tr>
        @endforeach

    </table>
</body>

</html>

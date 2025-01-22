<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }
    body{
        font-family: DejaVu Sans, sans-serif;
        box-sizing: border-box;
        border-collapse: collapse;
        padding: 0;
        margin: 0;
        font-size: 18px;
    }
    table {
        border-collapse: collapse;
    }

    .container {
        width: 95%;
        margin: 50px auto;
    }
    .title {
        width: 100%;
        border: none;
        margin-bottom: 20px;
    }
    .underlined {
        border-bottom: 2px solid black;
        font-weight: 700;
    }

    .title td {
        border: none;
    }

    .header__content {
        width: 100%;
    }
    .information {
        width: 80%;
    }
    .information__text {
        margin-top: 50px;
    }
    .info__name {
        font-size: 14px;
    }
    .info__value {
        padding-left: 30px;
    }
    .qr {
        width: 20%;
    }

    .main__table {
        width: 100%;
        border: 2px solid #000;
        margin-bottom: 20px;
    }
    .main__table th {
        color: black;
        font-weight: bold;
    }
    .main__table td,
    .main__table th {
        padding: 5px;
        border: 1px solid #000;
        text-align: left;
        font-size: 18px;
    }
    .main__table th {
        text-align: center;
    }

    .result,
    .result tr,
    .result td {
        width: 100%;
        border: none;
        font-weight: 700;
        text-align: right;
    }
    .result td {
        padding: 3px 0;
    }

    .footer__info {
        opacity: 0.8;
        font-size: 12px;
    }
    .footer__text {
        font-weight: 700;
        font-size: 16px;
    }
</style>
<body>
<div class="container">
    <table class="title">
        <tr>
            <td class="information">
                <table class="header__content">
                    <tr class="underlined">
                        <td>
                            Заказ наряд № 12 от {{ $dateNow = Carbon\Carbon::now()->translatedFormat('d M Y') }} г.
                        </td>
                    </tr>
                    <tr style="height: 40px"></tr>
                    <tr class="information__text">
                        <td>
                            <table>
                                <tr>
                                    <td class="info__name">
                                        Исполнитель
                                    </td>
                                    <td class="info__value">
                                        {{ $orderDetails['documentText'] }} <br>
                                        {{ $orderDetails['documentPhone'] }}
                                    </td>
                                </tr>
                                <tr style="height: 20px"></tr>
                                <tr>
                                    <td class="info__name">
                                        Заказчик
                                    </td>
                                    <td class="info__value">
                                        Розничный покупатель-Установка2, тел.: 123
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>


{{--            <td class="qr">Qr code</td>--}}
        </tr>
    </table>


    <table class="main__table">
        <tr>
            <th>№</th>
            <th>Дата</th>
            <th>Наименование товара</th>
            <th>Кол-во</th>
            <th>Ед.</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>

        @foreach($data as $order)
            <tr>
                <td>{{ $order['blankPosition']  }}</td>
                <td>{{ $order['blankDate'] }}</td>
                <td>{{ $order['name'] }}</td>
                <td>{{ $order['quantity'] }}</td>
                <td>{{ $order['measurement'] }}</td>
                <td>{{ $order['price'] }}</td>
                <td>{{ $order['totalPrice'] }}</td>
            </tr>
        @endforeach
    </table>

    <table class="result">
        <tr>
            <td>
                Итого : {{ $orderDetails['orderTotalSum'] }}
            </td>
        </tr>
    </table>

    <div class="footer__info">Всего наименований {{ $orderDetails['totalGoodsCount'] }}, на сумму {{ $orderDetails['orderTotalSum'] }} руб.</div>
    <div class="footer__text">
        {{$orderDetails['orderTotalSumAsString'] }} руб
    </div>
</div>
</body>
</html>

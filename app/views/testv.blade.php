<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        * {
            font-family: DejaVu Sans,
            font-size: 5px;
        }

        table {
            margin: 0;
            padding: 0;
            border-collapse: collapse;
        }

        td, th {
            padding: .1em 1em;
            border: 1px solid #999;
        }

        .table-container {
            width: 100%;
            _overflow: auto;
            margin: 0 0;
        }
    </style>
</head>
<body>
<table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
    <tr style="border: 1px solid white;  border-collapse: collapse; ">
        <td rowspan="2"
            style="width: 80%; font-size: 14px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
            Заявка на відбір товару
        </td>
        <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
            Номер:
        </td>
        <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $appID }}</td>
    </tr>
    <tr style="border: 1px solid white;  border-collapse: collapse;">
        <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
            Дата:
        </td>
        <td style="width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $strCDate }}</td>
    </tr>
</table>
<h1></h1>

<hr>
<div class="table-container">
    <table style="width: 100%;">
        <thead>
        <tr>
            <td style="align-content: center; text-align: center; font-size: 10px;">Дата відвантаження</td>
            <td style="align-content: center; text-align: center; font-size: 10px;">Перевізник</td>
            <td style="align-content: center; text-align: center; font-size: 10px;">Місто</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">{{ $strDate }}</td>
            <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">{{ $strTransporter }}</td>
            <td style="align-content: center; text-align: center; font-size: 14px; font-weight: bold;">{{ $city }}</td>
        </tr>
        </tbody>
        <tfoot>
        <tr style="width: 100%;">
            <td colspan="3" style="text-align: center; align-content: center; font-size: 10px;">Особливі відмітки</td>
        </tr>
        <tr style="width: 100%;">
            <td colspan="3"
                style="text-align: center; align-content: center; font-size: 14px; font-weight: bold;">{{ $specialNotes }}</td>
        </tr>
        </tfoot>
    </table>
    <br/>
    <br/>
    <table style="width: 100%;">
        <thead>
        <tr>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">Фірма</td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">Алиста</td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold;">1</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center; align-content: center; font-size: 12px;">Предприятие</td>
            <td style="text-align: center; align-content: center; font-size: 12px;">{{ $compName }}</td>
            <td style="text-align: center; align-content: center; font-size: 12px;"></td>
        </tr>
        <tr>
            <td style="text-align: center; align-content: center; font-size: 12px;">Відправник товару</td>
            <td style="text-align: center; align-content: center; font-size: 12px;">Скдад метизов</td>
            <td style="text-align: center; align-content: center; font-size: 12px;">{{ $StockID }}</td>
        </tr>
        <tr>
            <td style="text-align: center; align-content: center; font-size: 12px;">Адреса</td>
            <td style="text-align: center; align-content: center; font-size: 12px;">Дніпропетровськ, вул. Героїв
                Сталінграда, буд.147
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px;"></td>
        </tr>
        </tbody>
    </table>
    <br/>
    <br/>
    <table style="width: 100%;">
        <thead>
        <tr>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Код
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Товар
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Дод.Од.Вим.
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Дод.кількість
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Од.Вим.
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Кількість
            </td>
            <td style="text-align: center; align-content: center; font-size: 12px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">
                Загальна кількість
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach($prodBody as $key => $value)
            <tr>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[0] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[1] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[2] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[3] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[2] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[3] }}</td>
                <td style="text-align: center; align-content: center; font-size: 12px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value[4] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
    <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
        <tr style="border: 1px solid white;  border-collapse: collapse; ">
            <td rowspan="3" style="border: 1px solid white;  border-collapse: collapse; width: 70%;"></td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                Кількість:
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $TQty }}</td>
        </tr>
        <tr style="border: 1px solid white;  border-collapse: collapse;">
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                Додаткова кількість:
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $TQty }}</td>
        </tr>
        <tr style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Вага:
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $TWeight }}</td>
        </tr>
    </table>
    <br/>
    <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
        <tr style="border: 1px solid white;  border-collapse: collapse;">
            <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">
                Дозволив
            </th>
            <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">
                Відпустив
            </th>
            <th style="margin: 20px; padding: 20px; font-size: 12px; font-weight: bold; border: 1px solid white; border-collapse: collapse;">
                Узгодив
            </th>
        </tr>
        <tr style="border: 1px solid white;  border-collapse: collapse;">
            <th style="border: 1px solid white; border-collapse: collapse;">
                <hr>
            </th>
            <th style="border: 1px solid white; border-collapse: collapse;">
                <hr>
            </th>
            <th style="border: 1px solid white; border-collapse: collapse;">
                <hr>
            </th>
        </tr>
        <tr style="border: solid white;  border-collapse: collapse;">
            <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ
                Підпис
            </td>
            <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ
                Підпис
            </td>
            <td style="font-size: 8px; text-align: right; border: 1px solid white; border-collapse: collapse;">ПІБ
                Підпис
            </td>
        </tr>
    </table>
</div>
</body>
</html>
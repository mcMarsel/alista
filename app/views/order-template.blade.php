<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            * {
                    font-family: DejaVu Sans, font-size: 5px;
                }
            table
            {
                margin: 0;
                padding: 0;
                border-collapse: collapse;
            }
            td, th
            {
                padding: .1em 1em;
                border: 1px solid #999;
            }
            .table-container
            {
                width: 100%;
                _overflow: auto;
                margin: 0 0;
            }
        </style>
    </head>
    <body>
        <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
            <tr style="border: 1px solid white;  border-collapse: collapse; ">
                <td rowspan="2" style="width: 80%; font-size: 14px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Рахунок</td>
                <td style="text-align: right; width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Номер: </td>
                <td style="text-align: right; width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $DocID }}</td>
            </tr>
            <tr style="border: 1px solid white;  border-collapse: collapse;">
                <td style="text-align: right; width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Дата: </td>
                <td style="text-align: right; width: 20%; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $strDate }}</td>
            </tr>
        </table>
        <hr>
        <div class="table-container">
            <table style="width: 100%; border: 1px solid white;  border-collapse: collapse; ">
                <tbody>
                    <tr>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px; font-weight: bold;">ПУБЛІЧНЕ АКЦІОНЕРНЕ ТОВАРИСТВО "ДНІПРОПОЛІМЕРМАШ"</td>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">р/с 2600718904</td>
                    </tr>
                    <tr>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">49033, м. Дніпропетровськ</td>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">ПАТ «ПУМБ», м. Дніпропетровськ</td>
                    </tr>
                    <tr>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">вул. Героїв Сталінграда,147</td>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px; font-weight: bold;">МФО 334851</td>
                    </tr>
                    <tr>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px; font-weight: bold;">Податковий код: 002186104027, Свідоцтво: 100335408</td>
                        <td style="align-content: center; border: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">Код ОКПО 00218615</td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <br/>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="width: 20%; border-bottom: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px; font-weight: bold;">Підприємство</td>
                        <td style="width: 60%; border-bottom: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px; font-weight: bold;">{{ $CompName }}</td>
                        <td style="width: 20%; border-bottom: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px; font-weight: bold;">{{ $CompID }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 20%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">Адреса</td>
                        <td style="width: 60%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">{{ $CompAdd }}</td>
                        <td style="width: 20%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">72    1</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 20%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">Місто</td>
                        <td style="width: 60%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">{{ $CityName }}</td>
                        <td style="width: 20%; border-bottom: 1px solid white; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">4</td>
                    </tr>
                    <tr>
                        <td style="width: 20%; border-top: 1px solid white; border-collapse: collapse; text-align: right; font-size: 10px;">Телефон: </td>
                        <td style="width: 60%; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">{{-- $CompContact --}}</td>
                        <td style="width: 20%; border-top: 1px solid white; border-collapse: collapse; text-align: left; font-size: 10px;">0</td>
                    </tr>
                </tfoot>
            </table>
            <br/>
            <br/>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Код</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Назва товару, (робіт, послуг)</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Од.Вим.</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Кількість</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Ціна без ПДВ</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Сума без ПДВ</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Ціна з ПДВ</td>
                        <td style="text-align: center; align-content: center; font-size: 10px; font-weight: bold; overflow-y: hidden; margin: 0; padding: 0;">Сума з ПДВ</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $key => $value)
                        <tr>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value['ProdID'] }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value['ProdName'] }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ $value['UM'] }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ round($value['Qty'], 2) }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ round(($value['PriceMC']/1.2), 2) }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ round(($value['SumPrice']/1.2), 2) }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ round($value['PriceMC'], 2) }}</td>
                            <td style="text-align: center; align-content: center; font-size: 10px; overflow-y: hidden; margin: 0; padding: 0;">{{ round($value['SumPrice'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br/>
            <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
                <tr style="border: 1px solid white;  border-collapse: collapse; ">
                    <td style="width: 20%; text-align: left; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Кількість: {{ $TQty }}</td>
                    <td style="width: 65%; text-align: right; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Сума без ПДВ</td>
                    <td style="width: 15%; text-align: right; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">{{ $TSum_nt }}</td>
                </tr>
                <tr style="border: 1px solid white;  border-collapse: collapse;">
                    <td style="width: 20%; text-align: left; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Загальна вага: {{ $TWeight }}</td>
                    <td style="width: 65%; text-align: right; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">Сума ПДВ: </td>
                    <td style="width: 15%; text-align: right; font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;"></td>
                </tr>
            </table>

            <br/>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%; font-size: 12px; font-weight: bold; text-align: center;">Сума з ПДВ:</td>
                    <td style="width: 70%; font-size: 12px; font-weight: bold; text-align: center;">{{ $numberChar }}</td>
                    <td style="width: 15%; font-size: 12px; font-weight: bold; text-align: center;">{{ $TPrice_wt }}</td>
                </tr>
            </table>
            <br/>
            <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
                <tr style="border: 1px solid white;  border-collapse: collapse;">
                    <td  style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                        Вiдхилення кiлькостi одиниць товару в упаковцi може складати +/-3% вiд кiлькостi, зазначеної на упаковці
                    </td>
                </tr>
            </table>
            <br/>
            <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
                <tr style="border: 1px solid white;  border-collapse: collapse;">
                    <td  style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                        Директор:
                    </td>
                </tr>
            </table>
            <br/>
            <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
                <tr style="border: 1px solid white;  border-collapse: collapse;">
                    <td  style="font-size: 10px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                        М П
                    </td>
                </tr>
            </table>
            <br/>
            <table style="border: 1px solid white;  border-collapse: collapse; width: 100%;">
                <tr style="text-align: center; border: 1px solid white;  border-collapse: collapse;">
                    <td  style="text-align: center; font-size: 14px; font-weight: bold; border: 1px solid white;  border-collapse: collapse;">
                        Увага!!! Нові реквізити!!!
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
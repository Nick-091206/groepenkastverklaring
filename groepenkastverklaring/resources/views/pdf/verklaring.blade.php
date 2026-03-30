<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            background: #fff;
            margin: 1.8cm;
        }

        .header {
            width: 100%;
            display: table;
            margin-bottom: 3mm;
        }
        .header-left {
            display: table-cell;
            vertical-align: top;
            text-align: left;
        }
        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: top;
            width: 85mm;
        }
        .header-title {
            font-size: 26pt;
            font-weight: normal;
            letter-spacing: 0.5px;
            line-height: 1;
        }
        .header-address {
            font-size: 8pt;
            color: #444;
            margin-top: 2mm;
            line-height: 1.5;
        }
        .logo {
            max-height: 48mm;
            max-width: 83mm;
        }

        .hr {
            border: none;
            border-top: 2.5pt solid #1a1a1a;
            margin-bottom: 4mm;
        }

        table.groepen {
            width: 100%;
            border-collapse: collapse;
        }

        table.groepen thead {
            display: table-header-group;
        }

        table.groepen th {
            padding: 3px 6px;
            font-size: 8.5pt;
            font-weight: bold;
            border-bottom: 1pt solid #1a1a1a;
            text-align: left;
        }
        table.groepen th.col-groep,
        table.groepen td.col-groep {
            width: 28mm;
        }
        table.groepen td {
            padding: 1px 6px;
            font-size: 8.5pt;
            font-weight: bold;
            height: 7mm;
            vertical-align: middle;
        }
        tr.row-even { background-color: #dce9dc; }
        tr.row-odd  { background-color: #ffffff; }

        .footer {
            display: table;
            width: 100%;
            margin-top: 4mm;
            page-break-inside: avoid;
        }
        .footer-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 4mm;
        }
        .footer-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .warning-row {
            display: table;
            width: 100%;
        }
        .warning-icon {
            display: table-cell;
            width: 6mm;
            font-size: 11pt;
            vertical-align: top;
        }
        .warning-text {
            display: table-cell;
            font-size: 6.5pt;
            line-height: 1.55;
            vertical-align: top;
            color: #222;
        }
        .box {
            border: 1pt solid #555;
            padding: 2.5mm;
            margin-bottom: 3mm;
            min-height: 18mm;
        }
        .box-title {
            font-size: 7.5pt;
            font-weight: bold;
            margin-bottom: 2mm;
        }
        .box-lines .line {
            border-bottom: 0.5pt dotted #888;
            height: 7mm;
            margin-bottom: 1mm;
        }
    </style>
</head>
<body>

    <table class="groepen">
        <thead>
            <tr>
                <td colspan="2" style="border: none; padding: 0; background: #fff;">
                    <div class="header">
                        <div class="header-left">
                            <div class="header-title">Groepenindeling</div>
                            <div class="header-address">
                                <strong>{{ $naam }}</strong> &nbsp;&bull;&nbsp; {{ $adres }}, {{ $postcode }} {{ $stad }} &nbsp;&bull;&nbsp; {{ $datum }}
                            </div>
                        </div>
                        <div class="header-right">
                            @if (file_exists(public_path('images/logo.png')))
                                <img src="{{ public_path('images/logo.png') }}" class="logo" alt="logo">
                            @elseif (file_exists(public_path('images/logo.jpg')))
                                <img src="{{ public_path('images/logo.jpg') }}" class="logo" alt="logo">
                            @endif
                        </div>
                    </div>
                    <hr class="hr">
                </td>
            </tr>
            <tr>
                <th class="col-groep">Groep</th>
                <th>Omschrijving</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groepen as $nr => $omschrijving)
                <tr class="{{ $nr % 2 === 0 ? 'row-even' : 'row-odd' }}">
                    <td class="col-groep">{{ $nr }}</td>
                    <td>{{ $omschrijving }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr class="hr" style="margin-top: 0;">

    <div class="footer">
        <div class="footer-left">
            <div class="warning-row">
                <div class="warning-icon">&#9888;</div>
                <div class="warning-text">
                    <strong>Waarschuwing!</strong> Installatie laten uitvoeren door een erkend elektrotechnische installateur.<br>
                    <strong>Warning!</strong> Installation by person with electro technical expertise only.<br>
                    <strong>Warnung!</strong> Installation nur durch elektrotechnische Fachkraft.<br>
                    <strong>Avvertenza!</strong> Fare installare solo da un electricista qualificato.<br>
                    <strong>Avertissement!</strong> Installation uniquement par des personnes qualifi&eacute;es en &eacute;lectrotechnique.<br>
                    <strong>Advertencia!</strong> La instalaci&oacute;n deber&aacute; ser realizada &uacute;nicamente por electricistas especializados.
                </div>
            </div>
        </div>
        <div class="footer-right">
            <div class="box">
                <div class="box-title">De installateur van deze installatie:</div>
                @if($installateur)
                    <div style="font-size: 10pt; padding: 2mm 0;">
                        {{ $installateur }}
                        @if($installateur_telefoon)
                            <br>Tel: {{ $installateur_telefoon }}
                        @endif
                    </div>
                @else
                    <div class="box-lines">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                @endif
            </div>
            <div class="box">
                <div class="box-title">Netbeheerdernederland.nl<br>(storingsnummer)</div>
                <div style="font-size: 14pt; font-weight: bold; padding: 2mm 0;">0800-9009</div>
            </div>
        </div>
    </div>

</body>
</html>
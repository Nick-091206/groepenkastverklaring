<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #000;
        }

        .page {
            padding: 20mm 15mm;
        }

        /* Header */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 6mm;
        }
        .header-left {
            display: table-cell;
            vertical-align: bottom;
        }
        .header-right {
            display: table-cell;
            text-align: right;
            vertical-align: bottom;
        }
        .title {
            font-size: 22pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .address-block {
            font-size: 9pt;
            color: #333;
            margin-top: 2mm;
            line-height: 1.4;
        }

        /* Table */
        table.groepen {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8mm;
        }
        table.groepen th {
            background-color: #2c2c2c;
            color: #fff;
            padding: 4px 8px;
            text-align: left;
            font-size: 9.5pt;
        }
        table.groepen th.center {
            text-align: center;
        }
        table.groepen td {
            padding: 4px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9.5pt;
            height: 18px;
        }
        table.groepen td.nr {
            text-align: center;
            font-weight: bold;
            width: 40px;
        }
        tr.even { background-color: #f0f0f0; }
        tr.odd  { background-color: #ffffff; }

        /* Footer section */
        .footer-warning {
            font-size: 7.5pt;
            color: #444;
            border: 1px solid #aaa;
            padding: 4mm;
            margin-bottom: 5mm;
            line-height: 1.5;
        }
        .footer-warning p { margin-bottom: 2mm; }
        .footer-warning p:last-child { margin-bottom: 0; }

        .footer-boxes {
            display: table;
            width: 100%;
        }
        .footer-box {
            display: table-cell;
            width: 50%;
            border: 1px solid #aaa;
            padding: 3mm;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .footer-box:first-child {
            border-right: none;
        }
        .footer-box-title {
            font-weight: bold;
            font-size: 8.5pt;
            margin-bottom: 2mm;
            border-bottom: 1px solid #ccc;
            padding-bottom: 1mm;
        }
        .footer-box-line {
            height: 8mm;
            border-bottom: 1px dotted #aaa;
            margin-bottom: 2mm;
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="title">Groepenindeling</div>
            <div class="address-block">
                <strong>{{ $naam }}</strong><br>
                {{ $adres }}<br>
                {{ $postcode }} {{ $stad }}
            </div>
        </div>
    </div>

    <!-- Groepen tabel -->
    <table class="groepen">
        <thead>
            <tr>
                <th class="center" style="width:40px;">Groep</th>
                <th>Omschrijving</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groepen as $nr => $omschrijving)
                <tr class="{{ $nr % 2 === 0 ? 'even' : 'odd' }}">
                    <td class="nr">{{ $nr }}</td>
                    <td>{{ $omschrijving }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Waarschuwing -->
    <div class="footer-warning">
        <p><strong>NL</strong> &mdash; Werkzaamheden aan de elektrische installatie mogen uitsluitend worden uitgevoerd door een erkend installateur.</p>
        <p><strong>FR</strong> &mdash; Les travaux sur l&rsquo;installation &eacute;lectrique ne peuvent &ecirc;tre effectu&eacute;s que par un installateur agr&eacute;&eacute;.</p>
        <p><strong>DE</strong> &mdash; Arbeiten an der elektrischen Anlage d&uuml;rfen nur von einem zugelassenen Installateur durchgef&uuml;hrt werden.</p>
        <p><strong>EN</strong> &mdash; Work on the electrical installation may only be carried out by a certified installer.</p>
    </div>

    <!-- Installer + netbeheerder boxes -->
    <div class="footer-boxes">
        <div class="footer-box">
            <div class="footer-box-title">De installateur van deze installatie:</div>
            <div class="footer-box-line"></div>
            <div class="footer-box-line"></div>
            <div class="footer-box-line"></div>
        </div>
        <div class="footer-box">
            <div class="footer-box-title">Telefoonnummer netbeheerder:</div>
            <div class="footer-box-line"></div>
            <div class="footer-box-line"></div>
        </div>
    </div>

</div>
</body>
</html>

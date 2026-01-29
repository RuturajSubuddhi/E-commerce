<!DOCTYPE html>
<html>
<head>
    <title>Barcode Print</title>
    <style>
        body { font-family: Arial; }
        table { width: 100%; }
        .tdst {
            width: 25%;
            padding: 8px;
            border: 1px dashed #000;
            text-align: center;
        }
        .productname {
            font-size: 11px;
            font-weight: bold;
            display: block;
        }
        @media print {
            button { display: none; }
        }
    </style>
</head>

<body onload="window.print()">

@php
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
@endphp

<table style="width:100%">
    <tbody>
    @for($i = 0; $i < $qty; $i++)
        @if($i % 4 == 0)
            <tr>
        @endif

        <td class="tdst" align="center">
            <div class="productname">{{ $product->name }}</div>

            {{-- Barcode --}}
            {!! $generator->getBarcode($product->code, $generator::TYPE_CODE_128) !!}

            {{-- Barcode Number --}}
            <div style="font-size:11px; letter-spacing:2px; margin-top:2px;">
                {{ $product->code }}
            </div>

            <div class="productname">
                ₹ {{ $product->current_sale_price }}
            </div>
        </td>

        @if($i % 4 == 3)
            </tr>
        @endif
    @endfor
    </tbody>
</table>
 

</body>
</html>

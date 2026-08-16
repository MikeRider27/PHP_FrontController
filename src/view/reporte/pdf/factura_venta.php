<?php

use App\Core\NumeroALetras;

$total = (float) $venta['total'];
$totalEnLetras = NumeroALetras::convertir((int) round($total));
$anulada = $venta['venta_estado'] === 'ANULADA';

// Los precios cargados ya incluyen el IVA (regimen paraguayo), por eso el impuesto
// se retro-calcula a partir del valor de venta: IVA 10% = base / 11, IVA 5% = base / 21.
$totalExenta = 0.0;
$total5 = 0.0;
$total10 = 0.0;
foreach ($venta['detalle'] as $d) {
    $tasa = (int) $d['detalle_venta_iva_tasa'];
    $subtotal = (float) $d['subtotal'];
    if ($tasa === 5) {
        $total5 += $subtotal;
    } elseif ($tasa === 10) {
        $total10 += $subtotal;
    } else {
        $totalExenta += $subtotal;
    }
}
$iva5 = $total5 / 21;
$iva10 = $total10 / 11;
$totalIva = $iva5 + $iva10;

// Datos del emisor: placeholders hasta que se configure la integración con la SET.
$empresaNombre = 'SISTEMA ZEUS';
$empresaRuc = '-';
$empresaTimbrado = '-';
$empresaValidoHasta = '-';

$codigoVerificacion = strtoupper(substr(hash('sha256', $venta['venta_id'] . $venta['venta_numero'] . $venta['venta_fecha']), 0, 24));
$fechaEmision = date('d/m/Y H:i', strtotime($venta['venta_fecha']));
$fechaAnulacion = $venta['venta_fecha_anulacion'] ? date('d/m/Y H:i', strtotime($venta['venta_fecha_anulacion'])) : null;
?>
<html>
<head>
<meta charset="utf-8">
<style>
    * { box-sizing: border-box; }
    body { font-family: Helvetica, Arial, sans-serif; font-size: 9.5px; color: #000; }

    .marco { width: 100%; border: 1.5px solid #000; border-collapse: collapse; }
    .marco > tbody > tr > td { vertical-align: top; padding: 0; }

    /* Encabezado: emisor (izq) + timbrado/número de comprobante (der) */
    .celda-emisor { width: 62%; border-right: 1.5px solid #000; padding: 10px !important; text-align: center; }
    .logo { width: 34px; height: 34px; line-height: 34px; border-radius: 50%; background-color: #367fa9; color: #fff; font-weight: bold; font-size: 15px; text-align: center; display: inline-block; }
    .emisor-nombre { font-size: 13px; font-weight: bold; letter-spacing: 0.5px; margin-top: 4px; }
    .emisor-linea { font-size: 8.5px; color: #555; margin-top: 2px; }

    .celda-doc { width: 38%; padding: 10px !important; }
    .doc-fiscal { text-align: right; font-size: 8px; color: #555; line-height: 1.6; }
    .doc-fiscal strong { color: #000; }
    .doc-tipo { text-align: center; font-size: 13px; font-weight: bold; margin-top: 10px; }
    .doc-numero { text-align: center; font-size: 15px; font-weight: bold; letter-spacing: 1px; border: 1px solid #000; padding: 4px; margin-top: 4px; }
    .estado-marca { display: block; text-align: center; margin-top: 8px; padding: 2px 0; border: 1px solid #000; font-size: 9px; font-weight: bold; }
    .estado-anulada { border-color: #a94442; color: #a94442; }

    /* Grilla de datos de la venta / cliente */
    table.grilla { width: 100%; border-collapse: collapse; border: 1.5px solid #000; border-top: none; }
    table.grilla td { border-top: 1px solid #999; padding: 3px 8px; }
    table.grilla td.c1 { width: 20%; color: #555; white-space: nowrap; }
    table.grilla td.v1 { width: 30%; font-weight: bold; border-right: 1px solid #999; }
    table.grilla td.c2 { width: 20%; color: #555; white-space: nowrap; }
    table.grilla td.v2 { width: 30%; font-weight: bold; }

    /* Tabla de items + totales, un único bloque */
    table.items { width: 100%; border-collapse: collapse; border: 1.5px solid #000; border-top: none; }
    table.items th { background-color: #eaeaea; border: 1px solid #000; padding: 5px 6px; font-size: 8.5px; text-transform: uppercase; }
    table.items td { border: 1px solid #999; padding: 4px 6px; font-size: 9px; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }

    table.resumen { width: 100%; border-collapse: collapse; border: 1.5px solid #000; border-top: none; }
    table.resumen td { padding: 4px 8px; font-size: 9.5px; border-top: 1px solid #999; }
    table.resumen tr.total td { font-size: 12px; font-weight: bold; background-color: #eaeaea; }
    table.resumen td.label { color: #333; }
    table.resumen td.letras { font-style: italic; }

    /* Pie de verificación */
    table.verificacion { width: 100%; border-collapse: collapse; border: 1.5px solid #000; border-top: none; }
    table.verificacion td { padding: 8px; vertical-align: middle; }
    .sello { width: 50px; height: 50px; border: 1.5px solid #000; text-align: center; vertical-align: middle; font-size: 8px; font-weight: bold; color: #555; }
    .verif-texto { font-size: 8px; color: #333; padding-left: 10px !important; }
    .verif-texto .codigo { font-family: "Courier New", monospace; font-size: 9px; font-weight: bold; letter-spacing: 0.5px; margin: 2px 0; }
    .verif-texto .aviso { font-weight: bold; margin-top: 3px; }

    .anulacion { margin-top: 8px; padding: 6px 8px; border: 1px solid #a94442; background-color: #f2dede; color: #a94442; font-size: 9px; }

    .pie { margin-top: 6px; font-size: 8px; color: #777; text-align: center; }
</style>
</head>
<body>

    <table class="marco">
        <tbody>
        <tr>
            <td class="celda-emisor">
                <span class="logo">Z</span>
                <div class="emisor-nombre"><?=htmlspecialchars($empresaNombre)?></div>
                <div class="emisor-linea">Gestión de Inventario y Ventas</div>
            </td>
            <td class="celda-doc">
                <div class="doc-fiscal">
                    RUC: <strong><?=htmlspecialchars($empresaRuc)?></strong><br>
                    Timbrado N.º: <strong><?=htmlspecialchars($empresaTimbrado)?></strong><br>
                    Válido hasta: <strong><?=htmlspecialchars($empresaValidoHasta)?></strong>
                </div>
                <div class="doc-tipo">Comprobante de Venta</div>
                <div class="doc-numero"><?=htmlspecialchars($venta['venta_numero'])?></div>
                <?php if ($anulada): ?>
                <span class="estado-marca estado-anulada">ANULADA</span>
                <?php else: ?>
                <span class="estado-marca">CONFIRMADA</span>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="grilla">
        <tr>
            <td class="c1">Fecha de emisión:</td>
            <td class="v1"><?=htmlspecialchars($fechaEmision)?></td>
            <td class="c2">Forma de pago:</td>
            <td class="v2"><?=htmlspecialchars($venta['venta_forma_pago'])?></td>
        </tr>
        <tr>
            <td class="c1">Nombre o razón:</td>
            <td class="v1"><?=htmlspecialchars($venta['cliente_razon_social'])?></td>
            <td class="c2">Vendedor:</td>
            <td class="v2"><?=htmlspecialchars($venta['usuario_nick'])?></td>
        </tr>
        <tr>
            <td class="c1">Dirección:</td>
            <td class="v1"><?=htmlspecialchars($venta['cliente_direccion'] ?: '-')?></td>
            <td class="c2">Teléfono:</td>
            <td class="v2"><?=htmlspecialchars($venta['cliente_telefono'] ?: '-')?></td>
        </tr>
        <tr>
            <td class="c1">Ruc / Documento:</td>
            <td class="v1"><?=htmlspecialchars($venta['cliente_documento'] ?: '-')?></td>
            <td class="c2">N.º Venta:</td>
            <td class="v2"><?=htmlspecialchars($venta['venta_id'])?></td>
        </tr>
    </table>

    <table class="items">
        <tr>
            <th rowspan="2">Código</th>
            <th rowspan="2">Descripción</th>
            <th rowspan="2" class="text-right">Cantidad</th>
            <th rowspan="2" class="text-right">Precio Unit.</th>
            <th colspan="3">Valor de Venta</th>
        </tr>
        <tr>
            <th class="text-right">Exenta</th>
            <th class="text-right">5%</th>
            <th class="text-right">10%</th>
        </tr>
        <?php foreach ($venta['detalle'] as $d): $tasa = (int) $d['detalle_venta_iva_tasa']; ?>
        <tr>
            <td><?=htmlspecialchars($d['producto_codigo'])?></td>
            <td><?=htmlspecialchars($d['producto_nombre'])?></td>
            <td class="text-right"><?=$d['detalle_venta_cantidad']?></td>
            <td class="text-right"><?=number_format((float)$d['detalle_venta_precio_unitario'], 0, ',', '.')?></td>
            <td class="text-right"><?=$tasa === 0 ? number_format((float)$d['subtotal'], 0, ',', '.') : '0'?></td>
            <td class="text-right"><?=$tasa === 5 ? number_format((float)$d['subtotal'], 0, ',', '.') : '0'?></td>
            <td class="text-right"><?=$tasa === 10 ? number_format((float)$d['subtotal'], 0, ',', '.') : '0'?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="text-right"><strong>Sub Total</strong></td>
            <td class="text-right"><?=number_format($totalExenta, 0, ',', '.')?></td>
            <td class="text-right"><?=number_format($total5, 0, ',', '.')?></td>
            <td class="text-right"><?=number_format($total10, 0, ',', '.')?></td>
        </tr>
    </table>

    <table class="resumen">
        <tr>
            <td class="label" style="width:55%;">Liquidación del IVA — 5%: <?=number_format($iva5, 0, ',', '.')?> &nbsp;&nbsp; 10%: <?=number_format($iva10, 0, ',', '.')?></td>
            <td class="text-right" style="width:45%;">Total IVA: <?=number_format($totalIva, 0, ',', '.')?></td>
        </tr>
        <tr class="total">
            <td class="letras">Total a Pagar en Gs.<br><?=htmlspecialchars($totalEnLetras)?></td>
            <td class="text-right"><?=number_format($total, 0, ',', '.')?></td>
        </tr>
    </table>

    <table class="verificacion">
        <tr>
            <td class="sello" width="60">COD.</td>
            <td class="verif-texto">
                Código interno de verificación:
                <div class="codigo"><?=htmlspecialchars($codigoVerificacion)?></div>
                <div class="aviso">ESTE DOCUMENTO ES UNA REPRESENTACIÓN GRÁFICA DE UN COMPROBANTE DE VENTA INTERNO.</div>
                Este comprobante no constituye un Documento Tributario Electrónico validado por la SET. La integración con la SET se implementará más adelante.
            </td>
        </tr>
    </table>

    <?php if ($anulada): ?>
    <div class="anulacion">
        <strong>VENTA ANULADA</strong> el <?=htmlspecialchars($fechaAnulacion)?> — Motivo: <?=htmlspecialchars($venta['venta_motivo_anulacion'])?>
    </div>
    <?php endif; ?>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?> — Sistema ZEUS</div>

</body>
</html>

<?php

use App\Core\NumeroALetras;

$total = (float) $venta['total'];
$totalEnLetras = NumeroALetras::convertir((int) round($total));
$condicionVenta = $venta['venta_forma_pago'] === 'EFECTIVO' ? 'CONTADO' : 'CONTADO - TARJETA';
?>
<html>
<head>
<meta charset="utf-8">
<style>
    * { box-sizing: border-box; }
    body { font-family: Helvetica, Arial, sans-serif; font-size: 10px; color: #000; }

    .marco { width: 100%; border: 1.5px solid #000; border-collapse: collapse; margin-bottom: 0; }
    .marco > tbody > tr > td { vertical-align: top; padding: 0; }

    .celda-emisor { width: 55%; border-right: 1.5px solid #000; padding: 10px !important; }
    .emisor-nombre { font-size: 15px; font-weight: bold; letter-spacing: 0.5px; }
    .emisor-linea { font-size: 9px; margin-top: 3px; color: #222; }
    .emisor-actividad { font-size: 9px; margin-top: 6px; color: #555; }

    .celda-doc { width: 45%; padding: 10px !important; text-align: center; }
    .doc-tipo { font-size: 12px; font-weight: bold; border: 1px solid #000; padding: 3px; display: block; }
    .doc-numero { font-size: 15px; font-weight: bold; margin: 6px 0; letter-spacing: 1px; }
    table.doc-meta { width: 100%; border-collapse: collapse; margin-top: 4px; }
    table.doc-meta td { border: 1px solid #999; padding: 3px 5px; font-size: 9px; text-align: left; }
    table.doc-meta td.etiqueta { width: 55%; color: #555; }
    table.doc-meta td.valor { font-weight: bold; text-align: right; }

    .estado-marca { display: inline-block; margin-top: 6px; padding: 2px 10px; border: 1px solid #000; font-size: 9px; font-weight: bold; }
    .estado-anulada { border-color: #a94442; color: #a94442; }

    .marco-cliente { width: 100%; border: 1.5px solid #000; border-top: none; border-collapse: collapse; }
    .marco-cliente td { border-top: 1px solid #999; padding: 4px 8px; font-size: 9.5px; }
    .marco-cliente td.etiqueta { width: 18%; color: #555; text-transform: uppercase; font-size: 8px; padding-bottom: 0; }
    .marco-cliente tr.datos td { padding-top: 0; font-weight: bold; }

    table.items { width: 100%; border-collapse: collapse; border: 1.5px solid #000; border-top: none; margin-top: 0; }
    table.items th { background-color: #eaeaea; border: 1px solid #000; padding: 5px 6px; font-size: 9px; text-transform: uppercase; }
    table.items td { border: 1px solid #999; padding: 5px 6px; font-size: 9.5px; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .pie-totales { width: 100%; border: 1.5px solid #000; border-top: none; border-collapse: collapse; }
    .celda-letras { width: 65%; border-right: 1.5px solid #000; padding: 8px !important; vertical-align: middle !important; }
    .celda-letras .etiqueta { font-size: 8px; color: #555; text-transform: uppercase; }
    .celda-letras .valor { font-size: 10px; font-weight: bold; margin-top: 3px; }
    .celda-total { width: 35%; padding: 0 !important; }
    .celda-total table { width: 100%; border-collapse: collapse; }
    .celda-total td { padding: 5px 8px; font-size: 10px; border-top: 1px solid #999; }
    .celda-total tr:first-child td { border-top: none; }
    .celda-total .fila-total td { font-size: 13px; font-weight: bold; background-color: #eaeaea; }

    .anulacion { margin-top: 10px; padding: 8px; border: 1px solid #a94442; background-color: #f2dede; color: #a94442; font-size: 9.5px; }

    .pie { margin-top: 14px; font-size: 8px; color: #777; text-align: center; border-top: 1px dashed #ccc; padding-top: 6px; }
    .pie .aviso { font-weight: bold; color: #555; }
</style>
</head>
<body>

    <table class="marco">
        <tbody>
        <tr>
            <td class="celda-emisor">
                <div class="emisor-nombre">SISTEMA ZEUS</div>
                <div class="emisor-linea">Gestión de Inventario y Ventas</div>
                <div class="emisor-actividad">Comprobante interno de venta</div>
            </td>
            <td class="celda-doc">
                <span class="doc-tipo">COMPROBANTE DE VENTA</span>
                <div class="doc-numero"><?=htmlspecialchars($venta['venta_numero'])?></div>
                <table class="doc-meta">
                    <tr><td class="etiqueta">Fecha de Emisión</td><td class="valor"><?=htmlspecialchars($venta['venta_fecha'])?></td></tr>
                    <tr><td class="etiqueta">Condición de Venta</td><td class="valor"><?=htmlspecialchars($condicionVenta)?></td></tr>
                    <tr><td class="etiqueta">Vendedor</td><td class="valor"><?=htmlspecialchars($venta['usuario_nick'])?></td></tr>
                </table>
                <?php if ($venta['venta_estado'] === 'ANULADA'): ?>
                <span class="estado-marca estado-anulada">ANULADA</span>
                <?php else: ?>
                <span class="estado-marca">CONFIRMADA</span>
                <?php endif; ?>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="marco-cliente">
        <tr>
            <td class="etiqueta">Nombre o Razón Social</td>
            <td class="etiqueta">RUC / Nº Documento</td>
            <td class="etiqueta">Teléfono</td>
        </tr>
        <tr class="datos">
            <td><?=htmlspecialchars($venta['cliente_razon_social'])?></td>
            <td><?=htmlspecialchars($venta['cliente_documento'] ?: '-')?></td>
            <td><?=htmlspecialchars($venta['cliente_telefono'] ?: '-')?></td>
        </tr>
        <tr>
            <td class="etiqueta" colspan="3">Dirección</td>
        </tr>
        <tr class="datos">
            <td colspan="3"><?=htmlspecialchars($venta['cliente_direccion'] ?: '-')?></td>
        </tr>
    </table>

    <table class="items">
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th class="text-right">Cantidad</th>
            <th class="text-right">Precio Unit.</th>
            <th class="text-right">Total</th>
        </tr>
        <?php foreach ($venta['detalle'] as $d): ?>
        <tr>
            <td><?=htmlspecialchars($d['producto_codigo'])?></td>
            <td><?=htmlspecialchars($d['producto_nombre'])?></td>
            <td class="text-right"><?=$d['detalle_venta_cantidad']?></td>
            <td class="text-right"><?=number_format((float)$d['detalle_venta_precio_unitario'], 0, ',', '.')?></td>
            <td class="text-right"><?=number_format((float)$d['subtotal'], 0, ',', '.')?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <table class="pie-totales">
        <tr>
            <td class="celda-letras">
                <div class="etiqueta">Son Guaraníes</div>
                <div class="valor"><?=htmlspecialchars($totalEnLetras)?></div>
            </td>
            <td class="celda-total">
                <table>
                    <tr><td>Subtotal</td><td class="text-right"><?=number_format($total, 0, ',', '.')?></td></tr>
                    <tr class="fila-total"><td>Total a Pagar</td><td class="text-right"><?=number_format($total, 0, ',', '.')?> Gs.</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <?php if ($venta['venta_estado'] === 'ANULADA'): ?>
    <div class="anulacion">
        <strong>VENTA ANULADA</strong> el <?=htmlspecialchars($venta['venta_fecha_anulacion'])?> — Motivo: <?=htmlspecialchars($venta['venta_motivo_anulacion'])?>
    </div>
    <?php endif; ?>

    <div class="pie">
        <div class="aviso">Este comprobante es de uso interno y no constituye un Documento Tributario Electrónico válido ante la SET.</div>
        <div>Generado el <?=date('d/m/Y H:i')?> — Sistema ZEUS</div>
    </div>

</body>
</html>

<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Valor de Inventario</h1>
        <div class="subtitulo">Capital inmovilizado en stock, a precio de costo y de venta</div>
    </div>

    <div class="totales">
        Valor total a costo: <strong><?=number_format((float)$totalCosto, 0, ',', '.')?> Gs.</strong>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Valor total a venta: <strong><?=number_format((float)$totalVenta, 0, ',', '.')?> Gs.</strong>
    </div>

    <table>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th class="text-center">Stock</th>
            <th class="text-right">Costo Unit.</th>
            <th class="text-right">Venta Unit.</th>
            <th class="text-right">Valor Costo</th>
            <th class="text-right">Valor Venta</th>
        </tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?=htmlspecialchars($p['producto_codigo'])?></td>
            <td><?=htmlspecialchars($p['producto_nombre'])?></td>
            <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
            <td class="text-center"><?=$p['producto_stock_actual']?></td>
            <td class="text-right"><?=number_format((float)$p['producto_precio_costo'], 0, ',', '.')?></td>
            <td class="text-right"><?=number_format((float)$p['producto_precio_venta'], 0, ',', '.')?></td>
            <td class="text-right"><?=number_format((float)$p['valor_costo'], 0, ',', '.')?></td>
            <td class="text-right"><?=number_format((float)$p['valor_venta'], 0, ',', '.')?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($productos)): ?>
        <tr><td colspan="8" class="text-center">Sin productos</td></tr>
        <?php endif; ?>
    </table>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?></div>
</body>
</html>

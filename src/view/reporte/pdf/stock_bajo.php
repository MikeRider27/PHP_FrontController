<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Reporte de Stock Bajo</h1>
        <div class="subtitulo">Productos que llegaron o están por debajo del stock mínimo</div>
    </div>

    <table>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Categoría</th>
            <th class="text-right">Stock Actual</th>
            <th class="text-right">Stock Mínimo</th>
        </tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?=htmlspecialchars($p['producto_codigo'])?></td>
            <td><?=htmlspecialchars($p['producto_nombre'])?></td>
            <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
            <td class="text-right"><?=$p['producto_stock_actual']?></td>
            <td class="text-right"><?=$p['producto_stock_minimo']?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($productos)): ?>
        <tr><td colspan="5" class="text-center">No hay productos con stock bajo</td></tr>
        <?php endif; ?>
    </table>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?> — <?=count($productos)?> producto(s)</div>
</body>
</html>

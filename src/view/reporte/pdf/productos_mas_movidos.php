<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Productos más Movidos</h1>
        <div class="subtitulo">Rango: <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?></div>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Producto</th>
            <th class="text-right">Cantidad Movida</th>
            <th class="text-right">Cantidad de Movimientos</th>
        </tr>
        <?php $pos = 1; foreach ($productos as $p): ?>
        <tr>
            <td><?=$pos++?></td>
            <td><?=htmlspecialchars($p['producto_codigo'])?></td>
            <td><?=htmlspecialchars($p['producto_nombre'])?></td>
            <td class="text-right"><?=$p['total_movido']?></td>
            <td class="text-right"><?=$p['cantidad_movimientos']?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($productos)): ?>
        <tr><td colspan="5" class="text-center">Sin movimientos en el rango seleccionado</td></tr>
        <?php endif; ?>
    </table>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?></div>
</body>
</html>

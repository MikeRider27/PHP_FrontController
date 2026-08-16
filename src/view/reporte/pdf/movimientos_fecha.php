<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Movimientos por Fecha</h1>
        <div class="subtitulo">
            Rango: <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?>
            <?php if (!empty($tipo)): ?> — Tipo: <?=htmlspecialchars($tipo)?><?php endif; ?>
        </div>
    </div>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Producto</th>
            <th class="text-center">Tipo</th>
            <th class="text-right">Cantidad</th>
            <th class="text-right">Stock Ant.</th>
            <th class="text-right">Stock Nuevo</th>
            <th>Motivo</th>
            <th>Usuario</th>
        </tr>
        <?php foreach ($movimientos as $m): ?>
        <tr>
            <td><?=htmlspecialchars($m['movimiento_fecha'])?></td>
            <td><?=htmlspecialchars($m['producto_nombre'])?></td>
            <td class="text-center"><?=htmlspecialchars($m['movimiento_tipo'])?></td>
            <td class="text-right"><?=$m['movimiento_cantidad']?></td>
            <td class="text-right"><?=$m['movimiento_stock_anterior']?></td>
            <td class="text-right"><?=$m['movimiento_stock_nuevo']?></td>
            <td><?=htmlspecialchars($m['movimiento_motivo'] ?? '')?></td>
            <td><?=htmlspecialchars($m['usuario_nick'])?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($movimientos)): ?>
        <tr><td colspan="8" class="text-center">Sin movimientos en el rango seleccionado</td></tr>
        <?php endif; ?>
    </table>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?> — <?=count($movimientos)?> movimiento(s)</div>
</body>
</html>

<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Ventas por Período</h1>
        <div class="subtitulo">Rango: <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?></div>
    </div>

    <table>
        <tr>
            <th>Número</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Forma de Pago</th>
            <th class="text-center">Estado</th>
            <th class="text-right">Total</th>
            <th>Vendida por</th>
        </tr>
        <?php foreach ($ventas as $v): ?>
        <tr>
            <td><?=htmlspecialchars($v['venta_numero'])?></td>
            <td><?=htmlspecialchars($v['cliente_razon_social'])?></td>
            <td><?=htmlspecialchars($v['venta_fecha'])?></td>
            <td><?=htmlspecialchars($v['venta_forma_pago'])?></td>
            <td class="text-center"><?=htmlspecialchars($v['venta_estado'])?></td>
            <td class="text-right"><?=number_format((float)$v['total'], 0, ',', '.')?></td>
            <td><?=htmlspecialchars($v['usuario_nick'])?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ventas)): ?>
        <tr><td colspan="7" class="text-center">Sin ventas en el rango seleccionado</td></tr>
        <?php endif; ?>
    </table>

    <?php
    $totalPeriodo = array_sum(array_column(array_filter($ventas, fn($v) => $v['venta_estado'] === 'CONFIRMADA'), 'total'));
    ?>
    <div class="totales">
        Total ventas confirmadas: <strong><?=number_format((float)$totalPeriodo, 0, ',', '.')?> Gs.</strong>
    </div>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?> — <?=count($ventas)?> venta(s)</div>
</body>
</html>

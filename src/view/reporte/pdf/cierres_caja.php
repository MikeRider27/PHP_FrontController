<html>
<head>
<meta charset="utf-8">
<?php require BASE_PATH . '/view/reporte/pdf/_estilos.php'; ?>
</head>
<body>
    <div class="encabezado">
        <div class="marca">Sistema ZEUS</div>
        <h1>Historial de Cierres de Caja</h1>
        <div class="subtitulo">Turnos abiertos y cerrados</div>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th class="text-center">Estado</th>
            <th>Apertura</th>
            <th>Cierre</th>
            <th class="text-right">Monto Inicial</th>
            <th class="text-right">Monto Declarado</th>
            <th class="text-right">Diferencia</th>
        </tr>
        <?php foreach ($turnos as $t): ?>
        <tr>
            <td>#<?=$t['turno_id']?></td>
            <td class="text-center"><?=htmlspecialchars($t['turno_estado'])?></td>
            <td><?=htmlspecialchars($t['turno_fecha_apertura'])?> (<?=htmlspecialchars($t['usuario_apertura_nick'])?>)</td>
            <td><?=$t['turno_fecha_cierre'] ? htmlspecialchars($t['turno_fecha_cierre']) . ' (' . htmlspecialchars($t['usuario_cierre_nick']) . ')' : '-'?></td>
            <td class="text-right"><?=number_format((float)$t['turno_monto_inicial'], 0, ',', '.')?></td>
            <td class="text-right"><?=$t['turno_monto_declarado'] !== null ? number_format((float)$t['turno_monto_declarado'], 0, ',', '.') : '-'?></td>
            <td class="text-right"><?=$t['turno_diferencia'] !== null ? number_format((float)$t['turno_diferencia'], 0, ',', '.') : '-'?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($turnos)): ?>
        <tr><td colspan="7" class="text-center">Sin turnos registrados</td></tr>
        <?php endif; ?>
    </table>

    <div class="pie">Generado el <?=date('d/m/Y H:i')?></div>
</body>
</html>

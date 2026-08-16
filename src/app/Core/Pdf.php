<?php

namespace App\Core;

use Dompdf\Dompdf;

class Pdf
{
    public static function render(string $vista, array $datos, string $archivo, string $orientacion = 'portrait'): void
    {
        extract($datos);
        ob_start();
        require BASE_PATH . '/view/reporte/pdf/' . $vista . '.php';
        $html = ob_get_clean();

        $dompdf = new Dompdf(['isRemoteEnabled' => false, 'defaultFont' => 'Helvetica']);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientacion);
        $dompdf->render();
        $dompdf->stream($archivo, ['Attachment' => false]);
        exit;
    }
}

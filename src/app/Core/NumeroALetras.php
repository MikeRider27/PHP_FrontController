<?php

namespace App\Core;

class NumeroALetras
{
    private const UNIDADES = ['', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    private const DIEZ_A_DIECINUEVE = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
    private const DECENAS = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    private const CENTENAS = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

    public static function convertir(int $numero): string
    {
        if ($numero === 0) {
            return 'CERO';
        }

        $negativo = $numero < 0;
        $numero = abs($numero);
        $texto = self::convertirGrupo($numero);

        return trim(($negativo ? 'MENOS ' : '') . $texto);
    }

    private static function convertirGrupo(int $numero): string
    {
        if ($numero < 1000000000000) {
            $millardos = intdiv($numero, 1000000000);
            $resto = $numero % 1000000000;
            $texto = '';
            if ($millardos > 0) {
                $texto .= ($millardos === 1 ? 'MIL MILLONES' : self::convertirMenorAMillon($millardos) . ' MIL MILLONES') . ' ';
            }
            if ($resto > 0) {
                $texto .= self::convertirMenorAMilMillones($resto);
            }
            return trim($texto);
        }

        return (string) $numero;
    }

    private static function convertirMenorAMilMillones(int $numero): string
    {
        $millones = intdiv($numero, 1000000);
        $resto = $numero % 1000000;
        $texto = '';

        if ($millones > 0) {
            $texto .= ($millones === 1 ? 'UN MILLON' : self::convertirMenorAMillon($millones) . ' MILLONES') . ' ';
        }

        if ($resto > 0) {
            $texto .= self::convertirMenorAMillon($resto);
        }

        return trim($texto);
    }

    private static function convertirMenorAMillon(int $numero): string
    {
        $miles = intdiv($numero, 1000);
        $resto = $numero % 1000;
        $texto = '';

        if ($miles > 0) {
            $texto .= ($miles === 1 ? 'MIL' : self::convertirMenorAMil($miles) . ' MIL') . ' ';
        }

        if ($resto > 0) {
            $texto .= self::convertirMenorAMil($resto);
        }

        return trim($texto);
    }

    private static function convertirMenorAMil(int $numero): string
    {
        if ($numero === 100) {
            return 'CIEN';
        }

        $centena = intdiv($numero, 100);
        $resto = $numero % 100;
        $texto = self::CENTENAS[$centena];

        if ($resto > 0) {
            $texto .= ($texto !== '' ? ' ' : '') . self::convertirMenorACien($resto);
        }

        return trim($texto);
    }

    private static function convertirMenorACien(int $numero): string
    {
        if ($numero < 10) {
            return self::UNIDADES[$numero];
        }

        if ($numero < 20) {
            return self::DIEZ_A_DIECINUEVE[$numero - 10];
        }

        $decena = intdiv($numero, 10);
        $unidad = $numero % 10;

        if ($decena === 2) {
            return $unidad > 0 ? 'VEINTI' . self::UNIDADES[$unidad] : 'VEINTE';
        }

        $texto = self::DECENAS[$decena];
        if ($unidad > 0) {
            $texto .= ' Y ' . self::UNIDADES[$unidad];
        }

        return $texto;
    }
}

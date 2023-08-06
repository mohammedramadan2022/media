<?php

namespace App\Facade\Support\Tools;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\Response;

class PdfHtml
{
    public static function stream($html, $data, $filename): Response
    {
        return self::general($html, $data,'stream', $filename);
    }

    public static function download($html, $data, $filename): Response
    {
        return self::general($html, $data,'download', $filename);
    }

    private static function general($html, $data, $type, $filename): Response
    {
        $pdf = Pdf::loadView($html, $data);

        if ($type == 'download') return $pdf->download($filename);

        return $pdf->inline($filename);
    }
}

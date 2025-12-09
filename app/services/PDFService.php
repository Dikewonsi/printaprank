<?php
namespace App\services;

use TCPDF;

class PDFService
{
    public function renderFromFabricJson($certificate, array $designJson, array $fields): string
    {
        $outputDir = __DIR__ . '/../../public/downloads';
        if (!is_dir($outputDir)) { mkdir($outputDir, 0775, true); }
        $filename = 'certificate_' . $certificate->id . '_' . time() . '.pdf';
        $filepath = $outputDir . '/' . $filename;

        $pageW = 1600; $pageH = 1200; $dpi = 96;
        $mmW = $pageW * 25.4 / $dpi;
        $mmH = $pageH * 25.4 / $dpi;

        $pdf = new TCPDF('L', 'mm', [$mmW, $mmH], true, 'UTF-8', false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->AddPage();

        // Background image
        if (!empty($certificate->image)) {
            $bgPath = $_SERVER['DOCUMENT_ROOT'] . $certificate->image; // e.g., /images/template.jpg
            if (is_file($bgPath)) {
                $pdf->Image($bgPath, 0, 0, $mmW, $mmH, '', '', '', false, 300);
            }
        }

        $objects = $designJson['objects'] ?? [];
        foreach ($objects as $obj) {
            $left  = ($obj['left'] ?? 0) * 25.4 / $dpi;
            $top   = ($obj['top']  ?? 0) * 25.4 / $dpi;
            $width = ($obj['width'] ?? 0) * 25.4 / $dpi;

            if (in_array($obj['type'], ['textbox', 'text'])) {
                $text = $obj['text'] ?? '';
                $text = str_replace(
                    ['{{custom_name}}', '{{custom_message}}'],
                    [$fields['custom_name'] ?? '', $fields['custom_message'] ?? ''],
                    $text
                );

                $fontSize = ($obj['fontSize'] ?? 24) * 0.75; // adjust as needed
                [$r,$g,$b] = $this->hexToRgb($obj['fill'] ?? '#000');
                $pdf->SetTextColor($r, $g, $b);
                $pdf->SetFont('times', '', $fontSize);
                $align = strtoupper(($obj['textAlign'] ?? 'left')[0]); // L/C/R

                $pdf->SetXY($left, $top);
                $pdf->MultiCell($width ?: 0, 10, $text, 0, $align, false, 1);
            }
        }

        $pdf->Output($filepath, 'F');
        return $filepath;
    }

    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))];
    }
}

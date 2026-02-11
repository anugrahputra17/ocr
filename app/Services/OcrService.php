<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrService
{
    private $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe';
    private $popplerPath = 'C:\poppler-25.12.0\Library\bin\pdftoppm.exe';

    public function process($pdfPath, $outputFolder)
    {
        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0777, true);
        }

        // Convert PDF → Image
        $command = "\"{$this->popplerPath}\" -jpeg -r 400 \"$pdfPath\" \"$outputFolder/page\"";
        exec($command);

        $text = "";

        foreach (glob($outputFolder . "/page*.jpg") as $img) {
            $text .= (new TesseractOCR($img))
                ->executable($this->tesseractPath)
                ->lang('eng')
                ->psm(4)
                ->oem(1)
                ->run();

            $text .= "\n\n";
        }

        return $text;
    }

    public function parse($text)
    {
        preg_match('/Invoice\s*No[:\s]*([A-Z0-9\-]+)/i', $text, $inv);
        preg_match('/Date[:\s]*([0-9\/\-]+)/i', $text, $date);
        preg_match('/Total\s*Amount[:\s]*([\d\.,]+)/i', $text, $total);
        preg_match('/(USD|IDR|EUR)/i', $text, $curr);

        return [
            'invoice_number' => $inv[1] ?? null,
            'invoice_date' => $date[1] ?? null,
            'total_amount' => isset($total[1]) ? str_replace(',', '', $total[1]) : null,
            'currency' => $curr[1] ?? null,
        ];
    }

    public function cleanup($folder)
    {
        foreach (glob($folder . "/*") as $file) {
            unlink($file);
        }
        rmdir($folder);
    }
}

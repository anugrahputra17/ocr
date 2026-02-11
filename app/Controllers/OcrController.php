<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Services\OcrService;

class OcrController extends BaseController
{
    public function index()
    {
        return view('upload');
    }

    public function upload()
    {
        $file = $this->request->getFile('pdf_file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);

        $pdfPath = WRITEPATH . 'uploads/' . $newName;
        $tempFolder = WRITEPATH . 'uploads/temp_' . time();

        $model = new InvoiceModel();
        $id = $model->insert([
            'filename' => $newName,
            'status' => 'processing'
        ]);

        $ocr = new OcrService();

        try {
            $text = $ocr->process($pdfPath, $tempFolder);
            $parsed = $ocr->parse($text);

            $model->update($id, [
                ...$parsed,
                'raw_text' => $text,
                'status' => 'completed'
            ]);

            unlink($pdfPath);
            $ocr->cleanup($tempFolder);

        } catch (\Exception $e) {
            $model->update($id, ['status' => 'failed']);
        }

        return redirect()->to('/ocr/result/' . $id);
    }

    public function result($id)
    {
        $model = new InvoiceModel();
        $data['invoice'] = $model->find($id);

        return view('result', $data);
    }
}

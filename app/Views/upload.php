<h2>Upload Invoice PDF</h2>

<form action="<?= base_url('ocr/upload') ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="pdf_file" required>
    <button type="submit">Process OCR</button>
</form>

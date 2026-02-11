<h2>Hasil OCR</h2>

<table border="1" cellpadding="10">
<tr><th>Invoice</th><td><?= $invoice['invoice_number'] ?></td></tr>
<tr><th>Date</th><td><?= $invoice['invoice_date'] ?></td></tr>
<tr><th>Total</th><td><?= $invoice['currency'] ?> <?= $invoice['total_amount'] ?></td></tr>
<tr><th>Status</th><td><?= $invoice['status'] ?></td></tr>
</table>

<h3>Raw Text</h3>
<pre><?= $invoice['raw_text'] ?></pre>

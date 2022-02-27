<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penerimaan Barang</title>
    <style>
        html {
            padding-top: 10px;
            background: #e6e6e6;
            text-align: center;
        }

        .page_break {
            page-break-before: always;
        }

        table {
            border-collapse: collapse;
            margin: 8px 0;
            width: 100%;
        }

        table th,
        td {
            padding: 8px 14px 8px 14px;
            border: 1px solid #333;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>
<?php
$no = 1;
$stock = 0;
$total = 0
?>

<body>
    <h1>
        <center>Laporan <br>Penerimaan Barang </center>
    </h1>
    <table class='table table-bordered' cellspacing="0" cellpadding="2" rules="rows">
        <thead>
            <th class="text-center"> No </th>
            <th> No Penerimaan </th>
            <th > Kode Barang </th>
            <th> Nama Barang </th>
            <th> Tgl Terima </th>
            <th> Jumlah Barang</th>
            <th> Harga Satuan </th>
            <th> Jumlah Harga </th>
            <th> Penermia </th>
        </thead>
        <tbody>
            <?php foreach ($data as $item) : ?>
            <?php $stock += $item->stock; 
            $total += (int)$item->harga_satuan * $item->stock
            ?>
            <tr class="text-center">
                <td><?= $no++ ?></td>
                <td><?= $item->no_penerimaan ?></td>
                <td><?= $item->kode_barang ?></td>
                <td><?= $item->nama_barang ?></td>
                <td><?= $item->tgl_terima ?></td>
                <td><?= $item->stock ?></td>
                <td><?= number_format((int)$item->harga_satuan) ?></td>
                <td><?= number_format((int)$item->harga_satuan * $item->stock) ?></td>
                <td><?= $item->username ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="5"> Total Barang Masuk </td>
                <td> <?= $stock ?></td>
                <td> </td>
                <td><?= number_format($total) ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

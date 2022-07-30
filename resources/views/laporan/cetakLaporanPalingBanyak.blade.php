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
$total_qty = 0;
$total = 0
?>

<body>
    <h1>
        <center>Laporan <br>Penerimaan Barang Paling Banyak Digunakan </center>
    </h1>
    <h2> <center> Periode <?= $tanggal_dari ?> / <?= $tanggal_sampai ?> </center> </h2>
    <table class='table table-bordered' cellspacing="0" cellpadding="2" rules="rows">
        <thead>
            <th class="text-center"> No </th>
            <th> Kode Barang </th>
            <th > Nama Barang </th>
            <th> Total </th>
            <th> Total Qty Yang Dikeluarkan </th>
        </thead>
        <tbody>
            <?php foreach ($data as $item) : ?>
            <?php 
            $total += $item->total;
            $total_qty += $item->jumlah_brg;
            ?>
            <tr class="text-center">
                <td><?= $no++ ?></td>
                <td><?= $item->kode_barang ?></td>
                <td><?= $item->nama_barang ?></td>
                <td><?= $item->total ?></td>
                <td><?= $item->jumlah_brg ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="3"> Total Barang Masuk </td>
                <td><?= number_format($total) ?></td>
                <td><?= number_format($total_qty) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>

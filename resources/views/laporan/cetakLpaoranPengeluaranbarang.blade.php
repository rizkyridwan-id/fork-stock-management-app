<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengeluaran Barang</title>
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
$total = 0;
$stockjml = 0;
$nama = '';

// foreach ($data as $item) {
//     if ($item->kode_barang = $item->kode_barang) {
//         // $stockjml = $stockjml +  $item->jumlah;
//         // var_dump($item->nama_barang);
//         // $nama = $item->nama_barang;
//         echo 'masuk f' . $item->nama_barang;
//         return false;
//     }else{
//         echo 'ga masuk f';
//         var_dump($item);
//     }
// }
?>


<body>
    <h1>
        <center>Laporan <br>Pengeluaran Barang </center>
    </h1>
    <h2>
        <center> Periode <?= $tanggal_dari ?> / <?= $tanggal_sampai ?> </center>
    </h2>
    <table class='table table-bordered' cellspacing="0" cellpadding="2" rules="rows">
        <thead>
            <th class="text-center"> No </th>
            <th style="width:30px"> No Pengeluaran </th>
            <th style="width:30px"> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Tgl Keluar </th>
            <th> Divisi </th>
            <th> Keterangan </th>
            <th> Jumlah </th>
            <th> Harga Satuan </th>
            <th> Jumlah Harga </th>
            <th> username </th>
        </thead>
        <tbody>
            <?php foreach ($data as $item) : ?>
            <?php $stock += $item->jumlah;
            $total += $item->harga_satuan * $item->jumlah; ?>
            <tr class="text-center">
                <td><?= $no++ ?></td>
                <td><?= $item->no_pengeluaran ?></td>
                <td><?= $item->kode_barang ?></td>
                <td><?= $item->nama_barang ?></td>
                <td><?= $item->created_at ?></td>
                <td><?= $item->kode_divisi ?> - <?= $item->nama_divisi ?></td>
                <td><?= $item->keterangan ?></td>
                <td><?= $item->jumlah ?></td>
                <td><?= number_format($item->harga_satuan) ?></td>
                <td><?= number_format($item->harga_satuan * $item->jumlah) ?></td>
                <td><?= $item->username ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="text-center">
                <td colspan="7"> Total Barang Keluar </td>
                <td> <?= $stock ?></td>
                <td></td>
                <td> <?= number_format($total) ?></td>
                <td></td>
            </tr>

        </tfoot>
    </table>



</body>

</html>

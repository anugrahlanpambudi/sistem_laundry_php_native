<?php
require_once "config/config.php";


if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    exit;
}


$totalPelanggan = mysqli_fetch_assoc(mysqli_query($config, "SELECT COUNT(*) AS total FROM customers"))['total'];

$totalTransaksi = mysqli_fetch_assoc(mysqli_query($config, "SELECT COUNT(*) AS total FROM trans_orders"))['total'];

$totalOmset = mysqli_fetch_assoc(mysqli_query($config, "SELECT SUM(order_total) AS total FROM trans_orders"))['total'] ?? 0;

$transaksiBaru = mysqli_fetch_assoc(mysqli_query($config, "SELECT COUNT(*) AS total FROM trans_orders WHERE order_status = 0"))['total'];
$transaksiSelesai = mysqli_fetch_assoc(mysqli_query($config, "SELECT COUNT(*) AS total FROM trans_orders WHERE order_status = 1"))['total'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Laundry</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h2 class="mb-4">Dashboard Sistem Laundry</h2>

    <div class="row g-3">

       
        <div class="col-md-3">
            <div class="card text-bg-primary p-3 rounded-3">
                <h5>Total Pelanggan</h5>
                <h2><?= number_format($totalPelanggan) ?></h2>
            </div>
        </div>

       
        <div class="col-md-3">
            <div class="card text-bg-success p-3 rounded-3">
                <h5>Total Transaksi</h5>
                <h2><?= number_format($totalTransaksi) ?></h2>
            </div>
        </div>

      
        <div class="col-md-3">
            <div class="card text-bg-warning p-3 rounded-3">
                <h5>Total Omset</h5>
                <h2>Rp <?= number_format($totalOmset) ?></h2>
            </div>
        </div>

       
        <div class="col-md-3">
            <div class="card text-bg-danger p-3 rounded-3">
                <h5>Status Cucian</h5>
                <p class="mb-1">Baru: <b><?= $transaksiBaru ?></b></p>
                <p class="mb-0">Selesai: <b><?= $transaksiSelesai ?></b></p>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <h4>Statistik Sederhana</h4>

    <table class="table table-bordered text-center">
        <tr>
            <th>Baru</th>
            <th>Selesai</th>
        </tr>
        <tr>
            <td>
                <div style="background:#ffc107;height:40px;width:<?= $transaksiBaru * 10 ?>px;margin:auto;"></div>
                <?= $transaksiBaru ?> transaksi
            </td>

            <td>
                <div style="background:#198754;height:40px;width:<?= $transaksiSelesai * 10 ?>px;margin:auto;"></div>
                <?= $transaksiSelesai ?> transaksi
            </td>
        </tr>
    </table>

</body>
</html>

<?php
session_start();
include '../config/config.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = mysqli_query($config, "SELECT * FROM trans_orders WHERE id = '$id' LIMIT 1");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "Order not found";
    exit;
}

$order_id = $row['id'];
$queryDetails = mysqli_query($config, "SELECT s.name, od.* FROM trans_order_details od LEFT JOIN services s ON s.id = od.service_id WHERE order_id = '$order_id'");
$rowDetails = mysqli_fetch_all($queryDetails, MYSQLI_ASSOC);

// Ambil data pajak, bayar, dan kembalian
$taxPercent = $row['order_tax'];          // nominal pajak
$payAmount = $row['order_pay'];
$changeAmount = $row['order_change'];
$orderTotal = $row['order_total'];
$createdAt = $row['created_at'];

// Ambil persentase pajak aktif
$queryTax = mysqli_query($config, "SELECT * FROM taxs WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$rowTax = mysqli_fetch_assoc($queryTax);
$taxPercentValue = $rowTax['percent']; // persen pajak

$date = date("d-m-Y", strtotime($createdAt));
$time = date("H:i:s", strtotime($createdAt));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Receipt</title>
    <style>
        body {
            width: 80mm;
            font-family: 'Courier New', Courier, monospace;
            margin: 0 auto;
            padding: 10px;
            background-color: white;
        }

        .struck-page {
            width: 100%;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 35%;
            height: auto;
        }

        .header h2 {
            font-size: 18px;
            margin: 5px 0;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .info,
        .items,
        .totals,
        .payment {
            font-size: 12px;
        }

        .info-row,
        .item,
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            margin: 0 5px;
        }

        .item-price {
            min-width: 70px;
            text-align: right;
        }

        .total-row.grand {
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="struck-page">
        <div class="header">
            <img src="../assets/img/logo-print.png" alt="Logo">
            <h2>Struct Payment</h2>
            <p>Jl Benhil Karet Jakarta Pusat</p>
            <p>0858-7878-5858</p>
        </div>

        <div class="info">
            <div class="info-row">
                <span><?php echo $date ?></span>
                <span><?php echo $time ?></span>
            </div>
            <div class="info-row">
                <span>Transaction Id</span>
                <span><?php echo $row['order_code'] ?></span>
            </div>
            <div class="info-row">
                <span>Cashier</span>
                <span><?php echo $_SESSION['NAME'] ?? 'Unknown' ?></span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="items">
            <?php foreach ($rowDetails as $item): ?>
                <div class="item" style="display: flex; justify-content: space-between; margin: 5px 0; flex-wrap: wrap;">
                    <div>
                        <strong><?php echo $item['name'] ?></strong><br>
                        <small>Rp <?php echo number_format($item['price'], 0, ',', '.') ?> / kg</small>
                    </div>
                    <div style="text-align: right;">
                        <span><?php echo $item['qty'] ?> kg</span>
                    </div>
                    <div style="text-align: right; min-width: 80px;">
                        <strong>Rp <?php echo number_format($item['price'] * $item['qty'], 0, ',', '.') ?></strong>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="separator"></div>

        <div class="totals">
            <div class="total-row">
                <span>Pajak (PPN <?php echo $taxPercentValue ?>%)</span>
                <span>Rp <?php echo number_format($taxPercent, 0, ',', '.') ?></span>
            </div>
            <div class="total-row grand">
                <span>Total</span>
                <span>Rp <?php echo number_format($orderTotal, 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="payment">
            <div class="total-row">
                <span>Cash</span>
                <span>Rp <?php echo number_format($payAmount, 0, ',', '.') ?></span>
            </div>
            <div class="total-row">
                <span>Change</span>
                <span>Rp <?php echo number_format($changeAmount, 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
</body>

</html>
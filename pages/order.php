<?php
$query = mysqli_query(
    $config,
    "
    SELECT c.name, t.*
    FROM trans_orders t
    LEFT JOIN customers c ON c.id = t.customer_id
    ORDER BY t.id DESC
    "
);

$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($config, "DELETE FROM trans_orders WHERE id = $id");
    header('location:?page=order');
}

// UPDATE STATUS JIKA DIAMBIL
if (isset($_GET['pickup'])) {
    $id = $_GET['pickup'];
    mysqli_query($config, "UPDATE trans_orders SET order_status = 1 WHERE id = $id");
    header('location:?page=order');
}
?>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Data Order</h3>

                    <div class="d-flex justify-content-end mb-3 mt-2">
                        <a class="btn btn-primary" href="pos/add-order.php"><i class="bi bi-plus-circle"></i> Add Order</a>
                    </div>

                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Order End Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                        <?php foreach ($rows as $key => $v): ?>
                        <tr>
                            <td class="text-center"><?= $key + 1 ?></td>
                            <td><?= $v['order_code'] ?></td>
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['order_end_date'] ?></td>
                            <td>Rp <?= number_format($v['order_total']) ?></td>

                            <td class="text-center">
                                <?php 
                                    if ($v['order_status'] == 0) 
                                        echo "<span class='badge bg-secondary'>Sedang di proses</span>";
                                    else 
                                        echo "<span class='badge bg-success'>Sudah Diambil</span>";
                                ?>
                            </td>

                            <td class="text-center">

                                <a href="pos/print.php?id=<?= $v['id'] ?>" class="btn btn-success btn-sm">
                                    <i class="bi bi-printer"></i> Print
                                </a>

                                <?php if ($v['order_status'] == 0): ?>
                                    <a href="?page=order&pickup=<?= $v['id'] ?>" 
                                       class="btn btn-warning btn-sm"
                                       onclick="return confirm('Laundry sudah diambil customer?')">
                                        <i class="bi bi-check-circle"></i> Ambil
                                    </a>
                                <?php endif; ?>

                                <a href="?page=order&delete=<?= $v['id'] ?>"
                                    onclick="return confirm('Hapus data?')"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Delete
                                </a>

                            </td>
                        </tr>
                        <?php endforeach ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

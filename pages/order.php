<?php
// $query = mysqli_query($config, "SELECT c.name, `to`.* FROM trans_orders `to` LEFT JOIN customers c ON c.id = `to`.customer_id ORDER BY id DESC");
$query = mysqli_query(
    $config,
    "
    SELECT c.name, t.*
FROM trans_orders t
LEFT JOIN customers c ON c.id = t.customer_id
ORDER BY t.id DESC

",
);

$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($config, "DELETE FROM trans_orders WHERE id = $id");
    if ($delete) {
        header('location:?page=order');
    }
}

?>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Data Order</h3>
                    <div class="d-flex justify-content-end mb-3 mt-2">
                        <a class="btn btn-primary" href="pos/add-order.php"><i class="bi bi-plus-circle"></i> Add
                            Order</a>
                    </div>
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Order End Date</th>
                            <th>Order Total</th>
                            <th>Order Tax</th>
                            <th>Order Pay</th>
                            <th>Order Change</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($rows as $key => $v) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $key + 1; ?></td>
                            <td><?php echo $v['order_code']; ?></td>
                            <td><?php echo $v['order_end_date']; ?></td>
                            <td><?php echo $v['order_total']; ?></td>
                            <td><?php echo $v['order_tax']; ?></td>
                            <td><?php echo $v['order_pay']; ?></td>
                            <td><?php echo $v['order_change']; ?></td>
                            <td class="text-center"><?php echo $v['order_status']; ?></td>
                            <td class="text-center">
                                <a href="pos/print.php?id=<?php echo $v['id']; ?>" class="btn btn-success btn-sm"><i
                                        class="bi bi-printer"></i>Print</a>
                                <a href="?page=order&delete=<?php echo $v['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this data?')"
                                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>Delete</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

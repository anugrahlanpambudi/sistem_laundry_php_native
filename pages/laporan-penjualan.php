<?php
$query = mysqli_query($config, "SELECT c.name, `to`.* FROM trans_orders `to` LEFT JOIN customers c ON c.id = `to`.customer_id ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($config, "DELETE FROM trans_orders WHERE id = $id");
    if ($delete) {
        header("location:?page=order");
    }
}

?>

<style>
@media print {
    header, .header, .navbar {
        display: none !important;
    }

    #sidebar, .sidebar {
        display: none !important;
    }

    .btn, button, a.btn {
        display: none !important;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    table th, table td {
        border: 1px solid #000 !important;
        padding: 6px !important;
    }
}
</style>


<script>
function printReport() {
    window.print();
}
</script>


<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Data Report</h3>
                    <div class="d-flex justify-content-end mb-3 mt-2">
                        <button class="btn btn-primary" onclick="printReport()">
                            <i class="bi bi-printer"></i> Print Report
                        </button>

                    </div>
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Name</th>
                            <th>Order Code</th>
                            <th>Order End Date</th>
                            <th>Order Total</th>
                            <th>Order Tax</th>
                            <th>Order Pay</th>
                            <th>Order Change</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach ($rows as $key => $v) {
                        ?>
                            <tr class="text-center">
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $v['name'] ?></td>
                                <td><?php echo $v['order_code'] ?></td>
                                <td><?php echo $v['order_end_date'] ?></td>
                                <td><?php echo $v['order_total'] ?></td>
                                <td><?php echo $v['order_tax'] ?></td>
                                <td><?php echo $v['order_pay'] ?></td>
                                <td><?php echo $v['order_change'] ?></td>
                                <td>
                                <?php 
                                    if ($v['order_status'] == 0) 
                                        echo "<span class='badge bg-secondary'>Belum diambil</span>";
                                    else 
                                        echo "<span class='badge bg-success'>Sudah Diambil</span>";
                                ?>
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
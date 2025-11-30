<?php

$q_customers = mysqli_query($config, "SELECT  * FROM customers");
$customers = mysqli_fetch_all($q_customers, MYSQLI_ASSOC);
// var_dump($customers);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $q_delete = mysqli_query($config, "DELETE FROM customers WHERE id = $id");

    header("location:?page=customer");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <h3 class="card-title">Data Customers</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3 justify-content-end">
                            <a href="?page=tambah-customer" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add Customers
                            </a>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                            <?php
                            foreach ($customers as $key => $customer) {
                            ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $customer['name'] ?></td>
                                <td><?php echo $customer['phone'] ?></td>
                                <td><?php echo $customer['address'] ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm"
                                        href="?page=tambah-customer&edit=<?= $customer['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form class="d-inline" action="?page=customer&delete=<?= $customer['id'] ?>"
                                        method="post" onclick="return confirm('Are you sure you want to delete?')">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
    </div>
</body>

</html>
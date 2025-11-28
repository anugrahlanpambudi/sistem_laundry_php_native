<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$selectCustomer = mysqli_query($config, "SELECT * FROM customers WHERE id = '$id'");
$customer = mysqli_fetch_assoc($selectCustomer);
// var_dump($customer);

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $Insert = mysqli_query($config, "INSERT INTO customers (name, phone, address) VALUES ('$name', '$phone', '$address')");

    header("location:?page=customer");
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $update = mysqli_query($config, "UPDATE customers SET name='$name', phone='$phone', address='$address' WHERE id = $id");

    header('location:?page=customer');
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
                    <h1><?= isset($_GET['edit']) ? 'Update' : 'Add' ?> Customer</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <label for="" class="form-label">Customer Name</label> <br>
                        <input type="text" class="form-control w-50" name="name"
                            value="<?php echo $customer['name'] ?? '' ?>" required>
                        <label for="" class="form-label">Phone</label> <br>
                        <input type="text" class="form-control w-50" name="phone"
                            value="<?php echo $customer['phone'] ?? '' ?>" required>
                        <label for="" class="form-label">Address</label> <br>
                        <input type="text" class="form-control w-50" name="address"
                            value="<?php echo $customer['address'] ?? '' ?>" required>
                        <br><br>
                        <button type="submit" class="btn btn-primary"
                            name="<?= isset($_GET['edit']) ? 'update' : 'save' ?>"><?= isset($_GET['edit']) ? 'edit' : 'create' ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
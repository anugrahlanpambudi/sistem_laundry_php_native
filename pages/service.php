<?php

$query = mysqli_query($config, 'SELECT * FROM services');
$services = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $q_delete = mysqli_query($config, "DELETE FROM services WHERE id=$id");

    header('location:?page=service');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-tittle">Data Service</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end m-2">
                        <a href="?page=tambah-service" class="btn btn-primary">Add Service</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php 
                        foreach($services as $key => $service){
                            ?>
                        <tr>
                            <td> <?php echo $key + 1; ?></td>
                            <td> <?php echo $service['service_name']; ?></td>
                            <td><?php echo 'Rp. ' . number_format($service['price'], 2, ',', '.') . ' per KG'; ?></td>
                            <td>
                                <a href="?page=tambah-service&edit=<?php echo $service['id']; ?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                                <form class="d-inline" action="?page=service&delete=<?php echo $service['id']; ?>" method="post"
                                    onclick="return confirm('Are you sure for delete this?')">
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Delete</button>
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

</body>

</html>

<?php

$query = mysqli_query($config, 'SELECT * FROM levels');
$levels = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $q_delete = mysqli_query($config, "DELETE FROM levels WHERE id=$id");

    header('location:?page=level');
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
                    <h3 class="card-tittle">Data Levels</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end m-2">
                        <a href="?page=tambah-level" class="btn btn-primary">Add Levels</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php 
                        foreach($levels as $key => $level){
                            ?>
                        <tr>
                            <td> <?php echo $key + 1; ?></td>
                            <td> <?php echo $level['name']; ?></td>
                            <td>
                                <a href="?page=add-role-menu&edit=<?php echo $level['id']; ?>" class="btn btn-warning"><i class="bi bi-plus"></i> Add role</a>
                                <a href="?page=tambah-level&edit=<?php echo $level['id']; ?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                                <form class="d-inline" action="?page=level&delete=<?php echo $level['id']; ?>" method="post"
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

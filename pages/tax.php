<?php 


$query = mysqli_query($config, "SELECT * FROM taxs ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM taxs where id = $id");
    if($delete){
            header("location:?page=tax");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">              
                <div class="card-body">
                    <h3 class="card-title">Data Tax</h3>
                    <div class="d-flex justify-content-end p-2">
                        <a href="?page=tambah-tax" class="btn btn-primary"><i class="bi bi-plus-circle"></i>Add Tax</a>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Percent</th>
                            <th>Is Active</th>
                        </tr>
                        <?php
                        foreach ($rows as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['percent']; ?></td>
                            <td><?php echo $value['is_active'] == 1 ? 'Active' : 'Draft'; ?></td>
                            
                            <td> <a href="?page=tambah-tax&edit=<?php echo $value['id']?>" class="btn btn-success btn-sm"> 
                                <i class="bi bi-pencil"></i> Edit </a>
                                <a href="?page=tax&delete=<?php echo $value['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure for delete this?')" > 
                                <i class="bi bi-trash"></i>Delete</a>
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

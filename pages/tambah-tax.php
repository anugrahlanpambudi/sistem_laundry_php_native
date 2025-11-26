<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$query = mysqli_query($config, "SELECT * FROM taxs WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($query);

if (isset($_POST['save'])) {
    $percent = $_POST['percent'];
    $is_active = $_POST['is_active'];

    $insert = mysqli_query(
        $config,
        "INSERT INTO taxs (percent, is_active)
     VALUE ('$percent', '$is_active')",
    );
    if ($insert) {
        header('location:?page=tax');
    }
}
if (isset($_POST['update'])) {
    $percent = $_POST['percent'];
    $is_active = $_POST['is_active'];

    $update = mysqli_query($config, "UPDATE taxs SET percent='$percent', is_active='$is_active' WHERE id='$id'");
    if ($update) {
        header('location:?page=tax');
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-tittle"><?php echo isset($_GET['edit']) ? 'Edit' : 'Create'; ?> Tax</h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="w-50">
                        <div class="mb-3">
                            <label class="form-label" for="">Percent</label>
                            <input type="number" name="percent" class="form-control" value="<?php echo $rowEdit ? $rowEdit['percent'] : ''; ?>"required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Is Active</label>
                            <br>
                            <input type="radio" name="is_active" <?php echo ($rowEdit && $rowEdit['is_active'] == 0) ? 'checked' : ''; ?>value="0"> Draft
                            <br>
                            <input type="radio" name="is_active" <?php echo ($rowEdit && $rowEdit['is_active'] == 1) ? 'checked' : ''; ?>value="1"> Active
                        </div>
                        <button type="submit"
                            name="<?php echo isset($_GET['edit']) ? 'update' : 'save'; ?>"class="btn btn-primary mt-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?></button>
                    </div>

                </form>

            </div>

        </div>
    </div>


</body>

</html>

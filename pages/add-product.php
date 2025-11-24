<?php

$selectCategories = mysqli_query($koneksi, 'SELECT * FROM categories');
$categories = mysqli_fetch_all($selectCategories, MYSQLI_ASSOC);
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$s_product = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$id'");
$p = mysqli_fetch_assoc($s_product);

if (isset($_POST['save'])) {
    $c_id = $_POST['category_id'];
    $p_name = $_POST['product_name'];
    $p_price = $_POST['product_price'];
    $p_description = $_POST['product_description'];
    $p_photo = $_FILES['product_photo'];

    $filePath = 'assets/uploads/' . time() . '-' . $p_photo['name'];
    move_uploaded_file($p_photo['tmp_name'], $filePath);

    $insertProduct = mysqli_query(
        $koneksi,
        "INSERT INTO products (category_id, product_name, product_price, product_description, product_photo )
     VALUE ('$c_id', '$p_name', '$p_price', '$p_description', '$filePath')",
    );
    if ($insertProduct) {
        header('location:?page=product');
    }
}
if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $c_id = $_POST['category_id'];
    $p_name = $_POST['product_name'];
    $p_price = $_POST['product_price'];
    $p_description = $_POST['product_description'];
    $p_photo = $_FILES['product_photo'];

    $cek_foto = mysqli_query($koneksi, "SELECT product_photo FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($cek_foto);
    $oldFile = $row['product_photo'];

    $filePath = '$oldFile';
    if (!empty($p_photo['name'])) {
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }
        $filePath = 'assets/uploads' . time() . '-' . $p_photo['name'];
        move_uploaded_file($p_photo['tmp_name'], $filePath);
    }

    $update = mysqli_query($koneksi, "UPDATE products SET category_id='$c_id', product_name='$p_name', product_price='$p_price', product_description='$p_description', product_photo='$filePath' WHERE id=$id");
    if ($update) {
        header('location:?page=product');
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
                <h3 class="card-tittle"><?php echo isset($_GET['edit']) ? 'Edit Product' : 'Add Product'; ?></h3>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="w-50">
                        <label class="form-label" for="">Category Name</label><br>
                        <select class="form-select w-50" name="category_id" required>
                            <option value="">--Choose Category--</option>

                            <?php 
                        foreach($categories as $c){
                        ?>
                            <option <?php echo isset($p) && $p['category_id'] == $c['id'] ? 'selected' : ''; ?> value="<?php echo $c['id']; ?>"><?php echo $c['category_name']; ?></option>

                            <?php 
                        }
                        ?>
                            <option value=""></option>
                        </select>
                        <label class="form-label" for="">Produck Name</label>
                        <input class="form-control" type="text" name="product_name" value="<?php echo $p ? $p['product_name'] : ''; ?>"
                            required>

                        <label for="form-label">Photo</label><br>
                        <?php
                        if ($p) {
                            echo "<img src='" . $p ['product_photo'] . "' width='115'>";
                        }
                        ?>
                        <input class="form-control mt-1" type="file" name="product_photo">

                        <label for="" class="form-label">Price</label>
                        <input class="form-control" value="<?php echo $p ? intval($p['product_price']) : ''; ?>" type="number" name="product_price"
                            required>

                        <label for="" class="form-label">Description</label>
                        <textarea class="form-control" name="product_description" cols="30" rows="5" required><?php echo $p ? $p['product_description'] : ''; ?></textarea>
                        <button type="submit"
                            name="<?php echo isset($_GET['edit']) ? 'update' : 'save'; ?>"class="btn btn-primary mt-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?></button>
                    </div>

                </form>

            </div>

        </div>
    </div>


</body>

</html>

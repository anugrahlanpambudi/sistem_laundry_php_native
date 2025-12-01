<?php


// Cek apakah session sudah aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include config dengan path relatif aman
include __DIR__ . '/../config/config.php';

// Ambil id jika edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$rowEdit = null;

if ($id) {
    $query = mysqli_query($config, "SELECT * FROM taxs WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($query);
}

// Simpan data baru
if (isset($_POST['save'])) {
    $percent = $_POST['percent'];
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : 0;

    $insert = mysqli_query(
        $config,
        "INSERT INTO taxs (percent, is_active) VALUES ('$percent', '$is_active')"
    );

    if ($insert) {
        header('location:?page=tax');
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($config);
    }
}

// Update data existing
if (isset($_POST['update'])) {
    $percent = $_POST['percent'];
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : 0;

    $update = mysqli_query(
        $config,
        "UPDATE taxs SET percent='$percent', is_active='$is_active' WHERE id='$id'"
    );

    if ($update) {
        header('location:?page=tax');
        exit;
    } else {
        echo "Gagal update data: " . mysqli_error($config);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $rowEdit ? 'Edit' : 'Tambah'; ?> Tax</title>
</head>
<body>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo $rowEdit ? 'Edit' : 'Tambah'; ?> Tax</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="w-50">
                        <div class="mb-3">
                            <label class="form-label">Percent</label>
                            <input type="number" name="percent" class="form-control" value="<?php echo $rowEdit ? $rowEdit['percent'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Is Active</label><br>
                            <input type="radio" name="is_active" value="0" <?php echo ($rowEdit && $rowEdit['is_active'] == 0) ? 'checked' : ''; ?>> Draft<br>
                            <input type="radio" name="is_active" value="1" <?php echo ($rowEdit && $rowEdit['is_active'] == 1) ? 'checked' : ''; ?>> Active
                        </div>
                        <button type="submit" name="<?php echo $rowEdit ? 'update' : 'save'; ?>" class="btn btn-primary mt-2">
                            <?php echo $rowEdit ? 'Update' : 'Add'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

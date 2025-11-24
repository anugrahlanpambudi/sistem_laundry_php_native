<?php
// Ambil ID dari URL jika ada
$id = isset($_GET['edit']) ? $_GET['edit'] : '';

// Jika kita sedang dalam mode edit, ambil data level berdasarkan ID
if ($id) {
    $queryEdit = mysqli_query($config, "SELECT * FROM levels WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
}

// Proses ketika tombol update ditekan
if (isset($_POST['update'])) {
    $name = $_POST['name'];

    // Update data level berdasarkan ID
    $query = mysqli_query($config, "UPDATE levels SET name='$name' WHERE id='$id'");

    if ($query) {
        header('location:?page=level&update=success');
    }
}

// Proses ketika tombol submit ditekan untuk menambah data level
if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    // Insert data level baru ke dalam database
    $query = mysqli_query($config, "INSERT INTO levels (name) VALUES('$name')");

    if ($query) {
        header('location:?page=level&add=success');
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Level</h3>
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter level name" required
                               value="<?php echo $rowEdit['name'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="<?php echo $id ? 'update' : 'submit'; ?>">
                            <?php echo $id ? 'Save changes' : 'Submit'; ?>
                        </button>
                        <a href="?page=level" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

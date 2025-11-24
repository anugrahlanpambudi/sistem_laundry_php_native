<?php
// Ambil ID dari URL jika ada
$id = isset($_GET['edit']) ? $_GET['edit'] : '';

// Jika kita sedang dalam mode edit, ambil data layanan berdasarkan ID
if ($id) {
    $queryEdit = mysqli_query($config, "SELECT * FROM services WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
}

// Proses ketika tombol update ditekan
if (isset($_POST['update'])) {
    $name = $_POST['service_name'];  // Mengambil nama layanan dari form
    $price = $_POST['price'];        // Mengambil harga dari form

    // Update data layanan berdasarkan ID
    $query = mysqli_query($config, "UPDATE services SET service_name='$name', price='$price' WHERE id='$id'");

    if ($query) {
        header('location:?page=service&update=success');
    }
}

// Proses ketika tombol submit ditekan untuk menambah data layanan
if (isset($_POST['submit'])) {
    $name = $_POST['service_name'];  // Mengambil nama layanan dari form
    $price = $_POST['price'];        // Mengambil harga dari form

    // Insert data layanan baru ke dalam database
    $query = mysqli_query($config, "INSERT INTO services (service_name, price) VALUES('$name', '$price')");

    if ($query) {
        header('location:?page=service&add=success');
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($_GET['edit']) ? 'Edit' : 'Add'; ?> Service</h3>
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="service_name" class="form-control" placeholder="Enter service name"
                            required value="<?php echo $rowEdit['service_name'] ?? ''; ?>"> <!-- Pastikan ini service_name -->
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Enter service price"
                            required value="<?php echo $rowEdit['price'] ?? ''; ?>"> <!-- Pastikan ini price -->
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="<?php echo $id ? 'update' : 'submit'; ?>">
                            <?php echo $id ? 'Save changes' : 'Submit'; ?>
                        </button>
                        <a href="?page=service" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

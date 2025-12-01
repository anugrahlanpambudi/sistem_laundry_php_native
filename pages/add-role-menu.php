<?php

// Ambil ID dari URL jika ada
$id = isset($_GET['edit']) ? $_GET['edit'] : '';

// Jika kita sedang dalam mode edit, ambil data level berdasarkan ID
if ($id) {
    $queryEdit = mysqli_query($config, "SELECT * FROM levels WHERE id='$id'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
}
$level_id = $rowEdit['id'];
$queryMenus = mysqli_query($config, "SELECT * FROM menus ORDER BY id DESC");
$rowMenus = mysqli_fetch_all($queryMenus, MYSQLI_ASSOC);

$selectedMenu = mysqli_query($config, "SELECT * FROM level_menus WHERE level_id = '$level_id' ");
$selectedMenuIds = [];
$rowSelectedMenus = mysqli_fetch_all($selectedMenu, MYSQLI_ASSOC);
foreach ($rowSelectedMenus as $selectedMenus) {
    $selectedMenuIds[] = $selectedMenus['menu_id'];
}


// Proses ketika tombol submit ditekan untuk menambah data level
if (isset($_POST['submit'])) {
    $level_id = $_POST['level_id'];
    $menu_id = $_POST['menu_id'];

    mysqli_query($config, "DELETE FROM level_menus WHERE level_id = '$level_id' ");

    foreach ($menu_id as $key => $menu) {
        $insert = mysqli_query($config, "INSERT INTO level_menus (menu_id, level_id) VALUES ('$menu', '$level_id')");    
    };    
    header('location:?page=level&add=success');  
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
                        <label for="" class="form-label">Level Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter level name" required
                               value="<?php echo $rowEdit['name'] ?? ''; ?>" readonly>

                               <input type="hidden" name="level_id" value="<?php echo $rowEdit['id'] ?? ''; ?>" >
                    </div>
                    <div class="mb-3">
                        <?php foreach ($rowMenus as $menu): ?>
                        <label for="" class="form-label">
                            <input type="checkbox" name="menu_id[]" <?php echo in_array($menu['id'], $selectedMenuIds)? 'checked' : '' ?> value="<?php echo $menu['id']?>" ><?php echo $menu['name']?>
                        </label>
                        <br>
                        <?php endforeach ?>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">
                        Save changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php


$query = mysqli_query(
    $config,
    "SELECT l.name as level_name, u.* FROM users u LEFT JOIN levels l ON l.id = u.level_id ORDER BY u.id DESC"
);

$users = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM users WHERE id=$id");
    header('location:?page=user&hapus=berhasil');
}

?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-tittle">Data User</h3>
                <div class="mb-3" align="right">
                    <a href="?page=tambah-user" class="btn btn-primary">
                        <i class="bi bi-plus-square"> Add User</i>
                    </a>
                     
                </div>
                <table class="table" table-bordered table-striped datatable>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Level_id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $key => $value): ?>
                        <tr>
                            <td><?php echo $key += 1; ?></td>
                            <td><?php echo $value['level_id']; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['email']; ?></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="?page=tambah-user&edit=<?php echo $value['id']; ?>"
                                    style="margin-right: 2px;">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Tombol Delete -->
                                <a class="btn btn-warning btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this data?')"
                                    href="?page=user&delete=<?php echo $value['id']; ?>" style="margin-left: 5px;">
                                    <i class="bi bi-trash"></i>
                                </a>

                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM users WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

$queryLevel = mysqli_query($config, "SELECT * FROM levels ");
$rowLevels = mysqli_fetch_all($queryLevel, MYSQLI_ASSOC);


if (isset($_POST['update'])) {
    $level_id = $_POST['level_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if ($password) {
        $query = mysqli_query($config, "UPDATE users SET name='$name', email= '$email', password = '$password', level_id = '$level_id' WHERE id='$id'");
    } else {
        $query = mysqli_query($config, "UPDATE users SET name='$name', email= '$email', level_id = '$level_id' WHERE id='$id'");
    }

    if ($query) {
        header('location:?page=user&update=success');
    }
}

if (isset($_POST['submit'])) {
    $level_id = $_POST['level_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $query = mysqli_query($config, "INSERT INTO users (name, email, password, level_id) VALUES('$name','$email', '$password', $level_id)");

    if ($query) {
        header('location:?page=user&add=success');
    }
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-tittle">
                    <?php echo isset($_GET['edit'])? 'Edit' : 'Add'?> User
                </h3>
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for class ="form-label">Level Name</label>
                        <select name="level_id" id="" class="form-control">
                            <option value="">Choose One</option>
                            <?php foreach($rowLevels as $rowLevel): ?>
                                <option value="<?php echo $rowLevel['id']?>"><?php echo $rowLevel['name']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for class ="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required
                            value="<?php echo $rowEdit['name'] ?? ''; ?>">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="" class="form-label ">Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required
                            value="<?php echo $rowEdit['email'] ?? ''; ?>">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="" class="form-label ">Password * <small>Leave blank if you don't want to change. <br> </small> </label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="<?php echo $id ? 'update' : 'submit'; ?>">
                            <?php echo $id ? 'Save changes' : 'Submit'; ?>
                        </button>
                        <a href="?page=user" class="btn btn-secondary">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php
session_start();
require '../Classes/Database.php';
require '../Classes/User.php';
require '../Classes/Todolist.php';

$db  = new Database();
$conn = $db->getConnection();

$user = new User($conn);
$todolist = new Todolist($conn);

// var_dump($dataUser);


if (isset($_POST['add'])){
    if ($todolist->createList($_POST['list'])){
    }
}

if (isset($_POST['save-edit'])){
    if($user->update($_POST['new-username'], $_POST['new-password'])){
    }else{
        echo"update akun gagal";
    }
}

$dataUser = $user->getById($_SESSION['usr']['id_user']);


if (isset($_POST['btn-delete'])){
    if ($user->delete()){
        echo"<script>
                window.location.href = 'http://localhost/oophp-todolist/views/register.php';
        </script>
        ";
    }
}

if (isset($_POST['btn-delete-list'])){
    $todolist->delById($_POST['btn-delete-list']);
}

if (isset($_POST['btn-finish'])){
    $todolist->finish($_POST['btn-finish']);
}

if (isset($_POST['btn-edit-list'])){
    $_POST['id-list'] = $_POST['btn-edit-list'];
}


if ($todolist->getByUsrId()){
    $lists = $todolist->getByUsrId();
}else{
    $lists = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todolist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="d-flex align-items-center justify-content-between pt-3">
            <h4>hello, <?= $dataUser[0]['username']; ?></h4>
            <div class="d-flex">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>

                <form action="" method="post">
                    <button class="btn btn-warning text-white mx-1" name="btn-delete">Delete</button>
                </form>
            
                <button class="btn btn-danger">Logout</button>
            </div>
        </div>

        <!-- input tugas -->
        <div class="card my-3">
            <div class="card-body">
                <form action="" method="post">
                    <label for="list" class="form-label">Tugas</label>
                    <input type="text" name="list" id="" class="form-control" required>
                    <br>
                    <div class="d-grid">
                        <button class="btn btn-primary" name="add">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- todolist -->
        <?php if($lists): ?>
            <h4>My todolist</h4>
            <?php foreach($lists as $list): ?>
                <?php if($list['status_id'] == 2):?>
                    <div class="card mb-2">
                        <div class="card-body d-flex align-items-center justify-content-between py-1">
                            <p class="fs-5"><?=$list['list'];?></p>

                            <div class="d-flex">
                                
                                
                                
                                <form action="" method="post">
                                    <a href="?list=" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#editModalList">
                                        <button class="btn btn-primary mx-1" value="<?=$list['id_list'];?>" data-bs-toggle="modal" data-bs-target="#editModalList" name="btn-edit-list" type="submit">Edit</button>
                                    </a>
                                    
                                    <button class="btn btn-danger" value="<?=$list['id_list'];?>" name="btn-delete-list">Delete</button>
    
                                    <button class="btn btn-success" value="<?=$list['id_list'];?>" name="btn-finish">finished</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
            <h4>Finish todolist</h4>
            <?php foreach($lists as $list): ?>
                <?php if($list['status_id'] == 1):?>
                    <div class="card mb-2">
                        <div class="card-body d-flex align-items-center justify-content-between py-1">
                            <p class="fs-5"><?=$list['list'];?></p>
                            <form action="" method="post">
                                <button class="btn btn-danger" value="<?=$list['id_list'];?>" name="btn-delete-list">Delete</button>

                                <button class="btn btn-warning" value="<?=$list['id_list'];?>" name="btn-finish">Unfinished</button>
                            </form>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        <?php else: ?>
            <h4>Tidak ada tugas, happy holiday!</h4>
        <?php endif;?>
        
        <!-- finish todolist -->

        <!-- Modal Edit User -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                    <label for="new-username" class="form-label">Username</label>
                    <input type="text" name="new-username" id="" class="form-control" value="<?= $dataUser[0]['username']; ?>">
                    <label for="new-password" class="form-label">Password</label>
                    <input type="text" name="new-password" id="" class="form-control" value="<?= $dataUser[0]['password']; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="save-edit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
        </div>

        <!-- Modal Edit List -->
        <div class="modal fade" id="editModalList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit List</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                    <label for="new-username" class="form-label">List</label>
                    <input type="text" name="new-username" id="" class="form-control" value="
                    <?php foreach($lists as $list): ?>
                        <?php if($list['id_list'] == $_POST['id-list']):?>
                            <?=$list['list'];?>
                        <?php endif;?>
                    <?php endforeach;?>
                    ">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="save-edit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
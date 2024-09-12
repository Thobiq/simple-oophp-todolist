<?php
require '../Classes/Database.php';
require '../Classes/User.php';

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);

if (isset($_POST['submit'])){
    $login = $user->getByUsername($_POST['username'], $_POST['passwd']);
    if($login){
        session_start();
        $_SESSION['usr'] = $login;
        // var_dump($_SESSION['usr']);
        // var_dump($_SESSION['usr']['id_user']);
        echo "<script>
        alert('Login successfully!');
        window.location.href = 'http://localhost/oophp-todolist/views/todolist.php';
        </script>";
        exit;
    }else{
        echo "<script>
        alert('Incorrect Password or Username');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <div class="container-fluid bg-primary d-flex align-items-center" style="height: 100vh;">
        <div class="card mx-auto" style="width: 20rem;">
            
            <div class="card-body">
                <div>
                    <h2 class="text-center">Login</h2>
                </div>
                <form action="" method="post">
                    <div>
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div>
                        <label for="passwd" class="form-label">Password</label>
                        <input type="password" class="form-control" name="passwd" required>
                    </div>
                    <br>
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
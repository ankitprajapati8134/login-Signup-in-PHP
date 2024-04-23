<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") { //this code is for user who submit the form when click on submit button
    include 'partials/_dbconnect.php';

    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    //Check Whether this username Exists 
    $existSql = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if ($numExistRows > 0) { //if numExistRows is > 0 then it means user is already exist in db

        $showError = "Username already Exists";
    } else {
        echo"hello";
        // This code is only run when my exists is false then it will create the user
        if (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `date`)
                VALUES ('$username', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Password do not match";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php require 'partials/_nav.php'   ?>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You Account Is Created Now You Can Login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <?php
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <div class="container mt-4">
        <h1 class="text-center">SignUp to our website</h1>

        <form action="/login/signup.php" method="post">
            <div class="mb-3 col-md-4 mb-5">
                <input type="text" maxlength="15" class="form-control" id="username" name="username" placeholder="Username" aria-describedby="emailHelp">

            </div>
            <div class="mb-3 col-md-4 mb-5">
                <input type="password" maxlength="15" class="form-control" id="password" placeholder="Password" name="password">
            </div>
            <div class="mb-3 col-md-4 mb-5">
                <input type="password" maxlength="15" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
                <div id="emailHelp" class="form-text">Make sure to type the same password.</div>
            </div>

            <button type="submit" class="btn btn-primary col-md-4">SignUp</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
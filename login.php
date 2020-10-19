<?php
require_once "Auth.php";
session_start();

$fallback = "index.php";

if (isset($_GET["fallback"])) {
    $fallback = $_GET["fallback"];
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == 1) {
    header("location: " . $fallback);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auth = new Auth();
    $res = $auth->login($_POST["username"], $_POST["password"]);
    if ($res == 0) {
        $_SESSION["logged_in"] = 1;
        header("location: " . $fallback);
    } else {
        header("location: login.php?failed=" . $res);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Log In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/singleform.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<div class="container-fluid">
    <div class="row align-items-center justify-content-center" id="fullform">
        <div id="login" class="singleForm col-8 col-lg-3 p-5">
            <h1>Log in</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">TUM ID</label>
                    <input type="text" class="form-control" title="TUM ID" id="username" name="username"
                           pattern="[A-Za-z]{2}[0-9]{2}[A-Za-z]{3}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" pattern="[A-Za-z0-9]{10}"
                           required>
                </div>
                <div class="row align-items-center">
                    <div class="col-12 col-lg-4">
                        <button type="submit" class="btn btn-primary">Log In</button>
                    </div>
                    <div class="col-12 col-lg-8 text-lg-center pt-3 pt-lg-0">
                        <a href="signup.php">Forgot password / Sign up</a>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_GET["no-session"])) {
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                    You have no (more) active session, please consider logging in.
                </div>
                <?php
            } else if (isset($_GET["failed"])) {
                if ($_GET["failed"] == 1) {
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Wrong username/password!
                    </div>
                    <?php
                } else if ($_GET["failed"] == 2) {
                    ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Database failure. Please contact your administrator for further help.
                    </div>
                    <?php
                }
            } else if (isset($_GET["logged-out"])) {
                ?>
                <div class="alert alert-success mt-3" role="alert">
                    Succesfully logged out.
                </div>
                <?php
            } ?>
        </div>
    </div>
</div>
</body>
</html>

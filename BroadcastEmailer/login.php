<?php
session_start();
require 'functions.php';


if ( isset($_POST["submit"]) ) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // mengambil data pada database berdasarkan email yang sama
    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    // cek email ada/tidak
    if ( mysqli_num_rows($result) === 1 ) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if ( password_verify($password, $row["password"]) ) {
            // Set session
            $_SESSION["login"] = true;
            $_SESSION["emailUser"]= $row["email"];
            $_SESSION["password"]= $_POST["password"];
            $_SESSION["idUser"]= $row["id"];
            header("location: index.php");
            exit;
        }
    }

    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <style type="text/css">
        .notif {
            color: red;
            font-style: italic;
            position: relative;
            top: 425px;
            left: 485px;
            z-index: 1;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #17a2b8;
            height: 100vh;
        }
        #login .container #login-row #login-column #login-box {
            margin-top: 120px;
            max-width: 600px;
            height: 320px;
            border: 1px solid #9c9c9c;
            background-color: #eaeaea;
        }
        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }
        #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -85px;
        }
        
    </style>

</head>
<body>
    <?php if( isset($error) ) : ?>
        <div class="notif">Email / Password salah</div>
    <?php endif; ?>

    <div id="login">
        <!-- <h3 class="text-center text-white pt-5">Login form</h3> -->
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <button type="submit" name="submit" class="btn btn-info btn-md" value="submit">submit</button>
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="register.php" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
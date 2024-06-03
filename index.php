<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('images/library.png');
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0; 
        }

        .login-form {
            width: 100%; 
            max-width: 500px;
            padding: 5%;
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
        }

        .login-form h3 {
            text-align: center;
            color: #fff;
        }

        .btnSubmit {
            font-weight: 600;
            color: #0062cc;
            background-color: #fff;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php
    include("data_class.php");

    $emailmsg = $pasdmsg = $msg = "";

    function login($email, $password, $isAdmin) {
        $obj = new data();
        $obj->setconnection();
        if ($isAdmin) {
            $obj->adminLogin($email, $password);
        } else {
            $obj->userLogin($email, $password);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['login_email'] ?? null;
        $password = $_POST['login_password'] ?? null;
        $email = addslashes($email);
        $password = addslashes($password);
        $isAdmin = isset($_POST['admin_login']);

        if (!$email) {
            $emailmsg = "Email Empty";
        }
        if (!$password) {
            $pasdmsg = "Password Empty";
        }

        if (!$emailmsg && !$pasdmsg) {
            login($email, $password, $isAdmin);
        } else {
            $msg = "Please fill in all fields";
        }
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 login-form">
                <h3 style="color:#0062cc">图书管理系统</h3>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login_email" placeholder="Your Email *" value="" />
                        <label style="color:red">*<?= $emailmsg ?></label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="login_password" placeholder="Your Password *" value="" />
                        <label style="color:red">*<?= $pasdmsg ?></label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btnSubmit" value="Login" />
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="admin_login" id="adminLogin">
                        <label class="form-check-label" for="adminLogin">Login as Admin</label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="" async defer></script>
</body>
</html>

<?php
require_once 'asset/common/header.php';
if (isset($_SESSION['UserLoggedIn'])) {
    header('location:pannel.php');
}
?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.rtl.css">
    <title>ورود/ ثبت نام</title>
    <link rel="stylesheet" href="asset/stylesheet/style.css">
</head>
<body style="background-color: #e8e9e7">
<br><br><br>
<div class="container">
    <div class="row my-3">
        <div class="col-sm-6">
            <div class="card">
                <?php
                if (isset($_POST['btn_register'])) {
                    $database = new \classes\Database('root', '', 'ticket');
                    if (!empty($_POST['FirstName']) && !empty($_POST['LastName']) && !empty($_POST['PhoneNumber'])
                        && !empty($_POST['email']) && !empty($_POST['password'])) {
                        $sql = "INSERT INTO register_tbl(FirstName,LastName,phone,email,password) VALUES (?,?,?,?,?)";
                        $database->doing($sql, [$_POST['FirstName'], $_POST['LastName'], $_POST['PhoneNumber'], $_POST['email'], md5($_POST['password'])], 'insert');
                        $message = 'همه ی اطلاعات با موفقیت ثبت شد';
                    } else {
                        $error = 'همه ی اطلاعات درج نشد';
                    }
                }
                ?>
                <div class="card-header">ثبت نام</div>
                <div class="card-body">
                    <?php
                    if (!empty($message)) {
                        ?>
                        <div class="alert alert-success">
                            <?php
                            echo $message;
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($error_exist)) {
                        ?>
                        <div class="alert alert-danger"><?php echo $error_exist; ?></div>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($error)) {
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $error;
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <form method="post">
                        <label class="form-label">نام</label>
                        <input type="text" class="form-control" name="FirstName" placeholder="نام خود را وارد کنید"><br>
                        <label class="form-label">نام خانوادگی</label>
                        <input type="text" class="form-control" name="LastName"
                               placeholder="نام خانوادگی خود را وارد کتید"><br>
                        <label class="form-label">شماره تماس</label>
                        <input type="text" class="form-control" name="PhoneNumber"
                               placeholder="شماره تماس خود را وارد کنید"><br>
                        <label class="form-label">ایمیل</label>
                        <input type="text" class="form-control" name="email" placeholder="ایمیل خود را وارد کنید"><br>
                        <label class="form-label">رمز عبور</label>
                        <input type="password" class="form-control" name="password"
                               placeholder="رمز عبور خود را وارد کنید"><br>
                        <label class="form-label">تکرار رمز عبور</label>
                        <input type="password" class="form-control" name="ConfirmedPassword"
                               placeholder="تکرار رمز عبور را مطابق رمز عبور وارد کنید"><br>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" name="btn_register">ثبت اطلاعات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mttopLogin">
            <div class="card">
                <?php
                if (isset($_POST['btn_login'])) {

                    $sql = "SELECT * FROM register_tbl WHERE email=? AND password=?";
                    $database = new \classes\Database('root', '', 'ticket');
                    $checkLogin = $database->selection($sql, [$_POST['emailLogin'], md5($_POST['passwordLogin'])], 'fetch');
                    if ($checkLogin == true) {
                        if (isset($_POST['remember_me'])) {
                            setcookie('email', $_POST['emailLogin'], time() + (2 * 9 * 6));
                            setcookie('password', $_POST['passwordLogin'], time() + (2 * 9 * 6));
                        }
                        if (!isset($_POST['remember_me'])) {
                            setcookie('email', $_POST['emailLogin'], time() - (2 * 9 * 6));
                            setcookie('password', $_POST['passwordLogin'], time() - (2 * 9 * 6));
                        }
                        $_SESSION['UserLoggedIn'] = 'logged in';
                        $_SESSION['FirstName'] = $checkLogin->FirstName;
                        $_SESSION['LastName'] = $checkLogin->LastName;
                        @$_SESSION['phonenumber'] = $checkLogin->phone;
                        @$_SESSION['email'] = $checkLogin->email;
                        @$_SESSION['idUser'] = $checkLogin->ID;
                        header('location:pannel.php');
                    } else {
                        $error1 = 'ایمیل یا رمز عبور شما اشتباه است';
                    }
                }
                ?>
                <div class="card-header">ورود</div>
                <div class="card-body">
                    <?php
                    if (!empty($error1)) {
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $error1;
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <form method="post">
                        <label class="form-label">ایمیل</label>
                        <input type="text" class="form-control" name="emailLogin" value="<?php if (isset($_COOKIE['email'])) {echo $_COOKIE['email'];} ?>"
                               placeholder="ایمیل را وارد نمایید"><br>
                        <label class="form-label">رمز عبور</label>
                        <input type="password" class="form-control" name="passwordLogin" value="<?php if (isset($_COOKIE['password'])) {echo $_COOKIE['password'];} ?>"
                               placeholder="رمز عبور را وارد نمایید"><br>
                        <div class="form-check form-switch mt-2">
                            <input type="checkbox" class="form-check-input" name="remember_me" <?php if (isset($_COOKIE['email'])) {echo 'checked';} ?>>
                            <label class="form-check-label" style="margin-top: 4px">مرا به خاطر بسپار</label>
                        </div>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-danger" name="btn_login">ورود</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="asset/bootstrap/js/bootstrap.bundle.js"></script>
<?php

?>
</body>
</html>
<?php
session_start();
require_once __DIR__.DIRECTORY_SEPARATOR.'../time/jdf.php';
date_default_timezone_set('Asia/Tehran');
require_once __DIR__.DIRECTORY_SEPARATOR.'../../autoload.php';
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="../stylesheet/style.css">
</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg bg-secondary navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">پروژه تیکت</a>
        </button>
        <div class="d-flex">
            <ul class="text-white fs-7">
                <?php
                if (!isset($_SESSION['UserLoggedIn'])) {
                    echo 'برای ورود ابتدا لاگین کنید';
                } else {
                    echo $_SESSION['FirstName'].' '.$_SESSION['LastName'].' ';
                    echo '<a href="../../../Zicco/exit.php" class="btn btn-danger">خروج از سایت</a>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<script src="../bootstrap/js/bootstrap.bundle.js"></script>

</body>
</html>

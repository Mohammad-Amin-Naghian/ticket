<?php
require_once 'asset/common/header.php';
require_once 'asset/common/footer.php';
if (!isset($_SESSION['UserLoggedIn'])) {
    header('location:index.php');
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
    <title>تیکت ها</title>
    <link rel="stylesheet" href="asset/stylesheet/style.css">
</head>
<body>
<br><br>
<br><br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 mx-auto">
            <div class="card">
                <div class="card-header">لیست تیکت های موجود - ارسال تیکت
                <span class="float-end">
                    <?php
                    echo $_SESSION['email'];
                    ?>
                </span>

                </div>
                <div class="card-body">
                    <table class="table table-hover ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان درخواست</th>
                            <th>وضعیت تیکت</th>
                            <th>دسته بندی</th>
                            <th>وضعیت پاسخ دهی</th>
                            <th>مشاهده تیکت</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $database = new \classes\Database('root', '', 'ticket');
                        if ($_SESSION['email'] == 'asbina.app') {
                            $sql = "SELECT * FROM ticket_tbl";
                            $data = $database->selection($sql);
                        } else {
                            $sql = "SELECT * FROM ticket_tbl WHERE iduser=?";
                            $data = $database->selection($sql, [$_SESSION['idUser']]);
                        }
                        ?>

                        <?php
                        if (!empty($data)) {
                            foreach ($data as $key => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $value->ticket_title; ?></td>
                                    <td>
                                        <?php
                                        if ($value->statusTicket == 1 ) {
                                            echo '<span class="text-success">فعال</span>';
                                        }
                                        if ($value->statusTicket == 0 ) {
                                            echo '<span class="text-danger">غیرفعال</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($value->category == 1) {
                                            echo 'فنی';
                                        }
                                        if ($value->category == 2) {
                                            echo 'مالی';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($value->status == 0) {
                                            echo '<span class="text-danger">پاسخ داده نشده است</span>';
                                        }
                                        if ($value->status == 1) {
                                            echo '<span class="text-success">پاسخ داده شده است</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><a href="<?php echo 'listTicket.php?id=' . $value->ID ?>"
                                           class="btn btn-primary">مشاهده تیکت</a></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<div class="alert alert-warning">هیچ تیکتی برای نمایش وجود ندارد</div>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                if ($_SESSION['email'] != 'asbina.app') {
                ?>
                <div class="card-footer">
                    <div class="d-grid">
                        <a href="NewTicket.php" class="btn btn-success">ارسال تیکت جدید</a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script src="asset/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

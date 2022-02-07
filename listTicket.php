<?php
require_once 'asset/common/header.php';
$database = new \classes\Database('root', '', 'ticket');
if (isset($_GET['id']) && empty($_GET['id'])) {
    header('location:pannel.php');
}
$sql_table = 'SELECT * FROM ticket_tbl WHERE ID=?';
$data1 = $database->selection($sql_table, [$_GET['id']], 'fetch');
$status_ticket = $data1->statusTicket;
if ($status_ticket == 0 && $_SESSION['email'] != 'asbina.app') {
    header('location:pannel.php');
}
$sql = "SELECT * FROM ticket_tbl WHERE ID=?";
$data = $database->selection($sql, [$_GET['id']], 'fetch');

if (isset($_POST['btn_send_ticket'])) {
    $sql = 'INSERT INTO answerticket(idTicket,content,fname,lname,title) VALUES (?,?,?,?,?)';
    $database->doing($sql, [$_GET['id'], $_POST['comments'], $_SESSION['FirstName'], $_SESSION['LastName'], $data->ticket_title], 'insert');

    if ($_SESSION['email'] == "asbina.app") {
        $sql_update = 'UPDATE ticket_tbl SET status=? WHERE ID=?';
        $update_answer = $database->selection($sql_update, [1, $_GET['id']]);
    } else {
        $sql_update = 'UPDATE ticket_tbl SET status=? WHERE ID=?';
        $update_answer = $database->selection($sql_update, [0, $_GET['id']]);
    }
}
if (isset($_POST['btn_close_ticket'])) {
    $sql = 'UPDATE ticket_tbl SET statusTicket=? WHERE ID=?';
    $SQL_update = $database->doing($sql, [0, $_GET['id']]);
    header('location:pannel.php');
}
if (isset($_POST['btn_enable_ticket'])) {
    $sql = 'UPDATE ticket_tbl SET statusTicket=? WHERE ID=?';
    $SQL_update = $database->doing($sql, [1, $_GET['id']]);
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
    <link rel="stylesheet" href="asset/stylesheet/style.css">
</head>
<body>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <br><br>
            <div class="card">
                <div class="card-header">
                    <?php
                    echo $data->ticket_title;
                    ?>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <label class="form-label">پبام خود را وارد کنید</label>
                        <textarea name="comments" rows="5" class="form-control"></textarea>
                        <br>
                        <div class="d-grid">
                            <button type="submit" name="btn_send_ticket" class="btn btn-primary">ارسال تیکت</button>
                            <br>
                            <?php
                            if ($_SESSION['email'] == 'asbina.app') {
                            ?>
                            <button type="submit" name="btn_close_ticket" class="btn btn-warning">بستن تیکت</button>
                            <br>
                            <button type="submit" name="btn_enable_ticket" class="btn btn-success">فعال کردن تیکت
                            </button>
                            <?php
                            }
                            ?>
                        </div>
                    </form>

                    <br>

                    <ul class="list-group">
                        <?php
                        if ($_SESSION['idUser'] !=17) {
                        ?>
                        <li class="list-group-item"><span
                                    class="badge float-end bg-danger">1</span>
                            <?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] . ' ' . 'گفته : '; ?>
                        </li>
                        <?php
                        }
                        ?>
                        <li class="list-group-item"><p><?php echo $data->comment; ?></p></li>
                    </ul>
                    <?php
                    $sqls = 'SELECT * FROM answerticket WHERE idTicket=?';
                    $datas = $database->selection($sqls, [$_GET['id']], 'fetchall');
                    $number = 2;
                    if (!empty($datas)) {
                    foreach ($datas as $value) {
                        ?>
                        <ul class="list-group p-2">
                            <li class="list-group-item"><span
                                        class="badge float-end bg-danger"><?php echo $number++; ?></span><?php echo $value->fname . ' ' . $value->lname . ' ' . 'گفته'; ?>
                            </li>
                            <li class="list-group-item lh-base"><p><?php echo $value->content; ?></p></li>
                            <li class="list-group-item lh-base">
                                <?php
                                $time = $value->time;
                                $convert = new \classes\helical();
                                $shams = $convert->convert($time);
                                echo 'ارسال : '.$shams;
                                ?>
                            </li>
                        </ul>
                    <?php }
                    }?>
                </div>
                <div class="card-footer">
                    <div class="d-grid">
                        <a href="pannel.php" class="btn btn-info">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace('comments');
</script>
<script src="asset/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>
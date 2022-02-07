<?php
require_once 'asset/common/header.php';
require_once 'asset/common/footer.php';
$database = new \classes\Database('root', '', 'ticket');
if (isset($_POST['btn_sendTicket'])) {
    $filename = $_FILES['files']['name'];
    $tmp_name = $_FILES['files']['tmp_name'];
    $explode = explode('.',$filename);
    $extension = end($explode);
    if (in_array($extension,['png','jpg','jpeg',''])) {
        $randname = rand(0,4545).'_'.rand(4,787).'.'.$extension;
        move_uploaded_file($tmp_name,'image/'.$randname);
        $sql = "INSERT INTO ticket_tbl(ticket_title,category,comment,file_img,iduser,email) VALUES (?,?,?,?,?,?)";
        $database->selection($sql,[$_POST['ticket_title'],$_POST['category'],$_POST['comment'],$randname,$_SESSION['idUser'],$_SESSION['email']]);
        $message = 'تیکت شما با موفقیت ثبت شد';
    } else {
        $messageError = 'پسوند شما غیر مجاز است';
    }
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
    <title>افزودن تیکت</title>
    <link rel="stylesheet" href="asset/stylesheet/style.css">

</head>
<body>
<br><br><br>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="card">

                <div class="card-header">افزودن تیکت</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        if (!empty($message)) {
                            ?>
                            <div class="alert alert-success">
                                <?PHP
                                echo $message;
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($messageError)) {
                        ?>
                        <div class="alert alert-warning">
                            <?php echo $messageError; ?>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="mt-3 p-2">
                            <label class="form-label">عنوان تیکت</label>
                            <input type="text" placeholder="عنوان تیکت را وارد کنید" name="ticket_title"
                                   class="form-control">
                        </div>
                        <div class="mt-3 p-2">
                            <select name="category" class="form-select" aria-label="Default select example">
                                <option selected>انتخاب دسته بندی</option>
                                <option value="1">فنی</option>
                                <option value="2">مالی</option>
                            </select>
                        </div>
                        <div class="mt-3 p-2">
                            <label class="form-label">توضیحات</label>
                            <textarea name="comment" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="mt-3 p-2">
                            <label for="choose_file" class="form-label btn btn-warning"> اننخاب فایل</label>
                            <input type="file" id="choose_file" class="form-control" name="files"
                                   style="display: none;">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger" name="btn_sendTicket">ارسال تیکت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace('comment');
</script>
</body>
</html>

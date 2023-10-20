<?php
    session_start();
        $id = $_SESSION['id'];
        echo "<script>alert(".$_SESSION['id'].");</script>";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $.ajax({
        'url':'/nhom-F-web-security/delete_user.php?id='+<?php echo $id ?>,
        'type':'post',
        success: function (response) {
        // Xử lý phản hồi từ máy chủ nếu cần
        // Chuyển người dùng đến trang "delete_user.php" sau khi xử lý thành công
        window.location.href = '/nhom-F-web-security/list_users.php';   
    },
    error: function () {
        // Xử lý lỗi nếu có
        window.location.href = '/nhom-F-web-security/list_users.php';
    }
    });
    </script>
</body>
</html>
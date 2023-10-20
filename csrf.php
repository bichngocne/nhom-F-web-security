<?php
    session_start();
        $id = $_SESSION['id'];
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
                window.location.href ='/nhom-F-web-security/delete_user.php?id='+<?php echo $id ?>;
            },
    });
    </script>
</body>
</html>
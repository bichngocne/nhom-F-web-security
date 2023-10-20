<?php
session_start();
if(!empty($_GET['id']))
{
    $id = $_SESSION['id'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Click Image Form</title>
</head>

<body>
    <form method="post" action="delete_user.php" style="display: grid;justify-items: center;">

        <!-- Hình ảnh nhấp vào -->
        <div><img src="../nhom-F-web-security/public/images/cat.jpg" alt="Hacker Image" style="max-width: 300px; max-height: 200px;"></div>
        
        <div><input type="submit" value="mời bạn click vàoooo" onclick="submitForm()"></div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function submitForm() {
        // Lấy giá trị id từ session PHP và sử dụng nó trong mã JavaScript
        // var id = <?php echo json_encode($_SESSION['id']); ?>;
        // alert(id);

        // Gửi yêu cầu AJAX với id được truyền vào
        $.ajax({
            url: '/nhom-F-web-security/delete_user.php?id=' + id,
            type: 'post',
            success: function (response) {
                // Xử lý phản hồi từ máy chủ nếu cần
                alert('Request successful');
            },
            error: function () {
                // Xử lý lỗi nếu có
                alert('Error');
            }
        });
    }
    </script>
</body>

</html>
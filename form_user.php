<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;

if (!empty($_GET['id'])) {
    $_id = $_GET['id'];
    $user = $userModel->findUserById($_id);//Update existing user
}


if (!empty($_POST['submit'])) {

    // Lấy phiên bản hiện tại của dữ liệu từ cơ sở dữ liệu
    $currentVersion = $userModel->getCurrentVersion($_id);
    echo $currentVersion;
    if (!empty($_id)) {
    // Kiểm tra phiên bản của người dùng với phiên bản hiện tại
        if ($_POST['version'] === $currentVersion) {
        //     // Phiên bản trùng khớp, có thể cập nhật dữ liệu
            $userModel->updateUser($_POST);
            header('location: list_users.php');

        } else {
            // Phiên bản khác nhau, dữ liệu đã bị thay đổi bởi người khác
            // Hiển thị thông báo cho người dùng và cho họ quyết định tiếp theo
            echo '<script>alert("Dữ liệu đã bị thay đổi bởi người khác. Vui lòng thử lại?");</script>';
        }
   
    } else {
        $userModel->insertUser($_POST);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($user || !isset($_id)) { ?>
                <div class="alert alert-warning" role="alert">
                    User form
                </div>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $_id ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($user[0]['name'])) echo $user[0]['name'] ?>'>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                            <!-- Trường ẩn để lưu phiên bản của dữ liệu -->
                        <input type="hidden" name="version" value="<?php echo $user[0]['version'] ?>">
                    </div>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>
</body>
</html>
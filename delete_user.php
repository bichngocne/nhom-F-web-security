<?php
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$id = NULL;
// Kiểm tra xem có yêu cầu DELETE hợp lệ không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    // Lấy dữ liệu từ POST
    $id = $_POST['id'];

    // Xóa người dùng bằng SQL prepared statement
    $userModel->deleteUserById($id);

    // Chuyển hướng người dùng đến trang danh sách người dùng sau khi xóa
    header('Location: list_users.php');
    exit;
} else {
    // Yêu cầu không hợp lệ, xử lý hoặc từ chối nó
    echo '<script>alert("Invalid request.")</script>';
    die();
}
?>
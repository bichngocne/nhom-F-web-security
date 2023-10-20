<?php
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();
$user = NULL; //Add new user
$id = NULL;
if (isset($_POST['csrf_token']) && isset($_SESSION['csrf_token'])) {
    // Kiểm tra xem có yêu cầu DELETE hợp lệ không
    if (!empty($_POST['id']) && isset($_POST['csrf_token']) === isset($_SESSION['csrf_token'])) {
        // Lấy dữ liệu từ POST
        $id = $_POST['id'];

        // Xóa người dùng bằng SQL prepared statement
        $userModel->deleteUserById($id);

        // Chuyển hướng người dùng đến trang danh sách người dùng sau khi xóa
        header('Location: list_users.php');
        exit;
    } else {
        // Yêu cầu không hợp lệ, xử lý hoặc từ chối nó
        echo '<script>alert("Không thành công.")</script>';
        die();
    }
}
else {
    // Yêu cầu không hợp lệ, xử lý hoặc từ chối nó
    echo '<script>alert("attack CSRF")</script>';
    echo '<script>window.location.href ="http://localhost:82/nhom-F-web-security/list_users.php";</script>';
}
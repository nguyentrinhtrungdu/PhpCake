<?php
include "connect.php";

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$num = isset($_POST['num']) ? $_POST['num'] : '';

// Debug: Ghi giá trị nhận được vào log
error_log("ID: " . $id);
error_log("Username: " . $username);
error_log("Email: " . $email);
error_log("Pass: " . $pass);
error_log("Num: " . $num);

if ($id <= 0) {
    $arr = [
        'success' => false,
        'message' => 'ID không hợp lệ',
        'result' => []
    ];
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

$query = "UPDATE `user` SET `username` = ?, `email` = ?, `pass` = ?, `num` = ? WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $username, $email, $pass, $num, $id);

if ($stmt->execute()) {
    $arr = [
        'success' => true,
        'message' => 'Cập nhật thành công',
        'result' => []
    ];
} else {
    $arr = [
        'success' => false,
        'message' => 'Cập nhật không thành công: ' . $stmt->error,
        'result' => []
    ];
}

header('Content-Type: application/json');
echo json_encode($arr);

$stmt->close();
$conn->close();
?>

<?php
include "connect.php";

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $arr = [
        'success' => false,
        'message' => 'ID không hợp lệ',
        'result' => []
    ];
    echo json_encode($arr);
    exit();
}

$query = "SELECT * FROM `user` WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$arr = [
    'success' => !empty($user),
    'message' => !empty($user) ? 'Thành công' : 'Không tìm thấy người dùng',
    'result' => !empty($user) ? [$user] : [] // Đóng gói vào danh sách
];

echo json_encode($arr);

$stmt->close();
$conn->close();

?>

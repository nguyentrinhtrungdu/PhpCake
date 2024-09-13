<?php
include "connect.php";

// Nhận ID từ yêu cầu GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Debug: Ghi giá trị nhận được vào log (dùng cho debug)
error_log("Received ID: " . $id);

if ($id <= 0) {
    // Phản hồi nếu ID không hợp lệ
    $arr = [
        'success' => false,
        'message' => 'ID không hợp lệ',
        'result' => []
    ];
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

// Chuẩn bị câu lệnh truy vấn để xóa sản phẩm khỏi cơ sở dữ liệu
$query = "DELETE FROM `sanphammoi` WHERE `id` = ?";
$stmt = $conn->prepare($query);

// Kiểm tra xem truy vấn có được chuẩn bị thành công không
if ($stmt === false) {
    $arr = [
        'success' => false,
        'message' => 'Chuẩn bị truy vấn thất bại: ' . $conn->error,
        'result' => []
    ];
    header('Content-Type: application/json');
    echo json_encode($arr);
    exit();
}

// Gán giá trị ID vào câu lệnh truy vấn
$stmt->bind_param("i", $id);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    // Kiểm tra nếu không có dòng nào bị ảnh hưởng (nghĩa là ID không tồn tại)
    if ($stmt->affected_rows > 0) {
        $arr = [
            'success' => true,
            'message' => 'Xóa loại sản phẩm thành công',
            'result' => []
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'Không tìm thấy loại sản phẩm với ID đã cung cấp',
            'result' => []
        ];
    }
} else {
    // Phản hồi nếu việc thực thi truy vấn thất bại
    $arr = [
        'success' => false,
        'message' => 'Xóa loại sản phẩm không thành công: ' . $stmt->error,
        'result' => []
    ];
}

// Phản hồi kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($arr);

// Đóng kết nối
$stmt->close();
$conn->close();
?>

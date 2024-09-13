<?php
include "connect.php";

// Nhận dữ liệu từ yêu cầu POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$tensp = isset($_POST['tensp']) ? $_POST['tensp'] : '';
$hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';
$mota = isset($_POST['mota']) ? $_POST['mota'] : '';
$giasp = isset($_POST['giasp']) ? floatval($_POST['giasp']) : 0.0;
$loai = isset($_POST['loai']) ? intval($_POST['loai']) : 0;

// Debug: Ghi giá trị nhận được vào log
error_log("Received ID: " . $id);
error_log("Received Name: " . $tensp);
error_log("Received Image: " . $hinhanh);
error_log("Received Description: " . $mota);
error_log("Received Price: " . $giasp);
error_log("Received Category ID: " . $loai);

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

// Chuẩn bị câu lệnh truy vấn để cập nhật thông tin sản phẩm
$query = "UPDATE `sanphammoi` SET `tensp` = ?, `hinhanh` = ?, `mota` = ?, `giasp` = ?, `loai` = ? WHERE `id` = ?";
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

// Gán giá trị vào câu lệnh truy vấn
$stmt->bind_param("sssiii", $tensp, $hinhanh, $mota, $giasp, $loai, $id);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    // Kiểm tra nếu không có dòng nào bị ảnh hưởng (nghĩa là ID không tồn tại)
    if ($stmt->affected_rows > 0) {
        $arr = [
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công',
            'result' => []
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm với ID đã cung cấp',
            'result' => []
        ];
    }
} else {
    // Phản hồi nếu việc thực thi truy vấn thất bại
    $arr = [
        'success' => false,
        'message' => 'Cập nhật sản phẩm không thành công: ' . $stmt->error,
        'result' => []
    ];
}

// Phản hồi kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($arr);

// Đóng kết nối
$stmt->close();
$conn->close();

<?php
include "connect.php";

// Nhận từ khóa tìm kiếm từ POST request
$search = $_POST['search'] ?? '';

// Khởi tạo mảng phản hồi
$arr = [];

// Kiểm tra nếu từ khóa tìm kiếm không rỗng
if (!empty($search)) {
    // Xử lý từ khóa tìm kiếm để ngăn ngừa SQL injection
    $search = mysqli_real_escape_string($conn, $search);

    // Câu lệnh SQL tìm kiếm
    $query = "SELECT * FROM `sanphammoi` WHERE `tensp` LIKE '%$search%'";
    $data = mysqli_query($conn, $query);

    // Khởi tạo mảng kết quả
    $result = array();
    while ($row = mysqli_fetch_assoc($data)) {
        $result[] = $row;
    }

    // Kiểm tra nếu có kết quả
    if (!empty($result)) {
        // Trả về kết quả tìm kiếm
        $arr = [
            'success' => true,
            'message' => "Tìm kiếm thành công",
            'result' => $result
        ];
    } else {
        // Không có kết quả tìm kiếm
        $arr = [
            'success' => false,
            'message' => "Không có sản phẩm tìm kiếm"
        ];
    }
} else {
    // Không có từ khóa tìm kiếm
    $arr = [
        'success' => false,
        'message' => "Vui lòng nhập từ khóa tìm kiếm"
    ];
}

// Đặt tiêu đề và xuất JSON
header('Content-Type: application/json');
echo json_encode($arr);

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<?php
include "connect.php";

// Thiết lập header trả về dạng JSON
header('Content-Type: application/json');

// Kiểm tra xem ID có được cung cấp không
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Chuẩn bị câu truy vấn
    $query = "SELECT * FROM `sanphammoi` WHERE id = ?";

    // Chuẩn bị và thực thi câu truy vấn
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Lấy dữ liệu
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $arr = [
                'success' => true,
                'message' => "Thành công",
                'product' => $product
            ];
        } else {
            $arr = [
                'success' => false,
                'message' => "Không tìm thấy sản phẩm",
                'product' => null
            ];
        }
        
        $stmt->close();
    } else {
        $arr = [
            'success' => false,
            'message' => "Lỗi thực thi câu truy vấn",
            'product' => null
        ];
    }
    
    $conn->close();
    // Xuất chuỗi JSON
    echo json_encode($arr);
} else {
    $arr = [
        'success' => false,
        'message' => "ID sản phẩm không được cung cấp",
        'product' => null
    ];
    // Xuất chuỗi JSON
    echo json_encode($arr);
}
?>

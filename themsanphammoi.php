<?php 
include "connect.php";

// Get POST data
$tensp = isset($_POST['tensp']) ? $_POST['tensp'] : '';
$hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';
$mota = isset($_POST['mota']) ? $_POST['mota'] : '';
$loai = isset($_POST['loai']) ? $_POST['loai'] : 0;
$giasp = isset($_POST['giasp']) ? $_POST['giasp'] : 0;

// Validate required fields
if (empty($tensp) || empty($hinhanh) || empty($mota) || empty($loai) || empty($giasp)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Insert new product into the database
$query = "INSERT INTO sanphammoi (tensp, hinhanh, mota, loai, giasp) VALUES ('$tensp', '$hinhanh', '$mota', $loai, $giasp)";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add product.']);
}
?>
    
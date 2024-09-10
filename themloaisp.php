<?php 
include "connect.php";

// Get POST data
$tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
$hinhanh = isset($_POST['hinhanh']) ? $_POST['hinhanh'] : '';

// Validate required fields
if (empty($tensanpham) || empty($hinhanh)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Prepare and execute the SQL query to insert a new category
$query = "INSERT INTO sanpham (tensanpham, hinhanh) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $tensanpham, $hinhanh);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Category added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add category.']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

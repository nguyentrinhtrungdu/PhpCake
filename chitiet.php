<?php 
include "connect.php";




$page = isset($_POST['page']) ? $_POST['page'] : 1;
$loai = isset($_POST['loai']) ? $_POST['loai'] : '';

$total = 5;
$pos = ($page - 1) * $total;

$query = "SELECT * FROM `sanphammoi` WHERE `loai` = '$loai' LIMIT $pos, $total";


$data = mysqli_query($conn, $query);
$result = array();

while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
}

$arr = [
    'success' => !empty($result),
    'message' => !empty($result) ? "thành công" : "không thành công",
    'result' => $result
];

header('Content-Type: application/json');
echo json_encode($arr);
?>
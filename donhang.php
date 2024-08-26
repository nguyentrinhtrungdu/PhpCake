<?php 
include "connect.php";

$email = $_POST['email'] ?? '';
$num = $_POST['num'] ?? '';
$tongtien = $_POST['tongtien'] ?? '';
$iduser = $_POST['iduser'] ?? '';
$diachi = $_POST['diachi'] ?? '';
$soluong = $_POST['soluong'] ?? '';
$chitiet = $_POST['chitiet'] ?? '';

// Chèn dữ liệu vào bảng donhang
$query = "INSERT INTO `donhang` (`iduser`, `num`, `diachi`, `email`, `soluong`, `tongtien`) 
          VALUES ('$iduser', '$num', '$diachi', '$email', '$soluong', '$tongtien')";

$data = mysqli_query($conn, $query);

if ($data) {
    // Lấy ID đơn hàng vừa chèn
    $query = "SELECT id AS iddonhang FROM `donhang` WHERE `iduser` = '$iduser' ORDER BY id DESC LIMIT 1";
    $data = mysqli_query($conn, $query);
    
    if ($data) {
        $row = mysqli_fetch_assoc($data);
        $iddonhang = $row['iddonhang'];
        
        if(!empty($iddonhang)){
            $chitiet = json_decode($chitiet, true);
            foreach($chitiet as $value) {
                $truyvan = "INSERT INTO `chitietdonhang`(`iddonhang`, `idsp`, `soluong`, `gia`) 
                            VALUES ('$iddonhang', '{$value['idsp']}', '{$value['soluong']}', '{$value['giasp']}')";
                mysqli_query($conn, $truyvan);
            }

            $arr = [
                'success' => true,
                'message' => "Thành công",
            ];
        }
    }
} else {
    $arr = [
        'success' => false,
        'message' => "Thêm đơn hàng thất bại",
    ];
}

header('Content-Type: application/json');
echo json_encode($arr);
?>

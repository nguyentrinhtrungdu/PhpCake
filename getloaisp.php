<?php 
include "connect.php";

// Correct the query
$query = "SELECT * FROM `sanpham`";

// Execute the query
$data = mysqli_query($conn, $query);
$result = array();

// Check if the query was successful
    while ($row = mysqli_fetch_assoc($data)) {
        $result[] = $row;
    }

    if(!empty($result)) {
        $arr = [
            'success' => true,
            'message' => "thanh cong",
            'result' => $result
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "khong thanh cong",
            'result' => $result
        ];
    }



// Return the JSON response
print_r(json_encode($arr));
?>

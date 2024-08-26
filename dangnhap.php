<?php
include "connect.php";

// Retrieve form data from POST request
$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';

// Check if both fields are set
if(empty($email) || empty($pass)) {
    $arr = [
        'success' => false,
        'message' => "Both email and password are required."
    ];
} else {
    // Prepare and execute the query to find the user
    $query = 'SELECT * FROM `user` WHERE `email`="'.mysqli_real_escape_string($conn, $email).'" AND `pass`="'.mysqli_real_escape_string($conn, $pass).'"';
    $data = mysqli_query($conn, $query);
    
    $result = array();
    while($row = mysqli_fetch_assoc($data)){
        $result[] = $row;
    }

    if(!empty($result)){
        $arr = [
            'success' => true,
            'message' => "Login successful.",
            'result' => $result
        ];
    } else {
        $arr = [
            'success' => false,
            'message' => "Email or password incorrect.",
            'result' => $result
        ];
    }
}

// Return response as JSON
echo json_encode($arr);
?>

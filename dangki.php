<?php
include "connect.php";

// Retrieve form data from POST request
$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';
$username = $_POST['username'] ?? '';
$num = $_POST['num'] ?? '';

// Check if all fields are set
if(empty($email) || empty($pass) || empty($username) || empty($num)) {
    $arr = [
        'success' => false,
        'message' => "All fields are required."
    ];
} else {
    // Check if email already exists
    $query = 'SELECT * FROM `user` WHERE `email` = "'.mysqli_real_escape_string($conn, $email).'"';
    $result = mysqli_query($conn, $query);
    $numrow = mysqli_num_rows($result);

    if($numrow > 0) {
        $arr = [
            'success' => false,
            'message' => "Email already exists.",
        ];
    } else {
        // Proceed with the insert query
        $query = 'INSERT INTO `user`(`username`, `email`, `pass`, `num`) 
                  VALUES ("'.mysqli_real_escape_string($conn, $username).'", "'.mysqli_real_escape_string($conn, $email).'", "'.mysqli_real_escape_string($conn, $pass).'", "'.mysqli_real_escape_string($conn, $num).'")';
        $result = mysqli_query($conn, $query);

        if($result) {
            $arr = [
                'success' => true,
                'message' => "User registered successfully.",
            ];
        } else {
            $arr = [
                'success' => false,
                'message' => "Registration failed: " . mysqli_error($conn),
            ];
        }
    }
}

// Return response as JSON
echo json_encode($arr);
?>

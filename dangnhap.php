<?php
include "connect.php";

// Retrieve form data from POST request
$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';

// Check if all fields are set
if(empty($email) || empty($pass)) {
    $arr = [
        'success' => false,
        'message' => "Email and password are required."
    ];
} else {
    // Prepare and execute the query to check credentials
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Query to get user data based on email
    $query = 'SELECT * FROM `user` WHERE `email` = "'.$email.'" AND `pass` = "'.$pass.'"';
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // User found, login successful
        $user = mysqli_fetch_assoc($result);
        $arr = [
            'success' => true,
            'message' => "Login successful.",
            'user' => [
                'username' => $user['username'],
                'email' => $user['email'],
                'num' => $user['num']
            ]
        ];
    } else {
        // Invalid credentials
        $arr = [
            'success' => false,
            'message' => "Invalid email or password."
        ];
    }
}

// Return response as JSON
echo json_encode($arr);
?>

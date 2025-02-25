<?php
session_start();
include('../dbconn/conn.php');

if (isset($_POST['login-btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pword']);

    // Query to retrieve user information
    $login_query = "SELECT user_id, fname, email, role, pword FROM users WHERE email='$email' LIMIT 1"; // Fetch hashed password
    $login_query_run = mysqli_query($conn, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $data = mysqli_fetch_assoc($login_query_run);
        $user_id = $data['user_id'];
        $fullname = $data['fname'];
        $role = $data['role'];
        $hashed_password = $data['pword'];

        // Debugging output
        error_log("User Role: " . $role); // Log the user role for debugging

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Storing user data in the session
            $_SESSION['auth'] = true;
            $_SESSION['auth_role'] = "$role"; // 0 is admin, 1 is user
            $_SESSION['auth_user'] = [
                'user_id' => $user_id,
                'fullname' => $fullname,
                'email' => $email,
            ];

            // Redirect based on role
            if ($_SESSION['auth_role'] == '0') {
                $_SESSION['message'] = "Login Successfully!";
                header("Location: ../admin/index.php");
                exit(0);
            } elseif ($_SESSION['auth_role'] == '1') {
                $_SESSION['message'] = "Welcome User";
                header("Location: ../user/index.php");
                exit(0);
            } else {
                $_SESSION['success'] = "Role not recognized.";
                header("Location: login.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Invalid email or password";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid email or password";
        header("Location: login.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "You are not allowed to access this";
    header("Location: login.php");
}
?>

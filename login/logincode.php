<?php
session_start();
include("../dbconn/conn.php");

if (isset($_POST['login-btn']) && !empty($_POST['email']) && !empty($_POST['pword'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pword']);

    $login_query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $login_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($data = mysqli_fetch_assoc($result)) {
        $hashed_password = $data['pword'];

        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true); 

            $_SESSION['auth'] = true;
            $_SESSION['auth_role'] = $data['role']; // 'superadmin', 'admin', 'superuser', 'user'
            $_SESSION['auth_user'] = [
                'user_id' => $data['user_id'],
                'user_name' => $data['fullname'],
                'user_email' => $data['email'],
            ];

            $_SESSION['message_ni'] = "Welcome " . $_SESSION['auth_user']['user_name'];

            switch ($_SESSION['auth_role']) {
                case 'superadmin':
                    header("Location: ../superadmin/index.php");
                    break;
                case 'admin':
                    header("Location: ../admin/index.php");
                    break;
                case 'superuser':
                    header("Location: ../superuser/index.php");
                    break;
                case 'user':
                    header("Location: ../normal_user/index.php");
                    break;
                default:
                    $_SESSION['message_ni'] = "Invalid user role";
                    header("Location: login.php");
                    break;
            }
            exit(0);
        }
    }
    $_SESSION['message_ni'] = "Invalid Email or Password";
} else {
    $_SESSION['message_ni'] = "Please fill in all fields";
}
header("Location: login.php");
exit(0);
?>

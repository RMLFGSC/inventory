<?php
session_start();
include("../dbconn/conn.php");




//start of fixed asset
// if (isset($_POST['addMR'])) {
//     $items = $_POST['item'];
//     $qtys = $_POST['qty'];
//     $serialNOs = $_POST['serialNO'];
    
//     $name = mysqli_real_escape_string($conn, $_POST['name']);
//     $department = mysqli_real_escape_string($conn, $_POST['department']);
    
//     // Convert arrays to JSON strings
//     $items_json = json_encode($items);
//     $qtys_json = json_encode($qtys);
//     $serialNOs_json = json_encode($serialNOs);
    
//     $query = "INSERT INTO fixed_asset (name, department, item, qty, serialNO) 
//               VALUES ('$name', '$department', '$items_json', '$qtys_json', '$serialNOs_json')";
    
//     mysqli_query($conn, $query);
    
//     header("Location: asset.php");
//     exit();
// }


//start stockin
if (isset($_POST['addStockin'])) {
    $controlNO = $_POST['controlNO'];
    $cat_name = $_POST['category'];
    $dop = $_POST['dop'];
    $dr = $_POST['dr'];
    $item_names = $_POST['item'];
    $qtys = $_POST['qty'];
    $warranties = isset($_POST['warranty']) ? $_POST['warranty'] : [];

    for ($i = 0; $i < count($item_names); $i++) {
        $item = mysqli_real_escape_string($conn, $item_names[$i]);
        $qty = intval($qtys[$i]);
        $warranty = in_array($i + 1, $warranties) ? 1 : 0; 

        $query = "INSERT INTO stockin (controlNO, item, category, qty, dop, dr, warranty) 
                  VALUES ('$controlNO', '$item', '$cat_name', '$qty', '$dop', '$dr', '$warranty')";
        
        $query_run = mysqli_query($conn, $query);

        if (!$query_run) {
            echo "Error: " . mysqli_error($conn);
        }
    }
    header("Location: stockin.php");
    exit();
}



//start of request

if (!isset($_SESSION['auth_user']['user_id'])) {
    die("Error: User is not logged in.");
}

if (isset($_POST['addRequest'])) {
    if (empty($_POST['stockin_id']) || empty($_POST['qty'])) {
        $_SESSION['message'] = "No items selected for the request.";
        header("Location: requisitions.php");
        exit();
    }   

    $user_id = $_SESSION['auth_user']['user_id']; 
    $req_number = mysqli_real_escape_string($conn, $_POST['req_number']);
    
    // Fetch user details
    $userQuery = "SELECT fullname, department FROM users WHERE user_id = '$user_id'";
    $user = mysqli_fetch_assoc(mysqli_query($conn, $userQuery));
    
    $department = $user['department'];

    $items = $_POST['stockin_id'];
    $qtys = $_POST['qty']; 
    $status = 0; 
    $date = date('Y-m-d'); 

    // Loop through items and insert into request
    foreach ($items as $index => $item) {
        $item = mysqli_real_escape_string($conn, $item);
        $qty = intval($qtys[$index]);

        // Check if the stockin item exists in the stockin table
        $checkQuery = "SELECT stockin_id FROM stockin WHERE stockin_id = '$item'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($stockinRow = mysqli_fetch_assoc($checkResult)) {
            // Insert each item with the same req_number
            $query = "INSERT INTO request (req_number, user_id, stockin_id, qty, department, date, status) 
                      VALUES ('$req_number', '$user_id', '{$stockinRow['stockin_id']}', '$qty', '$department', '$date', '$status')";
            
            if (!mysqli_query($conn, $query)) {
                echo "Error: " . mysqli_error($conn);
                exit(); 
            }
        } else {
            echo "Error: Stockin item '$item' does not exist.";
            exit(); 
        }
    }

    $_SESSION['toast_message'] = "Request Added Successfully";
    header("Location: requisitions.php");
    exit();
}


// if (isset($_POST['adduser'])) {
//     $fname = mysqli_real_escape_string($conn, $_POST['fullname']);
//     $pword = mysqli_real_escape_string($conn, $_POST['pword']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
//     $number = mysqli_real_escape_string($conn, $_POST['number']);
//     $department = mysqli_real_escape_string($conn, $_POST['department']);
//     $role = mysqli_real_escape_string($conn, $_POST['role']);

//     $hashed_password = password_hash($pword, PASSWORD_DEFAULT);

//     $query = "INSERT INTO users (fullname, pword, email, number, department, role) VALUES ('$fname', '$hashed_password', '$email', '$number', '$department', '$role')";
//     $query_run = mysqli_query($conn, $query);

//     if ($query_run) {
//         $_SESSION['message'] = "User added successfully!";
//         header("Location: users.php");

//         exit(0);
//     } else {
//         $_SESSION['message'] = "User not added!";
//         header("Location: users.php");
//         exit(0);
//     }
// }




?>
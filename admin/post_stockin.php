<?php
include("../dbconn/conn.php"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stockin_id = $_POST['stockin_id'];
    $is_posted = $_POST['is_posted'];

    $updateQuery = "UPDATE stock_in SET is_posted = ? WHERE stockin_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $is_posted, $stockin_id); 

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Stock-in updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating stock-in: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
include("../dbconn/conn.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the posted data
    $stockinId = $_POST['stockin_id']; // Assuming you are sending stockin_id
    $category = $_POST['category'];
    $dop = $_POST['dop']; // Date of Purchase
    $dr = $_POST['dr']; // Date Received
    $items = $_POST['item']; // Array of items
    $quantities = $_POST['qty']; // Array of quantities
    $warranties = isset($_POST['warranty']) ? $_POST['warranty'] : []; // Array of warranties

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Update the stock-in record
        $updateQuery = "UPDATE stockin SET category = ?, dop = ?, dr = ? WHERE stockin_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $category, $dop, $dr, $stockinId);
        $stmt->execute();

        // Delete existing items for this stockin_id
        $deleteQuery = "DELETE FROM stockin_items WHERE stockin_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $stockinId);
        $deleteStmt->execute();

        // Insert new items
        foreach ($items as $index => $item) {
            $qty = $quantities[$index];
            $warranty = in_array($index, $warranties) ? 1 : 0; // Check if warranty is set for this item

            $insertQuery = "INSERT INTO stockin_items (stockin_id, item_name, qty, warranty) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("isii", $stockinId, $item, $qty, $warranty);
            $insertStmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Stock-in data posted successfully!']);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error posting stock-in data: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?> 
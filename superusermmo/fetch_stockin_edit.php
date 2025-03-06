<?php
include("../dbconn/conn.php");

if (isset($_POST['controlNO'])) {
    $controlNo = $_POST['controlNO'];

    // Query to fetch all items associated with the controlNO for editing
    $query = "SELECT * FROM stockin WHERE controlNO = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $controlNo);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row; // Collect all items
    }

    // Return all items
    echo json_encode(['controlNO' => $controlNo, 'items' => $items]);

    $stmt->close();
} else {
    echo json_encode(['items' => []]); // Return empty if no controlNO
}

$conn->close();
?>
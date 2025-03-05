<?php
include("../dbconn/conn.php");

if (isset($_POST['req_number'])) {
    $req_number = $_POST['req_number'];

    // Query to fetch requisition details along with items from stockin
    $query = "SELECT r.req_number, r.date, u.fullname AS requester_name, u.department, 
                     s.item_name, ri.qty 
              FROM request r 
              JOIN users u ON r.user_id = u.user_id 
              JOIN request_items ri ON r.req_number = ri.req_number 
              JOIN stockin s ON ri.stockin_id = s.stockin_id 
              WHERE r.req_number = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $req_number); 
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row; 
        }
        
        // Return the requisition details
        echo json_encode([
            'req_number' => $row['req_number'],
            'date_requested' => $row['date'],
            'requester_name' => $row['requester_name'],
            'department' => $row['department'],
            'itemsHtml' => array_map(function($item) {
                return '<tr><td>' . htmlspecialchars($item['item_name']) . '</td><td>' . htmlspecialchars($item['qty']) . '</td></tr>';
            }, $items)
        ]);
    } else {
        echo json_encode([
            'req_number' => '',
            'date_requested' => '',
            'requester_name' => '',
            'department' => '',
            'itemsHtml' => []
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'req_number' => '',
        'date_requested' => '',
        'requester_name' => '',
        'department' => '',
        'itemsHtml' => []
    ]);
}

$conn->close();
?>

<?php
include("../dbconn/conn.php"); 

if (isset($_POST['req_number'])) {
    $req_number = $_POST['req_number'];

    $query = "SELECT e.equip_name, r.qty FROM request r JOIN equipment e ON r.equipment_id = e.equipment_id WHERE r.req_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $req_number); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['equip_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['qty']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No items found for this requisition.</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='2'>Invalid requisition number.</td></tr>";
}

$conn->close();
?>

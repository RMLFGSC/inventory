<?php
include("../dbconn/conn.php");

// Check if control number is set in the POST request
if (isset($_POST['controlNO'])) {
    $controlNO = $_POST['controlNO'];

    $query = "SELECT * FROM stockin  
              WHERE controlNO = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $controlNO);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($controlNO) . "</td>
                <td>" . htmlspecialchars($row['item']) . "</td>
                <td>" . htmlspecialchars($row['qty']) . "</td>
                <td>" . htmlspecialchars($row['category']) . "</td>
                <td>" . htmlspecialchars($row['dop']) . "</td>
                <td>" . htmlspecialchars($row['dr']) . "</td>
                <td>" . ($row['warranty'] ? 'Yes' : 'No') . "</td>
              </tr>";
    }

    mysqli_stmt_close($stmt);
}


if (isset($_POST['req_number'])) {
    $reqNO = $_POST['req_number'];

    $query = "SELECT * FROM request WHERE req_number = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $reqNO);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($reqNO) . "</td>
                <td>" . htmlspecialchars($row['items']) . "</td>
                <td>" . htmlspecialchars($row['qty']) . "</td>
                <td>" . htmlspecialchars($row['status']) . "</td>
              </tr>";
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST['stockin_id'])) {
    $stockinId = $_POST['stockin_id'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM stockin WHERE stockin_id = ?");
    $stmt->bind_param("i", $stockinId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $stockinData = $result->fetch_assoc();
        echo json_encode($stockinData); // Return the data as JSON
    } else {
        echo json_encode([]); // Return an empty array if no data found
    }

    $stmt->close();
}
$conn->close();
?>
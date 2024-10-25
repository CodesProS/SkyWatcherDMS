<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); // Ensure the response is JSON

// Database connection settings (adjust as necessary)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skywatcher";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action) {
    if ($action === 'country') {
        $sql = "SELECT * FROM country";  
    } elseif ($action === 'city') {
        $sql = "SELECT * FROM city";  
    }
    elseif ($action === 'weatherd') {
        $sql = "SELECT * FROM weatherdetails";  
    }
    elseif ($action === 'forecasts') {
        $sql = "SELECT * FROM forecasts";  
    }
    elseif ($action === 'users') {
        $sql = "SELECT * FROM login";  
    }
    elseif ($action === 'conditions') {
        $sql = "SELECT * FROM conditions";  
    }
    elseif ($action === 'alerts') {
        $sql = "SELECT * FROM alerts";  
    }
    else {
        echo json_encode(["error" => "Invalid action."]);
        exit();
    }

    // Execute the query and fetch the result
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch all rows as an associative array
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);  // Return the result as JSON
    } else {
        echo json_encode(["error" => "No records found."]);
    }
} else {
    echo json_encode(["error" => "No action specified."]);
}

$conn->close();
?>

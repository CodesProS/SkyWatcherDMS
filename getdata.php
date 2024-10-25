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
        $sql = "SELECT CountryName, CountryID FROM country";  
    } elseif ($action === 'city') {
        $countryid = intval($_GET['countryid']);
        $sql = "SELECT CityName, CityID FROM city where CountryID = $countryid";  
    }
    elseif ($action === 'date')
    {
        $cityid = intval($_GET['cityid']);
        $sql = "SELECT FDate AS CDate FROM forecasts WHERE CityID = $cityid UNION SELECT WDate AS CDate FROM weatherrecords WHERE CityID = $cityid";
    } 
    elseif ($action === 'weatherrec')
    {
        $cityid = intval($_GET['cityid']);
        $dates = $_GET['dates'];
        $dates = mysqli_real_escape_string($conn, $dates);
        $sql = "SELECT w.WeatherID, f.ForescastID FROM weatherrecords w 
        LEFT JOIN forecasts f ON f.FDate = w.WDate 
        WHERE w.WDate = '$dates' AND w.CityID = $cityid";

       // $sql = "SELECT ForescastID FROM forecasts f";
    }
    elseif ($action == 'weatherdetails')
    {
        $weatherid = intval($_GET['weatherid']);
        $sql = "SELECT w.WeatherID,w.Temperature, w.WindSpeed, w.Humidity, w.Cloudiness, w.Visibility, w.Pressure, c.ConditionType, c.Summary, c.iconcode
        FROM weatherdetails w
        LEFT JOIN conditions c on c.ConditionID = w.ConditionID
        WHERE w.WeatherID = $weatherid 
        ";
    }
    elseif ($action == 'forecasts')
    {
        $forecastid = intval($_GET['forecastid']);
        $sql = "SELECT * from forecasts where ForescastID = $forecastid";
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

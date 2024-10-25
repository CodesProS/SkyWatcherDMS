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
        $sql = "SELECT DISTINCT FDate AS CDate FROM forecasts WHERE CityID = $cityid";
    } 
    elseif ($action === 'weatherrec')
    {
        $cityid = intval($_GET['cityid']);
        $dates = $_GET['dates'];
        $dates = mysqli_real_escape_string($conn, $dates);
        $sql = "SELECT f.ForescastID, f.WeatherID, f.Time, w.Temperature, w.WindSpeed, w.Humidity, w.Cloudiness, w.Visibility, w.Pressure, c.ConditionType, c.Summary, c.iconcode  FROM forecasts f 
        INNER JOIN weatherdetails w on w.WeatherID = f.WeatherID
        INNER JOIN conditions c on c.ConditionID = w.ConditionID
        WHERE f.FDate = '$dates' AND f.CityID = $cityid";
    }
    elseif ($action === 'averagedata')
    {
        $cityid = intval($_GET['cityid']);
        $dates = $_GET['dates'];
        $dates = mysqli_real_escape_string($conn, $dates);
        $sql = "SELECT AVG(w.Temperature) as Avgtemp, AVG(w.WindSpeed) as Avgwind, AVG(w.Humidity) as Avghumid, AVG(w.Cloudiness) as Avgcloud, AVG(w.Visibility) as Avgvis, AVG(w.Pressure) as Avgpress
        FROM forecasts f 
        INNER JOIN weatherdetails w on w.WeatherID = f.WeatherID
        WHERE f.FDate = '$dates' AND f.CityID = $cityid
        GROUP BY f.FDate
        ";
    }
    /*elseif ($action == 'weatherdetails')
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
    }*/
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

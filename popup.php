<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "skywatcher";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    print_r($_POST);
    //, Temperature, WindSpeed, Humidity, Cloudiness, Visibility, Pressure
    //, ?, ?, ?, ? , ? ,?
    //, $temp, $windspeed ,$humidity, $cloudiness, $visibility, $pressure
    if (isset($_POST['action']) && $_POST['action'] == 'Weather Details') {
        $temp = floatval($_POST['temp']);
        $humidity = floatval($_POST['humid']);
        $windspeed = intval($_POST['windspeed']);
        $pressure = intval($_POST['pressure']);
        $visibility = intval($_POST['visibility']);
        $cloudiness = intval($_POST['cloudiness']);
        $conditionid = intval($_POST['conditionid']);

        $sql = "INSERT INTO weatherdetails(ConditionID, Temperature, WindSpeed, Humidity, Cloudiness, Visibility, Pressure) VALUES (?, ?, ?, ?, ?, ? , ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ididiii", $conditionid, $temp, $windspeed ,$humidity, $cloudiness, $visibility, $pressure); 

        
    if ($stmt->execute()) {
        echo "Record Inserted";
    } else {
        echo "Failed to Insert Record";
    }
    $stmt->close();

    } elseif (isset($_POST['action']) && $_POST['action'] == 'Weather Records') {
        print_r($_POST);
        $wdate = $_POST['wdate'];
        $cityid = $_POST['cityid'];
        $weatherid = $_POST['weatherid'];

        $sql = "INSERT INTO weatherrecords(WDate, CityID, WeatherID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $wdate, $cityid, $weatherid); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }
    elseif (isset($_POST['action']) && $_POST['action'] == 'Forecast') {
        print_r($_POST);
        $wdate = $_POST['wdate'];
        $cityid = $_POST['cityid'];
        $weatherid = $_POST['weatherid'];

        $sql = "INSERT INTO forecasts(FDate, WeatherID, CityID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $wdate, $weatherid, $cityid); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }
    elseif (isset($_POST['action']) && $_POST['action'] == 'Alerts') {
        print_r($_POST);
        $cityid = $_POST['cityid'];
        $alerttype = $_POST['salerttype'];
        $alertdes = $_POST['alertdes'];

        $sql = "INSERT INTO alerts(CityID, AlertType, ADescription) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $cityid, $alerttype, $alertdes); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }
    elseif (isset($_POST['action']) && $_POST['action'] == 'City') {
        print_r($_POST);
        $countryid = $_POST['countryid'];
        $state = $_POST['state'];
        $cityname = $_POST['cityname'];

        $sql = "INSERT INTO city(CityName, CState, CountryID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $cityname, $state, $countryid); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }

    elseif (isset($_POST['action']) && $_POST['action'] == 'Country') {
        print_r($_POST);
        $countryname = $_POST['countryname'];
        $latitutde = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        $sql = "INSERT INTO country(CountryName, Latitude, Longitude) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdd", $countryname, $latitutde, $longitude); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }

    elseif (isset($_POST['action']) && $_POST['action'] == 'Admin') {

        $ruser = $_POST['username'];
        $rpass = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $isadmin = "Yes";


        $sql = "INSERT INTO login (username, password, firstname, lastname, isadmin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $ruser, $rpass, $firstname, $lastname, $isadmin); // Bind correct parameters

        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
        $stmt->close();
    }

    elseif (isset($_POST['action']) && $_POST['action'] == 'Conditions') {
        print_r($_POST);
        $conditiontype = $_POST['sconditiontype'];
        $conditionexp = $_POST['conditionexp'];
        $iconcode = intval($_POST['iconcode']);

        $sql = "INSERT INTO conditions(ConditionType, Summary, iconcode) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $conditiontype, $conditionexp, $iconcode); 
        if ($stmt->execute()) {
            echo "Record Inserted";
        } else {
            echo "Failed to Insert Record";
        }
    }

    $conn->close();
}
?>

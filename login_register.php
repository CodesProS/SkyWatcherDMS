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
    

    // Check if form action is for Register or Login
    if (isset($_POST['action']) && $_POST['action'] == 'Register') {
        print_r("Rec");
        // Collect Register form data
        $ruser = $_POST["rusername"];
        $rpass = $_POST["rpassword"];
        $firstname = $_POST["rfname"];
        $lastname = $_POST["rlname"];
        $isadmin = "No";

        // Insert into the database
        $sql = "INSERT INTO login (username, password, firstname, lastname, isadmin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $ruser, $rpass, $firstname, $lastname, $isadmin); // Bind correct parameters

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Not working";
        }
        $stmt->close();

    } elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
        // Collect Login form data
        $luser = $_POST["lusername"];
        $lpass = $_POST["lpassword"];

        // Check login credentials
        $sql = "SELECT password, isadmin, firstname FROM login WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $luser);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) { // Check if username exists
            $stmt->bind_result($pass, $isadmin, $firstname);
            $stmt->fetch();
            
            // Compare password
            if ($lpass == $pass) {  // Plaintext comparison
                echo $isadmin . $firstname;
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Invalid username or password.";
        }
        $stmt->close();
    }

    $conn->close();
}
?>

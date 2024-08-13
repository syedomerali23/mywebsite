<?php
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = ""; // No password
    $dbname = "jobnimbus";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, 3307);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $leadName = $_POST['leadName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $roofAge = $_POST['roofAge'];
    $roofType = $_POST['roofType'];
    $homeInsurance = $_POST['homeInsurance'];
    $email = $_POST['email'];
    $houseSize = $_POST['houseSize'];
    $leaks = $_POST['leaks'];
    $notes = $_POST['notes'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobnimbus (leadName, phone, address, date, roofAge, roofType, homeInsurance, email, houseSize, leaks, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $leadName, $phone, $address, $date, $roofAge, $roofType, $homeInsurance, $email, $houseSize, $leaks, $notes);

    // Execute statement
    if ($stmt->execute()) {
        echo "Registration Successful";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
?>

<?php
// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$zipcode = $_POST['zipcode'];
$date = $_POST['date'];
$time = $_POST['time'];
$roofAge = $_POST['roofAge'];
$roofType = $_POST['roofType'];
$homeInsurance = $_POST['homeInsurance'];
$email = $_POST['email'];
$houseSize = $_POST['houseSize'];
$leaks = $_POST['leaks'];
$notes = $_POST['notes'];

// Convert date and time to a format suitable for API requests
$dateTime = $date . 'T' . $time . ':00';

// JobNimbus API credentials
$jobnimbusApiKey = "lz1mg6w1968lk0r2";  // Replace with your actual API key
$jobnimbusUrl = "https://app.jobnimbus.com/api1/contacts";

// Data payload for creating a new contact in JobNimbus
$jobnimbusData = json_encode([
    "first_name" => $firstName,
    "last_name" => $lastName,
    "record_type_name" => "Retail",
    "status_name" => "Lead",
    "address_line1" => $address,
    "city" => $city,
    "state_text" => $state,
    "zip" => $zipcode,
    "sales_rep_name" => ""  // Adjust if needed
]);

$jobnimbusHeaders = [
    "Authorization: Bearer $jobnimbusApiKey",
    "Content-Type: application/json"
];

// Create contact in JobNimbus
$ch = curl_init($jobnimbusUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $jobnimbusHeaders);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jobnimbusData);
$responseJobNimbus = curl_exec($ch);
curl_close($ch);

// Calendly API credentials
$calendlyBearerToken = "eyJraWQiOiIxY2UxZTEzNjE3ZGNmNzY2YjNjZWJjY2Y4ZGM1YmFmYThhNjVlNjg0MDIzZjdjMzJiZTgzNDliMjM4MDEzNWI0IiwidHlwIjoiUEFUIiwiYWxnIjoiRVMyNTYifQ.eyJpc3MiOiJodHRwczovL2F1dGguY2FsZW5kbHkuY29tIiwiaWF0IjoxNzIzNDc5Nzk1LCJqdGkiOiI5YWZhMWEwMy1mYzQzLTRmZGMtODAwYy1mMGQyMjZkMjdmZTkiLCJ1c2VyX3V1aWQiOiI5ZWM0Yzg0NS0yMDIwLTQwY2YtYTFmMC1kNTZiMTBhM2QwYTEifQ.tVu3MVHUnl1cqgRqnraYQ0fTmaOofBtlrAtpyk434Eq2HagG5Ye22In4k2GHWYfpA08PCFFdDsojAWrpdPT_IQ";
$calendlyUrl = "https://api.calendly.com/one_off_event_types";

// Event data for Calendly
$calendlyData = json_encode([
    "name" => "Roofing Service Appointment",
    "host" => "https://api.calendly.com/users/9ec4c845-2020-40cf-a1f0-d56b10a3d0a1",  // Replace with actual host URL
    "duration" => 30,
    "timezone" => "America/New_York",
    "date_setting" => [
        "type" => "date_range",
        "start_date" => $date,
        "end_date" => $date
    ],
    "location" => [
        "kind" => "physical",
        "location" => $address . ", " . $city . ", " . $state . " " . $zipcode . ", " . $country,
        "additional_info" => "Appointment for roofing service."
    ]
]);

$calendlyHeaders = [
    "Authorization: Bearer $calendlyBearerToken",
    "Content-Type: application/json"
];

// Create event in Calendly
$ch = curl_init($calendlyUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $calendlyHeaders);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $calendlyData);
$responseCalendly = curl_exec($ch);
curl_close($ch);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .success {
            color: #28a745;
            font-size: 18px;
        }

        .error {
            color: #dc3545;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="message">
        <?php if ($responseJobNimbus && $responseCalendly): ?>
            <p class="success">Form Submitted Successfully!</p>
        <?php else: ?>
            <p class="error">There was an error submitting the form. Please try again.</p>
        <?php endif; ?>
    </div>
</body>

</html>

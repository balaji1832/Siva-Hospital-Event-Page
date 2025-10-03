<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";  // Your MySQL password
$dbname = "enquiry_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Check if contact number already exists
    $check_sql = "SELECT id FROM enquiries WHERE contact='$contact'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Contact number exists, show message to user
        echo "<script>alert('This contact number is already registered. Please use a different number.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO enquiries (name, contact, email, message) VALUES ('$name', '$contact', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to thank you page
        header("Location: thankyou.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>



<?php
// action_page.php

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "artist_portfolio";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $firstname = $conn->real_escape_string(htmlspecialchars(trim($_POST['firstname'])));
    $lastname = $conn->real_escape_string(htmlspecialchars(trim($_POST['lastname'])));
    $email = $conn->real_escape_string(filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL));
    $subject = $conn->real_escape_string(htmlspecialchars(trim($_POST['subject'])));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO submissions (firstname, lastname, email, subject) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $subject);

    // Execute the statement
    if ($stmt->execute()) {
        // Optional: Send email notification
        /*
        $to = 'nguyenjozey@gmail.com';
        $email_subject = 'New Contact Form Submission';
        $email_body = "You have received a new message from $firstname $lastname.\n\n".
                      "Here are the details:\n\n".
                      "Email: $email\n\n".
                      "Subject:\n$subject";
        $headers = "From: noreply@yourdomain.com\n";
        $headers .= "Reply-To: $email";
        mail($to, $email_subject, $email_body, $headers);
        */

        // Redirect to a thank you page
        header("Location: ../thankyou.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

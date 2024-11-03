<?php
$servername = "your_server";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch emails from the queue
$sql = "SELECT id, email, subject, message FROM email_queue WHERE processed = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $to = $row['email'];
        $subject = $row['subject'];
        $message = $row['message'];
        $headers = "From: your_email@example.com";

        // Send email
        if (mail($to, $subject, $message, $headers)) {
            // Mark as processed
            $update_sql = "UPDATE email_queue SET processed = 1 WHERE id = $id";
            $conn->query($update_sql);
            echo "Email sent successfully to $to\n";
        } else {
            echo "Failed to send email to $to\n";
        }
    }
} else {
    echo "No emails to send.\n";
}

$conn->close();
?>

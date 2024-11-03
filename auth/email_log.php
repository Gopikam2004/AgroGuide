<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "agroguid";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending emails
$sql = "SELECT * FROM email_log WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $to = $row['email'];
        $subject = $row['subject'];
        $message = $row['message'];
        
        // Send email
        if (mail($to, $subject, $message)) {
            // Update status to 'sent'
            $updateSql = "UPDATE email_log SET status = 'sent' WHERE id = " . $row['id'];
            $conn->query($updateSql);
        } else {
            // Update status to 'failed'
            $updateSql = "UPDATE email_log SET status = 'failed' WHERE id = " . $row['id'];
            $conn->query($updateSql);
        }
    }
}

$conn->close();
?>

<?php
// Include PHPMailer and Exception classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require  '../vendor/autoload.php'; // Adjust path as per your setup

include("../Includes/db.php"); // Adjust path as per your directory structure

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Check if the email exists in your database
    $query = "SELECT * FROM farmerregistration WHERE email = '$email'";
    $run_query = mysqli_query($con, $query);
    $count_rows = mysqli_num_rows($run_query);

    if ($count_rows > 0) {
        // Generate a unique token (you can use a library like random_bytes for secure token generation)
        $token = bin2hex(random_bytes(32)); // Example token generation

        // Store the token with the email and expiry time in your database
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiration time
        $update_query = "UPDATE farmerregistration SET reset_token = '$token', reset_token_expiry = '$expiry' WHERE email = '$email'";

        // Execute query and check for errors
        $run_update = mysqli_query($con, $update_query);
        if (!$run_update) {
            printf("Error: %s\n", mysqli_error($con));
            exit();
        }

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'agro123guide@gmail.com'; // Your Gmail address
            $mail->Password = 'maed ntmo cvuq ehcy'; // Your Gmail password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('agro123guide@gmail.com', 'AgroGuide Support');
            $mail->addAddress($email); // Email address where you want to send

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $resetLink = "https://localhost/AgroGuide-MiniProject/auth/reset_password.php?token=" . urlencode($token);

            $mail->Body = '<p>Dear user,</p><p>You have requested to reset your password. Please click the link below to reset your password:</p><p>' . $resetLink . '</p><p>This link will expire in 1 hour.</p><p>If you did not request this reset, please ignore this email.</p><p>Regards,<br/>The Support Team</p>';

            // Send the email
            $mail->send();
            echo "<script>alert('Password reset link sent to your email. Please check your inbox.');</script>";
            echo "<script>window.open('FarmerLogin.php','_self')</script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send password reset email. Please try again later.');</script>";
            error_log('Mailer Error: ' . $mail->ErrorInfo);
        }
    } else {
        echo "<script>alert('Email address not found. Please enter a valid email.');</script>";
    }
}
?>

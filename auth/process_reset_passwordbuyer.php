<?php
include("../Includes/db.php"); // Adjust path as per your directory structure

if (isset($_POST['submit'])) {
    $token = mysqli_real_escape_string($con, $_POST['token']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    if ($password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the token exists and is valid
        $check_token_query = "SELECT * FROM buyerregistration WHERE reset_token = '$token' AND reset_token_expiry >= 1";
        $result = mysqli_query($con, $check_token_query);

        if (mysqli_num_rows($result) > 0) {
            // Update the password in the database
            $update_query = "UPDATE buyerregistration SET buyer_password = '$hashed_password', reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = '$token'";

            if (mysqli_query($con, $update_query)) {
                echo "<p>Password updated successfully. You can now <a href='BuyerLogin.php'>login</a> with your new password.</p>";
            } else {
                echo "<p>There was an error updating the password: " . mysqli_error($con) . "</p>";
            }
        } else {
            echo "<p>Invalid or expired token. Please request a new password reset.</p>";
        }
    } else {
        echo "<p>Passwords do not match. Please try again.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>

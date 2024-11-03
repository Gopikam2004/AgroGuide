<?php
include("../Includes/db.php"); // Adjust path as per your directory structure

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);

    // Check if the token exists in the database and is not expired
    $query = "SELECT * FROM buyerregistration WHERE reset_token = '$token' AND reset_token_expiry >= 1";
    $run_query = mysqli_query($con, $query);
    $count_rows = mysqli_num_rows($run_query);

    if ($count_rows > 0) {
        // Token is valid, show password reset form
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password</title>
            <!-- Include your CSS and JS files -->
        </head>

        <body>
            <div class="container">
                <h2>Reset Your Password</h2>
                <form action="process_reset_passwordbuyer.php" method="post">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                    <input type="submit" name="submit" value="Update Password">
                </form>
            </div>
        </body>

        </html>
<?php
    } else {
        echo "<p>Invalid or expired token. Please request a new password reset.</p>";
    }
} else {
    echo "<p>Token not found.</p>";
}
?>

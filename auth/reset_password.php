<?php
include("../Includes/db.php"); // Adjust path as per your directory structure

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($con, $_GET['token']);

    // Check if the token exists in the database and is not expired
    $query = "SELECT * FROM farmerregistration WHERE reset_token = '$token' AND reset_token_expiry >= 1";
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
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                }

                .container {
                    max-width: 400px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                h2 {
                    text-align: center;
                    color: #4CAF50;
                    margin-bottom: 20px;
                }

                form {
                    display: flex;
                    flex-direction: column;
                }

                label {
                    font-weight: bold;
                }

                input[type="password"] {
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    font-size: 16px;
                }

                input[type="submit"] {
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    padding: 12px 20px;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }

                input[type="submit"]:hover {
                    background-color: #45a049;
                }

                .error-message {
                    color: red;
                    margin-top: 10px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <h2>Reset Your Password</h2>
                <form action="process_reset_password.php" method="post">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
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

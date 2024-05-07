<?php
include("../Includes/db.php");
session_start();
$sessphonenumber = $_SESSION['phonenumber'];

// Fetch farmer's details
if (isset($sessphonenumber)) {
    $sql = "SELECT * FROM farmerregistration WHERE farmer_phone = '$sessphonenumber' ";
    $run_query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($run_query)) {
        $name = $row['farmer_name'];
        $phone = $row['farmer_phone'];
        $address = $row['farmer_address'];
        $pan = $row['farmer_pan'];
        $bank = $row['farmer_bank'];
        $state = $row['farmer_state'];
        $district = $row['farmer_district'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Farmer Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../portal_files/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid" style="max-width:520px">
        <form action="EditProfile.php" method="post">
            <table align="center">
                <tr colspan=2>
                    <h1> FARMER'S PROFILE</h1>
                </tr>
                <tr align="center">
                    <td><label><b>Name :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticName" value="<?php echo $name; ?>">
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>Phone Number :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticPhone" value="<?php echo $phone; ?>">
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>Address :</b></label></td>
                    <td>
                        <textarea readonly class="form-control-plaintext border border-dark" rows="3"><?php echo $address; ?></textarea>
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>Pan Number :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticPan" value="<?php echo $pan; ?>">
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>Bank Account :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticBank" value="<?php echo $bank; ?>">
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>State :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticState" value="<?php echo $state; ?>">
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td><label><b>District :</b></label></td>
                    <td>
                        <input type="text" readonly class="form-control-plaintext border border-dark" id="staticDistrict" value="<?php echo $district; ?>">
                        <br>
                    </td>
                </tr>
            </table>
            <input type="submit" name="editProf" value="Edit Profile" class="btn btn-primary mt-3">
            <a href="farmerHomepage.php" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
</body>

</html>

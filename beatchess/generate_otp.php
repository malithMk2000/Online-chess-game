// generate_otp.php
<?php
session_start();
$otp = generateOTP();
$_SESSION["otp"] = $otp;
echo $otp;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PassWord Reset</title>
    <link rel="stylesheet" href="Assets/style/style.css">
</head>
<body>
    <form action="Controller/PasswordResetController.php" method="post">
        <input type="hidden" name="type" value="SendOtp">
        <input type="text" name="email" placeholder="Enter Your Email">
        <button type="submit" onlick="sendOtp()">Send Otp</button>
    </form>
    <form action="Controller/PasswordResetController.php" method="post" id = "otp">
    <input type="hidden" name="type" value="ResetPassword">
    <input type="text" name="Otp" placeholder="Enter One time password">
    </form>
    <script src="Assets/js/script.js"></script>
</body>
</html>
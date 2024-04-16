<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verify</title>
    <style>

        .email-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 75vh;
        }

    </style>

    <link rel="stylesheet" href="../Assets/style/EmailLink.css">
</head>
<body>
    <div class="email-container">
        <div class="email-link">
            <h1>Please Confirm Your Email To Login</h1>
            <form action="../Controller/RequestHandlingController.php" method="post">
            <input type="hidden" name="type" value="emailVerify">
            <h1>Enter Your Email Address</h1>
            <input class="input" type="email" name="email" id="" placeholder="Your Email">
            <div>
            <br>
            <input class="input" typ
            e="submit" value="Click Me">
            </form>
            </div>
        </div>
    </div>
</body>
</html>
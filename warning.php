<?php
require_once('db/auth_check.php');
checkNotAuthentication();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/styles.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Poppins"
        rel="stylesheet"
    />
    <title>E-bus</title>
</head>
<body>
    <div class="container">
        <div>
            <h1>To use our website you must register </h1>
        </div>
        <div>
            <a href="register.php" style="color: #7b47ba; font-size: 30px;  margin-right: 20px">Registration</a>
            <a href="sign-in.php" style="color: #7b47ba; font-size: 30px; margin-left: 20px">Login</a>
        </div>
    </div>
</body>>

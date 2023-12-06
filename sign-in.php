<?php
session_start();
require_once 'db/db.php';
require_once 'db/auth_check.php';
checkNotAuthentication();

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login_time'] = time();
        header('Location: main.php');
        exit();
    } else {
        $error_message = 'Invalid credentials';
    }
}
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
<div class="navbar">
    <div class="navbar-left">
        <a href="main.php">
            <img src="images/black-icon-transformed.png" />
            <div>e-bus</div>
        </a>
    </div>
    <div class="navbar-right"></div>
</div>
<div class="container">
    <div class="sign-up-form">
        <div class="sign-up-text">Sign-in</div>
        <form action="" method="post">
            <div>
                <input class="email" type="email" placeholder="Email" name="email"> <br />
            </div>
            <div>
                <input class="password" type="password" placeholder="New password" name="password">
            </div>
            <div>
                <span style="color: red;"><?php echo $error_message; ?></span>
            </div>
            <div class="submit">
                <button style="background-color: #7284e4; padding: 10px 20px 10px 20px; border-radius: 5px; color: #fff;font-size: 18px;font-weight: 600; border-color: #7284e4" type="submit">Sign-up</button>
            </div>
        </form>
    </div>
</div>
<div class="footer">
    <div class="footer_wrapper">
        <div class="flix-page-container">
            <hr class="flix-divider" />
        </div>
        <div class="footer_section">
            <div class="footer_left">
                <span class="footer_left-copyright"> © 2022-2023, АО «E-BUS» </span>
                <p class="footer_left-license">
                    License to provide information and services in the field of bus
                    transport No. 1.2.245/61 dated 03.02.2020, issued by Agency of the
                    Republic of Kazakhstan for Regulation and Development transport
                    sector.
                </p>
                <div>
                    <a href="https://www.greyhound.com/" class="footer-2__left-title">
                        Corporate website
                    </a>
                </div>
            </div>
            <div class="footer_right">
                <div class="">
                    <a
                        href="http://instagram.com/yrssl"
                        rel="nofollow noopener noreferrer"
                        target="_blank"
                    ><img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/instagram-icon.6d509383.svg"
                            alt="E-BUS в Instagram"
                            width="32"
                            height="32" /></a
                    ><a
                        href="https://www.youtube.com/"
                        rel="nofollow noopener noreferrer"
                        target="_blank"
                    ><img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/youtube-icon.2d4ad397.svg"
                            alt="E-BUS в YouTube"
                            width="32"
                            height="32" /></a
                    ><a
                        href="https://www.facebook.com"
                        rel="nofollow noopener noreferrer"
                        target="_blank"
                    ><img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/facebook-icon.53c62c05.svg"
                            alt="E-BUS в Facebook"
                            width="32"
                            height="32" /></a
                    ><a
                        href="https://twitter.com"
                        rel="nofollow noopener noreferrer"
                        target="_blank"
                    ><img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/twitter-icon.c1943575.svg"
                            alt="E-BUS в Twitter"
                            width="32"
                            height="32"
                        /></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

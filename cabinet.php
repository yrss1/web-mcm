<?php
require_once 'db/auth_check.php';
require_once 'db/db.php';
require_once 'functions/getBus.php';
checkAuthentication();

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM tickets WHERE user_id = ?');
$stmt->execute([$user_id]);
$tickets = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/styles.css" />
    <link
        rel="icon"
        type="image/x-icon"
        href="images/black-icon-transformed.png"
    />
    <link
        href="https://fonts.googleapis.com/css?family=Poppins"
        rel="stylesheet"
    />
    <title>E-bus</title>
</head>

<body>
<div class="back-img">
    <div class="navbar">
        <div class="navbar-left">
            <a href="main.php">
                <img src="images/black-icon-transformed.png" />
                <div>e-bus</div>
            </a>
        </div>
        <div class="navbar-right">
            <div class="schedule">
                <a href="destinations.php">
                    <img src="icons/marker.png" />
                    <div>Destinations</div>
                </a>
            </div>
            <div class="rules">
                <a href="rules.php">
                    <img src="icons/document.png" />
                    <div>Rules</div>
                </a>
            </div>
            <div class="contacts">
                <a href="contacts.php">
                    <img src="icons/phone.png" />
                    <div>Contacts</div>
                </a>
            </div>
            <div class="rules">
                <a href="help.php">
                    <img src="icons/interrogation.png" />
                    <div>Help</div>
                </a>
            </div>
            <div class="rules">
                <a href="cabinet.php">
                    <img src="icons/user.png" />
                    <div>Cabinet</div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php foreach ($tickets as $ticket): ?>
    <?php
        $stmt = $pdo->prepare('SELECT * FROM buses WHERE id = ?');
        $stmt->execute([$ticket['bus_id']]);
        $bus = $stmt->fetch();

        $stmt = $pdo->prepare('SELECT * FROM seats WHERE id = ?');
        $stmt->execute([$ticket['seat_id']]);
        $seat = $stmt->fetch();
        ?>
    <div class="cabinet">
        <div class="cabinet-top">
            E-BUS
        </div>
        <div class="cab">
            <div>BUS: <span><?php echo $bus['bus_number']?></span></div>
            <div >SEAT: <span><?php echo $seat['seat_number']?></span></div>
            <div >RATE: <span><?php echo $ticket['rate']?></span></div>
        </div>
        <div></div>
        <div class="cabinet-section">
            <div class="cabinet-left">
                <div>FIRST NAME: <?php echo $ticket['first_name']?></div>
                <div>FROM: <span><?php echo $bus['departure']?></span></div>
                <div>DATE-TIME: <span><?php echo $bus['departure_time']?></span></div>
            </div>
            <div class="cabinet-right">
                <div>LAST NAME: <?php echo $ticket['last_name']?></div>
                <div>TO: <span><?php echo $bus['arrival']?></span></div>
                <div>DATE-TIME: <span><?php echo $bus['arrival_time']?></span></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
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

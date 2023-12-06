<?php
require_once 'db/auth_check.php';
require_once 'db/db.php';
checkAuthentication();

$departure = $_GET['departure'];
$arrival = $_GET['arrival'];
$arrivalTime = $_GET['arrival_time'];

echo "Departure: $departure<br>";
echo "Arrival: $arrival<br>";
echo "Arrival Time: $arrivalTime<br>";

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
                    <img src="icons/user.png" />
                    <div>Contacts</div>
                </a>
            </div>
            <div class="rules">
                <a href="help.php">
                    <img src="icons/interrogation.png" />
                    <div>Help</div>
                </a>
            </div>
        </div>
    </div>
</div>
    <div class="container">
            <form class="find" type="get" action="{{ route('buses') }}">
                <div>
                    <input type="text" placeholder="From" id="autocomplete" class="autocomplete" name="departure" autocomplete="off"/>
                </div>
                <div>
                    <input type="text" placeholder="Where" name="arrival" id="autocomplete" class="autocomplete" autocomplete="off"/>
                </div>
                <div class="data">
                    <input type="date" name="arrival_time"/>
                </div>
                <div class="search">
                    <button type="submit" style="color: white"> Search </button>
                </div>
            </form>
        <div>
            <?php

            ?>
        </div>
        <div class="list-of-destinations">
            <?php foreach ($filteredBuses as $bus): ?>
                <div class="dest">
                    <div class="rating">
                        <svg
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M10 14.3653L5.14917 16.67L6.15667 11.5688L2.5 7.82792L7.64917 7.18527L10 2.5L12.3508 7.18527L17.5 7.82792L13.8433 11.5688L14.8508 16.67L10 14.3653Z"
                                    fill="#F6C13A"
                                    stroke="#F6C13A"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                            ></path>
                            <path
                                    d="M5.14917 16.6667L10 14.3625V8.43125V2.5L7.64917 7.18417L2.5 7.82667L6.15667 11.5667L5.14917 16.6667Z"
                                    fill="#F6C13A"
                                    stroke="#F6C13A"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                            ></path>
                        </svg>
                        <p class="main-rating">3.6</p>
                        <p>0009T</p>
                    </div>
                    <div class="dest-top">
                        <div class="dest-left">
                            <div class="time-start">
                                <?php echo $bus->departure_time; ?>
                                <p
                                        style="
                            color: #83878f;
                            margin-left: 10px;
                            font-size: 15px;
                            font-weight: 400;
                          "
                                >
                                    21 oct
                                </p>
                            </div>
                            <div class="place-start"><?php echo $bus->departure; ?></div>
                        </div>
                        <div class="dest-right">
                            <div class="time-end">
                                12:25
                                <p
                                        style="
                            color: #83878f;
                            margin-left: 10px;
                            font-size: 15px;
                            font-weight: 400;
                          "
                                >
                                    21 oct
                                </p>
                            </div>
                            <div class="place-end"><?php echo $bus->arrival; ?> </div>
                        </div>
                    </div>
                    <div class="dest-under">
                        <div class="dest-cost">400tng</div>
                        <div class="continue"><a href="">Continue</a></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script>
    console.log("<?php echo ("dest"); ?>");
    console.log(<?php echo $departure; ?>);
    console.log(<?php echo $arrival; ?>);
</script>
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

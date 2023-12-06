<?php
require_once('db/auth_check.php');
checkAuthentication();
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
        <form class="find" method="get" action="destinations.php">
            <div>
                <input type="text" placeholder="From" id="autocomplete" class="autocomplete" name="departure" autocomplete="off" value="<?php echo isset($_GET['departure']) ? htmlspecialchars($_GET['departure']) : ''; ?>"/>
            </div>
            <div>
                <input type="text" placeholder="Where" name="arrival" id="autocomplete" class="autocomplete" autocomplete="off" value="<?php echo isset($_GET['arrival']) ? htmlspecialchars($_GET['arrival']) : ''; ?>"/>
            </div>
            <div class="data">
                <input type="date" name="departure_time" value="<?php echo isset($_GET['departure_time']) ? htmlspecialchars($_GET['departure_time']) : ''; ?>"/>
            </div>
            <div class="search">
                <button type="submit" style="color: white"> Search </button>
            </div>
        </form>
        <div class="main-section">
            <h1 style="font-size: 20px">
                Why it is better to buy bus tickets on E-BUS
            </h1>
            <div class="why">
                <div class="why-li">
                    <img
                        src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/anywhere.49239dcd.svg"
                    />
                    <p class="main-text">
                        Look for options with a search for "Anywhere"
                    </p>
                    <p>
                        Will show you which day it is more profitable to fly and suggest
                        the best time to travel.
                    </p>
                </div>
                <div class="why">
                    <div class="why-li">
                        <img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/loan.0a2cfe72.svg"
                        />
                        <p class="main-text">90% refund guarantee on the ticket price</p>
                        <p>Pay 10% and get 90% of the ticket price back</p>
                    </div>
                </div>
                <div class="why">
                    <div class="why-li">
                        <img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/bonuses.ae183db9.svg"
                        />
                        <p class="main-text">Bonuses for every purchase</p>
                        <p>
                            Get 1% bonus for every order and 3% for promotional offers
                            offers
                        </p>
                    </div>
                </div>
                <div class="why">
                    <div class="why-li">
                        <img
                            src="https://aviax.cdn.aviata.me/releases/2023.1.2/assets/static/tour.e0290d31.svg"
                        />
                        <p class="main-text">Payment via Apple pay and Google pay</p>
                        <p class="just-text">Pay for tickets conveniently in one click</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script>
        var path = "{{ route('autocomplete') }}";
        $('input.autocomplete').typeahead({
            source: function (query, process) {
                return $.get(path, { term: query }, function (data) {
                    var limitedData = data.slice(0, 5);
                    return process(limitedData);
                });
            }
        });
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


<?php
require_once 'db/auth_check.php';
require_once 'db/db.php';
checkAuthentication();

if (isset($_SESSION['selected_bus_id'])) {
    $selected_bus_id = $_SESSION['selected_bus_id'];
    $selected_seat_id = $_SESSION['selected_seat_id'];

    $stmt = $pdo->prepare('SELECT * FROM buses WHERE id = ?');
    $stmt->execute([$selected_bus_id]);
    $selectedBus = $stmt->fetch();

    $difference = strtotime($selectedBus['arrival_time']) - strtotime($selectedBus['departure_time']);
    $days = floor($difference / (60 * 60 * 24));
    $hoursMinutes = gmdate('H\h i\m', $difference % (60 * 60 * 24));

    $stmt = $pdo->prepare('SELECT * FROM seats WHERE id = ?');
    $stmt->execute([$selected_seat_id]);
    $seat = $stmt->fetch();
} else {
    echo "No bus selected.";
}
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
    <form>
    <div class="menu-container">
        <div class="back-button"><a href="select-seat.php">< Back</a></div>
        <div class="buy-section">
            <div class="ticket-wrapper">
                <div class="ticket-left">
                    <div class="ticket-left-start">
                        <span class="departure">Departure</span>
                        <div>
                            <span class="city"><?php echo $selectedBus['departure'] ?></span>
                            <span class="date"><?php echo $selectedBus['departure_time'] ?></span>
                        </div>
                    </div>
                    <div class="ticket-left-start">
                        <span class="departure">Arrival</span>
                        <div>
                            <span class="city"><?php echo $selectedBus['arrival'] ?></span>
                            <span class="date"><?php echo $selectedBus['arrival_time'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="ticket-center">
                    <p>
                        Seat:
                        <span><?php echo $seat['seat_number'] ?></span>
                    </p>
                    <p><?php if ($days > 0) echo $days . 'd    '; echo $hoursMinutes?></p>
                </div>
                <div class="ticket-right">
                    <div class="city"><?php echo $selectedBus['price'] ?> ₸</div>
                    <div class="date">Cost per 1 adult passenger seat</div>
                </div>
            </div>
        </div>
        <div class="buy-section">
            <div class="buy-section-top">
                <div>
                    <label>First Name</label>
                    <input type="text" placeholder="First Name" required name="first_name">
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" placeholder="Last Name" required name="last_name"/>
                </div>
            </div>
            <div class="buy-section-under">
                <div>
                    <label>IIN</label>
                    <input type="text" placeholder="IIN" required name="iin"/>
                </div>
                <div>
                    <label>Rate</label>
                    <select name="rate">
                        <option>Adult</option>
                        <option>Child</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="buy-section">
            <p class="city">Contact details</p>
            <p class="date">Tickets can be booked only on Kazakh phone numbers</p>
            <div class="email-phone">
                <div>
                    <label>Email</label>
                    <input type="email" placeholder="exmaple@ebus.kz" required name="email"/>
                </div>
                <div>
                    <label>Phone number</label>
                    <input type="tel" placeholder="+77777777777" required name="phone"/>
                </div>
            </div>
        </div>
        <div class="buy-section">
            <div class="proceed">
                <p class="city">To be paid — <?php echo $selectedBus['price'] ?> ₸</p>
                <div class="accept">
                    <input type="checkbox" id="acceptCheckbox" required>
                    <label for="acceptCheckbox">
                        I accept
                        <a href="rules.php" target="_blank">the agreement and the rules for applying the tariff.</a>
                    </label>
                </div>
                <div>
                    <button class="proceed-button" formaction="payments.php" type="submit" style="color: #ffff">Proceed</button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>
<script>
    function checkAcceptance() {
        const acceptCheckbox = document.querySelector('input[type="checkbox"]');
        if (!acceptCheckbox.checked) {
            alert('Please accept the agreement before proceeding.');
        } else {
            window.location.href = 'payments.php';
        }
    }
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

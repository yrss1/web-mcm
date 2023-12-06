<?php
require_once 'db/auth_check.php';
require_once 'db/db.php';
checkAuthentication();

if (isset($_SESSION['selected_bus_id'])) {
    $selected_bus_id = $_SESSION['selected_bus_id'];
    $stmt = $pdo->prepare('SELECT * FROM buses WHERE id = ?');
    $stmt->execute([$selected_bus_id]);
    $selectedBus = $stmt->fetch();

    $difference = strtotime($selectedBus['arrival_time']) - strtotime($selectedBus['departure_time']);
    $days = floor($difference / (60 * 60 * 24));
    $hoursMinutes = gmdate('H\h i\m', $difference % (60 * 60 * 24));
    $stmt = $pdo->prepare('SELECT * FROM seats WHERE bus_id = ?');
    $stmt->execute([$selectedBus['id']]);
    $seats = $stmt->fetchAll();



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
    <div class="container cont">
        <div class="menu-container">
            <div class="back-button"><a href="destinations.php">< Back</a></div>
            <div class="menu-section">
                <div class="menu-section-left">
                    <div class="menu-section-left--city">
                        <p><?php echo $selectedBus['departure'] ?></p>
                        <p>
                            <span class="time"><?php echo date("H:i", strtotime($selectedBus['departure_time'])) ?></span>
                            <span class="date"><?php echo date("j M", strtotime($selectedBus['departure_time'])) ?></span>
                        </p>
                    </div>
                    <div class="menu-section-left--city">
                        <p><?php echo $selectedBus['arrival'] ?></p>
                        <p>
                            <span class="time"><?php echo date("H:i", strtotime($selectedBus['arrival_time'])) ?></span>
                            <span class="date"><?php echo date("j M", strtotime($selectedBus['arrival_time'])) ?></span>
                        </p>
                    </div>
                </div>
                <div class="menu-section-right">
                    On the way:
                    <span class="time"><?php if ($days > 0) echo $days . 'd    '; echo $hoursMinutes?></span>
                </div>
            </div>
            <div class="menu-section">
                <div class="bus">
                    <div class="row">
                        <?php foreach ($seats as $seat): ?>
                            <button class="seat <?php echo $seat['is_booked'] ? 'booked' : ''; ?>" onclick="selectSeat(this, <?php echo $seat['id']; ?>)">
                                <?php if ($seat['is_booked']): ?>
                                    <span class="cross" style="color: #4b5563">✖</span>
                                <?php else: ?>
                                    <?php echo $seat['seat_number']; ?>
                                <?php endif; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="menu-section">
                <div class="continue"><button id="continueLink" onclick="checkSeatSelection()">Continue</button></div>
            </div>
        </div>
    </div>
<script>
    localStorage.clear();
    let selectedSeatId = null;

    function selectSeat(button, seatId) {
        if (button.classList.contains('selected')) {
            button.classList.remove('selected');
            selectedSeatId = null;
        } else if (!button.classList.contains('booked')) {
            button.classList.add('selected');
            selectedSeatId = seatId;

            const allSeats = document.querySelectorAll('.seat');
            allSeats.forEach(seat => {
                if (seat !== button) {
                    seat.classList.remove('selected');
                }
            });
        } else {
            alert('This seat is already booked!');
        }
    }

    function checkSeatSelection(event) {
        if (selectedSeatId === null) {
            alert('Please select a seat before continuing.');
        }else {
            fetch("functions/set_selected_seat.php", {
                "method" : "POST",
                "header" : {
                    "Content-Type" : "application/json; charset=utf-8"
                },
                "body" : JSON.stringify(selectedSeatId)
            }).then(function (response){
                return response.text();
            }).then(function (data){
                console.log(data);
            })
            window.location.href = 'buy-menu.php';
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


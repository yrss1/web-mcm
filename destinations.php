<?php
require_once 'db/auth_check.php';
require_once 'db/db.php';
checkAuthentication();
$buses = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $departure = $_GET['departure'];
    $arrival = $_GET['arrival'];
    $departureTime = $_GET['departure_time'];
    if ($departureTime != null) {
        $stmt = $pdo->prepare('SELECT * FROM buses WHERE departure = ? AND arrival = ? AND departure_time BETWEEN ? AND ?');
        $nextDay = date('Y-m-d', strtotime($departureTime . ' +1 day'));
        $stmt->execute([$departure, $arrival, $departureTime, $nextDay]);
        $buses = $stmt->fetchAll();
    } else {
        $stmt = $pdo->prepare('SELECT * FROM buses WHERE departure = ? AND arrival = ?');
        $stmt->execute([$departure, $arrival]);
        $buses = $stmt->fetchAll();
    }
}
$stmt = $pdo->prepare('SELECT * FROM routes');
$stmt->execute();
$routes = $stmt->fetchAll();
if (isset($_GET['sorting'])) {
    $sortingOption = $_GET['sorting'];
    switch ($sortingOption) {
        case 'price':
            usort($buses, function($a, $b) {
                return $a['price'] - $b['price'];
            });
            break;
        case 'arrival':
            usort($buses, function($a, $b) {
                return strtotime($a['arrival_time']) - strtotime($b['arrival_time']);
            });
            break;
        case 'departure':
            usort($buses, function($a, $b) {
                return strtotime($a['departure_time']) - strtotime($b['departure_time']);
            });
            break;
        case 'rating':
            array_multisort(array_column($buses, 'rating'), SORT_DESC, $buses);
            break;
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
            rel="icon"
            type="image/x-icon"
            href="images/black-icon-transformed.png"
    />
    <link
            href="https://fonts.googleapis.com/css?family=Poppins"
            rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include jQuery UI Autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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

    <form class="find" method="get" action="destinations.php">
        <div class="trip-type">
            <label>
                <input type="radio" name="trip_type" value="one_way" <?php echo (isset($_GET['trip_type']) && $_GET['trip_type'] === 'one_way') ? 'checked' : 'checked'; ?> onchange="toggleInputFields('one_way');">
                One Way
            </label>
            <label>
                <input type="radio" name="trip_type" value="round_trip" <?php echo (isset($_GET['trip_type']) && $_GET['trip_type'] === 'round_trip') ? 'checked' : ''; ?> onchange="toggleInputFields('round_trip');">
                Round Trip
            </label>
        </div>
        <div class="find-input">
            <input type="text" placeholder="From" id="departureInput" class="autocomplete" name="departure" autocomplete="off" value="<?php echo isset($_GET['departure']) ? htmlspecialchars($_GET['departure']) : ''; ?>"/>
            <input type="text" placeholder="Where" id="arrivalInput" name="arrival" class="autocomplete" autocomplete="off" value="<?php echo isset($_GET['arrival']) ? htmlspecialchars($_GET['arrival']) : ''; ?>"/>
            <div class="data" style="display: flex">
                <input type="date" name="departure_time" id="departureTimeInput" value="<?php echo isset($_GET['departure_time']) ? htmlspecialchars($_GET['departure_time']) : ''; ?>"/>
                <input type="date" name="return_time" id="returnTimeInput" value="<?php echo isset($_GET['return_time']) ? htmlspecialchars($_GET['return_time']) : ''; ?>"/>
            </div>
            <div class="search">
                <button type="submit" style="color: white"> Search </button>
            </div>
        </div>
    </form>
    <div style="display: flex">
        <?php if ($buses !=null): ?>
            <div class="destination-left" style="display: flex; flex-direction: column">
                <div class="companies">
                    <button class="filter-btn" onclick="">MRSS</button>
                    <button class="filter-btn" onclick="">YRSSL</button>
                    <button class="filter-btn" onclick="">MDX</button>
                    <button class="filter-btn" onclick="">ALL</button>
                </div>
                <div class="filter">
                    <form class="sort-form" method="get" action="destinations.php">
                        <input type="hidden" name="departure" value="<?= htmlspecialchars($departure) ?>" />
                        <input type="hidden" name="arrival" value="<?= htmlspecialchars($arrival) ?>" />
                        <input type="hidden" name="departure_time" value="<?= htmlspecialchars($departureTime) ?>" />
                        <label><input type="radio" name="sorting" value="price" <?= isset($_GET['sorting']) && $_GET['sorting'] === 'price' ? 'checked' : '' ?> onchange="this.form.submit()">By price, cheapest first</label><br>
                        <label><input type="radio" name="sorting" value="arrival" <?= isset($_GET['sorting']) && $_GET['sorting'] === 'arrival' ? 'checked' : '' ?> onchange="this.form.submit()">By arrival time</label><br>
                        <label><input type="radio" name="sorting" value="departure" <?= isset($_GET['sorting']) && $_GET['sorting'] === 'departure' ? 'checked' : '' ?> onchange="this.form.submit()">By departure time</label><br>
                        <label><input type="radio" name="sorting" value="rating" <?= isset($_GET['sorting']) && $_GET['sorting'] === 'rating' ? 'checked' : '' ?> onchange="this.form.submit()">By high rating</label><br>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <div class="list-of-destinations">
            <?php foreach ($buses as $bus): ?>
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
                        <p class="main-rating"><?php echo $bus['rating']; ?></p>
                        <p><?php echo $bus['bus_number']; ?>T</p>
                        <p style="color: #7284e4; margin-left: 10px"><?php echo $bus['company']; ?></p>
                    </div>
                    <div class="dest-top">
                        <div class="dest-left">
                            <div class="time-start">
                                <?php echo date("H:i", strtotime($bus['departure_time'])); ?>
                                <p
                                        style="
                                color: #83878f;
                                margin-left: 10px;
                                font-size: 15px;
                                font-weight: 400;
                              "
                                >
                                    <?php echo date("j M", strtotime($bus['departure_time'])); ?>
                                </p>
                            </div>
                            <div class="place-start"><?php echo $bus['departure']; ?></div>
                        </div>
                        <div class="dest-right">
                            <div class="time-end">
                                <?php echo date("H:i", strtotime($bus['arrival_time'])); ?>
                                <p
                                        style="
                                color: #83878f;
                                margin-left: 10px;
                                font-size: 15px;
                                font-weight: 400;
                              "
                                >
                                    <?php echo date("j M", strtotime($bus['arrival_time'])); ?>
                                </p>
                            </div>
                            <div class="place-end"><?php echo $bus['arrival']; ?></div>
                        </div>
                    </div>
                    <div class="dest-under">
                        <div class="dest-cost"><?php echo $bus['price']; ?>₸</div>
                        <button onclick="setSelectedBusAndRedirect(<?php echo $bus['id'];?>)" class="my-btn">Continue</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    function setSelectedBusAndRedirect(selectedBus) {
        fetch("functions/set_selected_bus.php", {
            "method" : "POST",
            "header" : {
                "Content-Type" : "application/json; charset=utf-8"
            },
            "body" : JSON.stringify(selectedBus)
        }).then(function (response){
            return response.text();
        }).then(function (data){
            console.log(data);
        })
        window.location.href = 'select-seat.php';
    }
    document.addEventListener("DOMContentLoaded", function() {
        // Check if trip type is stored in local storage
        var storedTripType = localStorage.getItem('tripType');

        // Set the initial visibility based on stored trip type
        toggleInputFields(storedTripType || 'one_way');
    });

    function toggleInputFields(tripType) {
        var departureInput = document.getElementById('departureInput');
        var departureTimeInput = document.getElementById('departureTimeInput');
        var returnTimeInput = document.getElementById('returnTimeInput');

        if (tripType === 'one_way') {
            returnTimeInput.style.display = 'none';
        } else {
            returnTimeInput.style.display = 'flex';
        }

        // Store the selected trip type in local storage
        localStorage.setItem('tripType', tripType);
    }
    $(function() {
        // Define an array of city names from your $routes variable
        var cities = <?php echo json_encode(array_column($routes, 'name')); ?>;
        console.log(cities);

        // Initialize autocomplete for departure input
        $("#departureInput").autocomplete({
            source: cities
        });

        // Initialize autocomplete for arrival input
        $("#arrivalInput").autocomplete({
            source: cities
        });
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


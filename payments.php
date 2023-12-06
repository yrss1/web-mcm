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
    <div class="payment-container">
        <div class="payment-left">
            <div class="payment-left-section">
                <div class="order-number">
                    <div>Order number 183284583</div>
                    <div>To be paid <?php echo $selectedBus['price'] ?> ₸</div>
                </div>
                <p id="expiration-message">
                    The reservation expires on <span id="expiration-date"></span> at <span id="expiration-time"></span> (Astana time)<br />
                    Detailed information about your route has been sent to the email address.
                </p>
                <div class="">
                    <p>Order Details</p>
                    <div class="order-details">
                        <div class="order-details-top">
                            <div class="order-details-top-left">
                                <p class=""><?php echo $selectedBus['departure'] ?></p>
                                <span class="order-date">
                      <p class=""><?php echo date("H:i", strtotime($selectedBus['departure_time'])); ?></p>
                      <p class="date"><?php echo date("j M", strtotime($selectedBus['departure_time'])); ?></p>
                    </span>
                            </div>
                            <svg
                                data-v-cec40788=""
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="strelka"
                            >
                                <path
                                    data-v-cec40788=""
                                    d="M19 12H5"
                                    stroke="#202122"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                                <path
                                    data-v-cec40788=""
                                    d="M14 17L19 12"
                                    stroke="#202122"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                                <path
                                    data-v-cec40788=""
                                    d="M14 7L19 12"
                                    stroke="#202122"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                ></path>
                            </svg>
                            <div class="order-details-top-left">
                                <p class=""><?php echo $selectedBus['arrival'] ?></p>
                                <span class="order-date">
                      <p class=""><?php echo date("H:i", strtotime($selectedBus['arrival_time'])); ?></p>
                      <p class="date"><?php echo date("j M", strtotime($selectedBus['departure_time'])); ?></p>
                    </span>
                            </div>
                        </div>
                        <p></p>
                    </div>
                </div>
                <div>
                    <span class="city">Yerassyl Rymkul</span>
                    <span>Place <?php echo $seat['seat_number'] ?></span>
                </div>
            </div>
            <div class="payment-left-section">
                <div class="kaspi">
                    <div class="kaspi-left">
                        <p style="font-weight: 700; font-size: 20px">Payment method</p>
                        <div class="kaspi-left-payment">
                <span class="kaspi-span">
                    <span>
                        <input type="radio" name="payment-method" value="kaspi" />
                        <label>Online banking from Kaspi.kz</label>
                    </span>
                    <span>
                        <input type="radio" name="payment-method" value="card" />
                        <label>By bank card</label>
                    </span>
                </span>
                        </div>
                    </div>
                    <div class="kaspi-right">
                        <div class="kaspi-data" style="display: none;">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABM4AAATOAQAAAAAa8lf4AAAFkUlEQVR42u3dXY6jSgwGUOuyAJaUrbOkWUBLzETNaArKJqEfQunqfC8tmp+cZ8t2xTpqvgINDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NDQ0NbSxalHn8e+jXdlnfbTL/+dfy529+t8l0oP0XwwYNDQ0NDQ0NDQ0NDQ0NDQ3t/0hLKkVTX1BqSkNTc9lkST/1zJx/6uXvqhShoaGhoaGhoaGhoaGhoaGhfTh5xabp/Jlelnd+9Z9avi+/+h8q+pFCpQgNDQ0NDQ0NDQ0NDQ0NDQ3t7lyqFDXvPfZdQ8u/O/NpHUmlCA0NDQ0NDQ0NDQ0NDQ0NDW3UXO0perYJze2io+8kw2hbmjrSpFKEhoaGhoaGhoaGhoaGhoaGNi7t8p6iZ5Liz/aponBkTxEaGhoaGhoaGhoaGhoaGhra+LRrZ59F1xf0o8s8KkVoaGhoaGhoaGhoaGhoaGho92a9mGJJdXLZ5LFej0oRGhoaGhoaGhoaGhoaGhoa2ofzsqcoaQSa96ebzft357cm15p3l8gKVipFaGhoaGhoaGhoaGhoaGhoaB9O3dSzfD9wvrZoylcPLbFbWxRRbTE6rM5WKUJDQ0NDQ0NDQ0NDQ0NDQ0O7L/Vm6SW6ak+8Uxqa+/akfG1RhJ4iNDQ0NDQ0NDQ0NDQ0NDQ0tIFy3lN0PiMWr1ZYR6TDaFum+ig0lSI0NDQ0NDQ0NDQ0NDQ0NDS0zyffWT33PUWP/Ubr89VDyahaP9cW/cMqRWhoaGhoaGhoaGhoaGhoaGj3pa4UXV5blI+qrft+pLpwZE8RGhoaGhoaGhoaGhoaGhoa2r1568T6ZL5sS3tZH3a2vltHUilCQ0NDQ0NDQ0NDQ0NDQ0NDuy8v9xSdz6YVD2+Xyahac2lPERoaGhoaGhoaGhoaGhoaGtpQ6ZdUPzPvtwk1OfQUJQ/PZT/S4WE9RWhoaGhoaGhoaGhoaGhoaGhDJa8UPVNPkM352Wf56WZJi1FEd6pa2FOEhoaGhoaGhoaGhoaGhoaGdnfe2mh92FO09pWiQ96bL4t0kE2lCA0NDQ0NDQ0NDQ0NDQ0NDe2evLXCeu2H0fK7U18LSn6oedieIjQ0NDQ0NDQ0NDQ0NDQ0NLRh0k+fTfUwWj99FpHuKVri7Ci07WF7itDQ0NDQ0NDQ0NDQ0NDQ0NCGSl4pKsbN+uPMLu0pWvcP21OEhoaGhoaGhoaGhoaGhoaGNlTqSlFzt7ksthhtmepBtsP0mT1FaGhoaGhoaGhoaGhoaGhoaKPlUk9RfrdoItoyl6Whtj1JpQgNDQ0NDQ0NDQ0NDQ0NDQ3t9lzaU9S/ezJBFuU27Dh9WKUIDQ0NDQ0NDQ0NDQ0NDQ0N7Z6sVxLpYWfnq4eK2bRQKUJDQ0NDQ0NDQ0NDQ0NDQ0MbLH0tqMjh/LI1LQ0ld5t3p/ooNNNnaGhoaGhoaGhoaGhoaGhoaLfnfPqs3kpdtxit/Sai2N/N59r0FKGhoaGhoaGhoaGhoaGhoaHdm/OzzyJtBGrebY9C2/47l+uvDzmUlfQUoaGhoaGhoaGhoaGhoaGhod2bq5WiYkn1Yz9ulv/Qoaw01d1KKkVoaGhoaGhoaGhoaGhoaGhon89PKkVF4egwqhblMFpSVlIpQkNDQ0NDQ0NDQ0NDQ0NDQ7s9l/YU5e/Wp5v9zeP0U3qK0NDQ0NDQ0NDQ0NDQ0NDQ0IbIT84++3t5OPvsMF+Wl4aSh5fQU4SGhoaGhoaGhoaGhoaGhoY2QNZR84WGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGhoaGdjPtN0bVyb+esRrGAAAAAElFTkSuQmCC" width="250" height="250" alt="QR-код" style="mix-blend-mode: multiply" />
                            <p style="font-weight: 600; font-size: 20px"><?php echo $selectedBus['price'] ?> ₸</p>
                        </div>
                        <div class="card-data" style="display: none;">
                            <form action="#" method="post">

                                <h1>Payment form</h1>

                                <section>
                                    <label>Card number</label>
                                    <input>
                                </section>

                                <section>
                                    <label>Name on card</label>
                                    <input>
                                </section>

                                <section id="cc-exp-csc">
                                    <div>
                                        <label>Expiry date</label>
                                        <input>
                                    </div>
                                    <div>
                                        <label>Security code</label>
                                        <input>
                                        <div class="explanation">Last 3 digits on back of card</div>
                                    </div>
                                </section>

                                <button id="complete-payment">Complete payment</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="payment-right">
            <div>
                <p>Expires in</p>
                <div class="clock">
                    <span class="span-number">0</span>
                    <span class="span-number">0</span>
                    <span class="span-nonumber">:</span>
                    <span class="span-number">0</span>
                    <span class="span-number">0</span>
                </div>
            </div>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timeLimit = 1;
        let expirationTime = localStorage.getItem('expirationTime');

        if (!expirationTime) {
            expirationTime = new Date().getTime() + timeLimit * 60 * 1000;
            localStorage.setItem('expirationTime', expirationTime);
        }

        function updateTimer() {
            const now = new Date().getTime();
            const timeLeft = expirationTime - now;

            if (timeLeft <= 0) {
                alert('Sorry, the reservation time has expired.');
                document.querySelector('.proceed-button').setAttribute('disabled', 'true');
                localStorage.removeItem('expirationTime');
            } else {
                const expirationDate = new Date(expirationTime);
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                document.querySelector('.span-number:first-child').textContent = Math.floor(minutes / 10);
                document.querySelector('.span-number:nth-child(2)').textContent = minutes % 10;
                document.querySelector('.span-number:nth-child(4)').textContent = Math.floor(seconds / 10);
                document.querySelector('.span-number:last-child').textContent = seconds % 10;

                const expirationDateString = expirationDate.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });
                const expirationTimeString = expirationDate.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                });

                document.getElementById('expiration-date').textContent = expirationDateString;
                document.getElementById('expiration-time').textContent = expirationTimeString;

                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();
    });
    function handlePaymentMethodChange() {
        const paymentMethodRadios = document.querySelectorAll('input[name="payment-method"]');

        paymentMethodRadios.forEach(radio => {
            const dataBlock = document.querySelector(`.${radio.value}-data`); // добавляем "-data" к значению

            if (radio.checked) {
                dataBlock.style.display = 'block';
            } else {
                dataBlock.style.display = 'none';
            }
        });
    }

    document.querySelectorAll('input[name="payment-method"]').forEach(radio => {
        radio.addEventListener('change', handlePaymentMethodChange);
    });

    window.onload = handlePaymentMethodChange;
</script>
</body>
</html>

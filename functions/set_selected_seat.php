<?php
session_start();
if(isset($_POST)) {
    $data = file_get_contents("php://input");
    $selectedSeat = json_decode($data, true);
    $_SESSION['selected_seat_id'] = $selectedSeat;

    echo $selectedSeat;
}
?>

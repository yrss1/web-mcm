<?php
session_start();
if(isset($_POST)) {
    $data = file_get_contents("php://input");
    $selectedBus = json_decode($data, true);
    $_SESSION['selected_bus_id'] = $selectedBus;

    echo $selectedBus;
}
?>

<?php
session_start();

function checkAuthentication() {
    if (!isset($_SESSION["user_id"])) {
        header("Location: warning.php");
        exit();
    }
}

function checkNotAuthentication() {
    if (isset($_SESSION["user_id"])) {
        header("Location: main.php");
        exit();
    }
}
?>

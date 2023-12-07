<?php

require_once 'db/db.php';

function GetBus()
{
    $stmt = $pdo->prepare('SELECT * FROM buses');
    $stmt->execute();
    $bus = $stmt->fetchAll();
    return $bus;
}

?>
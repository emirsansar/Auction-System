<?php
    require_once '../database.php';

    $query = $db->prepare("SELECT * FROM items");
    $query->execute();
    $items = $query->fetchAll(PDO::FETCH_ASSOC);

?>
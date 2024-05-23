<?php
require_once '../database.php';

// Veritabanından tüm itemleri çek
$query = $db->prepare("SELECT * FROM items");
$query->execute();
$items = $query->fetchAll(PDO::FETCH_ASSOC);

?>

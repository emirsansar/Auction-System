<?php
require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = $_POST['itemId'];

    $query = $db->prepare("SELECT price FROM items WHERE id = :id");
    $query->bindParam(':id', $itemId);
    $query->execute();
    $item = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode((int) $item['price']);
}
?>
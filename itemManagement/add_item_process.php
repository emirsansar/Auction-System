<?php
session_start();

require_once '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName = $_POST['itemName'];
    $itemDate = $_POST['itemDate'];
    $itemPrice = $_POST['itemPrice'];

    $publisher = $_SESSION['username'];

    if (!$itemName || !$itemDate || !$itemPrice) {
        echo "Invalid input. Please check all fields.";
        exit();
    }

    if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $itemDate)) {
        echo "Invalid date format. Please use 'DD-MM-YYYY'";
        exit();
    }

    // Prepare and execute insert query
    $query = $db->prepare("INSERT INTO items (name, expired_date, price, publisher) VALUES (:name, :expired_date, :price, :publisher)");
    $query->bindParam(':name', $itemName);
    $query->bindParam(':expired_date', $itemDate);
    $query->bindParam(':price', $itemPrice);
    $query->bindParam(':publisher', $publisher);
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "Your item is successfully added.";
        echo "<br>";
        echo "<a href='../homePage/main_page.php'>Go back to 'Items List'</a>";
    } else {
        echo "Error adding item. Please try again.";
    }
} else {
    echo "Invalid request method.";
}

?>
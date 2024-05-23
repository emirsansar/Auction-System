<?php
    session_start();

    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newBid = $_POST['newPrice'];

        $itemId = $_POST['itemId'];
        $expired_date = $_POST['expired_date'];

        $highest_bidder = $_SESSION['username'];

        $query = $db->prepare("SELECT price FROM items WHERE id = :id");
        $query->bindParam(':id', $itemId);
        $query->execute();
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($newBid > $item['price']) {
            $updateQuery = $db->prepare("UPDATE items SET price = :price, highest_bidder = :highest_bidder WHERE id = :id");
            $updateQuery->bindParam(':price', $newBid);
            $updateQuery->bindParam(':id', $itemId);
            $updateQuery->bindParam(':highest_bidder', $highest_bidder);
            $updateQuery->execute();

            $item['price'] = $newBid;

            header('Location: item_detail.php?id=' . $itemId);
            exit();
        }
    }

?>
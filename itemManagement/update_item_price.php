<?php
    session_start();

    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newBid = $_POST['newBid'];
        $itemId = $_POST['itemId'];

        $query = $db->prepare("SELECT price FROM items WHERE id = :id");
        $query->bindParam(':id', $itemId);
        $query->execute();
        $item = $query->fetch(PDO::FETCH_ASSOC);

        if ($newBid > $item['price']) {
            $highest_bidder = $_SESSION['username'];

            $updateQuery = $db->prepare("UPDATE items SET price = :price, highest_bidder = :highest_bidder WHERE id = :id");
            $updateQuery->bindParam(':price', $newBid);
            $updateQuery->bindParam(':id', $itemId);
            $updateQuery->bindParam(':highest_bidder', $highest_bidder);
            $updateQuery->execute();

            $item['price'] = $newBid;

            header('Location: item_detail.php?id=' . $itemId);
            exit();
        }
        else {
            echo "<p style='color: red;'>Your bid cannot be equal to or lower than the current price.</p>";
            echo "<br>";
            echo "<a href='item_detail.php?id=" .$itemId. "'>Return to the 'item details'.</a>";
            echo "<br><br>";
            echo "<a href='../homePage/main_page.php'>Return to the 'Item List'.</a>";

        }
    }
?>
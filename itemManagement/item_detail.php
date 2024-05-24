<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../authentication/login.php');
    exit();
}

$itemId = $_GET['id'];

require_once '../database.php';

// ID'ye göre ilgili öğeyi sorgula
$query = $db->prepare("SELECT * FROM items WHERE id = :id");
$query->bindParam(':id', $itemId);
$query->execute();
$item = $query->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Böyle bir öğe bulunamadı!";
    exit();
}

$expiredDateTimestamp = strtotime($item['expired_date']);
$currentDateTimestamp = strtotime(date('Y-m-d'));

$secondsDiff = $expiredDateTimestamp - $currentDateTimestamp;

$daysDiff = floor($secondsDiff / (60 * 60 * 24));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class=" bg-secondary d-flex justify-content-center align-items-center vh-100" >

<div class="container bg-light col-md-6">
    <h1>Item Detail</h1>

    <label for="idLabel" style="font-size: 17px; font-weight: bold;"><strong>ID:</strong></label>
    <span id="idLabel"><?php echo $item['id']; ?></span><br>

    <label for="nameLabel" style="font-size: 17px; font-weight: bold;"><strong>Name:</strong></label>
    <span id="nameLabel"><?php echo $item['name']; ?></span><br>

    <label for="expiredDateLabel" style="font-size: 17px; font-weight: bold;" ><strong>Expired Date:</strong></label>
    <span id="expiredDateLabel"><?php echo $item['expired_date']; ?></span><br>

    <label for="publisherLabel" style="font-size: 17px; font-weight: bold;" ><strong>Publisher:</strong></label>
    <span id="publisherLabel"><?php echo $item['publisher']; ?></span><br>

    <label for="isSoldLabel" style="font-size: 17px; font-weight: bold;"><strong>Is Sold:</strong></label>
    <span id="isSoldLabel"><?php echo $item['is_sold'] ? 'Yes' : 'No'; ?></span><br><br>

    <?php if ($expiredDateTimestamp >= $currentDateTimestamp): ?>

        <?php if (!$item['is_sold']): ?>
            <label for="highestBidderLabel" style="font-size: 17px; font-weight: bold;" ><strong>Highest Bidder:</strong></label>
            <span id="highestBidderLabel"><?php echo $item['highest_bidder']; ?></span><br>

            <label for="price" id="priceLabel" style="font-size: 17px; font-weight: bold;"><strong>Current Price:</strong></label>
            <span id="currentPrice"><?php echo $item['price']; ?></span><br>

            <small class="form-text text-muted">The price is refreshed in every 2 seconds.</small><br>

            <?php if ($daysDiff < 1) { ?>
                <small style="color: red;">It's last day! The auction will be closed 23.59!</small>
            <?php }
            else { ?>
                <small style="color: red;"><?php echo $daysDiff; ?> days left until the auction closes.</small> <br><br>
            <?php } ?>

            <form method="post" action="update_item_price.php">

                <div class="form-group">
                    <label for="newBid">Your Auction:</label>
                    <input type="text" class="form-control" id="newBid" name="newBid" required><br>
                    <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
                    <input type="hidden" name="itemDate" value="<?php echo $item['expired_date']; ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>

            </form>
        <?php else: ?>
            <label for="highestBidderLabel" style="font-size: 17px; font-weight: bold;" ><strong>Winner User:</strong></label>
            <span id="highestBidderLabel"><?php echo $item['highest_bidder']; ?></span><br>

            <label for="price" id="lastPrice" style="font-size: 17px; font-weight: bold;"><strong>Last Price:</strong></label>
            <span id="lastPrice"><?php echo $item['price']; ?></span><br>
            <br>
            <p style="color: red;">This item has been sold!</p>
        <?php endif; ?>
    <?php else: ?>
        <p style="color: red;">This auction is expired!</p>
    <?php endif; ?> <br>

    <a href="../homePage/main_page.php">Back to 'Items List'</a> <br>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function (){

        function checkPrice(){
            $.ajax({
                url:"check_item_price.php",
                type:"POST",
                data: { itemId: <?php echo $itemId; ?> },
                success:function (result) {
                    if ($("#currentPrice").text() != result) {
                        $("#currentPrice").text(result);
                    }
                }
            });
        }

        setInterval(checkPrice, 2000);
    });

</script>


</body>
</html>
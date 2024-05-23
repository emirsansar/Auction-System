<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../authentication/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class=" bg-secondary d-flex justify-content-center align-items-center vh-100" >

    <div class="container bg-light col-md-9" >
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <h3>Items List</h3>
        <p>Click on the 'ID' number to access item details.</p>

        <table id="itemsTable" class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Expired Date</th>
                <th>Publisher</th>
                <th>Is Sold</th>
                <th>Price</th>
                <th>Highest Bidder</th>
            </tr>

            <?php
            require_once 'welcome_process.php';

            foreach ($items as $item) {
                echo "<tr>";
                echo "<td><a href='../itemManagement/item_detail.php?id=" . $item['id'] . "'>" . $item['id'] . "</a></td>";
                echo "<td>" . $item['name'] . "</td>";
                echo "<td>" . $item['expired_date'] . "</td>";
                echo "<td>" . $item['publisher'] . "</td>";
                echo "<td>" . ($item['is_sold'] ? 'Yes' : 'No') . "</td>";
                echo "<td>" . $item['price'] . "</td>";
                echo "<td>" . $item['highest_bidder'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table> <br><br>

        <button class="btn btn-success" onclick="redirectToAddItemPage()">Add Item</button>
        <br><br>
        <button class="btn btn-warning" onclick="logOut()">Log Out</button>
        <br><br>
    </div>

    <script>
        function redirectToAddItemPage(){
            window.location.href = "../itemManagement/add_item.php";
        }

        function logOut(){
            window.location.href = "../authentication/logout.php";
        }
    </script>


</body>
</html>

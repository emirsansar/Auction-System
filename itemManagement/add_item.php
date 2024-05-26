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
    <title>Add Item</title>

    <style></style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class=" bg-secondary d-flex justify-content-center align-items-center vh-100 " >

    <div class="container bg-light col-md-6">
        <h1>Add New Item</h1>

        <form method="post" action="add_item_process.php">
            <div class="form-group">
                <label for="itemName">Item Name:</label><br>
                <input type="text" class="form-control" id="itemName" name="itemName" required><br>
            </div>

            <div class="form-group">
                <label for="itemDate">Date (DD-MM-YYYY):</label><br>
                <input type="date" class="form-control" id="itemDate" name="itemDate" required><br>
            </div>

            <div class="form-group">
                <label for="itemPrice">Price:</label><br>
                <input type="number" class="form-control" id="itemPrice" name="itemPrice" step="0.01" required><br>
            </div>

            <button type="submit" class="btn btn-success">Add Item</button>
        </form>

        <br>
        <a href="../homePage/main_page.php">Back to Items List</a> <br>
    </div>

</body>
</html>
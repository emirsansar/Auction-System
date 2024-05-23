<?php
    session_start();

    if (isset($_SESSION['username'])) {
        header('Location: ../homePage/welcome.php');

        exit();
    }
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class=" bg-secondary d-flex justify-content-center align-items-center vh-100" >

    <div class="container bg-light col-md-4">
        <form action="login_process.php" method="post"> <br>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div> <br><br>

            <button type="button" class="btn btn-primary" onclick="redirectToRegister()">Sign Up</button>
            <button type="submit" class="btn btn-success">Log In</button> <br><br>

        </form>
    </div>

    <script>
        function redirectToRegister() {
            window.location.href = 'register.php';
        }
    </script>

</body>
</html>

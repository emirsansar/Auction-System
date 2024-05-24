<?php
    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];

        if ($password != $re_password) {
            echo "Passwords don't match! Please try again.";
            echo "<br>";
            echo "<a href='register.php'>Go back to Registration</a>";
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "Kullanıcı adı veya email zaten mevcut!";
        } else {
            $query = $db->prepare("INSERT INTO users (name, surname, username, email, password) VALUES (:name, :surname, :username, :email, :password)");
            $query->bindParam(':name', $name);
            $query->bindParam(':surname', $surname);
            $query->bindParam(':username', $username);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $passwordHash);
            $query->execute();

            header('Location: login.php');
            exit();
        }
    }
?>
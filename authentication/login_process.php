<?php
    session_start();

    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kullanıcı adı ve şifreyi veritabanında kontrol et
        $query = $db -> prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ( $user && password_verify($password, $user['password']) ) {
            // Kullanıcı adı ve şifre session'a kaydediliyor
            $_SESSION['username'] = $user['username'];

            // Yönlendirme
            header('Location: ../homePage/main_page.php');
            exit();
        } else {
            echo "Kullanıcı adı veya şifre yanlış!";
        }
    }
?>

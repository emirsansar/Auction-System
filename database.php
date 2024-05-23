<?php

try {
    $conn = mysqli_connect("127.0.0.1", "root", "");

    $sql = 'CREATE DATABASE IF NOT EXISTS Proje';

    if (mysqli_query($conn, $sql)) {

        if (mysqli_query($conn, "USE Proje")) {

            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                surname VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL UNIQUE,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

            mysqli_query($conn, $sql);


            $sql = "CREATE TABLE IF NOT EXISTS items (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(50) NOT NULL,
                expired_date DATE DEFAULT NULL,
                publisher VARCHAR(50) NOT NULL,
                is_sold TINYINT(1) NOT NULL DEFAULT 0,
                price INT(11) NOT NULL,
                highest_bidder VARCHAR(50) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

            mysqli_query($conn, $sql);
        }
        else {
            die(mysqli_error($conn));
        }
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }

    try {
        $db = new PDO("mysql:host=127.0.0.1;dbname=Proje;charset=utf8", "root", "");
    } catch (PDOException $e) {
        die("Failed to connect to database: " . $e->getMessage());
    }

    mysqli_close($conn);
}
catch (Exception $e) {
    echo "Connection to server error: " . $e->getMessage();
}

?>

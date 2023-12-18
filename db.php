<?php
// db.php

$host = "localhost";
$user = "root";
$password = "";
$database = "ecom1_project";

// Creation d'une connexion à la base de données
$con = mysqli_connect($host, $user, $password, $database);

// Vérification de la connexion
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

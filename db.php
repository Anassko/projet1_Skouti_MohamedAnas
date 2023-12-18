<?php
// db.php

$con = mysqli_connect("localhost", "root", "", "ecom1_project");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

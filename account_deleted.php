<?php

include("header.php");
include("head.php");
if (!session_id()) session_start();
?>
<html lang="en">

    <div class="container mt-5">
        <h2>Your Account has been Deleted</h2>

        <form action="register.php" method="get">
            <button type="submit" class="btn btn-primary mt-3">Register</button>
        </form>

        <p class="mt-3">Thank you for being a part of our community!</p>
    </div>
</html>

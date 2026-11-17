<?php
    require_once "HTML/Template/ITX.php";
    include "./php/common.php";

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    echo($user);
    echo($pass);
?>
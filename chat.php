<?php
    require_once "HTML/Template/ITX.php";
    include "./php/common.php";

    $templates = new HTML_Template_ITX('./components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $link = connect();

    if(userExists($user, $pass)) {
        $templates->loadTemplateFile("chat.html");
        $templates->setVariable("USER", $user)
    } else {    
        echo("¿Quién eres?");
    }

    @mysqli_close($link);
?>
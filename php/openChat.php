<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('./components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $chat_id = sanitize($_POST['chatId']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        echo("<h1>$user</h1>");
        echo("<h1>$pass</h1>");
        echo("<h1>$chat_id</h1>");

        @mysqli_close($link);
    }

    echo("<h1>Hola</h1>");
?>
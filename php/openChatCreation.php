<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('../components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $templates->loadTemplateFile("./create-chat.html", true, false);
        $templates->show();
    }
?>
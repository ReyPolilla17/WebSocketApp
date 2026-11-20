<?php
    require_once "HTML/Template/ITX.php";
    include "./php/common.php";

    $templates = new HTML_Template_ITX('./components');
    
    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    
    $user_id = userExists($user, $pass);
    
    if($user_id) {
        $link = connect();

        $templates->loadTemplateFile("chat.html");

        $templates->setVariable("USER", $user);
        $templates->setVariable("PASS", $pass);
        
        $templates->addBlockFile("CHAT", "CHAT", "./create-chat.html");
        $templates->touchBlock("CHAT");
        
        $query_user_chats = "CALL getUserChats($user_id)";
        $result_user_chats = mysqli_query($link, $query_user_chats);

        $i = 0;

        $templates->addBlockFile("CHATS_LIST", "CHATS_COLLECTION", "./chats-list.html");
        
        while($line_user_chats = mysqli_fetch_assoc($result_user_chats)) {
            $c_id = $line_user_chats['chat_id'];
            $c_name = $line_user_chats['chat_name'];
            $c_image = $line_user_chats['chat_image'];
            
            $templates->setCurrentBlock("CHATS");

            $templates->setVariable("IMAGE", $c_image);
            $templates->setVariable("NAME", $c_name);
            $templates->setVariable("ID", $c_id);

            $templates->parseCurrentBlock();
            
            $i++;
        }

        if($i) {
            mysqli_free_result($result_user_chats);
        }

        $templates->show();

        @mysqli_close($link);
    } else {    
        echo("¿Quién eres?");
    }
?>
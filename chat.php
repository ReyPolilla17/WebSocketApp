<?php
    require_once "HTML/Template/ITX.php";
    include "./php/common.php";

    $templates = new HTML_Template_ITX('./components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $link = connect();

    if(userExists($user, $pass)) {
        $templates->loadTemplateFile("chat.html");
        
        $templates->addBlockFile("CHAT", "CHAT", "./placeholder.html");
        $templates->touchBlock("CHAT");

        $query_user_id = "SELECT user_id FROM users WHERE user_name = '$user' AND user_password = '$pass' LIMIT 1";
        $result_user_id = mysqli_query($link, $query_user_id);
        
        if($line_user_id = mysqli_fetch_assoc($result_user_id)) {
            $user_id = $line_user_id['user_id'];
            
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

            mysqli_free_result($result_user_id);
        }
    } else {    
        echo("¿Quién eres?");
    }

    $templates->show();

    @mysqli_close($link);
?>
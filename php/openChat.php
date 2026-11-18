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

        $query_conversation = "SELECT * FROM conversations WHERE conversation_id = $chat_id";
        $result_conversation = mysqli_query($link, $query_conversation);

        if($line_conversation = mysqli_fetch_assoc($result_conversation)) {
            $templates->loadTemplateFile('conversation.html');

            $templates->setVariable("CHAT_IMAGE", $line_conversation['conversation_image']);
            $templates->setVariable("CHAT_NAME", $line_conversation['conversation_name']);
    
            $query_messages = "SELECT message_id, message_timestamp, message_content, user_id, user_name, user_image FROM v_chat_messages WHERE conversation_id = $chat_id";
            $result_messages = mysqli_query($link, $query_messages);
    
            $i = 0;

            while($line_messages = mysqli_fetch_assoc($result_messages)) {
                $message_id = $line_messages['message_id'];
                $message_timestamp = $line_messages['message_timestamp'];
                $message_content = $line_messages['message_content'];
                
                $m_user_id = $line_messages['user_id'];
                $m_user_name = $line_messages['user_name'];
                $m_user_image = $line_messages['user_image'];

                if($m_user_id == $user_id) {
                    $templates->setCurrentBlock("YOUR_MESSAGES");
                } else {
                    $templates->setCurrentBlock("OTHER_MESSAGES");
                }

                $templates->setVariable("ID", $message_id);
                $templates->setVariable("TIMESTAMP", $message_timestamp);
                $templates->setVariable("CONTENT", $message_content);
                $templates->setVariable("AUTHOR_NAME", $m_user_name);
                $templates->setVariable("AUTHOR_IMAGE", $m_user_image);

                $templates->parseCurrentBlock();

                $i++;
            }

            if($i) {
                mysqli_free_result($result_messages);
            }

            mysqli_free_result($result_conversation);
        } else {
            $templates->loadTemplateFile("placeholder.html");
            $templates->parseCurrentBlock();
        }

        $templates->show();

        @mysqli_close($link);
    } else {
        echo("HUH?");
    }
?>
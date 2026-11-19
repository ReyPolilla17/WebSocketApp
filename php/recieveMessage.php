<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('../components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $chat_id = sanitize($_POST['chatId']);
    $message_id = sanitize($_POST['messageId']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        $query_conversation = "SELECT 1 can_chat FROM user_conversation WHERE user_id = $user_id AND conversation_id = $chat_id LIMIT 1";
        $result_conversation = mysqli_query($link, $query_conversation);

        if($line_conversation = mysqli_fetch_assoc($result_conversation)) {
            $query_message = "SELECT message_id, message_timestamp, message_content, user_id, user_name, user_image FROM v_chat_messages WHERE conversation_id = $chat_id AND message_id = $message_id";
            $result_message = mysqli_query($link, $query_message);

            if($line_message = mysqli_fetch_assoc($result_message)) {
                $templates->loadTemplateFile("messages.html");

                $message_id = $line_message['message_id'];
                $message_timestamp = $line_message['message_timestamp'];
                $message_content = $line_message['message_content'];

                $m_user_id = $line_message['user_id'];
                $m_user_name = $line_message['user_name'];
                $m_user_image = $line_message['user_image'];

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

                mysqli_free_result($result_message);
            }
            
            mysqli_free_result($result_conversation);
        }

        $templates->show();

        @mysqli_close($link);
    }
?>
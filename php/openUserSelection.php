<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('../components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $type = sanitize($_POST['type']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        $templates->loadTemplateFile("user-selection.html");

        $query_users = "SELECT user_id, user_name, user_image, birth_date, creation_date FROM users WHERE user_id != $user_id";
        $block_name = "USERS_GROUP_LIST";
        
        if($type == 1) {
            $templates->addBlockFile("SELECTION", "CHAT_SELECTION", "./user-selection-chat.html");
            
            $query_users = "SELECT u.user_id, u.user_name, u.user_image, u.birth_date, u.creation_date, uc.conversation_id FROM user_conversation uc LEFT JOIN users u ON uc.user_id = u.user_id WHERE u.user_id != $user_id HAVING uc.conversation_id IN (SELECT c.conversation_id FROM user_conversation uc LEFT JOIN conversations c ON uc.conversation_id = c.conversation_id WHERE is_chat = 1 AND uc.user_id = $user_id)";
            $block_name = "USERS_CHAT_LIST";
        } else {
            $templates->addBlockFile("SELECTION", "GROUP_SELECTION", "./user-selection-group.html");
        }

        $templates->addBlockFile("USERS_LIST", "USERS_COLLECTION", "./users-list.html");
        $result_users = mysqli_query($link, $query_users);

        $i = 0;

        while($line_users = mysqli_fetch_assoc($result_users)) {
            $templates->setCurrentBlock($block_name);

            $templates->setVariable("USER_NAME", $line_users['user_name']);
            
            $templates->parseCurrentBlock();

            $i++;
        }

        if($i) {
            mysqli_free_result($result_users);
        }

        $templates->show();

        @mysqli_close($link);
    }
?>
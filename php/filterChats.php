<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('../components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $search_input = sanitize($_POST['searchInput']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        $query_chats = "SELECT c.conversation_id chat_id, IF(c.is_chat, u.user_image, c.conversation_image) chat_image, IF(c.is_chat, u.user_name, c.conversation_name) chat_name FROM user_conversation uc LEFT JOIN users u ON uc.user_id = u.user_id LEFT JOIN conversations c ON uc.conversation_id = c.conversation_id WHERE uc.conversation_id IN(SELECT conversation_id FROM user_conversation WHERE user_id = $user_id) AND u.user_id != $user_id HAVING chat_name LIKE '%$search_input%' OR chat_id LIKE '%$search_input%'";
        $result_chats = mysqli_query($link, $query_chats);

        $i = 0;

        $templates->loadTemplateFile("./chats-list.html");

        while($line_chats = mysqli_fetch_assoc($result_chats)) {
            $c_id = $line_chats['chat_id'];
            $c_name = $line_chats['chat_name'];
            $c_image = $line_chats['chat_image'];

            $templates->setCurrentBlock("CHATS");
            
            $templates->setVariable("IMAGE", $c_image);
            $templates->setVariable("NAME", $c_name);
            $templates->setVariable("ID", $c_id);

            $templates->parseCurrentBlock();

            $i++;
        }

        if($i) {
            mysqli_free_result($result_chats);
        }
        
        $templates->show();

        @mysqli_close($link);
    }
?>
<?php
    include "./common.php";

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $link = connect();

    $elements = array();

    $user_id = userExists($user, $pass);

    if($user_id) {
        $query_chats = "SELECT conversation_id FROM user_conversation WHERE user_id = $user_id";
        $result_chats = mysqli_query($link, $query_chats);
        
        $elements['user'] = $user_id;
        $chats = array();

        $i = 0;

        while($line_chats = mysqli_fetch_assoc($result_chats)) {
            array_push($chats, $line_chats['conversation_id']);
            
            $i++;
        }

        $elements['chats'] = $chats;

        if($i) {
            mysqli_free_result($result_chats);
        }
    }

    echo json_encode($elements);

    @mysqli_close($link);
?>
<?php
    include "./php/common.php";

    $user = sanitize($_POST['username']);
    $passwd = sanitize($_POST['password']);

    $link = connect();

    $data = array()

    if(userExists($user, $pass)) {
        $query_user_id = "SELECT user_id FROM users WHERE user_name = '$user' AND user_password = '$pass' LIMIT 1";
        $result_user_id = mysqli_query($link, $query_user_id);
        
        if($line_user_id = mysqli_fetch_assoc($result_user_id)) {
            $user_id = $line_user_id['user_id'];

            $query_chats = "SELECT conversation_id FROM user_conversation WHERE user_id = $user_id";
            $result_chats = mysqli_query($link, $query_chats);

            $i = 0;

            while($line_chats = mysqli_fetch_assoc($result_chats)) {
                $c_id = $line_user_chats['conversation_id'];
                
                $data[] = "$c_id";
                
                $i++;
            }

            if($i) {
                var_dump($data);
                mysqli_free_result($result_user_chats);
            }

            mysqli_free_result($result_user_id);
        }

        echo json_encode($data);
    }
?>
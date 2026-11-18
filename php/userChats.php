<?php
    include "./common.php";

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $link = connect();

    $str = "[";

    if(userExists($user, $pass)) {
        $query_user_id = "SELECT user_id FROM users WHERE user_name = '$user' AND user_password = '$pass' LIMIT 1";
        $result_user_id = mysqli_query($link, $query_user_id);
        
        if($line_user_id = mysqli_fetch_assoc($result_user_id)) {
            $user_id = $line_user_id['user_id'];

            $query_chats = "SELECT conversation_id FROM user_conversation WHERE user_id = $user_id";
            $result_chats = mysqli_query($link, $query_chats);

            $i = 0;

            while($line_chats = mysqli_fetch_assoc($result_chats)) {
                $c_id = $line_chats['conversation_id'];

                if($i) {
                    $str = "$str,";
                }
                
                $str = "$str '$c_id'";
                
                $i++;
            }

            if($i) {
                mysqli_free_result($result_chats);
            }

            mysqli_free_result($result_user_id);
        }
    }

    $str = "$str ]";

    echo json_encode($str);

    @mysqli_close($link);
?>
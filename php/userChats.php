<?php
    include "./common.php";

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    $link = connect();

    $str = "[";

    $elements = array();

    $user_id = userExists($user, $pass);

    if($user_id) {
        $query_chats = "SELECT conversation_id FROM user_conversation WHERE user_id = $user_id";
        $result_chats = mysqli_query($link, $query_chats);
        
        $elements['user'] = $user_id;
        
        $chats = array();

        $i = 0;

        while($line_chats = mysqli_fetch_assoc($result_chats)) {
            $c_id = $line_chats['conversation_id'];

            array_push($chats, $c_id);

            if($i) {
                $str = "$str,";
            }
            
            $str = "$str $c_id";
            
            $i++;
        }

        $elements['chats'] = $chats;

        if($i) {
            mysqli_free_result($result_chats);
        }
    }

    $str = "$str ]";

    echo json_decode($elements)
    echo($str);

    @mysqli_close($link);
?>
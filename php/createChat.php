<?php
    include './common.php';

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $user2_id = sanitize($_POST['userId']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        $query_chat = "CALL createChat($user_id, $user2_id)";
        $result_chat = mysqli_query($link, $query_chat);

        if($line_chat = mysqli_fetch_assoc($result_chat)) {            
            $line_chat['category'] = "u_$user2_id";

            $context = new ZMQContext();
            $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
            $socket->connect("tcp://localhost:5555");

            $socket->send(json_encode($line_chat));

            echo("$line_chat['conversation_id']\n$user2_id\n$user_id");

            mysqli_free_result($result_chat);
        }

        @mysqli_close($link);
    }
?>
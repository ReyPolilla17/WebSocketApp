<?php
    require_once "HTML/Template/ITX.php";
    include './common.php';

    $templates = new HTML_Template_ITX('../components');

    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $chat_id = sanitize($_POST['chatId']);
    $message = sanitize($_POST['message']);

    $user_id = userExists($user, $pass);

    if($user_id) {
        $link = connect();

        $query_conversation = "SELECT 1 can_chat FROM user_conversation WHERE user_id = $user_id AND conversation_id = $chat_id LIMIT 1";
        $result_conversation = mysqli_query($link, $query_conversation);

        if($line_conversation = mysqli_fetch_assoc($result_conversation)) {
            $query_send = "CALL sendMessage('$message', $chat_id, $user_id)";
            $result_send = mysqli_query($link, $query_send);

            if($line_send = mysqli_fetch_assoc($result_send)) {
                $line_send['type'] = 'message';
                var_dump($line_send);

                $context = new ZMQContext();
                $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
                $socket->connect("tcp://localhost:5555");

                $socket->send(json_encode($line_send));

                echo("hola");
            }

            mysqli_free_result($result_conversation);
        }

        @mysqli_close($link);
    }
?>
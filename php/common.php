<?php
    function sanitize($string) {
        return implode("\'", explode("'", implode("\\\\", explode("\\", $string))));
    }

    function connect() {
        $cfgServer['host']	= 'localhost';
        $cfgServer['user']	= 'messageApp';
        $cfgServer['password']	= '1234';
        $cfgServer['dbname']	= 'messages';

        $link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']);
        mysqli_select_db($link, $cfgServer['dbname']);

        return $link;
    }

    function userExists($user, $pass) {
        $link = connect();

        $query = "SELECT * FROM users WHERE user_name = '$user' AND user_password = '$pass' LIMIT 1";
        $result = mysqli_query($link, $query);

        @mysqli_close($link);

        if($line = mysqli_fetch_assoc($result)) {
            mysqli_free_result($result);    
            return 1;
        } else {
            return 0;
        }
    }
?>
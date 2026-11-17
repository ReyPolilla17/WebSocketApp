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
?>
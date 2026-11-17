<?php
    include "common.php";

    // trata todas las cadenas que recibe
    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);
    $date = sanitize($_POST['date']);

    // se conecta a la base de datos
    $link = connect();
    
    // verifica si el usuario existe
    $query = "SELECT * FROM users WHERE user_name = '$user' LIMIT 1";
    $result = mysqli_query($link, $query);

    // si el usuario existe, no permite crear la cuenta y regresa error
    if($line = mysqli_fetch_assoc($result)) {
        print('0');
        
        mysqli_free_result($result);
    } else { // de lo contrario, crea el usuario
        $reg_query = "CALL createUser('$user', '$pass', '$date')";
        mysqli_query($link, $reg_query);
        
        print('1');
    }

    // cierra la conexion con la base de datos
    @mysqli_close($link);
?>
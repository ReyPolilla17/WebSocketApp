<?php
    include "common.php";

    // trata las cadenas recibidas
    $user = sanitize($_POST['username']);
    $pass = sanitize($_POST['password']);

    // se conecta a la base de datos
    $link = connect();
    
    // busca usuarios con la información recibida
    $query = "SELECT * FROM b_cuentas WHERE usuario = '$user' AND contrasena = '$pass' LIMIT 1";
    $result = mysqli_query($link, $query);

    // si el usuario existe, regresa un 1 (la forma que encontré de hacer esto "seguro")
    if($line = mysqli_fetch_assoc($result)) {
        print("1");
        
        mysqli_free_result($result);
    } else { // de lo contrario, regresa 0
        print('0');
    }

    // cierra la conexión con la base de datos
    @mysqli_close($link);
?>
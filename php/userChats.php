<?php
    $data = array(
        'a' => 1
    );
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
?>
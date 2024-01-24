<?php


function excluir_users($user_id){
    //chamada a ligacao da bd
	include 'backend/connections/conn.php';

    $query = "DELETE FROM `users` WHERE `user_id` = $user_id";
    $result = $conn->query($query);

    if($conn->error){
        echo "Erro: " . $query . "<br>" . $conn->error;
    }

	include 'backend/connections/deconn.php';
}




?>
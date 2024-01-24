<?php


function excluir_departamento($id){
    //chamada a ligacao da bd
	include 'backend/connections/conn.php';
    mysqli_query($conn,"UPDATE users SET user_departamento = 1 WHERE user_departamento = '$id'");
    mysqli_query($conn,"DELETE FROM departamentos WHERE id = '$id'");

    if($conn->error){
        echo "Erro: " . $query . "<br>" . $conn->error;
    }
    
	include 'backend/connections/deconn.php';
}



?>
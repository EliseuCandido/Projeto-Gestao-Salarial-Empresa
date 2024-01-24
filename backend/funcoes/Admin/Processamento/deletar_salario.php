<?php

function excluir_salario($id){


        include 'backend/connections/conn.php';

        // Consulta SQL para deletar o processamento de salario
        $sql ="DELETE FROM processamento_salarios WHERE `processamento_salarios`.`id` =$id";
        $resultado = $conn->query($sql);
 

        include 'backend/connections/deconn.php';
       
}
?>

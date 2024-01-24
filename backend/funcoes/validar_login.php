<?php 
function validar_login($user_email, $user_senha){
    
    //chamada a ligacao da bd
    include 'backend/connections/conn.php';
    //Comparar os dados inseridos no form com a bd
    //mysqli_fetch_array - Retornar sob a form de array os valores obtidos na bd
    //mysqli_query - executar determinado comando sql (identificar a ligacao a usar para executar o comando)
    $validar = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$user_email' AND user_senha = '$user_senha'"));
    //Nao existem as credenciais inseridas na BD
    if(!$validar){
		echo '<div class="col-1">
        <h6>Os dados inseridos não são válidos</h6>
		</div>';
    }else{
        $_SESSION["user_type"] = $validar["user_type"];
        $_SESSION["user_email"] = $user_email;
        $_SESSION["user_id"] = $validar["user_id"]; 
        echo '<meta http-equiv="refresh" content="0;url=?">';
    }
    
    include 'backend/connections/deconn.php';
}
?>
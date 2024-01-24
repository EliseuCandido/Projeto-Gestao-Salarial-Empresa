<?php
//identificar variaveis utilizadas
$servername = "localhost";
$username = "root";
$password = "";
//criar a ligação a BD
$conn = mysqli_connect($servername, $username, $password);
//Verificar se a ligação foi bem sucedida
if(!$conn){
	//Nao foi estabelecida ligacao à BD
	die("Erro de Ligação: ".mysqli_connect_error());
}else{
	//foi estabelecida ligacao à BD
	mysqli_select_db($conn, "processamento_salarial");
	//opcional forçar tipologia de caracteres
	mysqli_set_charset($conn, "utf8");
}
?>

<?php
// Declaracao de funcao php
function barra_navegacao(){
	
	if(@$_SESSION["user_type"] == 'admin'){
		//Admin Menu
		echo '<li><a class="letra" href="?p=usuarios">Usuarios</a></li>';
    	echo '<li><a class="letra" href="?p=departamentos">Departamentos</a></li>';
		echo '<li><a class="letra" href="?p=processamentos">Processamentos</a></li>';
	}
	if(@$_SESSION["user_type"] == 'user'){
		echo '
			<li><a class="letra" href="?p=processos">Processos</a></li>
			<li><a class="letra" href="?p=profile">Perfil</a></li>';

	}

	if (@$_SESSION["user_email"] == null) {
		include 'modules/paginas/login.php';
	}
	//Opção de logout da conta autenticada
	// if(@$_SESSION["user_type"] != ''){
	// 	echo '<li><a href="sair.php">Sair</a></li>';
	// }
}

?>

<style>.letra {
	font-size: 1.2em; /* Ajuste o tamanho conforme necessário */
}</style>
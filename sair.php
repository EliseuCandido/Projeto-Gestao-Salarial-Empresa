<?php 
//habilitar a sessao que está em curso (vamos buscar os dados do browser)
session_start();
//destruimos esses mesmos dados (qualquer variavel de sessao e a sessao em si)
session_destroy();
//recarregamos a pagina
echo '<meta http-equiv="refresh" content="0;url=index.php">';

?>
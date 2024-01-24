<?php
//Habilitar a utilização de variáveis de sessão
session_start();

include 'validar_login.php';
include 'barradenavegacao.php';
include 'User/user_profile.php';
include 'User/user_processo.php';


// admin
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin'){
    // USUARIO
    include 'Admin/Usuario/criar_users.php';
    include 'Admin/Usuario/tabela_users.php';
    include 'Admin/Usuario/editar_users.php';
    include 'Admin/Usuario/excluir_users.php';
    

    // DEPARTAMENTO
    include 'Admin/Departamento/criar_departamento.php';
    include 'Admin/Departamento/tabela_departamento.php';
    include 'Admin/Departamento/editar_departamento.php';
    include 'Admin/Departamento/excluir_departamento.php';


    // SALARIO
    include 'Admin/Processamento/tabela_processamento.php';
    include 'Admin/Processamento/processar_salario.php';
    include 'Admin/Processamento/deletar_salario.php';


}
?>
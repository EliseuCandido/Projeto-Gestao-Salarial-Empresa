<main class="mb1" >
    <?php

    @$escolha = $_REQUEST['p'];

    switch ($escolha) {
        case 'sair':
            include 'modules/paginas/login.php';
            break;
        case 'profile':
            include 'modules/paginas/profile.php';
            break;
        case 'processos':
            include 'modules/paginas/processos.php';
            break;


        	//admin options
		case 'usuarios';
            include 'modules/admin/usuarios.php';
        break;
        case 'departamentos';
            include 'modules/admin/departamentos.php';
        break;
        case 'processamentos';
            include 'modules/admin/processamentos.php';
            break;
            //fazer para admin
        default:
            if(@$_SESSION["user_type"] == 'admin'){
                include 'modules/admin/usuarios.php';
            }
            if(@$_SESSION["user_type"] == 'user'){
                include 'modules/paginas/processos.php';
            }
         break;
    }

    ?>
    
</main>

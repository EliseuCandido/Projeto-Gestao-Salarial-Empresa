<?php

function echo_tabela_departamento() {
    ob_start();  // Inicia o buffer de saída
    include 'backend/connections/conn.php';
    
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        echo_editar_departamento($id);
    }
    elseif (isset($_GET['criar'])) {
        echo_criar_departamento();
    } else {
        $sql = $conn->prepare("SELECT * FROM `departamentos`");
        $sql->execute();
        $result = $sql->get_result();   

        echo '
        <a href="?p=departamentos&criar" class="btn btn-primary">CRIAR DEPARTAMENTO</a>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nome do Departamento</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            if ($row['id'] != 1) {     
                echo '<tr>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['descricao'] . '</td>';
                echo '<td>';
                echo '<a href="?p=departamentos&edit=' . $row['id'] . '" class="btn btn-primary btn-sm">Editar</a> '; // Bootstrap primary button
                echo '<a href="?p=departamentos&delete=' . $row['id'] . '" onclick="return confirm(\'Tem certeza de que deseja excluir este departamento?\')" class="btn btn-danger btn-sm">Excluir</a>'; // Bootstrap danger button
                echo '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>
            </table>
        </div>';
        
        $sql->close();
    }

    // Verificar se o parâmetro 'delete' está definido
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        excluir_departamento($id);
        echo '<meta http-equiv="refresh" content="0;url=?p=departamentos">';
    }

    include 'backend/connections/deconn.php';
    ob_end_flush();  // Limpa o buffer de saída e desliga a saída do buffer
}



?>

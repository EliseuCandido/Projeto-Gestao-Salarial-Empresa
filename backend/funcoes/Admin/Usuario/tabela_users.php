<?php

function echo_table_users() {
    ob_start();  // Inicia o buffer de saída
    include 'backend/connections/conn.php';

    echo '<style>
    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        word-break: break-word;
        overflow-wrap: break-word;
        line-height: 1.2em;  
        max-height: 2.4em;  
        overflow: hidden;  
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }

    @media screen and (max-width: 768px) {
        table thead {
            display: none;
        }
    
        table tr {
            margin-bottom: 10px;
            display: block;
            border-bottom: 2px solid #ddd;
        }
    
        table td {
            display: block;
            text-align: right;
            font-size: 13px;
            border-bottom: 1px dotted #ccc;
        }
    
        table td:last-child {
            border-bottom: 0;
        }
    
        table td:before {
            content: attr(data-label);
            float: left;
            text-transform: uppercase;
            font-weight: bold;
        }

        .botoes{
            padding-bottom: 40px!important;
        }
    }
    

    @media screen and (max-width: 480px) {
        th, td {
            padding: 2px;
            font-size: 10px;
            line-height: 0.8em;  
            max-height: 1.6em; 
        }
    }
    </style>';

    if (isset($_GET['edit'])) {
        $user_id = $_GET['edit'];
        echo_editar_users($conn, $user_id);
    }
    elseif (isset($_GET['criar'])){
        echo_criar_users();
    } else {
        $sql = $conn->prepare("SELECT users.*, departamentos.nome as departamento_nome FROM users LEFT JOIN departamentos ON users.user_departamento = departamentos.id");
        $sql->execute();
        $result = $sql->get_result();        
        // $result = mysqli_query($conn, "SELECT * FROM `users`");
        
        echo '<a href="?p=usuarios&criar" class="btn btn-primary">CRIAR USUARIOS</a>';

        echo '
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nome</th>
                        <th>NIF</th>
                        <th>IBAN</th>
                        <th>Telefone Móvel</th>
                        <th>Telefone</th>
                        <th>Morada</th>
                        <th>Localidade</th>
                        <th>CP</th>
                        <th>Departamento</th>
                        <th>Função</th>
                        <th>Estado</th>
                        <th>Data de Nascimento</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>';

        while ($row = $result->fetch_assoc()) {
            if ($row['user_type'] === 'admin') {
                continue;
            }

            echo '
            <tr>
                <td data-label="Email">' . $row['user_email'] . '</td>
                <td data-label="Nome">' . $row['user_nome'] . '</td>
                <td data-label="NIF">' . $row['user_nif'] . '</td>
                <td data-label="IBAN">' . $row['user_iban'] . '</td>
                <td data-label="Telefone Móvel">' . $row['user_telm'] . '</td>
                <td data-label="Telefone">' . $row['user_tel'] . '</td>
                <td data-label="Morada">' . $row['user_morada'] . '</td>
                <td data-label="Localidade">' . $row['user_localidade'] . '</td>
                <td data-label="CP">' . $row['user_cp'] . '</td>
                <td data-label="Departamento">' . $row['departamento_nome'] . '</td>
                <td data-label="Função">' . $row['user_funcao'] . '</td>
                <td data-label="Estado">' . $row['user_estado'] . '</td>
                <td data-label="Data de Nascimento">' . $row['user_data_nasc'] . '</td>
                <td class="botoes" data-label="Opções">
                    <a href="?p=usuarios&edit=' . $row['user_id'] . '" class="btn btn-primary btn-sm">Editar</a> 
                    <a href="?p=usuarios&delete=' . $row['user_id'] . '" onclick="return confirm(\'Tem certeza de que deseja excluir este usuário?\')" class="btn btn-danger btn-sm">Excluir</a>
                    <a href="?p=usuarios&estado=' . $row['user_id'] . '" onclick="return confirm(\'Tem certeza de que deseja alterar o estado deste usuário?\')" class="btn btn-warning btn-sm">Estado</a>
                </td>
            </tr>';
        }

        echo '
                </tbody>
            </table>
        </div>';
        $sql->close();
    }

    if (isset($_GET['delete'])) {
        $user_id = $_GET['delete'];
        excluir_users($user_id);
        echo '<meta http-equiv="refresh" content="0;url=?p=usuarios">';
        exit();
    }
        if (isset($_GET['estado'])) {
            $user_id = $_GET['estado'];
            // Vamos buscar o estado atual do usuário
            $sql = $conn->prepare("SELECT user_estado FROM users WHERE user_id = ?");
            $sql->bind_param("i", $user_id);
            $sql->execute();
            $result = $sql->get_result();
            $user = $result->fetch_assoc();
            $sql->close();
        
            // Se o usuário estiver 'ativo', vamos alterar para 'desativado', caso contrário, vamos alterar para 'ativo'
            $novo_estado = $user['user_estado'] == 'ativo' ? 'desativado' : 'ativo';
        
            $sql = $conn->prepare("UPDATE users SET user_estado = ? WHERE user_id = ?");
            $sql->bind_param("si", $novo_estado, $user_id);
            $sql->execute();
            $sql->close();
        
            // Redirecionar de volta para a página de usuários
            echo '<meta http-equiv="refresh" content="0;url=?p=usuarios">';
            exit();
        }


    include 'backend/connections/deconn.php';
    ob_end_flush();  // Limpa o buffer de saída e desliga a saída do buffer
}
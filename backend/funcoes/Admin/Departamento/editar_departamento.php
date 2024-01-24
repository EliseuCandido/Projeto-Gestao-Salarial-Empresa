<?php


function echo_editar_departamento($id) {
    //chamada a ligacao da bd
    include 'backend/connections/conn.php';
    if ($id == 1) {
        echo '<meta http-equiv="refresh" content="0;url=?p=departamentos">';
    }

    $sql = $conn->prepare("SELECT * FROM `departamentos` WHERE `id`=?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '
        <h3 class="mb-3">Editar Departamento</h3>
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Departamento</label>
                <input type="text" class="form-control" id="nome" name="nome" value="'.$row["nome"].'" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao">'.$row["descricao"].'</textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="bt_editar_departamento">Salvar Alterações</button>
            <a href="?p=departamentos" class="btn btn-secondary">Cancelar</a>
        </form>
        ';
        

        if (isset($_POST["bt_editar_departamento"])) {
            $nome = $_POST["nome"];
            $descricao = $_POST["descricao"];
            editar_departamento($id, $nome, $descricao);
        }
    }

    $sql->close();
    include 'backend/connections/deconn.php';
}

function editar_departamento($id, $nome, $descricao) {
    include 'backend/connections/conn.php';

    $sql = $conn->prepare("UPDATE `departamentos` SET `nome`=?, `descricao`=? WHERE `id`=?");
    $sql->bind_param("ssi", $nome, $descricao, $id);
    $sql->execute();
    $sql->close();

    include 'backend/connections/deconn.php';

    // Redireciona para a mesma página (substitua '?p=sua_pagina' pela URL atual)
    echo '<meta http-equiv="refresh" content="0;url=?p=departamentos">';

}



?>





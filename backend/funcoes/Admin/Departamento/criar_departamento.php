<?php

function echo_criar_departamento() {
    echo '
    <h3 class="my-3">Criar Novo Departamento</h3>
    <form method="post">
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="nome">Nome do Departamento</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome do Departamento" required>
            </div>
            <div class="col-sm-6">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" placeholder="Descrição do Departamento"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-primary" name="bt_criar_departamento">Criar Departamento</button>
                <a href="?p=departamentos" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
    ';

    if (isset($_POST["bt_criar_departamento"])) {
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];

        criar_departamento($nome, $descricao);
    }
}

function criar_departamento($nome, $descricao) {
    //chamada a ligacao da bd
    include 'backend/connections/conn.php';

    $sql = $conn->prepare("INSERT INTO `departamentos`(`nome`, `descricao`) VALUES (?, ?)");
    $sql->bind_param("ss", $nome, $descricao);
    $sql->execute();
    $sql->close();

    include 'backend/connections/deconn.php';

    echo '<meta http-equiv="refresh" content="0;url=?p=departamentos">';
}

?>

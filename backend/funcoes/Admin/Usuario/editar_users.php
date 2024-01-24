<?php


function echo_editar_users()
{
    if (!isset($_GET["edit"])) {
        echo '<meta http-equiv="refresh" content="0;url=?p=usuarios">';
    }

    $user_id = $_GET["edit"];

    // Chamada a ligação da bd
    include 'backend/connections/conn.php';

    $sql = $conn->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $sql->bind_param("i", $user_id);
    $sql->execute();
    $user = $sql->get_result()->fetch_assoc();
    $sql->close();



    echo '
    <!-- Edição de usuário existente -->
    <div class="container mt-3">
        <h3>Editar Usuário</h3>
        <form method="post" class="row g-3">
            <input type="hidden" name="user_id" value="' . (isset($user['user_id']) ? $user['user_id'] : '') . '">

            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="' . (isset($user['user_nome']) ? $user['user_nome'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="data_nasc" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nasc" name="data_nasc" value="' . (isset($user['user_data_nasc']) ? $user['user_data_nasc'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="nif" class="form-label">NIF</label>
                <input type="text" class="form-control" id="nif" name="nif" value="' . (isset($user['user_nif']) ? $user['user_nif'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" class="form-control" id="iban" name="iban" value="' . (isset($user['user_iban']) ? $user['user_iban'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="telm" class="form-label">Telefone Móvel</label>
                <input type="tel" class="form-control" id="telm" name="telm" value="' . (isset($user['user_telm']) ? $user['user_telm'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="tel" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="tel" name="tel" value="' . (isset($user['user_tel']) ? $user['user_tel'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="' . (isset($user['user_email']) ? $user['user_email'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="morada" class="form-label">Morada</label>
                <input type="text" class="form-control" id="morada" name="morada" value="' . (isset($user['user_morada']) ? $user['user_morada'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="localidade" class="form-label">Localidade</label>
                <input type="text" class="form-control" id="localidade" name="localidade" value="' . (isset($user['user_localidade']) ? $user['user_localidade'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="cp" class="form-label">CP</label>
                <input type="text" class="form-control" id="cp" name="cp" value="' . (isset($user['user_cp']) ? $user['user_cp'] : '') . '">
            </div>

            <div class="col-md-6">
                <label for="departamento" class="form-label">Departamento</label>
                <select class="form-control" id="departamento" name="departamento">';


    // Buscar os departamentos no banco de dados
    $sql = $conn->prepare("SELECT `id`, `nome` FROM `departamentos`");
    $sql->execute();
    $result = $sql->get_result();
    while ($row = $result->fetch_assoc()) {
        // Se o departamento do usuário for igual ao departamento da iteração atual, selecione essa opção
        $selected = ($user['user_departamento'] == $row['id']) ? 'selected' : '';
        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nome'] . '</option>';
    }



    echo '</select>
        </div>

        <div class="col-md-6">
            <label for="funcao" class="form-label">Função</label>
            <input type="text" class="form-control" id="funcao" name="funcao" value="' . (isset($user['user_funcao']) ? $user['user_funcao'] : '') . '">
        </div>

        <div class="col-md-6">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="ativo" ' . (isset($user['user_estado']) && $user['user_estado'] == 'ativo' ? 'selected' : '') . '>Ativo</option>
                <option value="desativado" ' . (isset($user['user_estado']) && $user['user_estado'] == 'desativado' ? 'selected' : '') . '>Desativado</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="bt_editar_users">Editar Usuário</button>
            <a href="?p=usuarios" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
';

    if (isset($_POST["bt_editar_users"])) {
        $nome = $_POST["nome"];
        $data_nasc = $_POST["data_nasc"];
        $nif = $_POST["nif"];
        $iban = $_POST["iban"];
        $telm = $_POST["telm"];
        $tel = $_POST["tel"];
        $user_email = $_POST["user_email"];
        $morada = $_POST["morada"];
        $localidade = $_POST["localidade"];
        $cp = $_POST["cp"];
        $departamento = $_POST["departamento"];
        $funcao = $_POST["funcao"];
        $estado = $_POST["estado"];

        editar_users($user_id, $nome, $data_nasc, $nif, $iban, $telm, $tel, $user_email, $morada, $localidade, $cp, $departamento, $funcao, $estado);
    }

    include 'backend/connections/deconn.php';
}

function editar_users($user_id, $user_nome, $user_data_nasc, $user_nif, $user_iban, $user_telm, $user_tel, $user_email, $user_morada, $user_localidade, $user_cp, $user_departamento, $user_funcao, $user_estado)
{
    // Chamada a ligação da bd
    include 'backend/connections/conn.php';

    $sql = $conn->prepare("UPDATE `users` SET `user_nome`=?, `user_data_nasc`=?, `user_nif`=?, `user_iban`=?, `user_telm`=?, `user_tel`=?, `user_email`=?, `user_morada`=?, `user_localidade`=?, `user_cp`=?, `user_departamento`=?, `user_funcao`=?, `user_estado`=? WHERE `user_id`=?");
    $sql->bind_param("sssssssssssssi", $user_nome, $user_data_nasc, $user_nif, $user_iban, $user_telm, $user_tel, $user_email, $user_morada, $user_localidade, $user_cp, $user_departamento, $user_funcao, $user_estado, $user_id);
    $sql->execute();
    $sql->close();

    include 'backend/connections/deconn.php';
    echo '<meta http-equiv="refresh" content="0;url=?p=usuarios">';
}

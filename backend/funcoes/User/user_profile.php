<?php
include 'backend/connections/conn.php';

function echo_profile() {
    if (!isset($_SESSION['user_id'])) {
        echo '<div class="alert alert-danger" role="alert">Usuário não está logado ou a sessão expirou.</div>';
        return;
    }

    $user_id = $_SESSION['user_id'];

    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obter dados do formulário
        $user_iban = $_POST["user_iban"];
        $user_telm = $_POST["user_telm"];
        $user_tel = $_POST["user_tel"];
        $user_morada = $_POST["user_morada"];
        $user_localidade = $_POST["user_localidade"];
        $user_cp = $_POST["user_cp"];

        // Preparar a consulta SQL
        $sql = $conn->prepare("UPDATE `users` SET `user_iban`=?, `user_telm`=?, `user_tel`=?, `user_morada`=?, `user_localidade`=?, `user_cp`=? WHERE `user_id`=?");
        $sql->bind_param("ssssssi", $user_iban, $user_telm, $user_tel, $user_morada, $user_localidade, $user_cp, $user_id);

        // Executar a consulta SQL
        if ($sql->execute()) {
            echo '<div class="alert alert-success" role="alert">Registro atualizado com sucesso.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Erro ao atualizar o registro: ' . $conn->error . '</div>';
        }

    }

    // Busca os dados atualizados do usuário
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $sql->bind_param("i", $user_id);
    $sql->execute();
    $result = $sql->get_result();



    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();


    if (isset($row['user_departamento']) && $row['user_departamento'] !== null) {
        $departamento_id = $row['user_departamento'];
        $sql_dep = $conn->prepare("SELECT nome FROM departamentos WHERE id = ?");
        $sql_dep->bind_param("i", $departamento_id);
        $sql_dep->execute();
        $result_dep = $sql_dep->get_result();
        $row_dep = $result_dep->fetch_assoc();
        $nome_departamento = $row_dep['nome'];
    }

        
        echo '
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card mt-5">
                        <img class="card-img-top rounded-circle mx-auto d-block mt-4" style="width: 200px; height: 200px; object-fit: cover;" src="https://img.freepik.com/vetores-premium/expressao-calmamente-surpreendida-no-rosto-de-homem-ou-indiferenca-emocao-de-surpresa-nada-mal-frustracao_165429-1345.jpg" alt="Imagem do perfil">

                        <div class="card-body">
                            <h3 class="card-title text-center">Perfil</h3>
                            <div class="view-profile">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Email:</strong> ' . $row['user_email'] . '</li>
                                    <li class="list-group-item"><strong>Nome:</strong> ' . $row['user_nome'] . '</li>
                                    <li class="list-group-item"><strong>NIF:</strong> ' . $row['user_nif'] . '</li>
                                    <li class="list-group-item"><strong>IBAN:</strong> ' . $row['user_iban'] . '</li>
                                    <li class="list-group-item"><strong>Telefone Móvel:</strong> ' . $row['user_telm'] . '</li>
                                    <li class="list-group-item"><strong>Telefone:</strong> ' . $row['user_tel'] . '</li>
                                    <li class="list-group-item"><strong>Morada:</strong> ' . $row['user_morada'] . '</li>
                                    <li class="list-group-item"><strong>Localidade:</strong> ' . $row['user_localidade'] . '</li>
                                    <li class="list-group-item"><strong>CP:</strong> ' . $row['user_cp'] . '</li>
                                    <li class="list-group-item"><strong>Departamento:</strong> ' . $nome_departamento . '</li>
                                    <li class="list-group-item"><strong>Função:</strong> ' . $row['user_funcao'] . '</li>
                                    <li class="list-group-item"><strong>Data de Nascimento:</strong> ' . $row['user_data_nasc'] . '</li>
                                </ul>
                                <button class="btn btn-primary edit-button">Editar</button>
                            </div>
                            <div class="edit-profile" style="display: none;">
                                <form id="edit-profile-form" method="POST" action="">

                                    <div class="form-group">
                                    <label for="user_email"><strong>Email:</strong></label>
                                    <input type="email" class="form-control" id="user_email" name="user_email" value="'.$row['user_email'].'" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="user_nome"><strong>Nome:</strong></label>
                                    <input type="text" class="form-control" id="user_nome" name="user_nome" value="'.$row['user_nome'].'" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="user_nif"><strong>NIF:</strong></label>
                                    <input type="text" class="form-control" id="user_nif" name="user_nif" value="'.$row['user_nif'].'" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="user_iban"><strong>IBAN:</strong></label>
                                    <input type="text" class="form-control" id="user_iban" name="user_iban" value="'.$row['user_iban'].'">
                                </div>
                                <div class="form-group">
                                    <label for="user_telm"><strong>Telefone Móvel:</strong></label>
                                    <input type="text" class="form-control" id="user_telm" name="user_telm" value="'.$row['user_telm'].'">
                                </div>
                                <div class="form-group">
                                    <label for="user_tel"><strong>Telefone:</strong></label>
                                    <input type="text" class="form-control" id="user_tel" name="user_tel" value="'.$row['user_tel'].'">
                                </div>
                                <div class="form-group">
                                    <label for="user_morada"><strong>Morada:</strong></label>
                                    <input type="text" class="form-control" id="user_morada" name="user_morada" value="'.$row['user_morada'].'">
                                </div>
                                <div class="form-group">
                                    <label for="user_localidade"><strong>Localidade:</strong></label>
                                    <input type="text" class="form-control" id="user_localidade" name="user_localidade" value="'.$row['user_localidade'].'">
                                </div>
                                <div class="form-group">
                                    <label for="user_cp"><strong>CP:</strong></label>
                                    <input type="text" class="form-control" id="user_cp" name="user_cp" value="'.$row['user_cp'].'">
                                </div>
                                    <button type="submit" class="btn btn-primary save-button">Salvar alterações</button>
                                    <button type="button" class="btn btn-secondary cancel-button">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(".edit-button").click(function(){
                $(".view-profile").hide();
                $(".edit-profile").show();
            });

            $(".cancel-button, .save-button").click(function(){
                $(".edit-profile").hide();
                $(".view-profile").show();
            });

        </script>
        ';
    } else {
        echo '<div class="alert alert-warning" role="alert">Não foram encontrados detalhes do usuário.</div>';
    }
    $sql->close();
}

include 'backend/connections/deconn.php';
?>

<?php

function echo_criar_users(){
    echo'
    <!-- Criação de novo usuário -->
    <h3>Criar Novo Usuário</h3>
    <form method="post">
        <div class="row mb1">
            <div class="col col-6 text_center vtext_middle">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Nome">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Data de Nascimento</label>
                <input type="date" name="data_nasc" placeholder="Data de Nascimento">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>NIF</label>
                <input type="text" name="nif" placeholder="NIF">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>IBAN</label>
                <input type="text" name="iban" placeholder="IBAN">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Telefone Móvel</label>
                <input type="tel" name="telm" placeholder="Telefone Móvel">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Telefone</label>
                <input type="tel" name="tel" placeholder="Telefone">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Email</label>
                <input type="email" name="user_email" placeholder="Email">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Senha</label>
                <input type="password" name="user_senha" placeholder="Senha">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Morada</label>
                <input type="text" name="morada" placeholder="Morada">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Localidade</label>
                <input type="text" name="localidade" placeholder="Localidade">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>CP</label>
                <input type="text" name="cp" placeholder="Código Postal">
            </div>

            <div class="col col-6 text_center vtext_middle">
            <label>Departamento</label>
            <select name="departamento">';

                // Chamada a ligação da bd
                include 'backend/connections/conn.php';

                // Buscar os departamentos no banco de dados
                $sql = $conn->prepare("SELECT `id`, `nome` FROM `departamentos`");
                $sql->execute();
                $result = $sql->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                }
            
                // $sql->close();

                include 'backend/connections/deconn.php';

                echo    '</select>
            </div>


            <div class="col col-6 text_center vtext_middle">
                <label>Função</label>
                <input type="text" name="funcao" placeholder="Função">
            </div>
            <div class="col col-6 text_center vtext_middle">
                <label>Estado</label>
                <input type="text" name="estado" placeholder="Estado">
            </div>
        </div>
        <div class="row mb1">
            <div class="col col-12 text_center vtext_middle">
               
                <button type="submit" class="btn btn-primary" name="bt_criar_users">Criar Usuário</button>
                <a href="?p=usuarios" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </form>
    ';    
    if(isset($_POST["bt_criar_users"])){


        $nome = $_POST["nome"];
        $data_nasc = $_POST["data_nasc"];      
        $nif = $_POST["nif"];
        $iban = $_POST["iban"];
        $telm = $_POST["telm"];
        $tel = $_POST["tel"];
        $user_email = $_POST["user_email"];
        $user_senha = $_POST["user_senha"];
        $morada = $_POST["morada"];
        $localidade = $_POST["localidade"];
        $cp = $_POST["cp"];
        $departamento = !empty($_POST["departamento"]) ? $_POST["departamento"] : NULL;
        $funcao = $_POST["funcao"];
        $estado = $_POST["estado"];
    
        criar_users($nome, $data_nasc, $nif, $iban, $telm, $tel, $user_email, $user_senha, $morada, $localidade, $cp, $departamento, $funcao, $estado);
    }
    
    
}

function criar_users($nome, $data_nasc, $nif, $iban, $telm, $tel, $user_email, $user_senha, $morada, $localidade, $cp, $departamento, $funcao, $estado){
    //chamada a ligacao da bd
    include 'backend/connections/conn.php';

    $sql = $conn->prepare("INSERT INTO `users`(`user_nome`, `user_data_nasc`, `user_nif`, `user_iban`, `user_telm`, `user_tel`, `user_email`, `user_senha`, `user_morada`, `user_localidade`, `user_cp`, `user_departamento`, `user_funcao`, `user_estado`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssssssssssss", $nome, $data_nasc, $nif, $iban, $telm, $tel, $user_email, $user_senha, $morada, $localidade, $cp, $departamento, $funcao, $estado);
    $sql->execute();
    $sql->close();
    
    include 'backend/connections/deconn.php';

    echo '<meta http-equiv="refresh" content="0;url=?p=usuarios">';

}


?>

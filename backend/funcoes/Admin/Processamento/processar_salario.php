<?php

    function criar_processamento(){
	    include 'backend/connections/conn.php';

        echo '<div class="container mt-4">
        <form method="post">
        <div class="form-group">
            <label for="salario_bruto">Salário Bruto:</label>
            <input type="number" step="0.01" name="salario_bruto" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="ano">Ano:</label>
            <input type="number" min="2000" max="2023" step="1" name="ano" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="mes">Selecione o mês:</label>
            <select name="mes" class="form-control" required>
            <option value="1">Janeiro</option>
            <option value="2">Fevereiro</option>
            <option value="3">Março</option>
            <option value="4">Abril</option>
            <option value="5">Maio</option>
            <option value="6">Junho</option>
            <option value="7">Julho</option>
            <option value="8">Agosto</option>
            <option value="9">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
        </select>

        <!-- Seleção do Utilizador -->
        <label for="utilizador_id">Selecione o utilizador:</label>
        <select name="utilizador_id" class="form-control" required>';

        // Consulta para obter os users e seus departamentos
        $sql = "SELECT u.user_id, u.user_nome, u.user_type, d.nome AS departamentos FROM users u
        JOIN departamentos d ON u.user_departamento = d.id WHERE u.user_estado = 'ativo'";
        $result = $conn->query($sql);

        // Gerar as opções do select com os users e seus departamentos
        while ($row = $result->fetch_assoc()) {
            // Se o tipo do usuário for 'admin', então pule esta iteração
            if ($row['user_type'] === 'admin') {
                continue;
            }
            echo '<option value="' . $row['user_id'] . '">' . $row['user_nome'] . ' - ' . $row['departamentos'] . '</option>';
        }

        echo'
        </select>
            <div class="form-group">
            <button type="submit" name="calcular" class="btn btn-primary">Calcular</button>
            <a href="?p=processamentos" class="btn btn-secondary">Voltar</a>
            </div>
            </form>
         </div>

        ';

        if (isset($_POST['calcular'])) {
            $salario_bruto = $_POST['salario_bruto'];
            $mes = (int)$_POST['mes'];
            $ano = (int)$_POST['ano'];
            $utilizador_id = (int)$_POST['utilizador_id'];
    
            // Buscar o departamentos_id do utilizador
            $sql = "SELECT user_departamento FROM users WHERE user_id = $utilizador_id";
            $result = $conn->query($sql);
            $departamento_id = $result->fetch_assoc()['user_departamento'];
    
            // Obter o número total de dias no mês selecionado
            $dias_no_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    
            // Identificar os dias úteis (excluindo finais de semana)
            $dias_trabalhados = 0;
            for ($dia = 1; $dia <= $dias_no_mes; $dia++) {
                $data = date('Y-m-d', strtotime($ano.'-'.$mes.'-'.$dia));
                $dia_da_semana = date('N', strtotime($data)); // 1 (Segunda) a 7 (Domingo)
    
                // Se for um dia útil (segunda a sexta), incrementar a contagem de dias trabalhados
                if ($dia_da_semana >= 1 && $dia_da_semana <= 5) {
                    $dias_trabalhados++;
                }
            }
    
            // Cálculos
            $base_ss = $salario_bruto;
            $desconto_seguranca_social = $base_ss * 0.11;
    
            $base_irs = $salario_bruto; // Alterado para calcular a base do IRS a partir do salário bruto
            $taxa_irs = 0;
    
            if ($base_irs <= 1000) {
                $taxa_irs = 0.09;
            } elseif ($base_irs > 1000 && $base_irs <= 1750) {
                $taxa_irs = 0.13;
            } elseif ($base_irs > 1750) {
                $taxa_irs = 0.16;
            }
    
            $desconto_irs = $base_irs * $taxa_irs;
            $alimentacao_por_dia = 5.25;
            $alimentacao = $alimentacao_por_dia * $dias_trabalhados;
            $salario_liquido = $salario_bruto - $desconto_seguranca_social - $desconto_irs + $alimentacao;
    
            // Armazenar valores em sessão para salvar depois
            $_SESSION['salario_bruto'] = $salario_bruto;
            $_SESSION['mes'] = $mes;
            $_SESSION['ano'] = $ano;
            $_SESSION['salario_liquido'] = $salario_liquido;
            $_SESSION['desconto_seguranca_social'] = $desconto_seguranca_social;
            $_SESSION['desconto_irs'] = $desconto_irs;
            $_SESSION['alimentacao'] = $alimentacao;
            $_SESSION['dias_trabalhados'] = $dias_trabalhados;
            $_SESSION['utilizador_id'] = $utilizador_id;
            $_SESSION['departamento_id'] = $departamento_id;
    
            // Mostrar os resultados
            echo "Salário Bruto: $salario_bruto <br>";
            echo "Dias Trabalhados: $dias_trabalhados <br>";
            echo "Desconto Segurança Social: $desconto_seguranca_social <br>";
            echo "Desconto IRS: $desconto_irs <br>";
            echo "Alimentação: $alimentacao <br>";
            echo "Salário Líquido: $salario_liquido <br>";
    
            // Mostrar botão para salvar os resultados
            echo '<form method="post"><button type="submit" name="salvar">Processar</button></form>';
        }
    
        if (isset($_POST['salvar'])) {
            $salario_bruto = $_SESSION['salario_bruto'];
            $mes = $_SESSION['mes'];
            $ano = $_SESSION['ano'];
            $salario_liquido = $_SESSION['salario_liquido'];
            $desconto_seguranca_social = $_SESSION['desconto_seguranca_social'];
            $desconto_irs = $_SESSION['desconto_irs'];
            $alimentacao = $_SESSION['alimentacao'];
            $dias_trabalhados = $_SESSION['dias_trabalhados'];
            $utilizador_id = $_SESSION['utilizador_id'];
            $departamento_id = $_SESSION['departamento_id'];
    
             // Verificar se já existe um registro para o mesmo utilizador_id, mes e ano
             $sql = "SELECT * FROM processamento_salarios WHERE utilizador_id = $utilizador_id AND mes = $mes AND ano = $ano";
             $result = $conn->query($sql);
     
             if ($result->num_rows > 0) {
                 // Se existe um registro, mostrar uma mensagem de erro
                 echo "Utilizador com dados já processado, não é possivel processar novamente";
             } else {
                 // Se não existe um registro, inserir o novo registro
                 $sql = "INSERT INTO processamento_salarios(salario_bruto, salario_liquido, desconto_seguranca_social, desconto_irs, alimentacao, dias_trabalhados, utilizador_id, departamento_id, mes, ano)
                         VALUES ('$salario_bruto', '$salario_liquido', '$desconto_seguranca_social', '$desconto_irs', '$alimentacao', '$dias_trabalhados', '$utilizador_id', '$departamento_id', '$mes', '$ano')";
     
                 if ($conn->query($sql) === TRUE) {
                     echo "Processamento realizado com sucesso.";
                 } else {
                     echo "Error: " . $sql . "<br>" . $conn->error;
                 }
             }
    
         }
         
         include 'backend/connections/deconn.php';
    }

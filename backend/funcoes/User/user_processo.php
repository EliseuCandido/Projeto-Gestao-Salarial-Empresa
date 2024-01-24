<?php
function echo_user_processo(){
    include 'backend/connections/conn.php';
   
    if (!isset($_SESSION['user_id'])) {
        echo '<div class="alert alert-danger" role="alert">Usuário não está logado ou a sessão expirou.</div>';
        return;
    }

    $user_id = $_SESSION['user_id'];

    echo'
   <style>
   
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

$user_id = $_SESSION['user_id'];

echo'
<div class="container my-5">
    <div class="d-flex justify-content-between mb-2">
    </div>
    <form method="post" action="" class="mb-4">
        <div class="form-row ">
            <div class="col-md-6 mb-3">
                <label for="ano">Ano:</label>
                <input type="text" class="form-control" name="ano" id="ano">
            </div>
            <div class="col-md-6 mb-3">
                <label for="mes">Mês:</label>
                <input type="text" class="form-control" name="mes" id="mes">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <input type="submit" class="btn btn-primary w-100" value="Filtrar">
            </div>
        </div>
    </form>
    <table class="table table-hover table-responsive-md">
        <thead class="thead-dark">
            <tr>
                <th>Salário Bruto</th>
                <th>Ano</th>
                <th>Mês</th>
                <th>Dias Trabalhados</th>
                <th>Desconto Segurança Social</th>
                <th>Desconto IRS</th>
                <th>Alimentação</th>
                <th>Salário Líquido</th>
            </tr>
        </thead>
        <tbody>';

        $ano = $_POST['ano'] ?? '';
        $mes = $_POST['mes'] ?? '';
        $filtro = " AND p.utilizador_id = $user_id";
        if ($ano != '') {
            $filtro .= " AND p.ano=$ano";
        }
        if ($mes != '') {
            $filtro .= " AND p.mes=$mes";
        }
        
        $sql = "SELECT p.*, u.user_nome AS nome_utilizador, d.nome AS nome_departamento
            FROM processamento_salarios p
            LEFT JOIN users u ON p.utilizador_id = u.user_id
            LEFT JOIN departamentos d ON p.departamento_id = d.id
            WHERE 1=1 $filtro";
        $resultado = $conn->query($sql);
        $totalBruto = $totalSeguranca = $totalIrs = $totalAlimentacao = $totalLiquido = 0;
        while ($linha = $resultado->fetch_assoc()) {
    echo "
        <tr>
            <td>$linha[salario_bruto]</td>
            <td>$linha[ano]</td>
            <td>$linha[mes]</td>
            <td>$linha[dias_trabalhados]</td>
            <td>$linha[desconto_seguranca_social]</td>
            <td>$linha[desconto_irs]</td>
            <td>$linha[alimentacao]</td>
            <td>$linha[salario_liquido]</td>
        </tr>
    ";
    $totalBruto += $linha['salario_bruto'];
    $totalSeguranca += $linha['desconto_seguranca_social'];
    $totalIrs += $linha['desconto_irs'];
    $totalAlimentacao += $linha['alimentacao'];
    $totalLiquido += $linha['salario_liquido'];
}
                
echo "
    <tr>
        <td colspan='10'></td>
        <td>Total Bruto: $totalBruto</td>
        <td>Total Segurança: $totalSeguranca</td>
        <td>Total IRS: $totalIrs</td>
        <td>Total Alimentação: $totalAlimentacao</td>
        <td>Total Líquido: $totalLiquido</td>
    </tr>
";

echo'
        </tbody>
    </table>
</div>
';
}
?>

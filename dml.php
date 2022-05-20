<?php include_once './template-header.php'; ?>
<?php
$dmlController = new Application\Controller\DmlController();

$usuarioSql = "CREATE TABLE IF NOT EXISTS usuario (
    id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
    cpf VARCHAR( 50 ) NOT NULL, 
    nome VARCHAR( 250 ) NOT NULL);";
$createUser = $dmlController->createTable($usuarioSql);

$infoSql = "CREATE TABLE IF NOT EXISTS info (
    id integer NOT NULL PRIMARY KEY AUTOINCREMENT,
    cpf VARCHAR( 50 ) NOT NULL, 
    genero VARCHAR( 1 ) NOT NULL, 
    ano_nascimento VARCHAR( 6 ) NOT NULL);";
$createInfo = $dmlController->createTable($infoSql);

$userData = [
    [1, '16798125050', 'Luke Skywalker'],
    [2, '59875804045', 'Bruce Wayne'],
    [3, '04707649025', 'Diane Prince'],
    [4, '21142450040', 'Bruce Banner'],
    [5, '83257946074', 'Harley Quinn'],
    [6, '07583509025', 'Peter Parker']
];
$insertUser = $dmlController->insertValues('usuario', ['id', 'cpf', 'nome'], $userData);

$infoData = [
    [1, '16798125050', 'M', '1976'],
    [2, '59875804045', 'M', '1960'],
    [3, '04707649025', 'F', '1988'],
    [4, '21142450040', 'M', '1954'],
    [5, '83257946074', 'F', '1970'],
    [6, '07583509025', 'M', '1972']
];
$insertInfo = $dmlController->insertValues('info', ['id', 'cpf', 'genero', 'ano_nascimento'], $infoData);

$data = $dmlController->list();
?>
<style>
    .exercices {
        margin: 10px;
    }

    .exercices div {
        padding: 10px;
    }

    .exercices span {
        font-weight: bold;
    }
</style>
<main>
    <div class="box">
        <h1>Exercício 3</h1>
        <div class="exercices">
            <div>
                <span>Tabela de Usuário:</span> <i><?php echo ($createUser) ? 'Tabela criada com sucesso!' : 'Erro ao criar a tabela';?></i>
            </div>
            <div>
                <span>Tabela de Info:</span> <i><?php echo ($createInfo) ? 'Tabela criada com sucesso!' : 'Erro ao criar a tabela';?></i>
            </div>
            <div>
                <span>Dados de Usuário:</span> <i><?php echo ($insertUser) ? 'Dados inseridos com sucesso!' : 'Erro ao inserir os dados na tabela';?></i>
            </div>
            <div>
                <span>Dados de Info:</span> <i><?php echo ($insertInfo) ? 'Dados inseridos com sucesso!' : 'Erro ao inserir os dados na tabela';?></i>
            </div>
            <div>
                <span>Resultado:</span> 
                <table style="width: 500px;" border="1" cellspacing="0">
                    <tr>
                        <td>usuário</td>
                        <td>maior_50_anos</td>
                    </tr>
                <?php
                    $year = date('Y') - 50;
                    while ($r = $data->fetchObject()) {
                        $maiorQue = ($r->ano_nascimento > $year) ? "SIM" : "NÃO";
                        echo "<tr><td>".$r->nome."</td><td>".$maiorQue."</td></tr>";
                    }
                ?>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include_once './template-footer.php'; ?>
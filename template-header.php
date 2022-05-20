<?php
require_once 'autoload.php';

$security = Library\Security::getInstance();
$security->validateLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Superlógica Tecnologias</title>
        <meta charset="utf-8">
        <link href="public/css/all.min.css" rel="stylesheet"> <!--load all styles -->
        <link rel="stylesheet" href="public/css/layout.css" />
        <script src="public/js/jquery.min.js"></script>
        <script src="public/js/jquery.mask.js"></script>
        <script src="public/js/func.js"></script>
    </head>
    <body>
        <?php
        if (isset($_GET['actionError'])) {
            if ($_GET['actionError'] == 1) {
                Library\System::msg("Ação não localizada!", 'error');
            }
        }
        if (isset($_GET['tpmsg']) && isset($_GET['msg'])) {
                Library\System::msg($_GET['msg'], $_GET['tpmsg']);
        }
        ?>
        <div id="wrapper">
            <header>
                <section>
                    <div class="header-logo">
                        <img src="public/images/logo.png" />
                    </div>
                    <div class="header-menu">
                        <nav>
                            <a href="client-list.php" title="Exercício 1"><i class="fas fa-user"></i> Exercício 1</a>
                            <a href="array.php" title="Exercício 2"><i class="fas fa-layer-group"></i> Exercício 2</a>
                            <a href="dml.php" title="Exercício 3"><i class="fas fa-database"></i> Exercício 3</a>
                            <a href="logout.php" title="Sair"><i class="fas fa-sign-out-alt"></i> Sair</a>
                        </nav>
                    </div>
                </section>
            </header>
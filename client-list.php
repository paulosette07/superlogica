<?php include_once './template-header.php'; ?>
<?php
$clientController = new Application\Controller\ClientController();
$search = null;
if (isset($_GET['search'])) {
    if ($_GET['search'] != '') {
        $search = $_GET['search'];
    }
}
$list = $clientController->list($search);
$rows = 0;
if ($list['total'] > 0) {
    $rows = $list['data'];
}
$pages = $list['pages'];
?>
<main>
    <div class="box">
        <h1>Exercício 1</h1>
        <div class="searchBox">
            <form action="" method="get" class="searchForm" >
                <input type="text" name="search" class="iTxt" value="<?php echo $search; ?>"/><input type="submit" value="Buscar" class="iBtn"/>
            </form>
        </div>
        <div class="listBox">
            <div class="addNutton"><a href="client-form.php">Adicionar</a></div>
            <?php if ($rows != 0) : ?>
                <table>
                    <tr>
                        <th>Nome</th>
                        <th>Nome de Login</th>
                        <th>CEP</th>
                        <th>E-mail</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?php echo $r->getName(); ?></td>
                            <td><?php echo $r->getUserName(); ?></td>
                            <td><?php echo $r->getZipCode(true); ?></td>
                            <td><?php echo $r->getEmail(); ?></td>
                            <td><a href="client-form.php?key=<?php echo $r->getId(); ?>"><i class="fas fa-edit" style="color: blue;"></i></a></td>
                            <td><a href="#" onclick="deleteConfirm(<?php echo $r->getId(); ?>, 'client-func');"><i class="fas fa-trash" style="color: red;"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php if ($pages->items_total > 0) { ?>
                    <?php echo $pages->display_pages(); ?>
                    <?php echo $pages->display_items_per_page(); ?>
                    <?php echo $pages->display_jump_menu(); ?>
                <?php } ?>
            <?php else: ?>
                Nenhum registro encontrado
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include_once './template-footer.php'; ?>
<?php include_once './template-header.php'; ?>
<?php
$array = [10, 20, 15, 40, 35, 60, 70];
$arrayToString = implode(",", $array);
$StringToArray = explode(",", $arrayToString);
$exist14InArray = (in_array(14, $array)) ? 'true' : 'false';

$arrayToTest = $array;
for($i = 0; $i<=count($arrayToTest); $i++) {
    $old = 0;
    if($i > 0) {
        $old = $array[$i-1];
    }
    if($arrayToTest[$i] < $old) {
        unset($arrayToTest[$i]);
    }
}

$arrayPop = $array;
array_pop($arrayPop);
$arrayReverse = array_reverse($array);

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
        <h1>Exercício 2</h1>
        <div class="exercices">
            <div>
                <span>Array:</span> <i>($array = [10, 20, 15, 40, 35, 60, 70])</i>
            </div>
            <div>
                <span>Posição 3 <i>(echo $array[2])</i>: </span> <?php echo $array[2]; ?>
            </div>
            <div>
                <span>Array para String <i>(implode(",", $array))</i>: </span> <?php echo $arrayToString; ?>
            </div>
            <div>
                <span>String para Array <i>(explode(",", $arrayToString))</i>: </span> <?php print_r($StringToArray); ?>
            </div>
            <div>
                <span>Existe 14 no array? <i>(in_array(14, $array))</i>: </span> <?php echo $exist14InArray; ?>
            </div>
            <div>
                <span>Apaga quando o valor atual é menor que o anterior? <i>(unset($array[$i]))</i>: </span> [<?php echo implode(', ', $arrayToTest); ?>]
            </div>
            <div>
                <span>Excluir o ultimo elemento: <i>(array_pop($array))</i>: </span> [<?php echo implode(', ', $arrayPop); ?>]
            </div>
            <div>
                <span>Invertendo a ordem do array: <i>(array_reverse($array))</i>: </span> [<?php echo implode(', ', $arrayReverse); ?>]
            </div>
        </div>        
    </div>
</main>
<?php include_once './template-footer.php'; ?>
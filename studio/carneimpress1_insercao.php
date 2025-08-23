<?php
include './conexao.php';
include './dbselect.php';

// Recebe a query do JavaScript
$queryInsercao = $_POST['query'];

// Executa a inserção
$resultadoInsercao = mysqli_query($conec, $queryInsercao);

// Verifica se a inserção foi bem-sucedida
if ($resultadoInsercao) {
    echo 'Sucesso';
} else {
    echo 'Erro: ' . mysqli_error($conec);
}
?>

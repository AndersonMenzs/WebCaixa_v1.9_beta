<?php

$teste = 'Teste de impressão';

echo $teste;

shell_exec("echo $teste > teste.txt");
echo shell_exec("php -v");


?>

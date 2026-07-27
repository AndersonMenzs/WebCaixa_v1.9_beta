<?php

// Código do estúdio
$std = '218';

$conec = mysqli_connect ('localhost', 'root', 'cpd@cloud');
    IF (!$conec) { ?>
		  <br><br><br><font size='5' color='red'><center>Você não conseguiu conectar-se ao Servidor de Banco de Dados<br><br>
		      Por favor, contate seu Administrador Web.</center></font><?php
		 }
?>

<?php	

    // Abrindo a Conexão
include "conexao.php";

    // Selecionando o Banco de Dados
include "dbselect.php";

// Consultando dados na tabela
$sqls = "select numdoc, estorno, modpgto from registro where numdoc = '$NDoc' ";
$rss  = mysqli_query($conec, $sqls) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");
$lns = mysqli_fetch_array($rss);
$NDoc_b 	= $lns['numdoc'];
$Est 		= $lns['estorno'];
$Modpg 		= $lns['modpgto'];


// Comparando dados da coluna numdoc

if ($NDoc_a <> $NDoc_b) {
	
	$nd = 'ok';
	$e = "Aqui 1!";

} elseif (($NDoc_a == $NDoc_b and $Est == 'x' and $Modpg <> $FPag1) or ($NDoc_a == $NDoc_b and $Est == 'x' and $Modpg <> $FPag2) or ($NDoc_a == $NDoc_b and $Est == 'x' and $Modpg <> $FPag3)) {
	
	$nd = 'ok';
	$e = "Aqui 2!";

} else {
	
	$nd = 'no';
	$e = "Aqui 3!";

	?>
	<font color="gold" size="6">
		<br><b><center><i>Número do Documento Existente.</i></center></b></font>
		<font color="gold" size="6">
			<b><center><i>Favor Inserir o Dado Corretamente!</i></center></b></font><br><br>

			<?php


			include "../rodape.php";

			?>
			<meta http-equiv="refresh" content="5;URL=./servrec.php?c_s=<?php echo $lg_user; ?>">

			<?php
			exit(10);
			

		}

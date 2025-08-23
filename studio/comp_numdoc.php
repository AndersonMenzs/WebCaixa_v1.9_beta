<?php	

    // Abrindo a Conexão
include "conexao.php";

    // Selecionando o Banco de Dados
include "dbselect.php";

// Consultando dados na tabela
$sqls = "select numdoc, estorno from registro where numdoc = '$NDoc' ";
$rss  = mysqli_query($conec, $sqls) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");
$lns = mysqli_fetch_array($rss);
$NDoc_b 	= $lns['numdoc'];
$Est 		= $lns['estorno'];

// Comparando dados da coluna numdoc
if ($NDoc_a == $NDoc_b) {

	$nd = "no";

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
			

		} else {
			$nd = "ok";
		}

		// Encerrando a Conexão
		mysqli_free_result($rss);


		?>

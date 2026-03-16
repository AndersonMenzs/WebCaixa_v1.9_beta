<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 5%;
			margin-left: 3%;
			margin-right: 3%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}
	</style>

	<script>
		function toggleDoc(doc) {
			var linhas = document.querySelectorAll(".doc_" + doc);

			linhas.forEach(function(l) {
				if (l.style.display === "none") {
					l.style.display = "table-row";
				} else {
					l.style.display = "none";
				}
			});
		}
	</script>

	<?php
	// Inserindo o Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

	<?php
	// Obtendo o Login
	$Sis      = "S7";
	$Rot      = "S7R1.1.1";
	$lg_user  = $_POST['txtuser'];
	$user  = substr($lg_user, 0, 8);
	$pss   = substr($lg_user, 8, 40);
	$DataAut  = $_POST['txtdata'];
	$dtD    = substr($DataAut, 0, 2);
	$dtM    = substr($DataAut, 3, 2);
	$dtA    = substr($DataAut, 8, 2);
	$DataForm = "$dtD$dtM$dtA";

	include "us_sist.php";
	
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<table width="100%" border="0" cellpadding="05" cellspacing="0" align="center">
		<tr>
			<td>
				<a href="cntaud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td align="center">
				<font color="gold" size="6">
					<b><u><i>Autenticações do Dia - <font color='#FFFFFF'><?php echo $DataAut; ?></i></u></center></b>
				</font>
			</td>
			<td>
				<a href="cntaud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table><br><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		// Consultando o Banco de Dados
		include "conexao.php";
		include "dbselect.php";

		$sql  = "SELECT * FROM spool WHERE spo LIKE '%$DataForm%' ";
		$rs   = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador");
		$regs = mysqli_num_rows($rs);

		if ($regs > 0) {
	?>
			<table border="01" cellpadding="05" cellspacing="0" align="center">
				<tr>
					<td>
						<font size='4' color='aqua'><b><i>Autentic.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Documento</i></b></font>
					</td>
				</tr>

				<?php
				while ($ln       = mysqli_fetch_array($rs)) {
					$Rec    = $ln['rec'];
					$Spo     = $ln['spo'];
				?>
						<tr>
							<td align="center">
								<font><b><i><?php echo "$Rec"; ?></i></b></font>
							</td>
							<td>
								<font><b><i><?php echo "$Spo"; ?></i></b></font>
							</td>
						</tr>
				<?php
				}
				?>
			</table>
		<?php
		} else {
		?>
			<br><br>
			<font size='6' color='gold'><b>
					<center>
						<blink><u>Nenhum</u></blink>
						<font color='#FFFFFF'> Registro Encontrado Nesta Data!!!
					</center>
				</b></font><?php
						} ?>
		<br><br>
		<center><a href="cntaud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></center><br>
	<?php
	} else {
	?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='cntaud.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.1.1.1";
	include "rodape.php";

	// Encerrando as Conexões
	mysqli_close($conec);
	?>

</body>

</html>
<html>

<head>
	<title>WebCaixa v1.20.7_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 5%;
			margin-left: 5%;
			margin-right: 5%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}
	</style>

	<script>
		function F5(event) {
			var tecla = document.all ? window.event.keyCode : event.which;
			if (document.all) {
				window.event.keyCode = 0;
				window.event.returnValue = false;
			}
			if (tecla == 116) return false;
		}

		document.onkeydown = F5;
	</script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	include "../cabecprs.php";

	// Obtendo o Login
	$Sis  = "S7";
	$Rot  = "S7R6";
	$user = substr(100000000 + trim($_POST['txtmat']), 1, 8);
	$pass = strtolower(trim($_POST['txtsen']));
	$pss  = sha1($pass);
	$lg_user = $user . $pss;

	if ($user == '' or $user == 0) {
		$lg_user = $_REQUEST['c_s'];
		$user = substr($lg_user, 0, 8);
		$pss     = substr($lg_user, 8, 40);
	}

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok' or $ch == 'ok-enc') { ?><br><br>
		<font color='gold' size='5'><b><u><i>
						<center>MENU ENCARREGADA</center>
					</i></u></b></font><br><br>
		<table border='0' cellpadding='7' cellspacing='0' align='center'>
			<?php
			// Autorizando/Negando o Fechamento Parcial
			include "conexao.php";
			include "dbselect.php";

			$sql = "select fch from datafix";
			$rs  = mysqli_query($conec, $sql) or die("Erro de Acesso #1. Contate seu Administrador.");
			$ln  = mysqli_fetch_array($rs);
			$Fch = $ln['fch'];

			if ($Fch > 0) { ?>
				<tr>
					<td>
						<a href="fchparcsem.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Fechamento Parcial&nbsp;&nbsp; <font color='lime'>(sem&nbsp;&nbsp;Impressão)</i></b></font>
					</td>
				</tr>
			<?php
			} ?>

			<tr>
				<td>
					<a href="ultfech2.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
					<font size='4'><b><i>- Reimprimir Fechamentos Anteriores </i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<a href="solic.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
					<font size='4'><b><i>- Solicitação de Lote de Recibo </i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<br>
					<center><a href="./index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a></center><br>
				</td>
			</tr>
		</table>

		<meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>">
	<?php
	} else { ?>
		<br>
		<font size="6">
			<b><i>
					<center>Usuário <font color="gold">
							<blink>Não Autorizado</blink>
							<font color="#FFFFFF"><br>

								<font color="#FFFFFF">ou<br>Senha <font color="gold">
										<blink>Incorreta</blink>
										<font color="#FFFFFF">!!!
					</center>
				</i></b>
		</font>
		<br>
		<center><a href="./index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a></center><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.6";
	include "../rodapext.php"; ?>

</body>

</html>
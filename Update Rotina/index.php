<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-top: 2%;
			margin-left: 2%;
			margin-right: 2%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}

		center {
			text-align: center;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		td {
			padding: 5px;
		}

		blink {
			text-decoration: underline;
		}

		@keyframes blink-slow {
			0% {
				opacity: 1;
			}

			50% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		.blink-slow {
			animation: blink-slow 1.5s linear infinite;
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

	<script language="JavaScript">
		<!--
		javascript: window.history.forward(1);
		//
		-->
	</script><?php

				include "../cabecprs.php";

				// Autorizando o Login
				$Sis         = "S7";
				$lg_user     = $_REQUEST['c_s'];
				$user      = substr($lg_user, 0, 8);
				$pss       = substr($lg_user, 8, 40);
				$contadig  = substr($lg_user, 48, 1);
				$compSenha = strlen($contadig);
				$geracod   = date('smi') + date('ssi');
				$geracodF  = 1000000 + $geracod;
				$Codigo    = substr($geracodF, 1, 6);

				if ($compSenha == '0') {
					$contadig = 1;
				}

				if ($contadig == '0' or $contadig == '6') {
					$AtuSen = 'no';
				} else {
					$AtuSen = 'ok';
				}

				$lg_user = $user . $pss;
				$dataatual = date('Y-m-d');
				$Mes     = date('m');

				$ch      = '';
				$chI     = '';
				$chF     = '';
				$Versao  = "WebCaixa v1.20.0_beta";

				// Verificando Cadastramentos
				include "conexao.php";
				include "dbselect.php";

				$sqlAt  = "update operador set dataop = '$dataatual' where mat = '$user' ";
				$rsAt   = mysqli_query($conec, $sqlAt) or die("Erro de Acesso #1. Contate seu Administrador.");

				$sqlI = "select mat from inicial";
				$sqlO = "select mat from operador";

				$rsI  = mysqli_query($conec, $sqlI) or die("Erro de Acesso #2. Contate seu Administrador.");
				$rsO  = mysqli_query($conec, $sqlO) or die("Erro de Acesso #3. Contate seu Administrador.");

				$regI = mysqli_num_rows($rsI);
				$regO = mysqli_num_rows($rsO);

				if ($regI == 0 and $regO == 0) {
					$chI = 'no';
				} else {
					$chI = 'ok';
				}

				if ($regI == 0) {
					$ini = 'no';
				} else {
					$ini = 'ok';
				}

				// Verificando Fechamento Anterior
				$sqlF = "select dtopen, dtclose from caixa order by dtopen desc";
				$rsF  = mysqli_query($conec, $sqlF) or die("Erro de Acesso #4. Contate seu Administrador.");
				$regF = mysqli_num_rows($rsF);
				$lnF  = mysqli_fetch_array($rsF);
				$abre  = $lnF['dtopen'];
				$fecha = $lnF['dtclose'];

				if ($regF > 0 and  $abre <> $dataatual and $fecha == NULL) {
					$chF = 'no';
				} ?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	include "us_sist.php";

	if ($ch == 'no') {
		include "us_cad.php";
	}
	?>

	<center>
		<font face="arial" color="gold" size="6"><b><i><u>SISTEMA DO CAIXA</u></i></b></font>
	</center>
	<center>
		<font size="4" color="lime"><b><i>(Versão: <?php echo "$Versao"; ?>)</i></b></font>
	</center><br>
	<?php

	include "sitcaixa.php";

	if ($chF == 'no' and $AtuSen == 'ok') {
		$abY    = substr($abre, 0, 4);
		$abM    = substr($abre, 5, 2);
		$abD    = substr($abre, 8, 2);
		$dtabre = "$abD/$abM/$abY"; ?>

		<br>
		<font size="6">
			<b><i>
					<center>Você <font color="gold">"<blink><u>Não Fechou o Caixa</u></blink>"<font color="#FFFFFF"> do Dia <font color="gold">"<blink><u><?php echo $dtabre; ?></u></blink>"<font color="#FFFFFF">!</center>
				</i></b>
		</font><br>

		<form name="frmfecha" method="post" action="fechacaixa.php">
			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="dtabre" value="<?php echo $abre; ?>">
			<input type="hidden" name="txtcod" value="<?php echo $Codigo; ?>">
			<table width="100%" border="0" cellpadding="10" cellspacing="0">
				<tr>
					<td width='20%'>
						<a href="http://localhost/caixa/"><img src="./images/voltar.gif"></a>
					</td>
					<td width='60%' align='center'>
						<input type="submit" name="btenv" value="Fechar o Caixa">&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td width='20%' align='right'>
						<a href="http://localhost/caixa/"><img src="./images/voltar.gif"></a>
					</td>
			</table>
		</form>
	<?php
	} else if ($chI == 'no' and $ch == 'ok' and $AtuSen = 'ok') { ?>
		<table width='20%' border='0' cellpadding='7' cellspacing='0' align='center'>
			<tr>
				<td width="35%"></td>
				<td width="35%">
					<a href="acaud.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
					<font size='4'><b><i>- Auditoria </i></b></font>
				</td>
				<td width="30%"></td>
			</tr>

			<tr>
				<td width="35%"></td>
				<td width="35%">
					<a href="sair.php"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
					<font size='4'><b><i>- Sair do Sistema</i></b></font>
				</td>
				<td width="30%"></td>
			</tr>
		</table>
	<?php
	} else if ($chI == 'ok' and ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')) { ?>
		<table width='35%' border='0' cellpadding='5' cellspacing='0' align='center'>
			<?php
			if ($ch == 'ok' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="acaud.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Auditoria </i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok' or $ch == 'ok-enc') and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="cadop.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Cadastramento </i></b></font>
					</td>
					<td width="30%"></td>
				</tr>

				<tr>
					<td width="35%">
					<td width="35%">
						<a href="opercst.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Pesquisar Matrícula &amp; CPF</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if ($ini == 'ok' and ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and ($chcx == 'x' or $chcx == 'a') and $AtuSen == 'ok') {

				$sql = "DELETE FROM spool2";
				$rs = mysqli_query($conec, $sql) or die("Erro ao acessar o banco de dados. Entre em contato com o administrador.");
				//mysqli_free_result($rs);

			?>

				<tr>
					<td width="35%">
					<td width="35%">
						<a href="abrecaixa.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Abertura do Caixa</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="consulta.php?c_s=<?php echo $lg_user ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Consultas</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="servrec.php?c_s=<?php echo $lg_user ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Recebimentos</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%"></td>
					<td width="35%">
						<a href="pgtos.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Despesas &amp; Recolhimentos</i></b></font>
					</td>

					
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="estorno.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Estornos</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="impressos.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Impressões de Documentos</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $chcx == 'f' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="fecha.php?c_s=<?php echo $lg_user . $abre; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Fechamento do Caixa</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}
			if ($ch == 'ok-enc' and $AtuSen == 'ok') { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="acenc.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Encarregadas</i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			}

			if ($chI == 'ok' and ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai')) { ?>
				<tr>
					<td width="35%">
					<td width="35%">
						<a href="senha.php?c_s=<?php echo $lg_user; ?>"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
						<font size='4'><b><i>- Alteração de Senha </i></b></font>
					</td>
					<td width="30%"></td>
				</tr>
			<?php
			} ?>
			<tr>
				<td width="35%">
				<td width="35%">
					<a href="sair.php"><img src="./images/star4.gif" width="25" border="0" align="top"></a>
					<font size='4'><b><i>- Sair do Sistema</i></b></font>
				</td>
				<td width="30%"></td>
			</tr>
		</table>
	<?php
	} else { ?><br>
		<font size="6" color="#FFFFFF"><b><i>
					<center>Usuário <font color="gold">
							<blink>Não Autorizado</blink>
							<font color="#FFFFFF"><br>

								<font color="#FFFFFF">ou<br>Senha <font color="gold">
										<blink>Incorreta</blink>
										<font color="#FFFFFF">!!!</center>
				</i></b></font><br>
		<center><a href="http://localhost/caixa"><img src="./images/voltar.gif"></a></center><br>
	<?php
	}

	// Encerrando
	mysqli_free_result($rsI);
	mysqli_free_result($rsO);
	mysqli_free_result($rsF);

	$SisRot = "S-7";
	include "../rodapext.php"; ?>

</body>

</html>
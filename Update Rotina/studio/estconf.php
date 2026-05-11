<html>

<head>
	<title>WebCaixa v1.20.6_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-left: 5%;
			margin-right: 5%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>


	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>

	<script>
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
	</script>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R4.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtaut']);
	$AutFull = 10000 + $Aut;
	$AutF      = substr($AutFull, 1, 4);

	include "conexao.php";
	include "dbselect.php";

	// Obtendo a Data Atual
	$DataAtual = date('Ymd');

	// Obtendo número do documento
	$sqlD = "select numdoc from registro where reg = '$Aut' and datarec = '$DataAtual' and estorno <> 'x' ";
	$rsD  = mysqli_query($conec, $sqlD);
	$lnD  = mysqli_fetch_array($rsD);
	$NumDocE = $lnD['numdoc'];

	// Obtendo Dados
	$sqlE = "select reg, numdoc, tiporec, datarec, horarec, operador, vlrec from registro where reg >= '$Aut' and tiporec > '0' and estorno <> 'x' and numdoc = '$NumDocE' and datarec
= '$DataAtual'";
	$rsE  = mysqli_query($conec, $sqlE);
	$regE = mysqli_num_rows($rsE);

	while ($lnE  = mysqli_fetch_array($rsE)) {
		$Aut      = $lnE['reg'];
		$NumDocE   = $lnE['numdoc'];
		$TipoRecE  = $lnE['tiporec'];
		$DataRecE  = $lnE['datarec'];
		$HoraRecE  = $lnE['horarec'];
		$VlPago    = $lnE['vlrec'];
		$VlRec     = $VlRec + $VlPago;
		$VlRecF    = number_format($VlRec, 2, ',', '.');
		$OperadorE = $lnE['operador'];
	}

	$sqlR = "select * from tiporec where codrec = '$TipoRecE' ";
	$rsR  = mysqli_query($conec, $sqlR) or die("Não foi possível acessar os dados");
	$lnR  = mysqli_fetch_array($rsR);
	$CodRec      = $lnR['codrec'];
	$NomeRec     = $lnR['nomerec'];
	$SiglaRec    = $lnR['siglarec'];

	if ($TipoRecE == 'A') {
		$sqlX = "delete from databebe where recibo = '$NumDocE' ";
		$rsX  = mysqli_query($conec, $sqlX) or die("Não foi possível acessar os dados");
	}
	?>

	<font color="gold" size="6">
		<b>
			<center><u><i>Estorno de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		if ($regE > 0) {
	?>
			<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
				<form name="confentr" method="post" action="geraest.php">
					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Autenticaçãoo Nº</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo $AutF; ?></i></b></font>
						</td>
					</tr>
					<?php

					if ($NumDocE <> 0) { ?>
						<tr>
							<td width="50%" align="center">
								<font color='gold' size='5'><b><i>Nº Documento</i></b></font>
							</td>
							<td width="50%" align="center">
								<font color='#FFFFFF' size='5'><b><i><?php echo $NumDocE; ?></i></b></font>
							</td>
						</tr>
					<?php
					} ?>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Tipo de Recebimento</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i>
										<blink><?php echo $NomeRec; ?></blink>
									</i></b></font>
						</td>
					</tr>

					<tr>
						<td width="50%" align="center">
							<font color='gold' size='5'><b><i>Valor Cobrado</i></b></font>
						</td>
						<td width="50%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo "R$ " . $VlRecF; ?></i></b></font>
						</td>
					</tr>

					<tr>
						<td width="40%" align="center">
							<font color='gold' size='5'><b><i>Senha</i></b></font>
						</td>
						<td width="60%" align="center">
							<input type='password' name='txtsen' size='6' maxlength='6' class="campos">
						</td>
					</tr>
			</table>
			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="txtaut" value="<?php echo $AutF; ?>">
			<input type="hidden" name="txtdoc" value="<?php echo $NumDocE; ?>">
			<input type="hidden" name="txttipo" value="<?php echo $TipoRecE; ?>">
			<input type="hidden" name="txtvlrec" value="<?php echo $VlRec; ?>">
			<p>
				<center>
					<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
					<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</p>
			</form>
		<?php
		} else { ?>
			<br><br><br><br>
			<font size='6'><b>
					<center>Autenticação <font color='gold'>
							<blink><u>Inexistente</u>
							</blink>
							<font color='#FFFFFF'>!!!</center>
				</b></font><br><br>
			<center><a href='estorno.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
		<?php
		}
	} else {
		?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.4.1";
	include "rodape.php";
	?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
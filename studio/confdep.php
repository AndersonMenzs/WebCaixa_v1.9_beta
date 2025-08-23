<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body {
			margin-top: 3%;
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

	<script>
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
	</script>

	<script src="val_pgto.js" charset="utf-8"></script>

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.2.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$MatReceb  = trim($_POST['txtreceb']);
	$MtRecF  = 100000000 + $MatReceb;
	$RecebFull = substr($MtRecF, 1, 8);
	$Cod       = trim($_POST['txtcod']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ',', '.');
	$SdCaixa   = trim($_POST['txtcaixa']) - $Valor;

	// Conectando o Banco de Dados
	include "conexao.php";

	//  Obtendo Dados do Recebedor
	include "dblog.php";
	$sqlF = "select nome from pessoal where mat = '$RecebFull' ";
	$rsF  = mysqli_query($conec, $sqlF) or die("Não foi Possível Acessar Dados do Recebedor");
	$lnF  = mysqli_fetch_array($rsF);
	$NomeRec  = $lnF['nome'];
	mysqli_free_result($rsF);

	include "dbselect.php";
	$sqlS = "select cargo from operador where mat = '$RecebFull' ";
	$rsS  = mysqli_query($conec, $sqlS) or die("Não foi Possível Acessar Dados do Recebedor");
	$lnS  = mysqli_fetch_array($rsS);
	$CargoRec = $lnS['cargo'];
	mysqli_free_result($rsS); ?>

	<font color="gold" size="6">
		<b>
			<center><u><i>RECOLHIMENTO</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok-adm' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		if ($CargoRec <> 'Aud' and $CargoRec <> 'Enc') { ?><br><br><br><br>
			<font size='6'><b>
					<center>Somente <font color='gold'>
							<blink><u>Encarregadas</u></blink>
							<font color='#FFFFFF'> ou <blink><u>
										<font color='gold'>Auditoras
									</u></blink>
								<font color='#FFFFFF'><br><br>Podem <font color='gold'>
										<blink><u>Receber Recolhimentos</u></blink>
										<font color="#FFFFFF">!!!</center>
				</b></font><br><br>
			<center><a href=JavaScript:window.history.back()><img src='images/voltar.gif'></a></center><br>
		<?php
		} else { ?>
			<table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
				<form name="confentr" method="post" action="geradep.php" OnSubmit="JavaScript:return checkdata()">
					<tr>
						<td width="40%" align="center">
							<font color='gold' size='5'><b><i>Nº do Envelope</i></b></font>
						</td>
						<td width="60%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo $Cod; ?></i></b></font>
						</td>
					</tr>

					<tr>
						<td width="40%" align="center">
							<font color='gold' size='5'><b><i>Valor Depositado</i></b></font>
						</td>
						<td width="60%" align="center">
							<font color='#FFFFFF' size='5'><b><i>
										<blink>R$ <?php echo $ValorF; ?></blink>
									</i></b></font>
						</td>
					</tr>

					<tr>
						<td width="40%" align="center">
							<font color='gold' size='5'><b><i>Recebedor</i></b></font>
						</td>
						<td width="60%" align="center">
							<font color='#FFFFFF' size='5'><b><i><?php echo $NomeRec; ?></i></b></font>
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

			<input type="hidden" name="txtuser" value="<?php echo "$lg_user"; ?>">
			<input type="hidden" name="txtenv" value="<?php echo "$Cod"; ?>">
			<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
			<input type="hidden" name="txtreceb" value="<?php echo "$RecebFull"; ?>">
			<input type="hidden" name="nomereceb" value="<?php echo "$NomeRec"; ?>">
			<input type="hidden" name="txtcaixa" value="<?php echo "$SdCaixa"; ?>">

			<br>
			<center>
				<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
				<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
			</center><br>	
			<center>
				<font color='#FFFFFF' size='3'><span id="msg"></span></font>
			</center>
			</form>
		<?php
		}
	} else { ?>
		<br><br><br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.3.2.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
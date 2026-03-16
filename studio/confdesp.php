<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	//echo "<pre>";
	//print_r($dados);
	//echo "</pre>";
	//exit();

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.1.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Cod       = trim($_POST['txtcod']);
	$Cod2      = trim($_POST['txtcod2']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ',', '.');
	$lsPr      = trim($_POST['lsPr']);
	$TipoPag   = trim($_POST['lsPr']);
	$lsref_desp	= trim($_POST['lsref_desp']);
	$lsref_remb	= trim($_POST['lsref_remb']);
	$TipoRef = ($lsref_desp != 'Selecione' and $lsPr == '1') ? $lsref_desp : (($lsref_remb != 'Selecione' and $lsPr == '5') ? $lsref_remb : '');
	$TipoDoc = ($lsref_desp != 'Selecione' and $lsPr == '1') ? 'CI' : (($lsref_remb != 'Selecione' and $lsPr == '5') ? 'RC' : ($lsPr == '7' ? 'VT' : ($lsPr == '6' ? 'SP' : ($lsPr == '4' ? 'MD' : ($lsPr == '2' ? 'MCS' : ($lsPr == '4' ? 'MPD' : ($lsPr == '8' ? 'OUT' : '')))))));
	$colab		= trim($_POST['colab']);
	$mat_vend	= trim($_POST['mat_vend']);
	$cliente	= trim($_POST['cliente']);

	include "conexao.php";
	include "dbselect.php";

	// Obtendo Dados
	$sql = "select * from pgtos where codpag = '$TipoPag' ";
	$rs  = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($rs);
	$NomeDesc = $ln['tipopag'];
	mysqli_free_result($rs);

	?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Despesas</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<table width="80%" border="5" cellpadding="10" cellspacing="0" align="center">
			<form name="confentr" method="post" action="geradesp.php" OnSubmit="JavaScript:return checkdata()">
				<tr>
					<td width="50%" align="center">
						<font color='gold' size='5'><b><i>Códigos</i></b></font>
					</td>
					<td width="50%" align="center">
						<font color='#FFFFFF' size='5'><b><i><?php echo $Cod; ?>&nbsp;&nbsp;&nbsp;<?php echo $Cod2; ?></i></b></font>
					</td>
				</tr>

				<tr>
					<td width="50%" align="center">
						<font color='gold' size='5'><b><i>Tipo de Despesa</i></b></font>
					</td>
					<td width="50%" align="center">
						<?php
						if ($lsPr == '1' or $lsPr == '5') {
						?>
							<font color='#FFFFFF' size='5'><b><i>
										<blink><?php echo $NomeDesc . " - " . $TipoRef; ?></blink>
									</i></b></font>
						<?php
						} else {
						?>
							<font color='#FFFFFF' size='5'><b><i>
										<blink><?php echo $NomeDesc; ?></blink>
									</i></b></font>
						<?php
						}
						?>
					</td>
				</tr>

				<tr>
					<td width="50%" align="center">
						<font color='gold' size='5'><b><i>Valor</i></b></font>
					</td>
					<td width="50%" align="center">
						<font color='#FFFFFF' size='5'><b><i>R$ <?php echo $ValorF; ?></i></b></font>
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
		<input type="hidden" name="txtcod" value="<?php echo $Cod; ?>">
		<input type="hidden" name="txtcod2" value="<?php echo $Cod2; ?>">
		<input type="hidden" name="txttipodesp" value="<?php echo $TipoPag; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
		<input type="hidden" name="txtmodpag" value="<?php echo 0; ?>">
		<input type="hidden" name="colab" value="<?php echo $colab; ?>">
		<input type="hidden" name="mat_vend" value="<?php echo $mat_vend; ?>">
		<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
		<input type="hidden" name="tipodoc" value="<?php echo $TipoDoc; ?>">
		<input type="hidden" name="tiporef" value="<?php echo $TipoRef; ?>">
		<input type="hidden" name="nomedesc" value="<?php echo $NomeDesc; ?>">

		<p>
			<center>
				<input id="ghost_click" type="submit" name="btenvia" value="Continuar">
				<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()">
			</center>
		</p>
		<center>
			<font color='#FFFFFF' size='3'><span id="msg"></span></font>
		</center>
		</form>
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
		<center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando
	$SisRot = "S-7.3.1.1";
	include "rodape.php";
	?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
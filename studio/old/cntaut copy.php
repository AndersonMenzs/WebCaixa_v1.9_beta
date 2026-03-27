<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
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
	$dtA    = substr($DataAut, 6, 4);
	$DataForm = "$dtA-$dtM-$dtD";

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	} ?>

	<table width="100%" border="0" cellpadding="05" cellspacing="0" align="center">
		<tr>
			<td>
				<a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
			<td align="center">
				<font color="gold" size="6">
					<b><u><i>Autenticações do Dia - <font color='#FFFFFF'><?php echo $DataAut; ?></i></u></center></b>
				</font>
			</td>
			<td>
				<a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
			</td>
		</tr>
	</table><br><br>
	<?php

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') {
		// Consultando o Banco de Dados
		include "conexao.php";
		include "dbselect.php";

		$sql  = "select caixa.fita, registro.reg, registro.numdoc, registro.tiporec, registro.parcela, registro.datarec, registro.horarec, registro.vlrec, registro.operador, registro.estorno from caixa inner join registro on caixa.dtopen = registro.datarec where registro.datarec = '$DataForm' ";
		$rs   = mysqli_query($conec, $sql) or die("Erro de Banco de Dados #1. Contate seu Administrador");
		$regs = mysqli_num_rows($rs);

		if ($regs > 0) {
	?>
			<table border="01" cellpadding="05" cellspacing="0" align="center">
				<tr>
					<td>
						<font size='4' color='aqua'><b><i>Fita</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Autentic.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Documento</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Parcela</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Data Rec.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Hora Rec.</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Valor Rec</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Operador</i></b></font>
					</td>
					<td>
						<font size='4' color='aqua'><b><i>Estornado</i></b></font>
					</td>
				</tr>

				<?php
				while ($ln       = mysqli_fetch_array($rs)) {
					$Fita    = $ln['fita'];
					$Reg     = $ln['reg'];
					$RegF    = substr(10000 + $Reg, 1, 4);
					$Doc     = $ln['numdoc'];
					$TipoRec = $ln['tiporec'];
					$Parc    = $ln['parcela'];
					$DtRec   = $ln['datarec'];
					$RecA  = substr($DtRec, 0, 4);
					$RecM  = substr($DtRec, 5, 2);
					$RecD  = substr($DtRec, 8, 2);
					$RecFull = "$RecD-$RecM-$RecA";
					$HrRec   = $ln['horarec'];
					$VlRec   = $ln['vlrec'];
					$VlRecF  = number_format($VlRec, 2, ",", ".");
					$Oper    = $ln['operador'];
					$Op1   = substr($user, 0, 7);
					$Dv1   = substr($user, 7, 1);
					$OpFull  = "$Op1-$Dv1";
					$Estorno = $ln['estorno'];

					if ($TipoRec <> 'E') {
				?>
						<tr>
							<td>
								<font><b><i><?php echo "$Fita"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i><?php echo "$RegF"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i><?php echo "$Doc"; ?></i></b></font>
							</td>
							<td align='center'>
								<?php
								if ($Parc == 0) {
									$Parc = "-";
								}
								?>
								<font><b><i><?php echo "$Parc"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i><?php echo "$RecFull"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i><?php echo "$HrRec"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i>R$ <?php echo "$VlRecF"; ?></i></b></font>
							</td>
							<td align='right'>
								<font><b><i><?php echo "$OpFull"; ?></i></b></font>
							</td>
							<td align='center'>
								<font><b><i>
											<?php
											if ($Estorno <> "") {
											?>
												<font color='gold'>
													<blink>Sim</blink>
												<?php
											} else {
												?>
													Não
												<?php
											}
												?>
										</i></b></font>
							</td>
						</tr>
				<?php
					}
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
		<center><a href="cnt.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></center><br>
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
		<center><a href='cnt.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
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
<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
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

		.campos {
			background-color: #C0C0C0;
			font: 12px sans-serif;
			color: #000000;
		}
	</style>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Excluindo Amizade Premiada
	$sqlr = "delete from amizpre where recib = '$NDoc' ";
	$rsr  = mysqli_query($conec, $sqlr) or die("Erro de Banco de Dados #E1. Contate seu Administrador.");

	// Gravando o Registro de Estorno
	$SubRec = 'EST';
	$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubRec', '$FPag', '0', '$dtRec', '$hora', '$VrEntr', '$Mat', '', '$Mat_Vend', '$Vendedora', '$Cliente')";
	$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #E2. Contate seu Administrador.");
	mysqli_free_result($rsGr);

	// Atualizando o Registro
	$sqlAt = "update registro set estorno = 'x' where reg = '$Aut' and datarec = '$DataAtual' and tiporec <> 'E' ";
	$rsAt  = mysqli_query($conec, $sqlAt) or die("Erro de Banco de Dados #E3. Contate seu Administrador.");
	mysqli_free_result($rsAt);

	// Consultando Registro Estornado
	$sqlART = "select * from registro where reg = '$Aut' and datarec = '$DataAtual' ";
	$rsART  = mysqli_query($conec, $sqlART) or die("Erro de Banco de Dados #E4. Contate seu Administrador.");
	$lnART  = mysqli_fetch_array($rsART);
	$Tipo  = $lnART['tiporec'];
	$STipo = $lnART['subtipo'];
	$Modo  = $lnART['modpgto'];
	$VlRec = $lnART['vlrec'];
	$Tipo = $lnART['tiporec'];
	mysqli_free_result($rsART);

	// Preparando a Via Cliente 
	?>
	<form name="geracntentr" method="post" action="via1est.php">
		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		<input type="hidden" name="txtaut" value="<?php echo $Aut; ?>">
		<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
		<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
		<input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
		<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
		<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
		<input type="hidden" name="txtvalor" value="<?php echo $VrEntr; ?>">
		<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
		<font size='6'><b>
				<center>Coloque a <font color='gold'>
						<blink>Via do Cliente</blink>
						<font color='#FFFFFF'> na Autenticadora
							e <br>
							<p>Clique no <font color='gold'>
									<blink>botão Abaixo</blink>
									<font color='#FFFFFF'>.</center>
			</b></font>
		</p><br>
		<center>
			<input id="ghost_click" type="submit" name="btimprime" value="Autenticar">
		</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
	</form>
</body>

</html>
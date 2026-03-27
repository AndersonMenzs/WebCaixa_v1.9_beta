<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-left: 1%;
			margin-right: 1%;
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
		function click() {
			if (event.button == 2 || event.button == 3) {
				oncontextmenu = 'return false';
			}
		}
		document.onmousedown = click
		document.oncontextmenu = new Function("return false;")
	</script>

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

	<SCRIPT LANGUAGE="JavaScript">
		function putFocus(formInst, elementInst) {
			if (document.forms.length > 0) {
				document.forms[formInst].elements[elementInst].focus();
			}
		}
	</script>

	<Script>
		function validate(field) {
			var valid = "0123456789"
			var ok = "yes";
			var temp;
			for (var i = 0; i < field.value.length; i++) {
				temp = "" + field.value.substring(i, i + 1);
				if (valid.indexOf(temp) == "-1") ok = "no";
			}
			if (ok == "no") {
				alert("Entrada Incorreta! \n  Digite apenas algarismos!");
				field.focus();
				field.select();
			}
		}
	</script>

	<script language="JavaScript">
		javascript: window.history.forward(1);
	</script>

	<script type="text/javascript" src="java_log.js" charset="utf-8">
	</script>

	<?php
	include "cabecprs.php";
	?>
</head>

<body background="./images/bg1.jpg" text="#FFFFFF" link='aqua' alink='aqua' vlink='aqua' onLoad="putFocus(0,0);" onselectstart="return false">
	<?php
	// Preparando Áreas
	$dataAtual = date('Y-m-d');
	$horaAtual = date('H');
	$minAtual  = date('i');
	$tmpAtual  = $horaAtual * 60 + $minAtual;

	$DataC = date('dmY');
	$HoraC = date('hiih');
	$CodeC = $DataC + $HoraC;

	// Acessando o Banco de Dados
	include "./conexao.php";
	include "./dbselect.php";

	// Excluindo Usuários Inativos
	$sqlI = "SELECT mat, dataop FROM operador WHERE cargo <> 'Adm' AND cargo <> 'aud' ";
	$rsI  = mysqli_query($conec, $sqlI) or die("Erro de Acesso #1. Contate seu Administrador.");

	while ($lnI = mysqli_fetch_array($rsI)) {
		$MatI  = $lnI['mat'];
		$dtOpI = $lnI['dataop'];

		include "./inatuser.php";
	}

	// Consultando o Último Acesso
	$sql = "select * from datafix";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Acesso #2. Contate seu Administrador.");
	$ln  = mysqli_fetch_array($rs);
	$dataComp = $ln['dataf'];
	$horaComp = $ln['horaf'];
	$minComp  = $ln['minf'];
	$tmpComp = $horaComp * 60 + $minComp;

	// Verificando Alteração da Data/Hora
	if ($dataAtual > $dataComp or $dataAtual == $dataComp and $tmpAtual >= $tmpComp) {
		// Atualizando a Data de Acesso
		$sql = "update datafix set dataf = '$dataAtual',
					horaf = '$horaAtual',
					minf  = '$minAtual' ";
		$rs  = mysqli_query($conec, $sql) or die("Não foi Possível Alterar os Dados"); ?>
		<br>
		<table width="75%" border="5" cellpadding="6" cellspacing="0" align="center">
			<tr>
				<td colspan="2">
					<font color="#FFFFFF">
						<center>
							<h1><i><b>Identificação de Usuário</b></i></h1>
						</center>
					</font>
				</td>
				<td rowspan="3" colspan="2">
					<font color="red">
						<center>
							<font size='6'><i><b><u>Verifique se Data &amp; Hora estão corretas!</u><br>
										<font size='7' color="lime"><?php echo "$data<br><font color='yellow'>$hora<br><font color='brown'>$diaSem"; ?>
									</b></i>
						</center>
					</font>
				</td>
			</tr>
			<tr>
				<td>
					<h2><i><b>
								<font color="gold">&nbsp;&nbsp;&nbsp;Login:</font>
							</b></i></h1>
				</td>
				<td>
					<form name="userlog" method="post" action="menu.php" OnSubmit="JavaScript:return checklog()" autocomplete="off">
						<input type="text" name="idinc" size="8" maxlength="8" class="campos" onKeyUp="validate(this)">
				</td>
			</tr>
			<tr>
				<td>
					<h2><i><b>
								<font color="gold">&nbsp;&nbsp;&nbsp;Senha:</font>
							</b></i></h1>
				</td>
				<td>
					<input type="password" name="idpass" size="6" maxlength="6" class="campos">
				</td>
			</tr>
			<tr>
				<td>
					<center>
						<input type="submit" value="Login">
					</center>
				</td>
				<td>
					<center>
						<input type="Reset" value="Limpar">
						</form>
				</td>
				<td>
					<center>
						<p>
							<font size='4'><a href="senhaprov.php">Esqueci Minha Senha</a></font>
						</p>
				</td>
				</td>
				<td>
					<center>
						<p>
							<font size='4'><a href="cadastra.php">Cadastramento Emergencial</a></font>
						</p>
				</td>
			</tr>
		</table>

		<p>
			<center>
				<font size='5' color='#FFFFFF'><b>Caso a data esteja <font color="red"><u>incorreta</u>
							<font color="#FFFFFF">
								ou a Hora <font color="orange"><u>muito adiantada</u>
									<font color="#FFFFFF"> ou <font color="orange"><u>atrasada</u>
											<font color="#FFFFFF"> Ligue <font color="red"><b>(21) 2121-5278<font color="#FFFFFF"> ou <font color="red">(21) 99212-0108<font color="#FFFFFF">.</b></font>
			</center>
		</p><br><br><?php
				} else { ?>
		<br><br><br>
		<font size="6">
			<b><i>
					<center>
						<font color="gold">
							<blink>DATA DO SISTEMA ALTERADA</blink>
							<font color="#FFFFFF"><br><br>

								<form name="relog" method="post" action="relog.php">
									<table border="5" cellpadding="10" cellspacing="0" align="center">
										<tr>
											<td align="center">
												<font color='gold' size='5'><b><i>Código Gerado:&nbsp;&nbsp;
															<font color='gold' size='5'><b><i><?php echo $CodeC; ?></i></b></font>
															<input type="hidden" name="txtcod" value="<?php echo $CodeC; ?>">
											</td>
										</tr>

										<tr>
											<td align="center">
												<font color='gold' size='5'><b><i>Contra-Senha</i></b></font>
												<input type="text" name="contrasenha" size="6" maxlength="6" class="campos" OnKeyUp="validate(this)">
											</td>
										</tr>

										<tr>
											<td align="center">
												<input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
												<input type="reset" name="btreset" value="Limpar">
											</td>
									</table>
								</form>
							<?php
						}
						include "rod_index.php"; ?>
</body>

</html>
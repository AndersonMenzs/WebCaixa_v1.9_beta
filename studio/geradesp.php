<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.1.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Cod       = trim($_POST['txtcod']);
	$Cod2      = trim($_POST['txtcod2']);
	$TipoDesp  = trim($_POST['txttipodesp']);
	$Valor     = trim($_POST['txtvalor']);
	$FPag      = trim($_POST['txtmodpag']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);
	$TipoRec   = '8';

	include "conexao.php";
	include "dbselect.php";

	// Obtendo a Sigla de Pagamento
	$sql = "select * from pgtos where codpag = '$TipoDesp' ";
	$rs  = mysqli_query($conec, $sql);
	$ln  = mysqli_fetch_array($rs);
	$SubTipo = $ln['siglapag'];
	mysqli_free_result($rs);

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			$lno  = mysqli_fetch_array($rso);
			$Mat = $lno['mat'];
			// Gravando o Registro
			$sqlr = "select * from registro order by datarec desc, reg desc";
			$rsr  = mysqli_query($conec, $sqlr) or die("Não foi possível acessar os Dados");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}
			$Reg  = $Reg + 1;
			$sqlGr = "insert into registro values($Reg, '0000000', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$Valor', '$Mat', '')";
			$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados");

			// Preparando a Via Cliente 
	?>
			<form name="geraprod" method="post" action="via1pag.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="txtcod" value="<?php echo $Cod; ?>">
				<input type="hidden" name="txtcod2" value="<?php echo $Cod2; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
				<input type="hidden" name="txttipodesp" value="<?php echo $TipoDesp; ?>">
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
				<font size='6'><b>
						<center>Coloque a <font color='gold'>
								<blink>Via do Caixa</blink>
								<font color='#FFFFFF'> na Autenticadora e <br>
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
		<?php

		} else {
		?>
			<font size='6'><b>
					<center>Senha <font color='gold'>
							<blink>Incorreta</blink><br>
							<font color='#FFFFFF'>ou<br>
								Usuário <font color='gold'>
									<blink>Não Autorizado</blink>
									<font color="#FFFFFF">!!!</center>
				</b></font><br>
			<center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br>
	<?php
		}
	}

	// Encerrando a Conexão
	$SisRot = "S-7.3.1.1.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
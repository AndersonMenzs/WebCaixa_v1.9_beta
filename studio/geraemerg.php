<html>

<head>
	<title>WebCaixa v1.20.21_beta</title>
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

	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	include "./valor_ext.php";

	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R3.2.1.1";
	$dtAut	 = date('dmy');
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$DataF     = date('d/m/Y');
	$Hora      = date('Hi');
	$HoraF     = date('H:i');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$MatU      = substr($user, 0, 1) . "." . substr($user, 1, 3) . "." . substr($user, 4, 3) . "-" . substr($user, 7, 1);
	$pss     = substr($lg_user, 8, 40);
	$Lacre   = trim($_POST['lacre']);
	$NomeRec   = trim($_POST['nomereceb']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ",", ".");
	$Valor_ext    = valorPorExtenso($ValorF);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	include "conexao.php";
	include "dbselect.php";
	include "valida_caixa.php";

	bloquear_se_caixa_anterior_aberto($conec, $lg_user);

	// Obtendo o PC
	$sqlo = "select pc, ape from inicial order by dtaltera desc ";
	$rso  = mysqli_query($conec, $sqlo);
	$lno  = mysqli_fetch_array($rso) or die("Não foi possível Acessar Filiais");
	$PCf = $lno['pc'];
	$Apef = $lno['ape'];


	// Obtendo Dados
	$sqlo = "select * from operador where mat = '$user' and pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><br><b>
			<center><u><i>EMERGENCIAL</i></u></center>
		</b>
	</font><br><br>
	<?php

	include "us_sist.php";

	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-adm') {
		if ($regso > 0) {

			// Variáveis para o tipo de registro
			$TipoRec   = '11';
			$SubTipo   = 'EMERG';
			$SgRec    = 'LC';
			$MatRec    = substr($user, 0, 7) . "-" . substr($user, 7, 8);

			// Gravando o Registro
			$sqlr = "select * from registro order by datarec desc, reg desc";
			$rsr  = mysqli_query($conec, $sqlr) or die("Não foi possível acessar os Dados");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			// Incrementando o número do registro
			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}

			$Reg  = $Reg + 1;

			// Gravando o registro do ajuste emergencial
			$sqlGr = "insert into registro values($Reg, '$Lacre', '$TipoRec', '$SubTipo', '0', '0', '$dtRec', '$HoraF', '$Valor', '$user', '', '', '', '')";
			$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro ao inserir registro emergencial #1. Contate seu Administrador.");

			// Preparando o registro do ajuste emergencial

			$RegFull = 10000 + $Reg;
			$Reg = substr($RegFull, 1, 4);
			$valorFormatado = 'R$ ' . number_format($Valor, 2, ',', '.');
			$Spo = $Reg . $PCf . $Hora . $Lacre . $dtAut . $valorFormatado . $SgRec . $SubTipo . $MatRec;

			// Gravando o registro do ajuste emergencial na tabela spool
			$sqp = "insert into spool (rec, spo) values('$Reg', '$Spo')";
			$rsqp  = mysqli_query($conec, $sqp) or die("Erro ao inserir registro emergencial #2. Contate seu Administrador.");

			// Gravando o registro do ajuste emergencial na tabela spool2
			$sqp2 = "insert into spool2 (rec, spo2) values('$Reg', '$Spo')";
			$rsqp2  = mysqli_query($conec, $sqp2) or die("Erro ao inserir registro emergencial #3. Contate seu Administrador.");

	?>
			<!-- Preparando a via da Tesouraria -->
			<form name="gerarec" method="post" action="via1newemerg.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="matf" value="<?php echo $MatU; ?>">
				<input type="hidden" name="lacre" value="<?php echo $Lacre; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
				<input type="hidden" name="txtvalor_ext" value="<?php echo $Valor_ext; ?>">
				<input type="hidden" name="txtnome" value="<?php echo $NomeRec; ?>">
				<input type="hidden" name="txtdata" value="<?php echo $DataF; ?>">
				<input type="hidden" name="txthora" value="<?php echo $HoraF; ?>">
				<input type="hidden" name="txtpc" value="<?php echo $PCf; ?>">
				<input type="hidden" name="aut" value="<?php echo $Spo; ?>">
				<p>
					<font size='6'><b>
							<center>Verifique se a impressora do <font color='gold'>
									<blink>Caixa</blink>
									<font color='#FFFFFF'> está ligada e com papel.
										<p>Logo após clique no <font color='gold'>
												<blink>botão abaixo</blink>
												<font color='#FFFFFF'>.</center>
						</b></font>
				</p><br>
				<center>
					<input id="ghost_click" type="submit" name="btimprime" value="Registrar" autofocus>
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form>
		<?php
		} else { ?>
			<font size="6">
				<b><i>
						<center>Senha <font color="gold">
								<blink>Incorreta</blink>
								<font color="#FFFFFF">!!!
						</center>
					</i></b>
			</font>
			<br>
			<center><a href="JavaScript:window.history.back()"><img src="./images/voltar.gif"></a></center><br>
		<?php }
	} else { ?>
		<br>
		<font size="6">
			<b><i>
					<center>Usuário <font color="gold">
							<blink>Não Autorizado</blink>
							<font color="#FFFFFF">!!! </center>
				</i></b>
		</font>
		<br>
		<center><a href="./index.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a></center><br>
	<?php
	}

	// Encerrando a Conexão
	mysqli_free_result($rso);
	mysqli_free_result($rsGr);
	$SisRot = "S-7.3.2.1.1";

	include "rodape.php"; ?>

</body>

</html>
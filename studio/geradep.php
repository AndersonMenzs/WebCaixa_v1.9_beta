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
	$Rot       = "S7R3.2.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$DataF     = date('d/m/Y');
	$HoraF     = date('H:i');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$MatU      = substr($user, 0, 1) . "." . substr($user, 1, 3) . "." . substr($user, 4, 3) . "." . substr($user, 7, 1);
	$pss     = substr($lg_user, 8, 40);
	$Envelope  = trim($_POST['txtenv']);
	$MatReceb  = trim($_POST['txtreceb']);
	$m1   = substr($MatReceb, 0, 1);
	$m2   = substr($MatReceb, 1, 3);
	$m3   = substr($MatReceb, 4, 3);
	$dv   = substr($MatReceb, 7, 1);
	$MatRecebF = "$m1.$m2.$m3-$dv";
	$NomeRec   = trim($_POST['nomereceb']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ",", ".");
	$SdCaixa   = trim($_POST['txtcaixa']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	// Preparando Áreas
	$trash     = "U" . substr(sha1("$SdCaixa"), 0, 41);
	$SdCaixaF  = number_format($SdCaixa, 2, "", "");
	$TamSd     = strlen($SdCaixaF);

	include "conexao.php";
	include "dbselect.php";

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
			<center><u><i>RECOLHIMENTOS</i></u></center>
		</b>
	</font><br><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			include "dblog.php";
			$sqlU = "select nome from pessoal where mat = '$user' ";
			$rsU  = mysqli_query($conec, $sqlU) or die("Não foi possível consultar Dados da Caixa");
			$lnU  = mysqli_fetch_array($rsU);
			$NomeU = $lnU['nome'];

			// Preparando Áreas
			$us1 = substr($Mat, 0, 1);
			$us2 = substr($Mat, 1, 3);
			$us3 = substr($Mat, 4, 3);
			$dv  = substr($Mat, 7, 1);
			$OperF = "$us1.$us2.$us3-$dv";

			// Obtendo o Nome do Operador
			$sqlo = "select mat, nome from pessoal where mat = '$Mat' ";
			$rso  = mysqli_query($conec, $sqlo) or die("Não foi possível Acessar Pessoal");
			$lno  = mysqli_fetch_array($rso);
			$MatP  = $lno['mat'];
			$mp1  = substr($MatP, 0, 1);
			$mp2  = substr($MatP, 1, 3);
			$mp3  = substr($MatP, 4, 3);
			$dvp  = substr($MatP, 7, 1);
			$MatF = "$mp1.$mp2.$mp3-$dvp";

			$NomeF = $lno['nome'];

			// Consultando Depósitos
			include "dbselect.php";
			$sqlCs  = "select regdep from depositos";
			$rsCs   = mysqli_query($conec, $sqlCs) or die("Não foi possível Consultar os Dados");
			$regsCs = mysqli_num_rows($rsCs);

			// Incrementando o Registro
			$regsCs = $regsCs + 1;

			// Imprimindo os Dados
			$traco = "------------------------------------------------";
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '------------- RECOLHIMENTO DE CAIXA ------------' > /dev/lp0");
			shell_exec("echo PC: '$PCf - $Apef' > /dev/lp0");
			shell_exec("echo Envelope: '$Envelope' > /dev/lp0");
			shell_exec("echo Data/Hora: '$DataF - $HoraF' > /dev/lp0");
			shell_exec("echo VALOR RECOLHIDO: R$ '$ValorF' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo '$MatU - $NomeU' > /dev/lp0");
			shell_exec("echo '      (Responsavel pelo Recolhimento)' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo '$MatRecebF - $NomeRec' > /dev/lp0");
			shell_exec("echo '      (Responsavel pelo Recebimento)' > /dev/lp0");

			for ($K = 0; $K <= $TamSd; $K++) {
				$D[] = substr($SdCaixaF, $K, 1);
			}

			for ($K = 0; $K < $TamSd; $K++) {
				switch ($D[$K]) {
					case 0:
						$D[$K] = "A";
						break;
					case 1:
						$D[$K] = "B";
						break;
					case 2:
						$D[$K] = "C";
						break;
					case 3:
						$D[$K] = "D";
						break;
					case 4:
						$D[$K] = "E";
						break;
					case 5:
						$D[$K] = "F";
						break;
					case 6:
						$D[$K] = "G";
						break;
					case 7:
						$D[$K] = "H";
						break;
					case 8:
						$D[$K] = "I";
						break;
					case 9:
						$D[$K] = "J";
						break;
				}
				$SdFinal = "$SdFinal" . "$D[$K]";
			}
			$SdFinal = "$SdFinal" . "$trash";

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\t\tAutenticacao' > /dev/lp0");
			shell_exec("echo '$SdFinal' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");

			// Gravando o Registro
			$sqlGr = "insert into depositos values('$regsCs', '$dtRec', '$HoraF', '$Envelope', '$Valor', '$MatReceb', '$user', '$SdFinal')";
			$rsGr  = mysqli_query($conec, $sqlGr) or die("Não foi possível salvar os Dados"); ?>
			<font size='6'><b>
					<center>Recolhimento Realizado <font color='gold'>
							<blink>com Sucesso</blink>
							<font color='#FFFFFF'>!!!</center>
				</b></font><br>

			<center><a href="pgtos.php?c_s=<?php echo $lg_user; ?>"><img src='images/voltar.gif'></a></center><br>
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
		<center><a href="pgtos.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a></center><br>
	<?php }

	// Encerrando a Conexão
	/* mysqli_free_result($rso);
	mysqli_free_result($rsGr); */
	$SisRot = "S-7.3.2.1.1";
	include "rodape.php"; ?>

</body>

</html>
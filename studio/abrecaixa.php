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
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php
	
	include "../cabecprs.php";

	// Conexão com o Banco de Dados
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o Login
	$Sis     = "S7";
	$Rot     = "S7R1";
	$lg_user = $_REQUEST['c_s'];
	$user  = substr($lg_user, 0, 8);
	$mat1 = substr($user, 0, 1);
	$mat2 = substr($user, 1, 3);
	$mat3 = substr($user, 4, 3);
	$dv   = substr($user, 7, 1);
	$userF    = "$mat1.$mat2.$mat3-$dv";
	$pss   = substr($lg_user, 8, 40);
	$ch      = '';
	$dtabert = date("Y-m-d");
	$dty   = substr($dtabert, 0, 4);
	$dtm   = substr($dtabert, 5, 2);
	$dtd   = substr($dtabert, 8, 2);
	$dataAbr = "$dtd/$dtm/$dty";
	$hora = date("H:i");
	$dia  = date("w");
	$gravaAbr = $dty . $dtm . $dtd;

	switch ($dia) {
		case 0:
			$diaSem = 'Domingo';
			break;

		case 1:
			$diaSem = 'Segunda-Feira';
			break;

		case 2:
			$diaSem = 'Terca-Feira';
			break;

		case 3:
			$diaSem = 'Quarta-Feira';
			break;

		case 4:
			$diaSem = 'Quinta-Feira';
			break;

		case 5:
			$diaSem = 'Sexta-Feira';
			break;

		case 6:
			$diaSem = 'Sabado';
			break;
	}

	include "us_sist.php";

	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<br>
		<font size='5' color='gold'><b><u><i>
						<center>ABERTURA DO CAIXA</center>
					</i></u></b></font><br>
		<table border="0" cellpadding="3" cellspacing="0" align="center">
			<?php

			// Removendo velhas Autenticações
			include 'remautent.php';

			// Obtendo Dados do PC
			include "dbselect.php";
			$sqlI = "select * from inicial";
			$rsI  = mysqli_query($conec, $sqlI) or die("Não foi possível abrir o Caixa");
			$lnI  = mysqli_fetch_array($rsI);
			$PC  = $lnI['pc'];
			$Ape = $lnI['ape'];

			// Autorizando um Fechamento Parcial
			$sqlX = "update datafix set fch = '4' ";
			$rsX  = mysqli_query($conec, $sqlX) or die("Não foi possível Liberar o Sistema");

			// Obtendo Apelido do Funcionário
			include "dblog.php";
			$sqlF = "select ape from pessoal where mat = '$user' ";
			$rsF  = mysqli_query($conec, $sqlF) or die("Não foi possível abrir o Caixa");
			$lnF  = mysqli_fetch_array($rsF);
			$ApeF = $lnF['ape'];

			// Obtendo Dados do Fechamento Anterior
			include "dbselect.php";
			$sqlA = "select fita, ano, dtclose, numerario from caixa order by dtclose";
			$rsA  = mysqli_query($conec, $sqlA) or die("Não foi possível abrir o Caixa");
			$regA = mysqli_num_rows($rsA);
			if ($regA == 0) {
				$Fita    = '001';
				$ano     = $dty;
				$sqlU = "select gaveta from inicial";
				$rsU  = mysqli_query($conec, $sqlU) or die("Não foi possível abrir o Caixa");
				$lnU  = mysqli_fetch_array($rsU);
				$abert = $lnU['gaveta'];
			} else {
				while ($lnA = mysqli_fetch_array($rsA)) {
					$anofita = $lnA['ano'];
					if ($anofita == $dty) {
						$ano = $anofita;
						$FitaAnt = $lnA['fita'];
						$FitaFull = 1001 + $FitaAnt;
						$Fita    = substr($FitaFull, 1, 3);
					} else {
						$ano  = $dty;
						$Fita = '001';
					}
					$fecha   = $lnA['dtclose'];
					$abert   = $lnA['numerario'];
				}
			}
			?>
			<tr>
				<td>
					<b><i>Fita Número - <?php echo "$Fita/$ano"; ?></i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<b><i>PC: <?php echo "$PC - $Ape"; ?></i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<b><i>Data: <?php echo "$dataAbr ($diaSem)"; ?></i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<b><i>Hora: <?php echo "$hora"; ?></i></b></font>
				</td>
			</tr>

			<tr>
				<td>
					<b><i>Operador: <?php echo "$userF - $ApeF"; ?></i></b></font>
				</td>
			</tr>

			<?php $inicial = number_format($abert, 2, ",", "."); ?>

			<tr>
				<td>
					<font color="gold"><b><i>Saldo de Abertura: <blink>R$ <?php echo $inicial; ?></blink></i></b></font>
				</td>
			</tr>
			<?php

			// Consultando Sobra ou Falta do Fechamento Anterior 
			include "dbselect.php";
			$sqlDf = "select * from difcx order by datadif desc";
			$rsDf  = mysqli_query($conec, $sqlDf) or die("Erro #00");
			$regDf = mysqli_num_rows($rsDf);

			if ($regDf > 0) {
				$lnDf = mysqli_fetch_array($rsDf);
				$DtDif = $lnDf['datadif'];
				$DtDifF = substr($DtDif, 8, 2) . "/" . substr($DtDif, 5, 2) . "/" . substr($DtDif, 0, 4);
				$Difer = $lnDf['difer'];
				$DiferF = number_format($Difer, 2, ",", ".");
				$SF    = $lnDf['sf'];
				$OperD = $lnDf['operador'];

				if ($SF <> '') { ?>
					<tr>
						<td>
							<font color="aqua"><b><i>Diferença de Caixa em <?php echo "$DtDifF"; ?><font color="#FFFFFF">: R$ <?php echo $DiferF; ?> <blink>(<?php echo "$SF"; ?>)</blink></i></b></font>
						</td>
					</tr><?php
						}
					} ?>
		</table><br><br>

		<table width="55%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td align="center">
					<a href='index.php?c_s=<?php echo "$lg_user"; ?>'><img src='./images/ok28.gif' border='0'></a>
				</td>
			</tr>
		</table><br>
		<?php			

		// Salvando os Dados
		$sql = "INSERT INTO antcaixa (
                            fita, ano, pc, ape, dtopen, diasem, hora, 
                            vlr_abertura, mov_anterior, difcx, sobra_falta, 
                            ape_operador, operador, dtcriado) 
                        VALUES (
                            '$Fita', '$ano', '$PC', '$Ape', '$dataAbr', 
                            '$diaSem', '$hora', '$inicial', '0,00', '$DiferF', 
                            '$SF', '$ApeF', '$userF', '$dtabert'
                        )";
		$rs  = mysqli_query($conec, $sql);


		$sqlGr = "insert into caixa (fita, ano, dtopen, numerario, operador) values ('$Fita', '$ano', '$gravaAbr', '$abert', '$user')";
		$rsGr  = mysqli_query($conec, $sqlGr);

		// Backups do banco de dados para o envio remoto
		shell_exec("/backups/scripts/./.mov_std2.sh");
		
	} else { ?>
		<br><br><br>
		<font size='5'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u>
						</blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	$SisRot = "S-7.1";
	include "rodape.php"; ?>

</body>

</html>
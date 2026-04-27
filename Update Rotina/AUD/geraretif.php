<?php

// Preparando as variáveis
$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

$destino = "Tesouraria";

$assunto        = "Documento de Alteração de Fechamento Anterior";

// Importando os Dados do Formulário
$Sis       = "S7";
$Rot       = "S7R0.6.1.1";
$lg_user   = trim($_POST['txtuser']);
$user    = substr($lg_user, 0, 8);
$pss     = substr($lg_user, 8, 40);
$userF     = substr($user, 0, 1) . "." . substr($user, 1, 3) . "." . substr($user, 4, 3) . "-" . substr($user, 7, 1);
$Autent    = trim($_POST['txtaut']);
$Fita      = trim($_POST['txtFita']);
$Valor	    = trim($_POST['txtvalor']);
$De        = trim($_POST['txtde']);
$Para      = trim($_POST['txtpara']);
$MatF      = trim($_POST['txtresp']);
$Ape       = trim($_POST['txtape']);
$Data	    = date('Y-m-d');

// Atualizando o Saldos
include "conexao.php";
include "dbselect.php";

switch ($De) {
	case 10:
		$cashi = $Valor;
		break;
	case 20:
		$cdebi = $Valor;
		break;
	case 30:
		$ccredvi = $Valor;
		break;
	case 31:
		$ccredpli = $Valor;
		break;
	case 32:
		$ccredpai = $Valor;
		break;
	case 40:
		$cheqvi = $Valor;
		break;
	case 50:
		$cheqpi = $Valor;
		break;
	case 60:
		$depclii = $Valor;
		break;
}

switch ($Para) {
	case 10:
		$casho = $Valor;
		break;
	case 20:
		$cdebo = $Valor;
		break;
	case 30:
		$ccredvo = $Valor;
		break;
	case 31:
		$ccredplo = $Valor;
		break;
	case 32:
		$ccredpao = $Valor;
		break;
	case 40:
		$cheqvo = $Valor;
		break;
	case 50:
		$cheqpo = $Valor;
		break;
	case 60:
		$depclio = $Valor;
		break;
}

if ($cashi == NULL) {
	$cashi = '0';
}

if ($cdebi == NULL) {
	$cdebi = '0';
}

if ($ccredvi == NULL) {
	$ccredvi = '0';
}

if ($ccredpli == NULL) {
	$ccredpli = '0';
}

if ($ccredpai == NULL) {
	$ccredpai = '0';
}

if ($cheqvi == NULL) {
	$cheqvi = '0';
}

if ($cheqpi == NULL) {
	$cheqpi = '0';
}

if ($depclii == NULL) {
	$depclii = '0';
}

if ($casho == NULL) {
	$casho = '0';
}

if ($cdebo == NULL) {
	$cdebo = '0';
}

if ($ccredvo == NULL) {
	$ccredvo = '0';
}

if ($ccredplo == NULL) {
	$ccredplo = '0';
}

if ($ccredpao == NULL) {
	$ccredpao = '0';
}

if ($cheqvo == NULL) {
	$cheqvo = '0';
}

if ($cheqpo == NULL) {
	$cheqpo = '0';
}

if ($depclio == NULL) {
	$depclio = '0';
}

// Alterando Valores
$sql = "insert into errlanc (cashi, cdebi, ccredvi, ccredpli, ccredpai, cheqvi, cheqpi, depclii, dataop, casho, cdebo, ccredvo, ccredplo, ccredpao, cheqvo, cheqpo, depclio) values ('$cashi', '$cdebi', '$ccredvi', '$ccredpli', '$ccredpai', '$cheqvi', '$cheqpi', '$depclii', '$Data', '$casho', '$cdebo', '$ccredvo', '$ccredplo', '$ccredpao', '$cheqvo', '$cheqpo', '$depclio')";
$rs  = mysqli_query($conec, $sql) or die("File geraretif Error #1. Contate seu Administrador.");

$sql = "select cashin, cashout from caixa where dtclose IS NULL";
$rs  = mysqli_query($conec, $sql) or die("File geraretif Error #2. Contate seu Administrador.");
$ln  = mysqli_fetch_array($rs);
$Cashin = $ln['cashin'];
$Cashout = $ln['cashout'];

if ($Cashin == NULL) {
	$Cashin = 0;
}

if ($Cashout == NULL) {
	$Cashout = 0;
}

if ($De == 10 or $Para == 10) {
	if ($De == 10) {
		$Cashout = $Cashout + $Valor;
	}

	if ($Para == 10) {
		$Cashin = $Cashin + $Valor;
	}

	$sql = "update caixa set cashin = $Cashin,
				     cashout= $Cashout where dtclose IS NULL";
	$rs  = mysqli_query($conec, $sql) or die("File geraretif Error #3. Contate seu Administrador.");
}

// Obtendo o PC
$sql = "select pc, ape from inicial order by dtaltera desc";
$rs  =  mysqli_query($conec, $sql) or die("File geraretif Error #4. Contate seu Administrador.");
$ln  = mysqli_fetch_array($rs);
$PC   = $ln['pc'];
$Apl  = $ln['ape'];

// Obtendo a Forma de Pagamento
$sql = "select modpag from fpagimp where codpag = '$De' ";
$rs  =  mysqli_query($conec, $sql) or die("File geraretif Error #5. Contate seu Administrador.");
$ln  = mysqli_fetch_array($rs);
$ModDe = $ln['modpag'];

$sql = "select modpag from fpagimp where codpag = '$Para' ";
$rs  =  mysqli_query($conec, $sql) or die("File geraretif Error #6. Contate seu Administrador.");
$ln  = mysqli_fetch_array($rs);
$ModPara = $ln['modpag'];

for ($I = 0; $I <= 1; $I++) {

	include "dblog.php";
	$sql = "select nome from pessoal where mat = '$user' ";
	$rs  =  mysqli_query($conec, $sql) or die("File geraretif Error #7. Contate seu Administrador.");
	$ln  = mysqli_fetch_array($rs);
	$NomeFunc = $ln['nome'];

	$Data = date('d/m/Y');
	$Hora = date('H:i');
	$Ano  = date('Y');
?>
	<!DOCTYPE html>
	<html lang="pt-br">

	<head>
		<meta charset="UTF-8">
		<title>Incorporar Sobra</title>
		<style>
			body {
				font-family: Arial, Helvetica, sans-serif;
				margin: 40px;
				color: #000;
			}

			.container {
				max-width: 800px;
				margin: auto;
				border: 1px solid #000;
				padding: 30px;
			}

			.header {
				display: flex;
				align-items: center;
				margin-bottom: 20px;
			}

			.header .logo {
				flex: 0 0 120px;
			}

			.header .logo img {
				max-height: 80px;
			}

			.header .titulo {
				margin-left: 20px;
			}

			.header .titulo h1 {
				font-size: 22px;
				margin: 0;
				text-transform: uppercase;
			}

			.header .titulo h2 {
				font-size: 16px;
				margin: 5px 0 0;
				font-weight: normal;
			}

			h1,
			h2 {
				margin: 5px 0;
			}

			h1 {
				font-size: 22px;
				text-transform: uppercase;
			}

			h2 {
				font-size: 16px;
				font-weight: normal;
			}

			.linha {
				margin: 15px 0;
			}

			.linha strong {
				display: inline-block;
				width: 110px;
			}

			.texto {
				margin-top: 30px;
				line-height: 1.6;
				text-align: justify;
			}

			.assinatura {
				margin-top: 60px;
			}

			.assinatura .linha-ass {
				margin-top: 40px;
				border-top: 1px solid #000;
				width: 300px;
			}

			.rodape {
				margin-top: 40px;
				font-size: 12px;
			}

			.logo {
				text-align: left;
				margin-bottom: 15px;
			}

			.logo img {
				max-height: 80px;
			}

			@media print {

				.container {
					border: none;
				}

				/* Remove margens padrão */
				@page {
					margin: 2mm;
				}

				body {
					margin: 2mm;
					padding: 2mm;
				}
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

	<body onload="window.print()">

		<body>

			<div class="container">

				<div class="header">
					<div class="logo">
						<img src="./images/logo.png" alt="Estrella Photo Studio">
					</div>

					<div class="titulo">
						<h1><?= $empresa ?></h1>
						<h2><?= $tipoDocumento ?></h2>
					</div>
				</div>

				<div class="linha">
					<strong>Data:</strong> <?= $Data ?><br>
					<strong>Hora:</strong> <?= $Hora ?><br>
					<strong>De:</strong> PC-<?= $PC . "(" . $Apl . ")" ?><br>
					<strong>Para:</strong> <?= $destino ?>
				</div>

				<div class="linha">
					<strong>Assunto:</strong> <?= $assunto ?>
				</div>

				<div class="texto">
					Eu, <strong><i><?= $NomeFunc ?></i></strong>, funcionário(a) registrado(a)
					sob matrícula <strong><i><?= $userF ?></i></strong> da unidade
					<strong><i>PC-<?= $PC . "(" . $Apl . ")" ?></i></strong>, alterando os seguintes dados de autenticação incorreta da
					<strong><i>FITA: <?= $Fita . "/" . $Ano ?></i></strong>, <strong><i>AUTENTIC. NÚMERO: <?= $Autent ?></i></strong> e
					<strong><i>VALOR AUTENTICADO: R$<?= $Valor ?></i></strong>, confirmo ter feito a operação de
					<strong><i>RETIFICAÇÃO DE FORMA DE PAGAMENTO</i></strong> afirmando o valor atual registrado de
					<strong><i>R$<?= $ModDe ?></i></strong> para <i><strong>R$<?= $ModPara ?></i></strong>, conforme acordo e políticas internas da empresa.
				</div>

				<div class="assinatura">
					<div class="linha-ass"></div>
					Assinatura do Funcionário(a)
				</div>

			</div>
			<script>
				setTimeout(function() {
					window.location.href = './aud.php?c_s=<?php echo $lg_user; ?>';
				}, 1000);
			</script>

		</body>

	</html>
<?php } ?>
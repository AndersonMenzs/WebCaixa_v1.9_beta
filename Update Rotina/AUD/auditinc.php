<?php

$empresa        = "ESTRELLA PHOTO STUDIO";
$tipoDocumento  = "Comunicação Interna";

$destino = "Tesouraria";

$assunto        = "Comprovante de Inclusão/Alteração de Valores Pela Auditoria";

// Obtendo o Login e Dados
$Sis        = "S7";
$Rot       = "S7R0.1.1";
$lg_user   = $_POST['txtuser'];
$user    = substr($lg_user, 0, 8);
$mat1 = substr($user, 0, 1);
$mat2 = substr($user, 1, 3);
$mat3 = substr($user, 4, 3);
$dv   = substr($user, 7, 1);
$userF     = "$mat1.$mat2.$mat3-$dv";
$pss     = substr($lg_user, 8, 40);
$dtAltera  = date('Ymd');
$NomeA     = trim($_POST['txtnome']);
$PCA       = trim($_POST['txtpc']);
$ApeA      = trim($_POST['txtape']);
$CofreA    = trim($_POST['txtcofre']);
$TrocoA    = trim($_POST['txttroco']);
$GavA      = trim($_POST['txtgav']);
$TotA      = $CofreA + $TrocoA + $GavA;

include "us_sist.php";
if ($ch == 'no') {
	include "us_cad.php";
}

include "dbselect.php";

if ($ch == 'ok') {
	// Verificando o Arquivo Inicial
	$sql = "select mat from inicial";
	$rs  = mysqli_query($conec, $sql) or die("Erro de Inclusão de Dados");
	$reg = mysqli_num_rows($rs);

	if ($reg > 0) {
		// Removendo Dados Incorretos
		$sqlG = "delete from inicial";
		$rsG  = mysqli_query($conec, $sqlG) or die("Não Foi Possível Remover os Dados da Auditoria.");
	}
	// Inserindo Novos Dados
	$sqlG = "insert into inicial values('$user', $dtAltera, $CofreA, $TrocoA, $GavA, $TotA, '$PCA', '$ApeA')";
	$rsG  = mysqli_query($conec, $sqlG) or die("Não foi possível salvar os dados da Auditoria.");

	// Atualizando o Caixa
	$sqlA = "select numerario from caixa where dtopen = '$dtAltera' ";
	$rsA  = mysqli_query($conec, $sqlA) or die("Não foi possível Consultar os Dados do Caixa.");
	$regsA = mysqli_num_rows($rsA);

	if ($regsA <> 0) {
		$sqlA = "update caixa set numerario = $GavA where dtopen = $dtAltera";
		$rsA  = mysqli_query($conec, $sqlA) or die("Não foi possível Atualizar os Dados do Caixa.");
	}
}
mysqli_free_result($rsG);

// Gerando Comprovante
$dtAltI  = date('d/m/Y');
$horaI   = date('H:i');
$PCA       = trim($_POST['txtpc']);
$ApeA      = trim($_POST['txtape']);
$CofreI = number_format($CofreA, 2, ",", ".");
$TrocoI = number_format($TrocoA, 2, ",", ".");
$GavI = number_format($GavA, 2, ",", ".");
$TotI = number_format($TotA, 2, ",", ".");

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<title>COMPOSIÇÃO INICIAL</title>
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
			<strong>Data:</strong> <?= $dtAltI ?><br>
			<strong>Hora:</strong> <?= $horaI ?><br>
			<strong>De:</strong> PC-<?= $PCA . "(" . $ApeA . ")" ?><br>
			<strong>Para:</strong> <?= $destino ?>
		</div>

		<div class="linha">
			<strong>Assunto:</strong> <?= $assunto ?>
		</div>

		<div class="texto">
			Eu, <strong><i><?= $NomeA ?></i></strong>, funcionário(a) registrado(a)
			sob matrícula <strong><i><?= $userF ?></i></strong> da unidade
			<strong><i>PC-<?= $PCA . "(" . $ApeA . ")" ?></i></strong>, confirmo ter feito a operação de
			<strong><i>COMPOSIÇÃO INICIAL DO WEBCAIXA</i></strong> afirmando os valores atuais registrados do
			<strong><i>Cofre: R$ <?= $CofreI ?> - Troco: R$ <?= $TrocoI ?> - Gaveta: R$ <?= $GavI ?></i></strong>,
			com o <strong><i>Total Inicial: R$ <?= $TotI ?></i></strong>, conforme acordo e políticas internas da empresa.
		</div>

		<div class="assinatura">
			<div class="linha-ass"></div>
			Assinatura do Funcionário(a)
		</div>

	</div>
	<script>
		setTimeout(function() {
			window.location.href = './index.php?c_s=<?php echo $lg_user; ?>';
		}, 1000);
	</script>

</body>

</html>
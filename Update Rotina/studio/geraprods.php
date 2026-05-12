<?php
// Debug
error_reporting(E_ALL);

ini_set('display_startup_errors', 1);
?>

<html>

<head>
	<title>WebCaixa v1.20.7_beta</title>
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
	<?php
	// Inserindo Cabeçalho
	include "../cabecprs.php";
	?>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php
	
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.8.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$hora      = date('H:i');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Ref_Std   = trim($_POST['ref_std']);
	$NumDoc    = trim($_POST['txtdoc']);
	$NumDocF = 100000000 + $NumDoc;
	$NDoc      = substr($NumDocF, 1, 8);
	$FPag_1      = trim($_POST['lsPr1']);
	$FPag_2      = trim($_POST['lsPr2']);
	$FPag_3      = trim($_POST['lsPr3']);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Vendedora_full = trim($_POST['vendedora']);
	$Cliente	= trim($_POST['cliente']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$Valor     = $txt1 + $txt2 + $txt3;
	$ValorF    = number_format($Valor, 2, ",", ".");
	$Book    = trim($_POST['pct_book']) ?? '';
	$RdBook  = trim($_POST['rdbook']);
	$Poster   = trim($_POST['ped_poster']) ?? '';
	$Produto  = trim($_POST['prod']) ?? '';
	$ProdutoK   = trim($_POST['ped_prod']) ?? '';

	// Verificando se os campos de pct_prod estão vazios ou não
	
	if (isset($_POST['ped_prod_1']) && !empty(trim($_POST['ped_prod_1']))) {
		$Pct_Prod = trim($_POST['ped_prod_1']);
	} elseif (isset($_POST['ped_prod_2']) && !empty(trim($_POST['ped_prod_2']))) {
		$Pct_Prod = trim($_POST['ped_prod_2']);
	} elseif (isset($_POST['ped_prod_3']) && !empty(trim($_POST['ped_prod_3']))) {
		$Pct_Prod = trim($_POST['ped_prod_3']);
	}

	$Parcelas = trim($_POST['parcelas']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	// Truncar o nome da vendedora com o primeiro nome completo e após o primeiro espaco, deixar somente uma letra e ponto.
	$Vendedora = strtoupper($Vendedora);
	$Vendedora = substr($Vendedora, 0, strpos($Vendedora, ' ') + 1) . substr($Vendedora, strpos($Vendedora, ' ') + 1, 1) . '.';

	if ($RdBook == 'n') {
		$TipoRec   = '6';
		$SubTipo   = 'PROD';
	} elseif ($RdBook == 's') {
		$TipoRec   = '7';
		$SubTipo   = 'BOOK';
	} elseif ($RdBook == 'pk') {
		$TipoRec   = '6';
		$SubTipo   = 'PRODK';
	} elseif ($RdBook == 'p') {
		$TipoRec   = '6';
		$SubTipo   = 'PROD';
	}
	
	// Variáveis
	$DataHoje = date('Y-m-d');

	include "conexao.php";
	include "dbselect.php";

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo) or die("Não foi Possível acessar os Dados");
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6"><br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b></font><br>
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

			if ($FPag_1 <> "00" or $FPag_1 == "99") {
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_1', '0', '$dtRec', '$hora', '$txt1', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #2. Contate seu Administrador.");
			}

			if ($FPag_2 <> "00" and $FPag_1 <> "99") {
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_2', '0', '$dtRec', '$hora', '$txt2', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #5. Contate seu Administrador.");
			}

			if ($FPag_3 <> "00" and $FPag_1 <> "99") {
				$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_3', '0', '$dtRec', '$hora', '$txt3', '$Mat', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
				$rsGr  = mysqli_query($conec, $sqlGr) or die("Erro de Banco de Dados #8. Contate seu Administrador.");
			}
			
			// Preparando a Via Cliente 
	?>
			<form name="gerapropentr" method="post" action="via1newprods.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
				<input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
				<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
				<input type="hidden" name="ref_std" value="<?php echo $Ref_Std; ?>">
				<input type="hidden" name="txt1" value="<?php echo $txt1; ?>">
				<input type="hidden" name="txt2" value="<?php echo $txt2; ?>">
				<input type="hidden" name="txt3" value="<?php echo $txt3; ?>">
				<input type="hidden" name="txtvalor" value="<?php echo $Valor; ?>">
				<input type="hidden" name="lsPr1" value="<?php echo $FPag_1; ?>">
				<input type="hidden" name="lsPr2" value="<?php echo $FPag_2; ?>">
				<input type="hidden" name="lsPr3" value="<?php echo $FPag_3; ?>">
				<input type="hidden" name="parcelas" value="<?php echo $Parcelas; ?>">
				<input type="hidden" name="txtmodpag_ext" value="<?php echo $ModPag; ?>">
				<input type="hidden" name="txtmodpag" value="<?php echo $ModPag; ?>">
				<input type="hidden" name="mat_vend" value="<?php echo $Mat_Vend; ?>">
				<input type="hidden" name="vendedora" value="<?php echo $Vendedora; ?>">
				<input type="hidden" name="cliente" value="<?php echo $Cliente; ?>">
				<input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
				<input type="hidden" name="txthora" value="<?php echo $hora; ?>">
				<input type="hidden" name="rdbook" value="<?php echo $RdBook; ?>">
				<input type="hidden" name="qtde_book" value="<?php echo isset($_POST['qtde_book']) ? trim($_POST['qtde_book']) : ''; ?>">
				<input type="hidden" name="pct_book" value="<?php echo $Book; ?>">
				<input type="hidden" name="qtde_poster" value="<?php echo isset($_POST['qtde_poster']) ? trim($_POST['qtde_poster']) : ''; ?>">
				<input type="hidden" name="ped_poster" value="<?php echo $Poster; ?>">
				<input type="hidden" name="qtde_prod" value="<?php echo isset($_POST['qtde_prod']) ? trim($_POST['qtde_prod']) : ''; ?>">
				<input type="hidden" name="prod" value="<?php echo $Produto; ?>">
				<input type="hidden" name="ped_prod" value="<?php echo $ProdutoK; ?>">
				<input type="hidden" name="tipo_top" value="<?php echo isset($_POST['tipo_top']) ? trim($_POST['tipo_top']) : ''; ?>">
				<input type="hidden" name="qtde_tkit_1" value="<?php echo isset($_POST['qtde_tkit_1']) ? trim($_POST['qtde_tkit_1']) : ''; ?>">
				<?php for ($i = 1; $i <= 10; $i++) { ?>
					<input type="hidden" name="qtde_top<?php echo $i; ?>" value="<?php echo isset($_POST['qtde_top' . $i]) ? trim($_POST['qtde_top' . $i]) : ''; ?>">
					<input type="hidden" name="ped_top_book<?php echo $i; ?>" value="<?php echo isset($_POST['ped_top_book' . $i]) ? trim($_POST['ped_top_book' . $i]) : ''; ?>">
				<?php } ?>
				<?php for ($i = 1; $i <= 3; $i++) { ?>
					<input type="hidden" name="qtde_kit_<?php echo $i; ?>" value="<?php echo isset($_POST['qtde_kit_' . $i]) ? trim($_POST['qtde_kit_' . $i]) : ''; ?>">
					<input type="hidden" name="ped_tkit_<?php echo $i; ?>" value="<?php echo isset($_POST['ped_tkit_' . $i]) ? trim($_POST['ped_tkit_' . $i]) : ''; ?>">
					<input type="hidden" name="ped_prod_<?php echo $i; ?>" value="<?php echo isset($_POST['ped_prod_' . $i]) ? trim($_POST['ped_prod_' . $i]) : ''; ?>">
				<?php } ?>
				<input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
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
					<input id="ghost_click" type="submit" name="btimprime" value="Autenticar" autofocus>
				</center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form><br>
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
	$SisRot = "S-7.2.8.1.1";
	include "rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>
</body>

</html>

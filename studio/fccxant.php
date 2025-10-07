<?php

// Debug
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('html_errors', 1);
ini_set('error_log', 'php_errors.log');
ini_set('log_errors', 1);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('track_errors', 1);*/

?>

<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		body {
			margin-left: 0%;
			margin-right: 0%;
			border: 3px solid gray;
			padding: 10px 10px 10px 10px;
			font-family: sans-serif;
		}
		
		/* Estilos para o relatório de impressão */
		#printable-report {
			display: none;
		}
		
		@media print {
			body { 
				font-family: Arial, sans-serif; 
				font-size: 10pt; 
				margin: 0; 
				padding: 10px; 
				background: white;
				color: black;
			}
			.report-section { 
				margin-bottom: 15px; 
				border: 1px solid #000; 
				padding: 8px; 
				page-break-inside: avoid;
			}
			.report-header { 
				text-align: center; 
				font-weight: bold; 
				margin-bottom: 10px;
				border-bottom: 2px solid #000;
				padding-bottom: 10px;
			}
			.report-table { 
				width: 100%; 
				border-collapse: collapse; 
				font-size: 9pt;
			}
			.report-table td, .report-table th { 
				border: 1px solid #000; 
				padding: 4px; 
				text-align: left;
			}
			.report-table th { 
				background-color: #f0f0f0; 
				font-weight: bold;
			}
			.total-row { 
				font-weight: bold; 
				background-color: #e0e0e0; 
			}
			.page-break { 
				page-break-after: always; 
			}
			.no-print { 
				display: none !important; 
			}
			.signature-table {
				width: 100%;
				margin-top: 30px;
			}
			.signature-table td {
				border: none;
				text-align: center;
				padding-top: 40px;
			}
		}
		
		.print-button {
			background: #4CAF50;
			color: white;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 14px;
			margin: 10px;
		}
		
		.print-button:hover {
			background: #45a049;
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
		
		function printReport() {
			var printContent = document.getElementById('printable-report').innerHTML;
			var originalContent = document.body.innerHTML;
			
			document.body.innerHTML = printContent;
			window.print();
			document.body.innerHTML = originalContent;
			window.location.reload();
		}
	</script>
	
	<?php
	// Obtendo a Data Atual
	$DataAtual = date('Y-m-d');
	$DataFecha = date('d/m/Y'); ?>
</head>

<body background="../images/bg1.jpg" link='lime' vlink='#FFFFFF' alink='lime' text="#FFFFFF">
	<?php
	include "../cabecprs.php";

	// Obtendo o Login
	$Sis       = "S7";
	$Rot       = "S7R5.2.1.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$mat1  = substr($user, 0, 1);
	$mat2  = substr($user, 1, 3);
	$mat3  = substr($user, 4, 3);
	$dv    = substr($user, 7, 1);
	$userF   = "$mat1.$mat2.$mat3-$dv";
	$pss   = substr($lg_user, 8, 40);
	$Gaveta  = trim($_POST['txtcash']);
	$GavAut  = number_format($Gaveta, 2, ",", ".");
	$ch      = '';
	$dtAbre  = trim($_POST['dtabre']);

	if ($dtAbre == '') {
		$dtAbre = date('Y-m-d');
	}
	$dty     = substr($dtAbre, 0, 4);
	$dtm     = substr($dtAbre, 5, 2);
	$dtd     = substr($dtAbre, 8, 2);
	$dataFch   = "$dtd/$dtm/$dty";
	$hora      = date("H:i");
	$horaNorm  = date("Hi");
	$horaInv   = date("iH");

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
		<font size='4' color='gold'>
			<b>
				<u>
					<i>
						<center>FECHAMENTO DO CAIXA</center>
					</i>
				</u>
			</b>
		</font>
		<?php

		// Iniciando Variáveis
		$RecProd      = 0;
		$RecConc      = 0;
		$RecBebe      = 0;
		$RecCntE      = 0;
		$RecCntP      = 0;
		$RecPVDE      = 0;
		$RecPVDP      = 0;
		$RecPrdt      = 0;
		$RecBook      = 0;
		$RecResg      = 0;
		$RecEst       = 0;
		$cDebFinal    = 0;
		$credTotV     = 0;
		$credTotPLoja = 0;
		$credTotPAdm  = 0;
		$cheqTotV     = 0;
		$cheqTotPre   = 0;
		$DepClientes  = 0;
		$cashTot      = 0;
		$DDP          = 0;
		$MCS          = 0;
		$MDV          = 0;
		$MPD          = 0;
		$RCL          = 0;
		$SRV          = 0;
		$VTR          = 0;
		$OUT          = 0;

		// Obtendo Apelido
		include "conexao.php";
		include "dblog.php";
		$sqlP = "select ape from pessoal where mat = '$user' ";
		$rsP  = mysqli_query($conec, $sqlP) or die("File fccxant Error #50. Contate seu Administrador.");
		$lnP = mysqli_fetch_array($rsP);
		$app = $lnP['ape'];

		// Obtendo Dados do PC
		include "dbselect.php";
		$sqlI = "select * from inicial";
		$rsI  = mysqli_query($conec, $sqlI) or die("File fccxant Error #51. Contate seu Administrador.");
		$lnI = mysqli_fetch_array($rsI);
		$PC  = $lnI['pc'];
		$Ape = $lnI['ape'];

		// Obtendo Dados para o Fechamento
		$sqlA = "select fita, ano, dtopen, numerario, cashout, incsobra, cashin from caixa where dtclose IS NULL";
		$rsA  = mysqli_query($conec, $sqlA) or die("File fccxant Error #52. Contate seu Administrador.");
		$regA = mysqli_num_rows($rsA);
		$lnA = mysqli_fetch_array($rsA);
		$Fita      = $lnA['fita'];
		$ano       = $lnA['ano'];
		$dtOpen    = $lnA['dtopen'];
		$opy       = substr($dtOpen, 0, 4);
		$opm       = substr($dtOpen, 5, 2);
		$opd       = substr($dtOpen, 8, 2);
		$dtOpenGr  = "$opy-$opm-$opd";
		$Numerario = $lnA['numerario'];
		$inicial   = number_format($Numerario, 2, ",", ".");
		$cashOut   = $lnA['cashout'];
		$cashOutF  = number_format($cashOut, 2, ",", ".");
		$IncSobra  = $lnA['incsobra'];
		if ($IncSobra == NULL) {
			$IncSobra = 0;
		}
		$IncSobraF = number_format($IncSobra, 2, ",", ".");
		$cashIn    = $lnA['cashin'];
		$cashInF   = number_format($cashIn, 2, ",", ".");

		// Inicializando Variáveis
		$DDP = 0;
		$MCS = 0;
		$MDV = 0;
		$MPD = 0;
		$RCL = 0;
		$SRV = 0;
		$VTR = 0;
		$OUT = 0;
		$Versao = "3.05";

		// Totalizando Chaveiros
		$sqlT = "SELECT vltx FROM taxas where codigo = 'CHV' order by datalt desc";
		$rsT  = mysqli_query($conec, $sqlT) or die('Erro #0!');
		$lnT  = mysqli_fetch_array($rsT);
		$VLTX = $lnT['vltx'];

		$sqlR = "SELECT numdoc, vlrec FROM registro where tiporec='9' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #4. Contate seu Administrador.');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$RecChav = $RecChav + $VlRec;
			$ValorChav    = number_format($RecChav, 2, ",", ".");
		}
		if ($ValorChav == '') {
			$ValorChav = '0,00';
			$NTChav = 0;
		} else {
			$NTChav = $RecChav / $VLTX;
		}

		// Totalizando Taxa de Produção
		$sqlR = "SELECT numdoc FROM registro where tiporec='1' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #5. Contate seu Administrador.');
		$NTxProd = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='1' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #6. Contate seu Administrador.');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$RecProd = $RecProd + $VlRec;
			$ValorProd    = number_format($RecProd, 2, ",", ".");
		}
		if ($ValorProd == '') {
			$ValorProd = '0,00';
		}

		// Totalizando Taxa de Incrição no Concurso
		$sqlR = "SELECT numdoc FROM registro where tiporec='2' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #7. Contate seu Administrador.');
		$NConcurso = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='2' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #8. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$RecConc = $RecConc + $VlRec;
			$ValorConc = number_format($RecConc, 2, ",", ".");
		}
		if ($ValorConc == '') {
			$ValorConc = '0,00';
		}

		// Totalizando Taxa Bebê Estrella
		$sqlR  = "SELECT numdoc FROM registro where tiporec='A' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, numdoc";
		$rsR   = mysqli_query($conec, $sqlR) or die('File fccxant Error #9. Contate seu Administrador.');
		$NBebe = mysqli_num_rows($rsR);

		$sqlR  = "SELECT vlrec FROM registro where tiporec='A' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR   = mysqli_query($conec, $sqlR) or die('File fccxant Error #10. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec     = $lnR['vlrec'];
			$RecBebe   = $RecBebe + $VlRec;
			$ValorBebe = number_format($RecBebe, 2, ",", ".");
		}
		if ($ValorBebe == '') {
			$ValorBebe = '0,00';
		}

		// Totalizando Contratos (Entrada)
		$sqlR = "SELECT numdoc FROM registro where tiporec='3' and subtipo = 'CNTE' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #11. Contate seu Administrador.');
		$NContEnt = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='3' and subtipo = 'CNTE' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #12. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec        = $lnR['vlrec'];
			$RecCntE      = $RecCntE + $VlRec;
			$ValorContEnt = number_format($RecCntE, 2, ",", ".");
		}
		if ($ValorContEnt == '') {
			$ValorContEnt = '0,00';
		}

		// Totalizando Contratos (Parcela)
		$sqlR = "SELECT numdoc FROM registro where tiporec='3' and subtipo = 'CNTP' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, parcela";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #13. Contate seu Administrador.');
		$NContParc = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='3' and subtipo = 'CNTP' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #14. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecCntP  = $RecCntP + $VlRec;
			$ValorContParc = number_format($RecCntP, 2, ",", ".");
		}
		if ($ValorContParc == '') {
			$ValorContParc = '0,00';
		}

		// Totalizando Propostas (Entrada)
		$sqlR = "SELECT numdoc FROM registro where tiporec='4' and subtipo = 'PVDE' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #15. Contate seu Administrador.');
		$NPropEnt = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='4' and subtipo = 'PVDE' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #16. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec        = $lnR['vlrec'];
			$RecPVDE      = $RecPVDE + $VlRec;
			$ValorPropEnt = number_format($RecPVDE, 2, ",", ".");
		}
		if ($ValorPropEnt == '') {
			$ValorPropEnt = '0,00';
		}

		// Totalizando Propostas (Parcela)
		$sqlR = "SELECT numdoc FROM registro where tiporec='4' and subtipo = 'PVDP' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, parcela";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #17. Contate seu Administrador.');
		$NPropParc = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='4' and subtipo = 'PVDP' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #18. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec         = $lnR['vlrec'];
			$RecPVDP       = $RecPVDP + $VlRec;
			$ValorPropParc = number_format($RecPVDP, 2, ",", ".");
		}
		if ($ValorPropParc == '') {
			$ValorPropParc = '0,00';
		}

		// Totalizando Produtos
		$sqlR = "SELECT numdoc FROM registro where tiporec='6' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #19. Contate seu Administrador.');
		$NPRecs = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='6' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #20. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecPrdt  = $RecPrdt + $VlRec;
			$VrPRecsF = number_format($RecPrdt, 2, ",", ".");
		}
		if ($VrPRecsF == '') {
			$VrPRecsF = '0,00';
		}

		// Books a Vista
		$sqlR = "SELECT numdoc FROM registro where tiporec='7' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #21. Contate seu Administrador.');
		$NBookRec = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='7' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #22. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecBook  = $RecBook + $VlRec;
			$VrBookRecF = number_format($RecBook, 2, ",", ".");
		}
		if ($VrBookRecF == '') {
			$VrBookRecF = '0,00';
		}

		// Resgate de Cheques
		$sqlR = "SELECT numdoc FROM registro where tiporec='5' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #23. Contate seu Administrador.');
		$NResgate = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='5' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #24. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecResg  = $RecResg + $VlRec;
			$ValorResg = number_format($RecResg, 2, ",", ".");
		}
		if ($ValorResg == '') {
			$ValorResg = '0,00';
		}

		// Despesas
		$sqlR = "SELECT numdoc FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #25. Contate seu Administrador.');
		$NumPgtos = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #26. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecDesp  = $RecDesp + $VlRec;
			$PgtoTot = number_format($RecDesp, 2, ",", ".");
		}
		if ($PgtoTot == '') {
			$PgtoTot = '0,00';
		}

		// Estornos
		$sqlR = "SELECT numdoc FROM registro where tiporec='E' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #27. Contate seu Administrador.');
		$NEstorno = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #28. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecEst  = $RecEst + $VlRec;
			$ValorEstorno = number_format($RecEst, 2, ",", ".");
		}
		if ($ValorEstorno == '') {
			$ValorEstorno = '0,00';
		}

		// Arrecadado em Dinheiro
		$sqlR = "SELECT vlrec FROM registro where modpgto='10' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #29. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$cashTot  = $cashTot + $VlRec;
			$Dinheiro = number_format($cashTot, 2, ",", ".");
		}
		if ($Dinheiro == '') {
			$Dinheiro = '0,00';
		}

		// Arrecadado em Pix QRCode
		$sqlR = "SELECT vlrec FROM registro where modpgto='70' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #29. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$pixQRCode = $pixQRCode + $VlRec;
			$PixQRCode = number_format($pixQRCode, 2, ",", ".");
		}
		if ($PixQRCode == '') {
			$PixQRCode = '0,00';
		}

		// Arrecadado em Pix CNPJ
		$sqlR = "SELECT vlrec FROM registro where modpgto='71' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #29. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$pixCNPJ = $pixCNPJ + $VlRec;
			$PixCNPJ = number_format($pixCNPJ, 2, ",", ".");
		}
		if ($PixCNPJ == '') {
			$PixCNPJ = '0,00';
		}

		// Arrecadado em Card Débito
		$sqlR = "SELECT vlrec FROM registro where modpgto='20' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #30. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$cDebFinal  = $cDebFinal + $VlRec;
			$CardDeb = number_format($cDebFinal, 2, ",", ".");
		}
		if ($CardDeb == '') {
			$CardDeb = '0,00';
		}

		// Arrecadado em Card Crédito a Vista
		$sqlR = "SELECT vlrec FROM registro where modpgto='30' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #31. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$credTotV  = $credTotV + $VlRec;
			$CardVista = number_format($credTotV, 2, ",", ".");
		}
		if ($CardVista == '') {
			$CardVista = '0,00';
		}

		// Arrecadado em Card Crédito Parc. Loja
		$sqlR = "SELECT vlrec FROM registro where modpgto='31' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #32. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$credTotPLoja  = $credTotPLoja + $VlRec;
			$CardParcLj = number_format($credTotPLoja, 2, ",", ".");
		}
		if ($CardParcLj == '') {
			$CardParcLj = '0,00';
		}

		// Arrecadado em Card Crédito Parc. Adm.
		$sqlR = "SELECT vlrec FROM registro where modpgto='32' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #33. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$credTotPAdm  = $credTotPAdm + $VlRec;
			$CardParcAdm = number_format($credTotPAdm, 2, ",", ".");
		}
		if ($CardParcAdm == '') {
			$CardParcAdm = '0,00';
		}

		// Arrecadado em Cheques a Vista
		$sqlR = "SELECT vlrec FROM registro where modpgto='40' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #34. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$cheqTotV  = $cheqTotV + $VlRec;
			$CheqTotal = number_format($cheqTotV, 2, ",", ".");
		}
		if ($CheqTotal == '') {
			$CheqTotal = '0,00';
		}

		// Arrecadado em Cheques Pre-datados
		$sqlR = "SELECT vlrec FROM registro where modpgto='50' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #35. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$cheqTotPre  = $cheqTotPre + $VlRec;
			$CheqPre = number_format($cheqTotPre, 2, ",", ".");
		}
		if ($CheqPre == '') {
			$CheqPre = '0,00';
		}

		// Depósito de Clientes
		$sqlR = "SELECT vlrec FROM registro where modpgto='60' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('File fccxant Error #36. Contate seu Administrador.');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$DepClientes   = $DepClientes + $VlRec;
			$DepCli = number_format($DepClientes, 2, ",", ".");
		}
		if ($DepCli == '') {
			$DepCli = '0,00';
		}

		// Obtendo o Total Depositado
		$sqlR = "select * from depositos where dtdep = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die("File fccxant Error #37. Contate seu Administrador.");
		while ($lnR = mysqli_fetch_array($rsR)) {
			$Dep  = $lnR['valor'];
			$Recl = $Recl + $Dep;
		}
		$Recolh = number_format($Recl, 2, ".", "");

		// Totalizando Recebimentos
		$Entradas    = $cashTot + $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $DepClientes + $pixQRCode + $pixCNPJ;
		$DemaisTot   = $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $pixQRCode + $pixCNPJ;
		$Geral       = $Recolh + $DemaisTot;
		$TotIn     = number_format($Entradas, 2, ",", ".");
		$RecolTot  = number_format($Recolh, 2, ",", ".");
		$TotOutros = number_format($DemaisTot, 2, ",", ".");
		$TotGeral  = number_format($Geral, 2, ",", ".");

		// Desmembrando Pagamentos
		$sqlD = "SELECT subtipo,vlrec FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsD  = mysqli_query($conec, $sqlD) or die('File fccxant Error #38. Contate seu Administrador.');
		while ($lnD  = mysqli_fetch_array($rsD)) {
			$STipo   = $lnD['subtipo'];
			$VlRec   = $lnD['vlrec'];

			switch ($STipo) {
				case 'DDP':
					$DDP = $DDP + $VlRec;
					break;

				case 'MCS':
					$MCS = $MCS + $VlRec;
					break;

				case 'MDV':
					$MDV = $MDV + $VlRec;
					break;

				case 'MPD':
					$MPD = $MPD + $VlRec;
					break;

				case 'RCL':
					$RCL = $RCL + $VlRec;
					break;

				case 'SRV':
					$SRV = $SRV + $VlRec;
					break;

				case 'VTR':
					$VTR = $VTR + $VlRec;
					break;

				case 'OUT':
					$OUT = $OUT + $VlRec;
					break;
			}
		}

		// Formatando Resultados
		$DDPF = number_format($DDP, 2, ",", ".");
		$MCSF = number_format($MCS, 2, ",", ".");
		$MDVF = number_format($MDV, 2, ",", ".");
		$MPDF = number_format($MPD, 2, ",", ".");
		$RCLF = number_format($RCL, 2, ",", ".");
		$SRVF = number_format($SRV, 2, ",", ".");
		$VTRF = number_format($VTR, 2, ",", ".");
		$OUTF = number_format($OUT, 2, ",", ".");

		// Totalizando Pagamentos
		$Pgtos   = $DDP + $MCS + $MDV + $MPD + $RCL + $SRV + $VTR + $OUT;
		$PgtoTot = number_format($Pgtos, 2, ",", ".");

		// Calculando a Diferença de Caixa
		$Diferenca = ($Recolh + $Pgtos + $Gaveta + $cashOut) - ($Numerario + $cashTot + $IncSobra + $cashIn);
		$Fechamento = ($Numerario + $cashTot + $IncSobra + $cashIn) - ($Recolh + $Pgtos + $cashOut);
		$FechamentoF = number_format($Fechamento, 2, ",", ".");

		if ($Diferenca > -0.009 and $Diferenca < 0.009) {
			$Diferenca = 0;
		}

		if ($Diferenca > 0) {
			$SF = "Sobra";
		} else if ($Diferenca < 0) {
			$SF = "Falta";
		} else {
			$SF = "";
		}

		// Salvando a Diferença de Caixa
		$sqlDf = "INSERT into difcx (datadif, difer, sf, operador) values ('$dtAbre', $Diferenca, '$SF', '$user')";
		$rsDf  = mysqli_query($conec, $sqlDf) or die('File fccxant Error #39. Contate seu Administrador.');

		$DifCx = number_format($Diferenca, 2, ",", ".");

		if ($Diferenca == 0) {
			$cd = '';
		} else if ($Diferenca > 0) {
			$cd = '(SOBRA)';
		} else {
			$cd = '(FALTA)';
		}

		// Totalizando Autenticações
		$sqlA = "SELECT reg FROM registro where datarec = '$dtOpen' and estorno = '' group by reg";
		$rsA  = mysqli_query($conec, $sqlA) or die('File fccxant Error #40. Contate seu Administrador.');
		$TotAut = mysqli_num_rows($rsA); 

		// IMPRESSÃO VIA /dev/lp0 EM FORMATO DE TABELA
		$impressao = "";
		$impressao .= "==============================================\n";
		$impressao .= "      ESTRELLA PHOTO STUDIO\n";
		$impressao .= "   FECHAMENTO DO CAIXA - FITA Nº $Fita/$ano\n";
		$impressao .= "==============================================\n";
		$impressao .= "Data: $dataFch | Hora: $hora\n";
		$impressao .= "PC: $PC - $Ape\n";
		$impressao .= "Operador: $userF ($app)\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "DADOS DA ABERTURA:\n";
		$impressao .= "Saldo de Abertura: R$ $inicial\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "RECEBIMENTOS POR TIPO:\n";
		$impressao .= "Chaveiros: $NTChav itens - R$ $ValorChav\n";
		$impressao .= "Taxa Producao: $NTxProd itens - R$ $ValorProd\n";
		$impressao .= "Insc. Concurso: $NConcurso itens - R$ $ValorConc\n";
		$impressao .= "Contratos Ent: $NContEnt itens - R$ $ValorContEnt\n";
		$impressao .= "Contratos Parc: $NContParc itens - R$ $ValorContParc\n";
		$impressao .= "Propostas Ent: $NPropEnt itens - R$ $ValorPropEnt\n";
		$impressao .= "Propostas Parc: $NPropParc itens - R$ $ValorPropParc\n";
		$impressao .= "Produtos/Serv: $NPRecs itens - R$ $VrPRecsF\n";
		$impressao .= "Books Vista: $NBookRec itens - R$ $VrBookRecF\n";
		$impressao .= "Despesas: $NumPgtos itens - R$ $PgtoTot\n";
		$impressao .= "Estornos: $NEstorno itens - R$ $ValorEstorno\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "FORMA DE PAGAMENTO:\n";
		$impressao .= "Dinheiro: R$ $Dinheiro\n";
		$impressao .= "Pix QR Code: R$ $PixQRCode\n";
		$impressao .= "Pix CNPJ: R$ $PixCNPJ\n";
		$impressao .= "Cartao Debito: R$ $CardDeb\n";
		$impressao .= "Cartao Cred. Vista: R$ $CardVista\n";
		$impressao .= "Cartao Cred. Parc Adm: R$ $CardParcAdm\n";
		$impressao .= "TOTAL RECEBIDO: R$ $TotIn\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "PAGAMENTOS/DESPESAS:\n";
		$impressao .= "Desp. Pessoal: R$ $DDPF\n";
		$impressao .= "Mat. Consumo: R$ $MCSF\n";
		$impressao .= "Mat. Divulg: R$ $MDVF\n";
		$impressao .= "Mat. Producao: R$ $MPDF\n";
		$impressao .= "Reemb. Clientes: R$ $RCLF\n";
		$impressao .= "Servicos: R$ $SRVF\n";
		$impressao .= "Vale Transp: R$ $VTRF\n";
		$impressao .= "Outros: R$ $OUTF\n";
		$impressao .= "TOTAL PAGAMENTOS: R$ $PgtoTot\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "RESUMO FINAL:\n";
		$impressao .= "Saldo Inicial: R$ $inicial\n";
		$impressao .= "Total Arrecadado: R$ $TotIn\n";
		$impressao .= "Recolhido Dinheiro: R$ $RecolTot\n";
		$impressao .= "Outros Recolhimentos: R$ $TotOutros\n";
		$impressao .= "Despesas: R$ $PgtoTot\n";
		$impressao .= "Estornos: R$ $ValorEstorno\n";
		$impressao .= "Saldo Gaveta: R$ $GavAut\n";
		if ($IncSobra > 0) {
			$impressao .= "Sobra Incorporada: R$ $IncSobraF\n";
		}
		$impressao .= "SALDO FECHAMENTO: R$ $FechamentoF\n";
		$impressao .= "DIFERENCA CAIXA: R$ $DifCx $cd\n";
		$impressao .= "----------------------------------------------\n";
		$impressao .= "Autenticacoes Validas: $TotAut\n";
		$impressao .= "==============================================\n\n";

		// Enviando para a impressora
		shell_exec("echo '$impressao' > /dev/lp0");
		?>

		<!-- BOTÕES DE AÇÃO -->
		<p align="center" class="no-print">
			<a href='http://localhost/caixa'><img src='./images/sair2.gif' border='0'></a>&nbsp;&nbsp;&nbsp;
			<a href="reimpfch.php?c_s=<?php echo $lg_user; ?>"><img src="./images/reimp.gif" border="0"></a>&nbsp;&nbsp;&nbsp;
			<button class="print-button" onclick="printReport()">🖨️ Imprimir Relatório Laser</button>
		</p>

		<!-- RELATÓRIO PARA IMPRESSORA LASER -->
		<div id="printable-report">
			<!-- ... (o conteúdo HTML para impressão laser permanece igual) ... -->
		</div>

		<?php
		// ... (o restante do código de gravação no banco permanece igual)
		// Gravando Spool de Reimpressão
		$sqlS = "update spoolfch set fita 	= '$Fita',
			    ano  	= '$ano',
			    pc   	= '$PC',
			    ape  	= '$Ape',
			    datafch 	= '$dataFch',
			    dtabre 	= '$dtAbre',
			    dataatual	= '$DataAtual',
			    datafecha 	= '$DataFecha',
			    hora 	= '$hora',
			    user 	= '$userF',
			    app 	= '$app',
			    inicial 	= '$inicial',
			    nvendas 	= '$NVendas',
			    valorvend 	= '$ValorVend',
			    totin 	= '$TotIn',
			    recolhe 	= '$RecolTot',
			    numpgtos 	= '$NumPgtos',
			    pgtotot 	= '$PgtoTot',
			    totpgto 	= '$TotPgto',
			    fechamento 	= '$FechamentoF',
			    gavaut 	= '$GavAut',
			    difcx 	= '$DifCx',
			    cd	 	= '$cd',
			    numprodsrec	= '$NPRecs',
			    nbookrec 	= '$NBookRec',
			    numchav 	= '$NTChav',
			    numtxprod 	= '$NTxProd',
			    numconcurso	= '$NConcurso',
			    numbebe	= '$NBebe',
			    numcontent 	= '$NContEnt',
			    numcontparc	= '$NContParc',
			    numpropent 	= '$NPropEnt',
			    numpropparc	= '$NPropParc',
			    numresgate 	= '$NResgate',
			    numestorno 	= '$NEstorno',
			    vrchav 	= '$ValorChav',
			    vrprod 	= '$ValorProd',
			    vrprecs 	= '$VrPRecsF',
			    vrconc 	= '$ValorConc',
			    vrbebe 	= '$ValorBebe',
			    vrbookrec 	= '$VrBookRecF',
			    vrcontent 	= '$ValorContEnt',
			    vrpropent 	= '$ValorPropEnt',
			    vrcontparc 	= '$ValorContParc',
			    vrpropparc 	= '$ValorPropParc',
			    vrresg 	= '$ValorResg',
			    vrestorno 	= '$ValorEstorno',
                sobra = '$IncSobra',
			    incsobra 	= '$IncSobraF',
			    depcli 	= '$DepCli',
			    dinheiro 	= '$Dinheiro',
			    carddeb 	= '$CardDeb',
			    cardvista 	= '$CardVista',
			    cardparclj	= '$CardParcLj',
			    cardparcadm	= '$CardParcAdm',
			    cheqtotal 	= '$CheqTotal',
			    cheqpre 	= '$CheqPre',
			    DDPtot 	= '$DDPF',
			    MCStot 	= '$MCSF',
			    MDVtot 	= '$MDVF',
			    MPDtot 	= '$MPDF',
			    RCLtot 	= '$RCLF',
			    SRVtot 	= '$SRVF',
			    VTRtot 	= '$VTRF',
			    OUTtot 	= '$OUTF',
			    diferenca	= $Diferenca ";

		$rsS  = mysqli_query($conec, $sqlS) or die("File fccxant Error #41. Contate seu Administrador.");

		// Salvando os Dados
		$sqlGr = "update caixa set dtclose   = '$dtOpenGr',
				recolh      = '$Recolh',
				difer        = '$Diferenca',
				numerario    = '$Fechamento',
				operador     = '$user',
				numtxprod    = '$NTxProd',
				vrtxprod     = '$RecProd',
				numconcurso  = '$NConcurso',
				vrconcurso   = '$RecConc',
				numbebe      = '$NBebe',
				vrbebe       = '$RecBebe',
				numcontent   = '$NContEnt',
				vrcontent    = '$RecCntE',
				numcontparc  = '$NContParc',
				vrcontparc   = '$RecCntP',
				numpropent   = '$NPropEnt',
				vrpropent    = '$RecPVDE',
				numpropparc  = '$NPropParc',
				vrpropparc   = '$RecPVDP',
				numprodsrec  = '$NPRecs',
				vrprodsrec   = '$RecPrdt',
				nbookrec     = '$NBookRec',
				vrbookrec    = '$RecBook',
				numresgate   = '$NResgate',
				vrresgate    = '$RecResg',
				numestorno   = '$NEstorno',
				vrestorno    = '$RecEst',
				cdebfinal    = '$cDebFinal',
				credtotvist  = '$credTotV',
				credtotploja = '$credTotPLoja',
				credtotpadm  = '$credTotPAdm',
				cheqtotvist  = '$cheqTotV',
				cheqtotpre   = '$cheqTotPre',
				totdepcli    = '$DepClientes',
				numpgtos     = '$NumPgtos',
				cashtot	     = '$cashTot',
				despddp      = '$DDP',
				despmcs      = '$MCS',
				despmdv      = '$MDV',
				despmpd      = '$MPD',
				desprcl      = '$RCL',
				despsrv      = '$SRV',
				despvtr      = '$VTR',
				despout      = '$OUT'  where fita = '$Fita' and ano = '$ano' ";

		$rsGr  = mysqli_query($conec, $sqlGr) or die("File fccxant Error #100. Contate seu Adminsitrador");

		// ... (restante do código de backup para antfech permanece igual)

	} else { ?>
		<br><br><br>
		<font size='6'><b>
				<center>Acesso <font color='gold'>
						<blink><u>não Autorizado</u></blink>
						<font color='#FFFFFF'>!!!</center>
			</b></font><br><br><br>
		<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
	<?php
	}

	// Encerrando a Conexão
	if (isset($rsA) && $rsA instanceof mysqli_result) {
		mysqli_free_result($rsA);
	}
	if (isset($rsR) && $rsR instanceof mysqli_result) {
		mysqli_free_result($rsR);
	}
	if (isset($rsRec) && $rsRec instanceof mysqli_result) {
		mysqli_free_result($rsRec);
	}
	if (isset($rsDep) && $rsDep instanceof mysqli_result) {
		mysqli_free_result($rsDep);
	}
	if (isset($rsGr) && $rsGr instanceof mysqli_result) {
		mysqli_free_result($rsGr);
	}
	$SisRot = "S-7.5.2.1.1";
	include "rodape.php"; ?>

</body>

</html>
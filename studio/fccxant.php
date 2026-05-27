<?php

// Debug
ini_set('error_log', 'php_errors.log');

?>

<html>

<head>
	<title>WebCaixa v1.20.18_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			margin-left: 0%;
			margin-right: 0%;
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
	</script><?php

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
		?>
		<script>
			(function() {
				var sairUrl = 'sair.php?c_s=<?php echo rawurlencode($lg_user); ?>';

				if (window.history && window.history.pushState) {
					window.history.replaceState({
						fechamento: true
					}, document.title, window.location.href);
					window.history.pushState({
						fechamento: true
					}, document.title, window.location.href);

					window.addEventListener('popstate', function() {
						window.location.replace(sairUrl);
					});
				}
			})();
		</script>
		<?php
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

	$TipoFech = "Final";

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
		$RecChav      = 0;
		$RecDesp      = 0;
		$Recl         = 0;
		$pixQRCode    = 0;
		$pixCNPJ      = 0;
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
		$NBebe        = 0;
		$NResgate     = 0;
		$NEstorno     = 0;
		$NTChav       = 0;
		$NPropParc    = 0;
		$NVendas      = 0;
		$ValorChav      = '0,00';
		$ValorProd      = '0,00';
		$ValorConc      = '0,00';
		$ValorBebe      = '0,00';
		$ValorContEnt   = '0,00';
		$ValorContParc  = '0,00';
		$ValorPropEnt   = '0,00';
		$ValorPropParc  = '0,00';
		$ValorVend      = '0,00';
		$VrPRecsF       = '0,00';
		$VrBookRecF     = '0,00';
		$ValorResg      = '0,00';
		$ValorEstorno   = '0,00';
		$PgtoTot        = '0,00';
		$Dinheiro       = '0,00';
		$PixQRCode      = '0,00';
		$PixCNPJ        = '0,00';
		$CardDeb        = '0,00';
		$CardVista      = '0,00';
		$CardParcLj     = '0,00';
		$CardParcAdm    = '0,00';
		$CheqTotal      = '0,00';
		$CheqPre        = '0,00';
		$DepCli         = '0,00';
		$Recolh         = '0.00';
		$RecolTot       = '0,00';
		$TotIn          = '0,00';
		$TotOutros      = '0,00';
		$TotGeral       = '0,00';
		$TotPgto        = '0,00';

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
		$Versao = "4.0";

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

		// Obtendo o Total Depositado
		$sqlR = "select * from depositos where dtdep = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die("File fccxant Error #37. Contate seu Administrador.");

		while ($lnR = mysqli_fetch_array($rsR)) {
			$Dep  = $lnR['valor'];
			$Recl = $Recl + $Dep;
		}

		$Recolh = number_format($Recl, 2, ".", "");

		// Totalizando Recebimentos
		$Entradas    = $cashTot + $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $pixQRCode + $pixCNPJ;
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
		$TotAut = mysqli_num_rows($rsA); ?><p>

		<table width="100%" border="05" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td rowspan='2' align='center'>
					<font color='gold'><b><i>Dados da Abertura</i></b></font>
				</td>
				<td width='12%' align='center'>
					<font color="gold"><b><i>Fita Nº</b></i></font>
				</td>
				<td width='27%' align='center'>
					<font color="gold"><b><i>PC <b><i></b></i></font>
				</td>
				<td width='12%' align='center'>
					<font color="gold"><b><i>Data</b></i></font>
				</td>
				<td width='19%' align='center'>
					<font color="gold"><b><i>Operador</b></i></font>
				</td>
				<td width='15%' align='center'>
					<font color="gold"><b><i>Saldo de Abertura</b></i></font>
				</td>
			</tr>

			<tr>
				<td width='12%' align='center'>
					<b><i><b><i><?php echo "$Fita/$ano"; ?></i></b></b></i></font>
				</td>
				<td width='27%' align='center'>
					<b><i><b><i><?php echo "$PC - $Ape"; ?></i></b></b></i></font>
				</td>
				<td width='12%' align='center'>
					<b><i><b><i><?php echo $dataFch; ?></i></b></b></i></font>
				</td>
				<td width='19%' align='center'>
					<b><i><b><i><?php echo "$userF ($app)"; ?></i></b></b></i></font>
				</td>
				<td width='15%' align='center'>
					<b><i><b><i>R$ <?php echo $inicial; ?></i></b></b></i></font>
				</td>
			</tr>
		</table>
		</p>

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="34%">
					<table border="05" cellpadding="02" cellspacing="0">
						<tr>
							<td align='center'>
								<font color="aqua"><b><i>FECHAMENTO POR TIPO DE RECEBIMENTO</b></i></font>
							</td>
						</tr>

						<!--<tr>
							<td>
								<font color="gold"><b><i>Chaveiros:. . . . . . . . . </b></i></font>
								<b><i><?php //echo "$NTChav itens --> R$ $ValorChav"; 
										?></i></b>
							</td>
						</tr>-->

						<tr>
							<td>
								<font color="gold"><b><i>Taxa de Produção:. . . </b></i></font>
								<b><i><?php echo "$NTxProd itens --> R$ $ValorProd"; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Inscrição Concurso:. . </b></i></font>
								<b><i><?php echo "$NConcurso itens --> R$ $ValorConc"; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Contratos (Entrada):. . </b></i></font>
								<b><i><?php echo "$NContEnt itens --> R$ $ValorContEnt"; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Contratos (Parcela):. .</b></i></font>
								<b><i><?php echo "$NContParc itens --> R$ $ValorContParc"; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Propostas (Entrada):. . </b></i></font>
								<b><i><?php echo "$NPropEnt itens --> R$ $ValorPropEnt"; ?></i></b>
							</td>
						</tr>

						<!--<tr>
							<td>
								<font color="gold"><b><i>Propostas (Parcela):. . </b></i></font>
								<b><i><?php //echo "$NPropParc itens --> R$ $ValorPropParc"; 
										?></i></b>
							</td>
						</tr>-->

						<tr>
							<td>
								<font color="gold"><b><i>Produtos &amp; Serviços:. <font color='#FFFFFF'><?php echo " $NPRecs itens --> R$ $VrPRecsF"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Books &agrave; Vista: . . . . . .<font color='#FFFFFF'><?php echo " $NBookRec itens --> R$ $VrBookRecF"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Despesas: . . . . . . . . . </b></i></font>
								<b><i><?php echo "$NumPgtos itens --> R$ $PgtoTot"; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Estornos:. . . . . . . . . . <font color='#FFFFFF'><?php echo " $NEstorno itens --> R$ $ValorEstorno"; ?> </b></i></font>
							</td>
						</tr>
					</table>
				</td>
				<td width="33%">
					<table border="05" cellpadding="02" cellspacing="0" align="center">
						<tr>
							<td align='center'>
								<font color="aqua"><b><i>FECHAMENTO POR FORMA DE PAGAMENTO</b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Dinheiro: . . . . . . . . </b></i></font>
								<b><i>R$ <?php echo $Dinheiro; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Pix QR Code:. . . . </b></i></font>
								<b><i>R$ <?php echo $PixQRCode; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Pix CNPJ:. . . . </b></i></font>
								<b><i>R$ <?php echo $PixCNPJ; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Cartão Débito: . . . . </b></i></font>
								<b><i>R$ <?php echo $CardDeb; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Cartão Crédito (A Vista):. . . . </b></i></font>
								<b><i>R$ <?php echo $CardVista; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Cartão Crédito (Parc. Loja): . </b></i></font>
								<b><i>R$ <?php echo $CardParcLj; ?></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>Cartão Crédito (Parc. Adm.): </b></i></font>
								<b><i>R$ <?php echo $CardParcAdm; ?></i></b>
							</td>
						</tr>
					</table><br>

					<center>
						<font color="gold"><b><i>&nbsp;Diferença de Caixa: </b></i></font>
						<b>
							<i>R$ <?php echo $DifCx;
									if ($Diferenca <> 0) { ?>
									<font color='gold'>
										<blink><?php echo $cd; ?><blink>
									</font><?php
										} ?>
							</i></b>
					</center>
				</td>
				<td width="33%">
					<table border="05" cellpadding="02" cellspacing="0" align="right">
						<tr>
							<td align='center'>
								<font color="aqua">
									<b>
										<i>TOTALIZAÇÕES: &nbsp;&nbsp;<font color='#FFFFFF'>
												<blink>
													<?php echo "$TotAut Autenticações Válidas"; ?></blink></b></i>
								</font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Saldo Inicial:. . . . . . . . . . . <font color='#FFFFFF'><?php echo "R$ $inicial"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Total Arrecadado: . . . . . . . <font color='#FFFFFF'><?php echo "R$ $TotIn"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Recolhido em Dinheiro: . . . <font color='#FFFFFF'><?php echo "R$ $RecolTot"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Outros Recolhimentos: . . . <font color='#FFFFFF'><?php echo "R$ $TotOutros"; ?> </b></i></font>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Recolhimento Total:. . . . . . </b></i></font><b><i>R$ <?php echo $TotGeral; ?><blink>
											</font></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Despesas:. . . . . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $PgtoTot; ?><blink>
											</font></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Estornos: . . . . . . . . . . . . . . </b></i></font><b><i>R$ <?php echo $ValorEstorno; ?><blink>
											</font></i></b>
							</td>
						</tr>

						<tr>
							<td>
								<font color="gold"><b><i>&nbsp;Saldo de Caixa (Gaveta): . . . </b></i></font><b><i>R$ <?php echo $GavAut; ?><blink>
											</font></i></b>
							</td>
						</tr>

						<tr>
							<td><?php
								if ($IncSobra > 0) { ?>
									<font color="gold"><b><i>&nbsp;Sobra Incorporada ao Caixa: </b></i></font>
									<b><i><?php echo "R$ $IncSobraF"; ?></i></b>
								<?php
								} else {
								?>
									&nbsp;
								<?php
								}
								?>
							</td>
						</tr>

						<tr>
							<td><?php
								if ($cashIn > 0) { ?>
									<font color="gold"><b><i>&nbsp;Retificação de Lançamento(Créd): </b></i></font>
									<b><i><?php echo "R$ $cashInF"; ?></i></b>
								<?php
								} else {
								?>
									&nbsp;
								<?php
								}
								?>
							</td>
						</tr>

						<tr>
							<td>
								<?php
								if ($cashOut > 0) { ?>
									<font color="gold"><b><i>&nbsp;Retificação de Lançamento(Déb):&nbsp; </b></i></font>
									<b><i><?php echo "R$ $cashOutF"; ?></i></b>
								<?php
								} else {
								?>
									&nbsp;
								<?php
								}
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php

		// Calculando Recolhimentos
		$TPgto = $Pgtos + $Recl;
		$TotPgto = number_format($TPgto, 2, ",", ".");

		// Variáveis zeradas
		$NBebe = '0';
		$NResgate = '0';

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

		$rsS  = mysqli_query($conec, $sqlS)  or die("File fccxant Error #041. Contate seu Adminsitrador");

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

		$rsGr  = mysqli_query($conec, $sqlGr) or die("File fccxant Error #100. SQL Error: " . mysqli_error($conec) . " | Query: " . $sqlGr);

		// spoolfch
		$sqlATF_1 = "SELECT fita, datafch FROM spoolfch ORDER BY datafch DESC LIMIT 1";
		$rsATF_1 = mysqli_query($conec, $sqlATF_1) or die("Erro ao consultar spoolfch: " . mysqli_error($conec));
		$lnATF_1 = mysqli_fetch_assoc($rsATF_1);
		$FitaFch_1 = $lnATF_1['fita'];


		// antfech
		$sqlATF_2 = "SELECT fita, datafch FROM antfech WHERE YEAR(STR_TO_DATE(datafch, '%d/%m/%Y')) = YEAR(CURDATE())ORDER BY datafch DESC LIMIT 1";
		$rsATF_2 = mysqli_query($conec, $sqlATF_2) or die("Erro ao consultar antfech: " . mysqli_error($conec));
		$lnATF_2 = mysqli_fetch_assoc($rsATF_2);
		$FitaFch_2 = $lnATF_2['fita'] ?? 0;

		if ($FitaFch_1 > $FitaFch_2) {
			// Especifique os campos conforme sua estrutura
			$sqlATF_3 = "INSERT INTO `antfech`(
							`fita`,
							`ano`,
							`pc`,
							`ape`,
							`datafch`,
							`dtabre`,
							`dataatual`,
							`datafecha`,
							`hora`,
							`user`,
							`app`,
							`inicial`,
							`nvendas`,
							`valorvend`,
							`totin`,
							`recolhe`,
							`totpgto`,
							`numpgtos`,
							`pgtotot`,
							`fechamento`,
							`gavaut`,
							`difcx`,
							`cd`,
							`numprodsrec`,
							`nbookrec`,
							`numchav`,
							`numtxprod`,
							`numconcurso`,
							`numbebe`,
							`numcontent`,
							`numcontparc`,
							`numpropent`,
							`numpropparc`,
							`numresgate`,
							`numestorno`,
							`vrchav`,
							`vrprod`,
							`vrprecs`,
							`vrconc`,
							`vrbebe`,
							`vrbookrec`,
							`vrcontent`,
							`vrpropent`,
							`vrcontparc`,
							`vrpropparc`,
							`vrresg`,
							`vrestorno`,
							`sobra`,
							`incsobra`,
							`depcli`,
							`dinheiro`,
							`carddeb`,
							`cardvista`,
							`cardparclj`,
							`cardparcadm`,
							`cheqtotal`,
							`cheqpre`,
							`DDPtot`,
							`MCStot`,
							`MDVtot`,
							`MPDtot`,
							`RCLtot`,
							`SRVtot`,
							`VTRtot`,
							`OUTtot`,
							`diferenca`
						) SELECT
							`fita`,
							`ano`,
							`pc`,
							`ape`,
							`datafch`,
							`dtabre`,
							`dataatual`,
							`datafecha`,
							`hora`,
							`user`,
							`app`,
							`inicial`,
							`nvendas`,
							`valorvend`,
							`totin`,
							`recolhe`,
							`totpgto`,
							`numpgtos`,
							`pgtotot`,
							`fechamento`,
							`gavaut`,
							`difcx`,
							`cd`,
							`numprodsrec`,
							`nbookrec`,
							`numchav`,
							`numtxprod`,
							`numconcurso`,
							`numbebe`,
							`numcontent`,
							`numcontparc`,
							`numpropent`,
							`numpropparc`,
							`numresgate`,
							`numestorno`,
							`vrchav`,
							`vrprod`,
							`vrprecs`,
							`vrconc`,
							`vrbebe`,
							`vrbookrec`,
							`vrcontent`,
							`vrpropent`,
							`vrcontparc`,
							`vrpropparc`,
							`vrresg`,
							`vrestorno`,
							`sobra`,
							`incsobra`,
							`depcli`,
							`dinheiro`,
							`carddeb`,
							`cardvista`,
							`cardparclj`,
							`cardparcadm`,
							`cheqtotal`,
							`cheqpre`,
							`DDPtot`,
							`MCStot`,
							`MDVtot`,
							`MPDtot`,
							`RCLtot`,
							`SRVtot`,
							`VTRtot`,
							`OUTtot`,
							`diferenca`
						FROM
							`spoolfch`";
			$rsATF_3 = mysqli_query($conec, $sqlATF_3) or die("Erro ao inserir dados: " . mysqli_error($conec));
		}

		?>

		<form method="post" action="impfccxant.php?c_s=<?php echo $lg_user; ?>" target="_blank">
			<input type="hidden" name="c_s" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="tipoFech" value="<?php echo $TipoFech; ?>">
			<input type="hidden" name="fita" value="<?php echo $Fita; ?>">
			<input type="hidden" name="ano" value="<?php echo $ano; ?>">
			<input type="hidden" name="datafch" value="<?php echo $dataFch; ?>">
			<input type="hidden" name="pc" value="<?php echo $PC; ?>">
			<input type="hidden" name="ape" value="<?php echo $Ape; ?>">
			<input type="hidden" name="hora" value="<?php echo $hora; ?>">
			<input type="hidden" name="app" value="<?php echo $app; ?>">
			<input type="hidden" name="inicial" value="<?php echo $inicial; ?>">
			<input type="hidden" name="totin" value="<?php echo $TotIn; ?>">
			<input type="hidden" name="recolh" value="<?php echo $RecolTot; ?>">
			<input type="hidden" name="numvendas" value="<?php echo $NVendas; ?>">
			<input type="hidden" name="valorvend" value="<?php echo $ValorVend; ?>">
			<input type="hidden" name="numpgtos" value="<?php echo $NumPgtos; ?>">
			<!--<input type="hidden" name="pgtoservicos" value="<?php //echo $PgtoServicos; ?>">-->
			<input type="hidden" name="pgtotot" value="<?php echo $PgtoTot; ?>">
			<input type="hidden" name="totpgto" value="<?php echo $TotPgto; ?>">
			<input type="hidden" name="fechamentoF" value="<?php echo $FechamentoF; ?>">
			<input type="hidden" name="gavaut" value="<?php echo $GavAut; ?>">
			<input type="hidden" name="difcx" value="<?php echo $DifCx; ?>">
			<input type="hidden" name="cd" value="<?php echo $cd; ?>">
			<input type="hidden" name="numprodsrec" value="<?php echo $NPRecs; ?>">
			<input type="hidden" name="nbookrec" value="<?php echo $NBookRec; ?>">
			<input type="hidden" name="numchav" value="<?php echo $NTChav; ?>">
			<input type="hidden" name="numtxprod" value="<?php echo $NTxProd; ?>">
			<input type="hidden" name="numconcurso" value="<?php echo $NConcurso; ?>">
			<input type="hidden" name="numbebe" value="<?php echo $NBebe; ?>">
			<input type="hidden" name="numcontent" value="<?php echo $NContEnt; ?>">
			<input type="hidden" name="numcontparc" value="<?php echo $NContParc; ?>">
			<input type="hidden" name="numpropent" value="<?php echo $NPropEnt; ?>">
			<input type="hidden" name="numpropparc" value="<?php echo $NPropParc; ?>">
			<input type="hidden" name="numresgate" value="<?php echo $NResgate; ?>">
			<input type="hidden" name="numestorno" value="<?php echo $NEstorno; ?>">
			<input type="hidden" name="vrchav" value="<?php echo $ValorChav; ?>">
			<input type="hidden" name="vrprod" value="<?php echo $ValorProd; ?>">
			<input type="hidden" name="vrprecs" value="<?php echo $VrPRecsF; ?>">
			<input type="hidden" name="vrconc" value="<?php echo $ValorConc; ?>">
			<input type="hidden" name="vrbebe" value="<?php echo $ValorBebe; ?>">
			<input type="hidden" name="vrbookrec" value="<?php echo $VrBookRecF; ?>">
			<input type="hidden" name="vrcontent" value="<?php echo $ValorContEnt; ?>">
			<input type="hidden" name="vrpropent" value="<?php echo $ValorPropEnt; ?>">
			<input type="hidden" name="vrcontparc" value="<?php echo $ValorContParc; ?>">
			<input type="hidden" name="vrpropparc" value="<?php echo $ValorPropParc; ?>">
			<input type="hidden" name="vrresg" value="<?php echo $ValorResg; ?>">
			<input type="hidden" name="vrestorno" value="<?php echo $ValorEstorno; ?>">
			<input type="hidden" name="sobra" value="<?php echo $IncSobra; ?>">
			<input type="hidden" name="depcli" value="<?php echo $DepCli; ?>">
			<input type="hidden" name="dinheiro" value="<?php echo $Dinheiro; ?>">
			<input type="hidden" name="carddeb" value="<?php echo $CardDeb; ?>">
			<input type="hidden" name="cardvista" value="<?php echo $CardVista; ?>">
			<input type="hidden" name="cardparclj" value="<?php echo $CardParcLj; ?>">
			<input type="hidden" name="cardparcadm" value="<?php echo $CardParcAdm; ?>">
			<input type="hidden" name="pixqrcode" value="<?php echo $PixQRCode; ?>">
			<input type="hidden" name="pixcnpj" value="<?php echo $PixCNPJ; ?>">
			<?php

			// IncSobra
			if ($IncSobra > 0.009) {
			?>
				<input type="hidden" name="incsobra" value="<?php echo $IncSobraF; ?>">
				<?php
			}

			// Gerando a Retificação
			$sql = "select * from errlanc where dataop = '$DataAtual'";
			$rs  = mysqli_query($conec, $sql) or die("File fccxant Error #42. Contate seu Administrador.");
			$regs = mysqli_num_rows($rs);

			if ($regs > 0) {

				while ($ln = mysqli_fetch_array($rs)) {
					$cashi    = $ln['cashi'];
					$cdebi    = $ln['cdebi'];
					$ccredvi  = $ln['ccredvi'];
					$ccredpli = $ln['ccredpli'];
					$ccredpai = $ln['ccredpai'];
					$cheqvi   = $ln['cheqvi'];
					$cheqpi   = $ln['cheqpi'];
					$depclii  = $ln['depclii'];

					$casho    = $ln['casho'];
					$cdebo    = $ln['cdebo'];
					$ccredvo  = $ln['ccredvo'];
					$ccredplo = $ln['ccredplo'];
					$ccredpao = $ln['ccredpao'];
					$cheqvo   = $ln['cheqvo'];
					$cheqpo   = $ln['cheqpo'];
					$depclio  = $ln['depclio'];

					if ($cashi > 0) {
						$De = 'Dinheiro';
						$Dif = $cashi;
					} else if ($cdebi > 0) {
						$De = 'Cartao de Debito';
						$Dif = $cdebi;
					} else if ($ccredvi > 0) {
						$De = 'Cartao de Credito a Vista';
						$Dif = $ccredvi;
					} else if ($ccredpli > 0) {
						$De = 'Cartao Credito Parcelamento Loja';
						$Dif = $ccredpli;
					} else if ($ccredpai > 0) {
						$De = 'Cartao Credito Parcel. Administradora';
						$Dif = $ccredpai;
					} else {
						$De = 'Deposito de Clientes';
						$Dif = $depclii;
					}
					if ($casho > 0) {
						$Para = 'Dinheiro';
					} else if ($cdebo > 0) {
						$Para = 'Cartao de Debito';
					} else if ($ccredvo > 0) {
						$Para = 'Cartao de Credito a Vista';
					} else if ($ccredplo > 0) {
						$Para = 'Cartao Credito Parcelamento Loja';
					} else if ($ccredpao > 0) {
						$Para = 'Cartao Credito Parcel. Administradora';
					} else {
						$Para = 'Deposito de Clientes';
					}

					$DifF = number_format($Dif, 2, ",", ".");

				?>
					<input type="hidden" name="lancDe[]" value="<?php echo $De; ?>">
					<input type="hidden" name="lancPara[]" value="<?php echo $Para; ?>">
					<input type="hidden" name="lancValor[]" value="<?php echo $DifF; ?>">
			<?php
				}
			}

			?>
			<input type="hidden" name="ddpf" value="<?php echo $DDPF; ?>">
			<input type="hidden" name="mcsf" value="<?php echo $MCSF; ?>">
			<input type="hidden" name="mdvf" value="<?php echo $MDVF; ?>">
			<input type="hidden" name="mpdf" value="<?php echo $MPDF; ?>">
			<input type="hidden" name="rclf" value="<?php echo $RCLF; ?>">
			<input type="hidden" name="srvf" value="<?php echo $SRVF; ?>">
			<input type="hidden" name="vtrf" value="<?php echo $VTRF; ?>">
			<input type="hidden" name="outf" value="<?php echo $OUTF; ?>">
			<input type="hidden" name="recolh" value="<?php echo $RecolTot; ?>">

			<?php


			// Emitindo Comprovante de Sobra ou Falta
			if ($Diferenca > 0) {

			?>
				<input type="hidden" name="fechamentoF" value="<?php echo $FechamentoF; ?>">
				<input type="hidden" name="gavaut" value="<?php echo $GavAut; ?>">
				<input type="hidden" name="difcx" value="<?php echo $DifCx; ?>">
				<input type="hidden" name="cd" value="<?php echo $cd; ?>">

			<?php

			} else if ($Diferenca < 0) {

			?>
				<input type="hidden" name="fechamentoF" value="<?php echo $FechamentoF; ?>">
				<input type="hidden" name="gavaut" value="<?php echo $GavAut; ?>">
				<input type="hidden" name="difcx" value="<?php echo $DifCx; ?>">
				<input type="hidden" name="cd" value="<?php echo $cd; ?>">

			<?php
			}

			// Spoll 2
			$SqlSp = "select * from spool2 order by rec";
			$rsSp  = mysqli_query($conec, $SqlSp) or die("Não foi possível obter dados da spool");
			while ($lnSp  = mysqli_fetch_array($rsSp)) {
				$Spo = $lnSp['spo2'];
			?>
				<input type="hidden" name="spool2[]" value="<?php echo $Spo; ?>">
			<?php
			}

			if ($Diferenca > 0) {
			?>
				<input type="hidden" name="difcx" value="<?php echo $DifCx; ?>">
			<?php
			} else if ($Diferenca < 0) {
			?>
				<input type="hidden" name="difcx" value="<?php echo $DifCx; ?>">
				<?php
			}

			// Obtendo a Relação de Operadores Cadastrados
			$sqlCad = "select * from cadastro where dtcad = '$dtAbre' ";
			$rsCad  = mysqli_query($conec, $sqlCad) or die("File fccxant Error #43. Contate seu Administrador.");
			$regCad = mysqli_num_rows($rsCad);
			$rsH2 = null;

			if ($regCad > 0) {
				while ($lnCad = mysqli_fetch_array($rsCad)) {
					$MatCad = $lnCad['mat'];

					$sqlH2 = "select * from operador where mat = '$MatCad' ";
					$rsH2  = mysqli_query($conec, $sqlH2) or die("File fccxant Error #44. Contate seu Administrador.");
					while ($lnH2 = mysqli_fetch_array($rsH2)) {
						$MatOp  = $lnH2['mat'];
						$MatOpF = substr($MatOp, 0, 1) . "." . substr($MatOp, 1, 3) . "." . substr($MatOp, 4, 3) . "-" . substr($MatOp, 7, 1);
						$Cargo  = $lnH2['cargo'];
						if ($Cargo == 'Cai') {
							$Cargo = 'Ag. Adm';
						}
						$Tempo  = $lnH2['horaop'];
						$Free   = $lnH2['free'];
						if ($Free == 'f') {
							$Compl = ' - Free-Lancer';
						} else {
							$Compl = '';
						}
						$Resp   = $lnH2['resp'];
						$RespF  = substr($Resp, 0, 1) . "." . substr($Resp, 1, 3) . "." . substr($Resp, 4, 3) . "-" . substr($Resp, 7, 1);

				?>
						<input type="hidden" name="cadMat[]" value="<?php echo $MatOpF; ?>">
						<input type="hidden" name="cadCargo[]" value="<?php echo $Cargo; ?>">
						<input type="hidden" name="cadTempo[]" value="<?php echo $Tempo; ?>">
						<input type="hidden" name="cadCompl[]" value="<?php echo $Compl; ?>">
						<input type="hidden" name="cadResp[]" value="<?php echo $RespF; ?>">
					<?php
					}
				}
			}
			if ($rsH2 instanceof mysqli_result) {
				mysqli_free_result($rsH2);
			}

			// Obtendo a Relação de Recuperação de Senhas
			$sqlR  = "select * from restsenha where datar = '$dtAbre' ";
			$rsR   = mysqli_query($conec, $sqlR) or die("File fccxant Error #45. Contate seu Administrador.");
			$regsR = mysqli_num_rows($rsR);

			if ($regsR > 0) {
				while ($lnR = mysqli_fetch_array($rsR)) {
					$UserR  = $lnR['user'];
					$UserRF = substr($UserR, 0, 1) . "." . substr($UserR, 1, 3) . "." . substr($UserR, 4, 3) . "-" . substr($UserR, 7, 1);
					$CpfR   = $lnR['cpf'];
					$CpfRF = substr($CpfR, 0, 3) . "." . substr($CpfR, 3, 3) . "." . substr($CpfR, 6, 3) . "-" . substr($CpfR, 9, 2);
					$AudR   = $lnR['aud'];
					$AudRF = substr($AudR, 0, 1) . "." . substr($AudR, 1, 3) . "." . substr($AudR, 4, 3) . "-" . substr($AudR, 7, 1);
					$DataR  = $lnR['datar'];
					$DataRF = substr($DataR, 8, 2) . "/" . substr($DataR, 5, 2) . "/" . substr($DataR, 0, 4);
					$HoraR  = $lnR['horar'];

					?>
					<input type="hidden" name="cpfrf[]" value="<?php echo $CpfRF; ?>">
					<input type="hidden" name="userf[]" value="<?php echo $UserRF; ?>">
					<input type="hidden" name="audrf[]" value="<?php echo $AudRF; ?>">
					<input type="hidden" name="datarf[]" value="<?php echo $DataRF; ?>">
					<input type="hidden" name="horarf[]" value="<?php echo $HoraR; ?>">
				<?php
				}
			}

			// Imprimindo Recolhimentos
			$sqlRec = "select dtopen from caixa order by dtopen desc ";
			$rsRec  = mysqli_query($conec, $sqlRec) or die("File fccxant Error #48. Contate seu Administrador.");
			$regRec = mysqli_num_rows($rsRec);
			$lnRec = mysqli_fetch_array($rsRec);
			$dtOpen  = $lnRec['dtopen'];
			$DataAb = substr($dtOpen, 8, 2) . "/" . substr($dtOpen, 5, 2) . "/" . substr($dtOpen, 0, 4);

			if ($regRec > 0) {
				$sqlDep = "select hrdep, envelope, valor, matreceb from depositos where dtdep = '$dtOpen' ";
				$rsDep  = mysqli_query($conec, $sqlDep) or die("File fccxant Error #49. Contate seu Administrador.");
				$AcRec  = 0;
				$ACount = 0;

				while ($lnDep = mysqli_fetch_array($rsDep)) {
					$Hora   = $lnDep['hrdep'];
					$Nvlp   = $lnDep['envelope'];
					$Vlr    = $lnDep['valor'];
					$Matr   = $lnDep['matreceb'];
					$Mtrc   = $Matr + 0;
					$ACount = $ACount + 1;
					$AcRec  = $AcRec + $Vlr;
				}
				$TRec  = number_format($AcRec, 2, ",", ".");
				?>
				<input type="hidden" name="acrec" value="<?php echo $AcRec; ?>">
				<input type="hidden" name="acount" value="<?php echo $ACount; ?>">
				<input type="hidden" name="trec" value="<?php echo $TRec; ?>">
			<?php
			} else {
				$SDep = "Não houve depósitos nesta data.";
			?>
				<input type="hidden" name="SDep" value="<?php echo $SDep; ?>">
			<?php
			}
			//shell_exec("echo '   ***  $horaInv''$horaNorm'-'$Entradas'-'$horaInv''$horaNorm ***' >> /backups/fccxant_$dtAbre.txt");
			?>
			<table width="50%" align="center" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Imprimir" class="btn">
						<input type="button" value="Sair" class="btn" onclick="window.location.href='sair.php?c_s=<?php echo $lg_user; ?>'">
					</td>
				</tr>
			</table>
		</form>
	<?php
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

	$SisRot = "S-7.5.2.1.1";
	include "rodape.php"; ?>

</body>

</html>

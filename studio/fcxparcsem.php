<?php

// Debug
ini_set('error_log', 'php_errors.log');

?>

<html>

<head>
	<title>WebCaixa v1.20.21_beta</title>
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
	</script>
	<?php

	// Obtendo a Data Atual
	$DataAtual = date('Ymd');

	?>
</head>

<body background="../images/bg1.jpg" link='lime' vlink='#FFFFFF' alink='lime' text="#FFFFFF">

	<?php

	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";
	exit;*/

	include "../cabecprs.php";

	// Obtendo o Login
	$Sis     = "S7";
	$Rot       = "S7R5.0.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$mat1 = substr($user, 0, 1);
	$mat2 = substr($user, 1, 3);
	$mat3 = substr($user, 4, 3);
	$dv   = substr($user, 7, 1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	$pss     = substr($lg_user, 8, 40);
	$Codigo    = trim($_POST['txtcod']);
	$CtSen     = trim($_POST['txtsen']);
	$Counter   = 5 - trim($_POST['txtfch']);
	$Gaveta    = trim($_POST['txtcash']);
	$GavAut    = number_format($Gaveta, 2, ",", ".");
	$ch        = '';
	$dtAbre    = date('Y-m-d');
	$dty     = substr($dtAbre, 0, 4);
	$dtm     = substr($dtAbre, 5, 2);
	$dtd     = substr($dtAbre, 8, 2);
	$dataFch   = "$dtd/$dtm/$dty";
	$hora      = date("H:i");

	// Calculando a Contra-Senha
	$c0 = substr($Codigo, 0, 1);
	$c1 = substr($Codigo, 1, 1);
	$c2 = substr($Codigo, 2, 1);
	$c3 = substr($Codigo, 3, 1);
	$c4 = substr($Codigo, 4, 1);
	$c5 = substr($Codigo, 5, 1);

	include "us_sist.php";
	if ($ch == 'no') {
		include "us_cad.php";
	}

	if ($ch == 'ok-enc' or $ch == 'ok') {
		?>

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

		// Obtendo Apelido
		include "conexao.php";
		include "dblog.php";

		$sqlP = "select ape from pessoal where mat = '$user' ";
		$rsP  = mysqli_query($conec, $sqlP) or die("Não foi possível fechar o Caixa");
		$lnP = mysqli_fetch_array($rsP);
		$app = $lnP['ape'];

		// Obtendo Dados do PC
		include "dbselect.php";
		$sqlI = "select * from inicial";
		$rsI  = mysqli_query($conec, $sqlI) or die("Não foi possível fechar o Caixa");
		$lnI = mysqli_fetch_array($rsI);
		$PC  = $lnI['pc'];
		$Ape = $lnI['ape'];

		// Bloqueando o Fechamento Parcial
		$sqlX = "select fch from datafix";
		$rsX  = mysqli_query($conec, $sqlX) or die("Erro de Acesso #1. Contate seu Administrador.");
		$lnX  = mysqli_fetch_array($rsX);
		$Fx = $lnX['fch'];

		if ($ch == 'ok-enc' and $Fx > 0) {
			$Fx   = $Fx - 1;
			$sqlX = "update datafix set fch = '$Fx' ";
			$rsX  = mysqli_query($conec, $sqlX) or die("Erro de Acesso #2. Contate seu Administrador.");
		}

		// Obtendo Dados para o Fechamento
		$sqlA = "select fita, ano, dtopen, numerario, cashout, incsobra, cashin from caixa where dtclose is null";
		$rsA  = mysqli_query($conec, $sqlA) or die("Não foi possível fechar o Caixa");
		$regA = mysqli_num_rows($rsA);
		$lnA = mysqli_fetch_array($rsA);
		$Fita      = $lnA['fita'];
		$ano       = $lnA['ano'];
		$dtOpen    = $lnA['dtopen'];
		$opy     = substr($dtOpen, 0, 4);
		$opm     = substr($dtOpen, 5, 2);
		$opd     = substr($dtOpen, 8, 2);
		$dtOpenGr  = "$opy$opm$opd";
		$Numerario = $lnA['numerario'];
		$inicial   = number_format($Numerario, 2, ",", ".");
		$cashOut   = $lnA['cashout'];
		$cashOutF  = number_format($cashOut, 2, ",", ".");
		$IncSobra  = $lnA['incsobra'];
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

		// Totalizando Chaveiros
		/*$sqlT = "SELECT vltx FROM taxas where codigo = 'CHV' order by datalt desc";
		$rsT  = mysqli_query($conec, $sqlT) or die('Erro #0!');
		$lnT  = mysqli_fetch_array($rsT);
		$VLTX = $lnT['vltx'];

		$sqlR = "SELECT numdoc, vlrec FROM registro where tiporec='9' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #1!');

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
		}*/

		// Totalizando Taxa de Produção
		$sqlR = "SELECT numdoc FROM registro where tiporec='1' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #1A!');
		$NTxProd = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='1' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #2A!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$RecProd = $RecProd + $VlRec;
			$ValorProd    = number_format($RecProd, 2, ",", ".");
		}

		if ($ValorProd == '') {
			$ValorProd = '0,00';
		}

		// Totalizando Incrição no Concurso
		$sqlR = "SELECT numdoc FROM registro where tiporec='2' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #3!');
		$NConcurso = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='2' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #4!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #5!');
		$NContEnt = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='3' and subtipo = 'CNTE' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #6!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #7!');
		$NContParc = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='3' and subtipo = 'CNTP' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #8!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #9!');
		$NPropEnt = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='4' and subtipo = 'PVDE' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #1A!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec        = $lnR['vlrec'];
			$RecPVDE      = $RecPVDE + $VlRec;
			$ValorPropEnt = number_format($RecPVDE, 2, ",", ".");
		}

		if ($ValorPropEnt == '') {
			$ValorPropEnt = '0,00';
		}

		// Totalizando Propostas (Parcela)
		/*$sqlR = "SELECT numdoc FROM registro where tiporec='4' and subtipo = 'PVDP' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc, parcela";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #2A!');
		$NPropParc = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='4' and subtipo = 'PVDP' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #3A!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec         = $lnR['vlrec'];
			$RecPVDP       = $RecPVDP + $VlRec;
			$ValorPropParc = number_format($RecPVDP, 2, ",", ".");
		}

		if ($ValorPropParc == '') {
			$ValorPropParc = '0,00';
		}*/

		// Totalizando Produtos
		$sqlR = "SELECT numdoc FROM registro where tiporec='6' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #4A!');
		$NPRecs = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='6' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #5A!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #6A!');
		$NBookRec = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='7' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #7A!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecBook  = $RecBook + $VlRec;
			$VrBookRecF = number_format($RecBook, 2, ",", ".");
		}

		if ($VrBookRecF == '') {
			$VrBookRecF = '0,00';
		}

		// Resgate de Cheques
		/*$sqlR = "SELECT numdoc FROM registro where tiporec='5' and estorno <> 'x' and datarec = '$dtOpen' group by numdoc";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #8A!');
		$NResgate = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='5' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #9A!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$RecResg  = $RecResg + $VlRec;
			$ValorResg = number_format($RecResg, 2, ",", ".");
		}

		if ($ValorResg == '') {
			$ValorResg = '0,00';
		}*/

		// Despesas
		$sqlR = "SELECT numdoc FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #1B!');
		$NumPgtos = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #2B!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #3B!');
		$NEstorno = mysqli_num_rows($rsR);

		$sqlR = "SELECT vlrec FROM registro where tiporec='E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #4B!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #5B!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #6B!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #7B!');

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
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #8B!');

		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec    = $lnR['vlrec'];
			$credTotPLoja  = $credTotPLoja + $VlRec;
			$CardParcLj = number_format($credTotPLoja, 2, ",", ".");
		}

		if ($CardParcLj == '') {
			$CardParcLj = '0,00';
		}

		// Arrecadado em Card Crédito Parc. Adm.
		/*$sqlR = "SELECT vlrec FROM registro where modpgto='32' and tiporec <> 'E' and estorno <> 'x' and datarec = '$dtOpen' order by tiporec";
		$rsR  = mysqli_query($conec, $sqlR) or die('Erro #9B!');
		while ($lnR  = mysqli_fetch_array($rsR)) {
			$VlRec   = $lnR['vlrec'];
			$credTotPAdm  = $credTotPAdm + $VlRec;
			$CardParcAdm = number_format($credTotPAdm, 2, ",", ".");
		}
		if ($CardParcAdm == '') {
			$CardParcAdm = '0,00';
		}*/

		// Obtendo o Total Depositado
		$sqlR = "select * from depositos where dtdep = '$dtOpen' ";
		$rsR  = mysqli_query($conec, $sqlR) or die("Erro #4C!");
		while ($lnR = mysqli_fetch_array($rsR)) {
			$Dep  = $lnR['valor'];
			$Recl = $Recl + $Dep;
		}
		$Recolh = number_format($Recl, 2, ".", "");

		// Totalizando Recebimentos
		$Entradas  = $cashTot + $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $pixQRCode + $pixCNPJ;
		$DemaisTot = $cDebFinal + $credTotV + $credTotPLoja + $credTotPAdm + $pixQRCode + $pixCNPJ;
		$Geral     = $Recolh + $DemaisTot;
		$TotIn     = number_format($Entradas, 2, ",", ".");
		$RecolTot  = number_format($Recolh, 2, ",", ".");
		$TotOutros = number_format($DemaisTot, 2, ",", ".");
		$TotGeral  = number_format($Geral, 2, ",", ".");

		// Desmembrando Pagamentos
		$sqlD = "SELECT subtipo,vlrec FROM registro where tiporec='8' and estorno <> 'x' and datarec = '$dtOpen' ";
		$rsD  = mysqli_query($conec, $sqlD) or die('Erro #5C!');

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
		$MPDF = number_format($MPD, 2, ",", ".");
		$RCLF = number_format($RCL, 2, ",", ".");
		$SRVF = number_format($SRV, 2, ",", ".");
		$VTRF = number_format($VTR, 2, ",", ".");
		$OUTF = number_format($OUT, 2, ",", ".");

		// Totalizando Pagamentos
		$Pgtos   = $DDP + $MCS + $MPD + $RCL + $SRV + $VTR + $OUT;
		$PgtoTot = number_format($Pgtos, 2, ",", ".");

		// Calculando a Diferença de Caixa
		$Diferenca = ($Recolh + $Pgtos + $Gaveta + $cashOut) - ($Numerario + $cashTot + $IncSobra + $cashIn);

		if ($Diferenca > -0.009 and $Diferenca < 0.009) {
			$Diferenca = 0;
		}

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
		$rsA  = mysqli_query($conec, $sqlA) or die('Erro #6C!');
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
								<font color="gold"><b><i>Chaveiros: . . . . . . . . . </b></i></font>
								<b><i><?php //echo "$NTChav itens --> R$ $ValorChav"; ?></i></b>
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
								<font color="gold"><b><i>Contratos (Parcela): . .</b></i></font>
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
								<b><i><?php //echo "$NPropParc itens --> R$ $ValorPropParc"; ?></i></b>
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
					</table><br>

					<center>
						<font color="gold"><b><i>&nbsp;Diferença de Caixa: </b></i></font>
						<b><i>R$ <?php echo $DifCx; ?></i></b>
						<?php
						if ($Diferenca <> 0) { ?>
							<font color='gold'>
								<blink><?php echo $cd; ?><blink>
							</font>
						<?php
						} ?>
						</i></b>
					</center>
				</td>
				<td width="33%">
					<table border="05" cellpadding="02" cellspacing="0" align="right">
						<tr>
							<td align='center'>
								<font color="aqua"><b><i>TOTALIZAÇÕES: &nbsp;&nbsp;<font color='#FFFFFF'>
												<blink><?php echo "$TotAut Autenticações Válidas"; ?></blink></b></i></font>
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
									<b><i>
											<?php echo "R$ $IncSobraF"; ?></i></b>
								<?php
								} else { ?>
									&nbsp;
								<?php
								} ?>
							</td>
						</tr>

						<tr>
							<td><?php
								if ($cashIn > 0) { ?>
									<font color="gold"><b><i>&nbsp;Retificação de Lançamento(Créd): </b></i></font>
									<b><i><?php echo "R$ $cashInF"; ?></i></b>
								<?php
								} else { ?>
									&nbsp;
								<?php
								} ?>
							</td>
						</tr>

						<tr>
							<td><?php
								if ($cashOut > 0) { ?>
									<font color="gold"><b><i>&nbsp;Retificação de Lançamento(Déb):&nbsp; </b></i></font>
									<b><i><?php echo "R$ $cashOutF"; ?></i></b>
								<?php
								} else { ?>
									&nbsp;
								<?php
								} ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<p>
			<center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/ok28.gif' border='0'></a></center>
		</p>
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

	// Encerrando a Conexão
	mysqli_free_result($rsA);
	mysqli_free_result($rsR);
	$SisRot = "S-7.5.0.1";
	include "rodape.php"; ?>

</body>

</html>
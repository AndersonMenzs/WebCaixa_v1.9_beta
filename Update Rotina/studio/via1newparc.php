<?php

//debug
error_reporting(E_ALL);

ini_set('display_startup_errors', 1);
ini_set('error_log', 'php_errors.log');


// Pesquisando PC
include "conexao.php";
include "dbselect.php";

// Inserindo Cabeçalho
include "../cabecprs.php";
include "./valor_ext.php";

?>
<html>

<body background="../images/bg1.jpg" text="#FFFFFF">

	<?php
	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";
	exit();*/

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1.2";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$PC		= trim($_POST['pc']);
	$Ref_Std   = trim($_POST['ref_std']);
	$NDoc      = trim($_POST['txtdoc']);
	$TipoRec   = trim($_POST['tiporec']);
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$FPag_1      = isset($_POST['lsPr1']) ? (trim($_POST['lsPr1']) == '00' ? '' : trim($_POST['lsPr1'])) : '';
	$FPag_2      = isset($_POST['lsPr2']) ? (trim($_POST['lsPr2']) == '00' ? '' : trim($_POST['lsPr2'])) : '';
	$FPag_3      = isset($_POST['lsPr3']) ? (trim($_POST['lsPr3']) == '00' ? '' : trim($_POST['lsPr3'])) : '';
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$ModPag    = trim($_POST['modpag']);
	$hora      = trim($_POST['txthora']);
	$h1 = substr($hora, 0, 2);
	$h2 = substr($hora, 3, 2);
	$horaaut   = $h1 . $h2;
	$Mat       = trim($_POST['txtmat']);
	$Mat_Vend  = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	$VrRec     = trim($_POST['vrrec']);
	$VrRecF    = number_format($VrRec, 2, ',', '.');
	$vlr_ext   = valorPorExtenso($VrRecF);
	$VrPrest   = trim($_POST['vrprest']);
	$PIni = trim($_POST['txtparc_ini']);
	$PUlt = trim($_POST['txtparc_ult']);
	$QtdParcPag = trim($_POST['qtdeparc']);
	$VrParcial = $_POST['vrparcial'];
	$Parc_Card_Cred = $_POST['parc_card_cred'];
	$Rdopt = $_POST['rdopt'];
	$Pedido = $_POST['pedido'];
	$DataAtual = date('Ymd');

	// Pesquisando PC
	include "conexao.php";
	include "dbselect.php";

	// Obtendo o código do PC
	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Não foi possível acessar o PC");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Obtendo o Tipo de Recebimento
	$sqlRec = "select siglarec from tiporec where codrec = '$TipoRec' ";
	$rsRec = mysqli_query($conec, $sqlRec) or die("Não foi possível acessar o Tipo de Recebimento");
	$lnRec = mysqli_fetch_array($rsRec);
	$SgRec  = $lnRec['siglarec'];
	$tipo = "CONTR. PARCELADO";
	$tipo_2 = "PEDIDO";

	// Verifica se é um pedido
	if ($Rdopt == 'BOOK' or $Rdopt == 'POSTER' or $Rdopt == 'BOOK/POSTER') {

		// Obtendo Dados da solicitação do pedido
		$sqlE = "select * from registro where reg = '$Aut' and (tiporec = 3 or tiporec = 4 or tiporec = 6 or tiporec = 7) and estorno <> 'x' and datarec = $DataAtual";
		$rsE  = mysqli_query($conec, $sqlE);
		$regE = mysqli_num_rows($rsE);

		// Arrays para armazenar múltiplos valores
		$ModPgtoE_array = array();
		$VlRec = 0;

		while ($lnE  = mysqli_fetch_array($rsE)) {
			$Aut      = $lnE['reg'];
			$NumDocE   = $lnE['numdoc'];
			$TipoRecE  = $lnE['tiporec'];
			$ModPgtoE_array[] = $lnE['modpgto']; // Armazena todas as formas de pagamento
			$DataRecE  = $lnE['datarec'];
			$HoraRecE  = $lnE['horarec'];
			$VlPago    = $lnE['vlrec'];
			$VlRec     = $VlRec + $VlPago;
		}

		// Remove duplicatas e prepara a exibição das formas de pagamento
		$ModPgtoE_unique = array_unique($ModPgtoE_array);

		// Se há mais de uma forma de pagamento, exibe "Diversos"
		if (count($ModPgtoE_unique) > 1) {
			$ModPgtoE_display = 'Diversos';
			$SlgPag = 'Diversos';
			$SlgPag_a = 'DIV';
		} else {
			// Caso contrário, busca os dados da única forma de pagamento
			$ModPgtoE = $ModPgtoE_unique[0];
			$sqlM = "select modpag, siglapag from formapag where codpag = '$ModPgtoE' ";
			$rsM  = mysqli_query($conec, $sqlM) or die("Erro de Banco de Dados #2. Contate seu Administrador");
			$lnM  = mysqli_fetch_array($rsM);
			$ModPgtoE_display = $lnM['modpag'];
			$SlgPag  = $lnM['siglapag'];

			// Verificando cada forma de pagamento
			if ($ModPgtoE == '10') {
				$SlgPag_a = 'DIN';
			} elseif ($ModPgtoE == '20') {
				$SlgPag_a = 'CTD';
			} elseif ($ModPgtoE == '30') {
				$SlgPag_a = 'CTV';
			} elseif ($ModPgtoE == '70') {
				$SlgPag_a = 'PXQ';
			} elseif ($ModPgtoE == '71') {
				$SlgPag_a = 'PXC';
			} elseif ($ModPgtoE == '31') {
				$SlgPag_a = 'CPL';
			}
		}

		$sqlR = "select * from tiporec where codrec = '$TipoRecE' ";
		$rsR  = mysqli_query($conec, $sqlR) or die("Erro de Banco de Dados #3. Contate seu Administrador");
		$lnR  = mysqli_fetch_array($rsR);
		$CodRec      = $lnR['codrec'];
		$NomeRec     = $lnR['nomerec'];
		mysqli_free_result($rsE);
		mysqli_free_result($rsR);

		// Consulta o número de documento e soma os valores
		$sqlP = "SELECT SUM(vlrec) AS vlrec FROM registro WHERE numdoc = '$NumDocE' AND datarec = '$DataRecE' ";
		$rsP  = mysqli_query($conec, $sqlP) or die("Erro de Banco de Dados #4. Contate seu Administrador");
		$lnP  = mysqli_fetch_array($rsP);
		$VlRec = $lnP['vlrec'];
		$VlRecF    = number_format($VlRec, 2, ',', '.');
	}

	// Imprimindo o Registro da Spool
	$SqlSp = "select * from spool order by rec";
	$rsSp  = mysqli_query($conec, $SqlSp) or die("Não foi possível obter dados da spool");
	$lnSp  = mysqli_fetch_array($rsSp);
	$Num = $lnSp['rec'];
	$Spo = $lnSp['spo'];

	// Consulta SQL corrigida com parênteses
	$sqlFm = "SELECT siglapag FROM formapag WHERE codpag IN('$FPag_1', '$FPag_2', '$FPag_3') AND codpag <> '---'";
	$rsFm = mysqli_query($conec, $sqlFm) or die("Não foi possível acessar o Forma de Pagamento");

	$FmRec = [];

	while ($lnFm = mysqli_fetch_assoc($rsFm)) {
		$FmRec[] = $lnFm['siglapag'];
	}

	// Remove duplicatas, caso existam
	$FmRec = array_unique($FmRec);

	// Define o modo de pagamento
	$ModPag = '';
	$FmRec_a = '';

	// Se houver mais de uma forma diferente
	if (count($FmRec) > 1) {
		$ModPag = " ";
		$FmRec_a = 'DIV';
	} elseif (in_array("DIN", $FmRec)) {
		$ModPag = "DINHEIRO";
		$FmRec_a = "DIN";
	} elseif (in_array("CTD", $FmRec)) {
		$ModPag = "CARTÃO DÉBITO";
		$FmRec_a = "CTD";
	} elseif (in_array("CTV", $FmRec)) {
		$ModPag = "CARTÃO CRÉDITO";
		$FmRec_a = "CTV";
	} elseif (in_array("PXQ", $FmRec)) {
		$ModPag = "PIX QR CODE";
		$FmRec_a = "PXQ";
	} elseif (in_array("PXC", $FmRec)) {
		$ModPag = "PIX CNPJ";
		$FmRec_a = "PXC";
	} elseif (in_array("CPL", $FmRec)) {
		$ModPag = "CART. CRED. PARC. LOJA";
		$FmRec_a = "CPL";
	}

	if ($Rdopt == 'BOOK' or $Rdopt == 'POSTER' or $Rdopt == 'BOOK/POSTER') {
		// Imprimindo o Recibo
		$MatRec = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
		$VrRecF    = number_format($VrRec, 2, ',', '.');
		$Aut1 = $Reg;
		$Aut2 = "$Reg$PC$NDoc $dtAut" . "R$ " . "$VrRecF$SlgPag_a$MatRec$Rdopt";

		// Gravando a Spool
		$sql = "insert into spool values ('$Aut1', '$Aut2')";
		$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");

		// Gravando a Spool
		$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
		$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");

	} elseif ($Rdopt == 'NORMAL') {
		// Imprimindo o Recibo
		$MatRec = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);
		$VrRecF    = number_format($VrRec, 2, ',', '.');
		$Aut1 = $Reg;
		$Aut2 = "$Reg$PC$NDoc $dtAut" . "R$ " . "$VrRecF$FmRec_a$MatRec";

		// Gravando a Spool
		$sql = "insert into spool values ('$Aut1', '$Aut2')";
		$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");

		// Gravando a Spool
		$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
		$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");
	}
	
	// Encerrando a Conexão
	mysqli_close($conec);

	$SisRot = "S-7.2.2.1.2";
	include "./rodape.php"; ?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_cntparc.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&txtmat=<?php echo urlencode($Mat); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&Ref_Std=<?php echo urlencode($Ref_Std); ?>' +
				'&SgRec=<?php echo urlencode($SgRec); ?>' +
				'&PIni=<?php echo urlencode($PIni); ?>' +
				'&PUlt=<?php echo urlencode($PUlt); ?>' +
				'&FPag_1=<?php echo urlencode($FPag_1); ?>' +
				'&FPag_2=<?php echo urlencode($FPag_2); ?>' +
				'&FPag_3=<?php echo urlencode($FPag_3); ?>' +
				'&txt1=<?php echo urlencode($txt1); ?>' +
				'&txt2=<?php echo urlencode($txt2); ?>' +
				'&txt3=<?php echo urlencode($txt3); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&QtdParcPag=<?php echo urlencode($QtdParcPag); ?>' +
				'&VrPrest=<?php echo urlencode($VrPrest); ?>' +
				'&VrRec=<?php echo urlencode($VrRec); ?>' +
				'&FmRec=<?php echo urlencode($FmRec_a); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&mat_vend=<?php echo urlencode($Mat_Vend); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>' +
				'&VrParcial=<?php echo urlencode($VrParcial); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&parc_card_cred=<?php echo urlencode($Parc_Card_Cred); ?>';

			// Verifica se o $Rdopt tem algum valor antes de adicioná-lo à URL
			<?php if ($Rdopt == 'BOOK' || $Rdopt == 'POSTER' || $Rdopt == 'BOOK/POSTER') { ?>
				url += '&rdopt=<?php echo urlencode($Rdopt); ?>';
				url += '&pedido=<?php echo urlencode($Pedido); ?>';
				url += '&tipo_2=<?php echo urlencode($tipo_2); ?>';
			<?php } ?>

			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

	<script>
		// Chama a função de forma segura após o carregamento da página
		if (document.readyState === 'complete') {
			try {
				imprimirERedirecionar();
			} catch (e) {}
		} else {
			window.addEventListener('load', function() {
				try {
					imprimirERedirecionar();
				} catch (e) {}
			});
		}
	</script>

</body>

</html>

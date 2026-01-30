<?php

//Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<html>

<head>
	<title>WebCaixa v1.19_beta</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	/*$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	echo "<pre>";
	var_dump($dados);
	echo "</pre>";*/

	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R2.2.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$NDoc      = trim($_POST['txtdoc']);
	$NDoc_a 	= trim($_POST['txtdoc']);
	$FPag_1    = trim($_POST['lsPr1']);
	$FPag_2    = trim($_POST['lsPr2']);
	$FPag_3    = trim($_POST['lsPr3']);
	$ModPag    = trim($_POST['txtmodpag_ext']);
	$Mat_Vend = trim($_POST['mat_vend']);
	$Vendedora = trim($_POST['vendedora']);
	$Vendedora_full = trim($_POST['vendedora']);
	$Cliente   = trim($_POST['cliente']);
	//$rdAut     = trim($_POST['rdaut']);
	$rdAut     = 'c';
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);
	$hora	  = date('H:i');
	$EntrForm  = trim($_POST['txtvalor']);
	$txt1 = isset($_POST['txt1']) ? (float) trim($_POST['txt1']) : 0;
	$txt2 = isset($_POST['txt2']) ? (float) trim($_POST['txt2']) : 0;
	$txt3 = isset($_POST['txt3']) ? (float) trim($_POST['txt3']) : 0;
	$VrEnt	 = $txt1 + $txt2 + $txt3;
	$VrEntr    = number_format($VrEnt, 2, ',', '.');
	$QtdeParc  = trim($_POST['qtdeparc']);
	$VrEntr    = trim($_POST['txtvalor']);
	$Parc      = trim($_POST['txtvalor']);
	$PIni      = trim($_POST['txtparc_ini']);
	$PUlt 	= trim($_POST['txtparc_ult']);

	// Truncar o nome da vendedora com o primeiro nome completo e após o primeiro espaco, deixar somente uma letra e ponto.
	$Vendedora = strtoupper($Vendedora);
	$Vendedora = substr($Vendedora, 0, strpos($Vendedora, ' ') + 1) . substr($Vendedora, strpos($Vendedora, ' ') + 1, 1) . '.';

	// Variáveis
	$TipoRec   = '3';
	$SubTipo   = 'CNTP';
	$DataHoje = date('Y-m-d');

	include "conexao.php";
	include "dbselect.php";

	// Obtendo Dados
	$sqlo = "select * from operador where pass = '$Senha' ";
	$rso  = mysqli_query($conec, $sqlo);
	$regso = mysqli_num_rows($rso); ?>

	<font color="gold" size="6">
		<br><b>
			<center><u><i>Sistema de Autenticação</i></u></center>
		</b>
	</font><br>
	<?php

	include "us_cad.php";

	if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm') {
		if ($regso > 0) {
			$lno  = mysqli_fetch_array($rso);
			$Mat = $lno['mat'];

			// Sanitizar a matrícula lida do banco: manter apenas dígitos e garantir 8 caracteres
			$MatClean = preg_replace('/\D/', '', $Mat);
			$MatClean = str_pad($MatClean, 8, '0', STR_PAD_LEFT);
			// Usar $MatClean nos inserts. Manter $Mat para compatibilidade de exibição.
			$Mat = $MatClean;


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

			// Gravando Várias Parcelas
			$ParcUlt = $VrEnt - $Parc * ($QtdeParc - 1);

			echo "Parcela Primeira: " . $Parc . "<br>";
			echo "Valor da Parcela: " . $VrEnt . "<br>";
			echo "Quantidade de Parcelas: " . $QtdeParc . "<br>";
			echo "Parcela Última: " . $ParcUlt . "<br>";

			$ParcUlt = number_format($ParcUlt, 2, '.', '');
			
		// Formatar MatRec UMA VEZ antes do loop (não a cada iteração!)
		$MatRec = substr($MatClean, 1, 6) . "-" . substr($MatClean, 7, 1);
		$MatFormatado = substr($MatClean, 0, 7) . "-" . substr($MatClean, 7, 1);

	// Debug: mostrar conteúdo preciso de $Mat
			if ($rdAut == 'c') {
				for ($K = 1; $K <= $QtdeParc; $K++) {
					$Reg  = $Reg + 1;

					if ($K == $QtdeParc) {
						if ($FPag_1 <> "00") {
							$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_1', '$PIni', '$dtRec', '$hora', '$ParcUlt', '$MatClean', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
							$rsGr  = mysqli_query($conec, $sqlGr) or die("File geracntparc Error #3.1. Contate seu Administrador.");
						} 
						
						if ($FPag_2 <> "00") {
							$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_2', '$PIni', '$dtRec', '$hora', '$ParcUlt', '$MatClean', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
							$rsGr  = mysqli_query($conec, $sqlGr) or die("File geracntparc Error #3.2. Contate seu Administrador.");
						} 
						
						if ($FPag_3 <> "00") {
							$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag_3', '$PIni', '$dtRec', '$hora', '$ParcUlt', '$MatClean', '', '$Mat_Vend', '$Vendedora_full', '$Cliente')";
							$rsGr  = mysqli_query($conec, $sqlGr) or die("File geracntparc Error #3.3. Contate seu Administrador.");
						}
					}

					// Criando o spoll
					$RegFull  = 10000 + $Reg;
					$RegSp    = substr($RegFull, 1, 4);

					$sqlPC  = "select pc from inicial";
					$rsPC  = mysqli_query($conec, $sqlPC) or die("File geracntparc Error #3A. Contate seu Administrador.");
					$lnPC = mysqli_fetch_array($rsPC);
					$PCSp    = $lnPC['pc'];

					$hSp     = substr($hora, 0, 2);
					$mSp     = substr($hora, 3, 2);
					$HoraSp  = $hSp . $mSp;
					$NDocSp  = $NDoc;
					$dtAutSp = date('dmy');
					$PParc   = number_format($Parc, 2, ',', '');
					$PParcUlt = number_format($ParcUlt, 2, ',', '');
					$ParcSp  = "R$ " . $PParc;
					$PParcUlt = "R$ " . $PParcUlt;

					$sqlSg  = "select siglarec from tiporec where codrec = '$TipoRec' ";
					$rsSg   = mysqli_query($conec, $sqlSg) or die("Não foi possível consultar o Tipo");
					$lnSg = mysqli_fetch_array($rsSg);
					$SgRecSp = $lnSg['siglarec'];
					$tipo = "CONTRATO PARCELADO";

					// Consulta SQL corrigida com parênteses
					$sqlFm = "SELECT siglapag FROM formapag WHERE (codpag = '$FPag_1' OR codpag = '$FPag_2' OR codpag = '$FPag_3') AND codpag <> '---'";
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
					}

					/*$sqlSgpag  = "select siglapag from formapag where codpag = '$FPag' ";
					$rsSgpag   = mysqli_query($conec, $sqlSgpag) or die("Não foi possível consultar o Tipo");
					$lnSgpag = mysqli_fetch_array($rsSgpag);
					$FmRecSp = $lnSgpag['siglapag'];*/

				// Reduzindo a Matrícula para impressão/spool — usar $MatRec já formatado (fora do loop)
				
						$Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $ParcSp . $SgRecSp . $FmRec_a . $MatRec;
					
					$sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
					$rsSp1  = mysqli_query($conec, $sqlSp1) or die("File geracntparc Error #1. Contate seu Administrador.");

					$sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
					$rsSp2  = mysqli_query($conec, $sqlSp2) or die("File geracntparc Error #2. Contate seu Administrador.");
					$PIni = $PIni + 1;
				}
			} else {
				$Reg  = $Reg + 1;
				for ($K = 1; $K <= $QtdeParc; $K++) {
					if ($K == $QtdeParc) {
						$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag', '$PIni', '$dtRec', '$hora', '$ParcUlt', '$MatClean', '', '', '', '')";
						} else {
						$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag', '$PIni', '$dtRec', '$hora', '$Parc', '$MatClean', '', '', '', '')";
					}
					$rsGr  = mysqli_query($conec, $sqlGr) or die("File geracntparc Error #3. Contate seu Administrador.");
					$PIni = $PIni + 1;
				}

				// Criando o spoll
				$RegFull  = 10000 + $Reg;
				$RegSp    = substr($RegFull, 1, 4);

				$sqlPC  = "select pc from inicial";
				$rsPC  = mysqli_query($conec, $sqlPC) or die("File geracntparc Error #4. Contate seu Administrador.");
				$lnPC = mysqli_fetch_array($rsPC);
				$PCSp    = $lnPC['pc'];

				$hSp     = substr($hora, 0, 2);
				$mSp     = substr($hora, 3, 2);
				$HoraSp  = $hSp . $mSp;
				$NDocSp  = $NDoc;
				$dtAutSp = date('dmy');
				$VrEntrF = number_format($VrEntr, 2, ',', '');

				if (strlen($VrEntrF) < 7) {
					$VrEntrSp   = "R$ " . $VrEntrF;
				} else {
					$VrEntrSp   = "R$" . $VrEntrF;
				}

				$sqlSg  = "select siglarec from tiporec where codrec = '$TipoRec' ";
				$rsSg   = mysqli_query($conec, $sqlSg) or die("File geracntparc Error #5. Contate seu Administrador.");
				$lnSg = mysqli_fetch_array($rsSg);
				$SgRecSp = $lnSg['siglarec'];

				$sqlSgpag  = "select siglapag from formapag where codpag = '$FPag' ";
				$rsSgpag   = mysqli_query($conec, $sqlSgpag) or die("File geracntparc Error #6. Contate seu Administrador.");
				$lnSgpag = mysqli_fetch_array($rsSgpag);
				$FmRecSp = $lnSgpag['siglapag'];

				// Reduzindo a Matrícula para spool (usar $MatClean)
				$MatRecSp = substr($MatClean, 1, 6) . "-" . substr($MatClean, 7, 1);

				include "dbselect.php";
				$Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $VrEntrSp . $SgRecSp . $FmRecSp . $MatRecSp;
				$sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
				$rsSp1  = mysqli_query($conec, $sqlSp1) or die("File geracntparc Error #7. Contate seu Administrador.");

				$sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
				$rsSp2  = mysqli_query($conec, $sqlSp2) or die("File geracntparc Error #8. Contate seu Administrador.");
				$PIni = $PIni + 1;
			}

			exit();

			// Preparando a Via Cliente 
	?>
			<form name="geracntparc" method="post" action="via1parc.php">
				<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
				<font size='6'><b>
						<center>Coloque a <font color='gold'>
								<blink>Via do Cliente</blink>
								<font color='#FFFFFF'> na Autenticadora
									e <br>
									<p>Clique no <font color='gold'>
											<blink>botão Abaixo</blink>
											<font color='#FFFFFF'>.</center>
					</b></font>
				</p><br>
				<center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
				<center>
					<font color='#FFFFFF' size='3'><span id="msg"></span></font>
				</center>
			</form><?php

				} else { ?>
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
			/* mysqli_free_result($rso);
       mysqli_free_result($rsGr);
       mysqli_free_result($rsx); */

			$SisRot = "S-7.2.2.1.1";
			include "./rodape.php"; ?>

	<script src="./js/ghost_click.js"></script>

</body>

</html>
<?php

// Pesquisando PC
include "conexao.php";
include "dbselect.php";

// Inserindo Cabeçalho
include "../cabecprs.php";
include "./valor_ext.php";

?>
<html>

<body background="../images/bg1.jpg" text="#FFFFFF" onload="imprimirERedirecionar()">
	<?php
	// Importando os Dados do Formulário
	$Sis       = "S7";
	$Rot       = "S7R1.1.1";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$pss     = substr($lg_user, 8, 40);
	$Aut       = trim($_POST['txtreg']);
	$AutFull = 10000 + $Aut;
	$Reg       = substr($AutFull, 1, 4);
	$NDoc      = trim($_POST['txtdoc']);
	$SlgPag    = trim($_POST['tipopag']);
	$dtRec     = trim($_POST['dtrec']);
	$aRec    = substr($dtRec, 2, 2);
	$mRec    = substr($dtRec, 5, 2);
	$dRec    = substr($dtRec, 8, 2);
	$dtAut     = $dRec . $mRec . $aRec;
	$Opt       = $_POST['txthora'];
	$VrEnt     = trim($_POST['txtvalor']);
	$VrEntr    = number_format($VrEnt, 2, ',', '');
	$VrEntrF   = "R$ " . "$VrEntr";
	$Mat       = trim($_POST['txtmat']);
	$Mat_Vend  = $_POST['txtmatvend'];
	$Vendedora = $_POST['vendedora'];
	$Cliente   = $_POST['cliente'];
	$vlr_ext   = valorPorExtenso($VrEnt);

	// Obtendo o código do PC
	$sqlPC = "select pc from inicial";
	$rsPC  = mysqli_query($conec, $sqlPC) or die("Não foi possível acessar o PC");
	$lnPC  = mysqli_fetch_array($rsPC);
	$PC  = $lnPC['pc'];

	// Obtendo o tipo de solicitação
	$tipo = "PEDIDO";

	// Reduzindo a Matrícula
	$MatRec = substr($Mat, 1, 6) . "-" . substr($Mat, 7, 1);
	$Mat = substr($Mat, 0, 7) . "-" . substr($Mat, 7, 1);

	// Imprimindo o Recibo
	$Aut1 = $Reg;
	$Aut2 = "$Reg$PC$NDoc$dtAut$VrEntrF$SlgPag$MatRec$Opt";

	// Gravando a Spool
	include "dbselect.php";
	$sql = "insert into spool2 values ('$Aut1', '$Aut2')";
	$rs  = mysqli_query($conec, $sql) or die("Não foi possível gravar a Spool");

	// Encerrando a Conexão
	$SisRot = "S-7.1.1.1";
	include "./rodape.php";

	?>

	<script>
		function imprimirERedirecionar() {
			// Monta a URL com os dados
			var url = './recibo_solicbook.php?tipo=<?php echo urlencode($tipo); ?>' +
				'&NDoc=<?php echo urlencode($NDoc); ?>' +
				'&PC=<?php echo urlencode($PC); ?>' +
				'&ModPag=<?php echo urlencode($ModPag); ?>' +
				'&fpag_1=<?php echo urlencode($FPag_1); ?>' +
				'&fpag_2=<?php echo urlencode($FPag_2); ?>' +
				'&fpag_3=<?php echo urlencode($FPag_3); ?>' +
				'&fmrec=<?php echo urlencode($FmRec_a); ?>' +
				'&txt1=<?php echo urlencode($txt1); ?>' +
				'&txt2=<?php echo urlencode($txt2); ?>' +
				'&txt3=<?php echo urlencode($txt3); ?>' +
				'&data=<?php echo urlencode($dtRec); ?>' +
				'&Vendedora=<?php echo urlencode($Vendedora); ?>' +
				'&Cliente=<?php echo urlencode($Cliente); ?>' +
				'&vlr_ext=<?php echo urlencode($vlr_ext); ?>' +
				'&Reg=<?php echo urlencode($Reg); ?>' +
				'&horaaut=<?php echo urlencode($horaaut); ?>' +
				'&dtAut=<?php echo urlencode($dtAut); ?>' +
				'&SgRec=<?php echo urlencode($SgRec); ?>' +
				'&VrEnt=<?php echo urlencode($VrEnt); ?>' +
				'&VrEntr=<?php echo urlencode($VrEntr); ?>' +
				'&VrEntrF=<?php echo urlencode($VrEntrF); ?>' +
				'&Mat=<?php echo urlencode($Mat); ?>' +
				'&Opt=<?php echo urlencode($Opt); ?>';
			window.open(url, '_blank');
			setTimeout(function() {
				window.location.href = './servrec.php?c_s=<?php echo $lg_user; ?>';
			}, 1000);
		}
	</script>

</body>

</html>
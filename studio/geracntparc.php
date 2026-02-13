<?php

// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$Mat_Vend = trim($_POST['mat_vend']);
$Vendedora = trim($_POST['vendedora']);
$Vendedora_full = trim($_POST['vendedora']);
$Cliente   = trim($_POST['cliente']);
$rdAut     = 'c';
$Pass      = strtolower(trim($_POST['txtsen']));
$Senha     = sha1($Pass);
$hora	  = date('H:i');
$txt1 = isset($_POST['txtvalor1']) ? (float) trim($_POST['txtvalor1']) : 0;
$txt2 = isset($_POST['txtvalor2']) ? (float) trim($_POST['txtvalor2']) : 0;
$txt3 = isset($_POST['txtvalor3']) ? (float) trim($_POST['txtvalor3']) : 0;
$VrPrest  = trim($_POST['vrprest']);
$VrRec = isset($_POST['vrrec']) ? (float) trim($_POST['vrrec']) : 0;
$VrRecF    = number_format($VrRec, 2, ',', '.');
$QtdeParc  = trim($_POST['qtdeparc']);
$Parc      = trim($_POST['vrprest']);
$PIni      = trim($_POST['txtparc_ini']);
$PUlt 	= trim($_POST['txtparc_ult']);
$Parc_card_cred = trim($_POST['parc_card_cred']);
$ref_std = trim($_POST['ref_std']);

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
$regso = mysqli_num_rows($rso);

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
			$rsr  = mysqli_query($conec, $sqlr) or die("File geracntparc Error #1. Contate seu Administrador.");
			$regsr = mysqli_num_rows($rsr);
			$lnr = mysqli_fetch_array($rsr);
			$Reg     = $lnr['reg'];
			$dtReceb = $lnr['datarec'];

			if ($regsr == 0 or $dtComp <> $dtReceb) {
				$Reg = 0;
			}

			// Gravando Várias Parcelas
			$ParcUlt = $VrRec - $VrTot * ($QtdeParc - 1);
			$ParcUlt = number_format($ParcUlt, 2, '.', '');

			// Formatar MatRec UMA VEZ antes do loop (não a cada iteração!)
			$MatRec = substr($MatClean, 1, 6) . "-" . substr($MatClean, 7, 1);
			$MatFormatado = substr($MatClean, 0, 7) . "-" . substr($MatClean, 7, 1);
		}
	}
<html>

<head>
	<title>WebCaixa v1.20.0_beta</title>
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
	$Rot       = "S7R3.2.1.1";
	$dtRec     = date('Y-m-d');
	$dtComp    = date('Y-m-d');
	$DataF     = date('d/m/Y');
	$HoraF     = date('H:i');
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$MatU      = substr($user, 0, 1) . "." . substr($user, 1, 3) . "." . substr($user, 4, 3) . "." . substr($user, 7, 1);
	$pss     = substr($lg_user, 8, 40);
	$Envelope  = trim($_POST['txtenv']);
	$MatReceb  = trim($_POST['txtreceb']);
	$m1   = substr($MatReceb, 0, 1);
	$m2   = substr($MatReceb, 1, 3);
	$m3   = substr($MatReceb, 4, 3);
	$dv   = substr($MatReceb, 7, 1);
	$MatRecebF = "$m1.$m2.$m3-$dv";
	$NomeRec   = trim($_POST['nomereceb']);
	$Valor     = trim($_POST['txtvalor']);
	$ValorF    = number_format($Valor, 2, ",", ".");
	$SdCaixa   = trim($_POST['txtcaixa']);
	$Pass      = strtolower(trim($_POST['txtsen']));
	$Senha     = sha1($Pass);

	// Preparando Áreas
	$trash     = "U" . substr(sha1("$SdCaixa"), 0, 41);
	$SdCaixaF  = number_format($SdCaixa, 2, "", "");
	$TamSd     = strlen($SdCaixaF);

	include "conexao.php";
	include "dbselect.php";
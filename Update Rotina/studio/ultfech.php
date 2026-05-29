<html>

<head>
	<title>WebCaixa v1.20.20_beta</title>
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
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">
	<?php

	// Obtendo o Login
	$Sis     = "S7";
	$Rot       = "S7R5.3";
	$lg_user   = trim($_POST['txtuser']);
	$user    = substr($lg_user, 0, 8);
	$userF = substr($user, 0, 1) . "." . substr($user, 1, 3) . "." . substr($user, 4, 3) . "-" . substr($user, 7, 1);
	$pss     = substr($lg_user, 8, 40);
	$horaNorm  = date("Hi");
	$horaInv   = date("iH");

	// Obtendo os Dados da Spool de Fechamento
	include "conexao.php";
	include "dbselect.php";

	$sql = "select * from spoolfch";
	$rs  = mysqli_query($conec, $sql) or die("Não foi possível Reimprimir o Fechamento do Caixa");
	$ln = mysqli_fetch_array($rs);
	$Fita         = $ln['fita'];
	$ano          = $ln['ano'];
	$PC		= $ln['pc'];
	$Ape		= $ln['ape'];
	$userF	= $ln['user'];
	$dataFch	= $ln['datafch'];
	$dtAbre	= $ln['dtabre'];
	$dtAbreF      = substr($dtAbre, 8, 2) . "/" . substr($dtAbre, 5, 2) . "/" . substr($dtAbre, 0, 4);
	$DataAtual	= $ln['dataatual'];
	$DataFecha	= $ln['datafecha'];
	$hora		= $ln['hora'];
	$app		= $ln['app'];
	$inicial	= $ln['inicial'];
	$NVendas	= $ln['nvendas'];
	$ValorVend	= $ln['valorvend'];
	$cashTot	= $ln['dinheiro'];
	$cDebFinal	= $ln['carddeb'];
	$credTotV	= $ln['cardvista'];
	$credTotPLoja	= $ln['cardparclj'];
	$credTotPAdm	= $ln['cardparcadm'];
	$cheqTotV	= $ln['cheqtotal'];
	$cheqTotPre	= $ln['cheqpre'];
	$DepClientes	= $ln['depcli'];
	$TotIn	= $ln['totin'];
	$Recolh	= $ln['recolhe'];
	$TotPgto	= $ln['totpgto'];
	$FechamentoF	= $ln['fechamento'];
	$GavAut	= $ln['gavaut'];
	$DifCx	= $ln['difcx'];
	$cd		= $ln['cd'];
	$NPRecs	= $ln['numprodsrec'];
	$NBookRec	= $ln['nbookrec'];
	$NTChav	= $ln['numchav'];
	$NTxProd      = $ln['numtxprod'];
	$NConcurso    = $ln['numconcurso'];
	$NContEnt     = $ln['numcontent'];
	$NContParc    = $ln['numcontparc'];
	$NPropEnt     = $ln['numpropent'];
	$NPropParc    = $ln['numpropparc'];
	$NResgate     = $ln['numresgate'];
	$NEstorno     = $ln['numestorno'];
	$ValorChav    = $ln['vrchav'];
	$ValorProd    = $ln['vrprod'];
	$NumPgtos     = $ln['numpgtos'];
	$PgtoTot      = $ln['pgtotot'];
	$VrPRecsF	= $ln['vrprecs'];
	$ValorConc    = $ln['vrconc'];
	$VrBookRecF   = $ln['vrbookrec'];
	$ValorContEnt = $ln['vrcontent'];
	$ValorPropEnt = $ln['vrpropent'];
	$ValorContParc = $ln['vrcontparc'];
	$ValorPropParc = $ln['vrpropparc'];
	$ValorResg    = $ln['vrresg'];
	$ValorEstorno = $ln['vrestorno'];
	$IncSobra     = $ln['sobra'];
	$IncSobraF    = $ln['incsobra'];

	$DepCli	= $ln['depcli'];
	$Dinheiro     = $ln['dinheiro'];
	$CardDeb      = $ln['carddeb'];
	$CardVista    = $ln['cardvista'];
	$CardParcLj   = $ln['cardparclj'];
	$CardParcAdm  = $ln['cardparcadm'];
	$CheqTotal    = $ln['cheqtotal'];
	$CheqPre      = $ln['cheqpre'];
	$DDPtot       = $ln['DDPtot'];
	$MCStot       = $ln['MCStot'];
	$MDVtot       = $ln['MDVtot'];
	$MPDtot       = $ln['MPDtot'];
	$RCLtot       = $ln['RCLtot'];
	$SRVtot       = $ln['SRVtot'];
	$VTRtot       = $ln['VTRtot'];
	$OUTtot       = $ln['OUTtot'];
	$Diferenca    = $ln['diferenca'];

	// Obtendo o Total Arrecadado
	$sqlDT = "select datarec from registro order by datarec desc ";
	$rsDT  = mysqli_query($conec, $sqlDT) or die("File reimpfech Error #3. Contate seu Administrador.");
	$lnDT  = mysqli_fetch_array($rsDT);
	$DtRec = $lnDT['datarec'];

	$sqlTT = "select vlrec from registro where datarec = '$DtRec' and tiporec <> '8' ";
	$rsTT  = mysqli_query($conec, $sqlTT) or die("File reimpfech Error #4. Contate seu Administrador.");
	while ($lnTT = mysqli_fetch_array($rsTT)) {
		$VlRec    = $lnTT['vlrec'];
		$Entradas = $Entradas + $VlRec;
	}

	for ($I = 0; $I <= 1; $I++) {
		// Imprimindo os Dados
		$traco = "------------------------------------------------";
		shell_exec("echo Estrella Photo Studio > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '* * * F E C H A M E N T O - D O - C A I X A * * ' > /dev/lp0");
		shell_exec("echo '----------------- ( F I N A L ) --------------- ' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo Fita Numero: '$Fita/$ano' > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo PC: '$PC - $Ape' > /dev/lp0");
		shell_exec("echo Data: '$dataFch' > /dev/lp0");

		if ($dtAbre <> $DataAtual) {
			shell_exec("echo '* * * * * CAIXA FECHADO EM: $DataFecha * * * * *' > /dev/lp0");
		}

		shell_exec("echo Hora: $hora > /dev/lp0");
		shell_exec("echo Operador: '$userF ($app)' > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo 'Valor de Abertura:. . . . . . . . R$ $inicial' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		shell_exec("echo '----------------- RECEBIMENTOS -----------------' > /dev/lp0");
		shell_exec("echo 'POR TIPO DE SERVICO' > /dev/lp0");
		shell_exec("echo '-------------------' > /dev/lp0");
		shell_exec("echo 'Chaveiros: . . . . . . . [$NTChav] - R$ $ValorChav' > /dev/lp0");
		shell_exec("echo 'Taxa de Producao:. . . . [$NTxProd] - R$ $ValorProd' > /dev/lp0");
		shell_exec("echo 'Inscricao Concurso:. . . [$NConcurso] - R$ $ValorConc' > /dev/lp0");
		shell_exec("echo 'Contrato(Entrada): . . . [$NContEnt] - R$ $ValorContEnt' > /dev/lp0");
		shell_exec("echo 'Contrato(Parcela): . . . [$NContParc] - R$ $ValorContParc' > /dev/lp0");
		shell_exec("echo 'Proposta(Entrada): . . . [$NPropEnt] - R$ $ValorPropEnt' > /dev/lp0");
		shell_exec("echo 'Proposta(Parcela): . . . [$NPropParc] - R$ $ValorPropParc' > /dev/lp0");
		shell_exec("echo 'Produtos(Exceto Books) - [$NPRecs] - R$ $VrPRecsF' > /dev/lp0");
		shell_exec("echo 'Books a Vista: . . . . . [$NBookRec] - R$ $VrBookRecF' > /dev/lp0");
		shell_exec("echo 'Resgate Cheques: . . . . [$NResgate] - R$ $ValorResg' > /dev/lp0");
		shell_exec("echo 'Despesas:. . . . . . . . [$NumPgtos] - R$ $PgtoTot' > /dev/lp0");
		shell_exec("echo 'Estorno: . . . . . . . . [$NEstorno] - R$ $ValorEstorno' > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo 'POR FORMA DE RECEBIMENTO' > /dev/lp0");
		shell_exec("echo '------------------------' > /dev/lp0");
		shell_exec("echo 'Dinheiro:. . . . . . . . . . . . R$ $Dinheiro' > /dev/lp0");
		shell_exec("echo 'Cartao de Debito:. . . . . . . . R$ $CardDeb' > /dev/lp0");
		shell_exec("echo 'Cartao Credito (a Vista):. . . . R$ $CardVista' > /dev/lp0");
		shell_exec("echo 'Cartao Credito (Parcelado Loja): R$ $CardParcLj' > /dev/lp0");
		shell_exec("echo 'Cartao Credito (Parc. Admnist.): R$ $CardParcAdm' > /dev/lp0");
		shell_exec("echo 'Cheques (A Vista): . . . . . . . R$ $CheqTotal' > /dev/lp0");
		shell_exec("echo 'Cheques (Pre-datados): . . . . . R$ $CheqPre' > /dev/lp0");
		shell_exec("echo 'Deposito de Clientes:. . . . . . R$ $DepCli' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo 'Total de Recebimentos: . . . . . R$ $TotIn' > /dev/lp0");

		if ($IncSobra < 0.009) {
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '------------ INCORPORACAO DE SALDO ------------' > /dev/lp0");
			shell_exec("echo 'Sobra Incorporada ao Caixa:. . . R$ $IncSobraF' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
		}

		// Gerando a Retificação
		#$sql = "select * from errlanc where dataop = $DataAtual ";
		$sql = "select * from errlanc where dataop = '$DataAtual' ";
		$rs  = mysqli_query($conec, $sql) or die("Não foi possível acessar a tabela de erros");
		$regs = mysqli_num_rows($rs);

		if ($regs > 0) {
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '---------- RETIFICACAO DE LANCAMENTO ----------' > /dev/lp0");
			shell_exec("echo '            (NA FORMA DE PAGAMENTO)' > /dev/lp0");

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
					shell_exec("echo $traco > /dev/lp0");

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
				} else if ($cheqvi > 0) {
					$De = 'Cheque a Vista';
					$Dif = $cheqvi;
				} else if ($cheqpi > 0) {
					$De = 'Cheque Pre-datado';
					$Dif = $cheqpi;
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
				} else if ($cheqvo > 0) {
					$Para = 'Cheque a Vista';
				} else if ($cheqpo > 0) {
					$Para = 'Cheque Pre-datado';
				} else {
					$Para = 'Deposito de Clientes';
				}

				$DifF = number_format($Dif, 2, ",", ".");

				shell_exec("echo 'DE:    $De' > /dev/lp0");
				shell_exec("echo 'PARA:  $Para' > /dev/lp0");
				shell_exec("echo 'VALOR: R$ $DifF' > /dev/lp0");
				shell_exec("echo '\n' > /dev/lp0");
			}
		}

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '------------------ PAGAMENTOS ------------------' > /dev/lp0");
		shell_exec("echo DESPESAS > /dev/lp0");
		shell_exec("echo -------- > /dev/lp0");
		shell_exec("echo 'de Pessoal:. . . . . . . . . . . R$ $DDPtot' > /dev/lp0");
		shell_exec("echo 'Material de Consumo: . . . . . . R$ $MCStot' > /dev/lp0");
		shell_exec("echo 'Material de Divulgacao:. . . . . R$ $MDVtot' > /dev/lp0");
		shell_exec("echo 'Material de Producao:. . . . . . R$ $MPDtot' > /dev/lp0");
		shell_exec("echo 'Reembolso de Clientes: . . . . . R$ $RCLtot' > /dev/lp0");
		shell_exec("echo 'Servicos Prestados:. . . . . . . R$ $SRVtot' > /dev/lp0");
		shell_exec("echo 'Vale Transporte: . . . . . . . . R$ $VTRtot' > /dev/lp0");
		shell_exec("echo 'Outros:. . . . . . . . . . . . . R$ $OUTtot' > /dev/lp0");
		shell_exec("echo 'T O T A L: . . . . . . . . . . . R$ $PgtoTot' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo RECOLHIMENTOS > /dev/lp0");
		shell_exec("echo ------------- > /dev/lp0");
		shell_exec("echo 'Total Recolhido: . . . . . . . . R$ $Recolh' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo 'Pagamentos + Recolhimentos:. . . R$ $TotPgto' > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '---------------- SALDO DE CAIXA ----------------' > /dev/lp0");
		shell_exec("echo 'Valor Real: . . . . . . . . . R$ $FechamentoF' > /dev/lp0");
		shell_exec("echo 'Gaveta: . . . . . . . . . . . R$ $GavAut' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");

		shell_exec("echo 'Diferenca do Caixa:. . . R$ $DifCx $cd' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		// Emitindo Comprovante de Sobra ou Falta
		if ($Diferenca > 0) {
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo Estrella Photo Studio > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '- - - - - DOCUMENTO DE SOBRA DE CAIXA - - - - -' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo PC: '$PC - $Ape' > /dev/lp0");
			shell_exec("echo Data: '$dataFch' > /dev/lp0");
			shell_exec("echo Hora: $hora > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");

			shell_exec("echo 'Saldo de Fechamento:. . . . . R$ $FechamentoF' > /dev/lp0");
			shell_exec("echo 'Valor Informado:. . . . . . . R$ $GavAut' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo 'Sobra de Numerario: . . . . . R$ $DifCx' > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo ---------------------------------------- > /dev/lp0");
			shell_exec("echo Assinatura da Auditora > /dev/lp0");
		} else if ($Diferenca < 0) {
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo '* * * * * - Estrella Photo Studio - * * * * *' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '- - - - - DOCUMENTO DE FALTA DE CAIXA - - - - -' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo PC: '$PC - $Ape' > /dev/lp0");
			shell_exec("echo Data: '$dataFch' > /dev/lp0");
			shell_exec("echo Hora: $hora > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");

			shell_exec("echo 'Saldo de Fechamento:. . . . . R$ $FechamentoF' > /dev/lp0");
			shell_exec("echo 'Valor Informado:. . . . . . . R$ $GavAut' > /dev/lp0");
			shell_exec("echo $traco > /dev/lp0");
			shell_exec("echo 'Falta de Numerario: . . . . . R$ $DifCx' > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo ---------------------------------------- > /dev/lp0");
			shell_exec("echo Assinatura da Aux. Administrativa > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo ---------------------------------------- > /dev/lp0");
			shell_exec("echo Assinatura da Encarregada > /dev/lp0");

			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo ---------------------------------------- > /dev/lp0");
			shell_exec("echo Assinatura da Auditora > /dev/lp0");
		}
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		shell_exec("echo $traco > /dev/lp0");
		if ($Diferenca > 0) {
			shell_exec("echo '----- HOUVE SOBRA DE R$ $DifCx -----' > /dev/lp0");
		} else if ($Diferenca < 0) {
			shell_exec("echo '----- HOUVE FALTA DE R$ $DifCx -----' > /dev/lp0");
		}
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '================================================' > /dev/lp0");
		shell_exec("echo '===                                          ===' > /dev/lp0");
		shell_exec("echo '===            H-I-S-T-O-R-I-C-O             ===' > /dev/lp0");
		shell_exec("echo '===                                          ===' > /dev/lp0");
		shell_exec("echo '================================================' > /dev/lp0");

		shell_exec("echo '        OPERADORES CADASTRADOS NO SISTEMA' > /dev/lp0");
		shell_exec("echo '        ---------- ----------- -- -------' > /dev/lp0");

		// Obtendo a Relação de Operadores Cadastrados
		$sqlH2 = "select * from operador where dataop = '$dtAbre' ";
		$rsH2  = mysqli_query($conec, $sqlH2) or die("Não foi possível acessar a Relação de Opreadores");
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

			shell_exec("echo 'FUNC. CADASTRADO: $MatOpF $Compl' > /dev/lp0");
			shell_exec("echo 'NA FUNCAO: $Cargo' > /dev/lp0");
			shell_exec("echo 'AS: $Tempo' hs > /dev/lp0");
			shell_exec("echo 'CADASTRADO POR: $RespF' > /dev/lp0");
			shell_exec("echo '                - - - X - - -' > /dev/lp0");
		}

		mysqli_free_result($rsH2);

		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		// Obtendo a Relação de Recuperação de Senhas
		$sqlR  = "select * from restsenha where datar = '$dtAbre' ";
		$rsR   = mysqli_query($conec, $sqlR) or die("Não foi possível acessar o Arquivo de Senhas");
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

				shell_exec("echo '        SOLICITACOES DE SENHA PROVISORIA' > /dev/lp0");
				shell_exec("echo '        ------------ -- ----- ----------' > /dev/lp0");

				shell_exec("echo 'SOLICITANTE: $UserRF     CPF: $CpfRF' > /dev/lp0");
				shell_exec("echo 'DATA: $DataRF             HORA: $HoraR' > /dev/lp0");
				shell_exec("echo 'AUTORIZADO POR: $AudRF' > /dev/lp0");
			}

			mysqli_free_result($rsR);
		}

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo Visto do Caixa: --------------------------- > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		shell_exec("echo '- - - TERMINO DA FITA NUMERO - $Fita/$ano - - -' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");

		// Concurso Bebê Estrella
		$sqlRf = "select dtopen from caixa where dtclose <> '0000-00-00' order by dtopen desc ";
		$rsRf  = mysqli_query($conec, $sqlRf) or die("Não foi possível acessar a o Concurso Bebê Estrella");
		$lnRf  = mysqli_fetch_array($rsRf);
		$dtRef = $lnRf['dtopen'];
		$dtRefB = substr($dtRef, 8, 2) . "/" . substr($dtRef, 5, 2) . "/" . substr($dtRef, 0, 4);

		$sqlRel = "select * from databebe where dthoje = '$dtRef'order by recibo";
		$rsRel  = mysqli_query($conec, $sqlRel) or die("Não foi possível acessar a o Concurso Bebê Estrella");
		$regRel = mysqli_num_rows($rsRel);

		if ($regRel > 0) {
			// Cabeçalho
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo '============================================' > /dev/lp0");
			shell_exec("echo 'RECIBOS BEBE ESTRELLA  -  DATA: $dtRefB' > /dev/lp0");
			shell_exec("echo '\tRECIBO   -   NASCIMENTO' > /dev/lp0");
			shell_exec("echo '-------------------------------------------' > /dev/lp0");


			while ($lnRel  = mysqli_fetch_array($rsRel)) {
				$RecB = $lnRel['recibo'];
				$NasB = $lnRel['dtnasc'];
				$DtNascB = substr($NasB, 8, 2) . "/" . substr($NasB, 5, 2) . "/" . substr($NasB, 0, 4);

				shell_exec("echo '\t$RecB   -   $DtNascB' > /dev/lp0");
			}
			shell_exec("echo '============================================' > /dev/lp0");
			shell_exec("echo '\n' > /dev/lp0");
		}

		// Imprimindo Recolhimentos
		$sqlRec = "select dtclose from caixa order by dtclose desc ";
		$rsRec  = mysqli_query($conec, $sqlRec) or die("Não foi possível acessar a Abertura do Caixa");
		$regRec = mysqli_num_rows($rsRec);
		$lnRec = mysqli_fetch_array($rsRec);
		$dtClose  = $lnRec['dtclose'];
		$DataAb = substr($dtClose, 8, 2) . "/" . substr($dtClose, 5, 2) . "/" . substr($dtClose, 0, 4);


		shell_exec("echo '==============================================' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '             ESTUDIO: PC-$PC' > /dev/lp0");
		shell_exec("echo '       RECOLHIMENTOS EM $DataAb' > /dev/lp0");
		shell_exec("echo '       ------------- -- ----------' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '          CAPA DE LOTE(R) - $horaNorm'-'$Dinheiro'-'$horaInv' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo ' HORA\t\tENVELOPE\tVALOR\tMATRIC' > /dev/lp0");

		if ($regRec > 0) {
			$sqlDep = "select hrdep, envelope, valor, matreceb from depositos where dtdep = '$dtClose' ";
			$rsDep  = mysqli_query($conec, $sqlDep) or die("Não foi possível acessar Depósitos");
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

				shell_exec("echo '$Hora\t\t$Nvlp\t\t$Vlr\t\t$Mtrc' > /dev/lp0");
			}
			$TRec  = number_format($AcRec, 2, ",", ".");
			shell_exec("echo '\n' > /dev/lp0");
			shell_exec("echo 'QUANT. DE RECOLHIMENTOS: $ACount - R$ $TRec' > /dev/lp0");
		} else {
			shell_exec("echo ' *** NAO HOUVE DEPOSITOS NESTA DATA ***' > /dev/lp0");
		}
		shell_exec("echo '\n' > /dev/lp0");

		shell_exec("echo '   ***  $horaInv$horaNorm-$Entradas-$horaInv$horaNorm ***' > /dev/lp0");
		shell_exec("echo '==============================================' > /dev/lp0");

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
	}
	mysqli_free_result($rs);
	$SisRot = "S-7.5.3"; ?>
	<center>
		<font color='yellow'><b>
				<h1>Aguarde a Tela de Login e Senha.</h1>
			</b></font>
	</center>
	<center>
		<font color='yellow'><b>
				<h2>Por Favor, Obrigado!</h2>
			</b></font>
	</center>
	<meta http-equiv="refresh" content="5;URL=../index.php">

</body>

</html>
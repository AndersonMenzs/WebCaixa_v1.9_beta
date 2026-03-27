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
		font-family:sans-serif;
	       }
	</style>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>

	<script>
	function F5(event) {
	var tecla = document.all ? window.event.keyCode : event.which;
	if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
	if (tecla == 116) return false;
	}

	document.onkeydown = F5;
	</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF"><?php
      // Importando os Dados do Formulário
	 $Sis   = "S7";
	 $Rot   = "S7R3.3.1.1";
	 $Rec   = $_REQUEST['c_s'];
	 $lg_user = substr($Rec,0,48);
	   $user  = substr($lg_user,0,8);
	   $MatU  = substr($user,0,1).".".substr($user,1,3).".".substr($user,4,3).".".substr($user,7,1);
	   $pss   = substr($lg_user,8,40);
	 $RegDep = substr($Rec,48,6);

      // Conectando ao Banco de Dados
	 include "conexao.php";
	 include "dbselect.php";

      // Recuperando Dados
	 $sql = "select * from depositos where regdep = $RegDep";
	 $rs  = mysqli_query($conec, $sql) or die ("Não foi possível Acessar Depósitos");
	 $ln  = mysqli_fetch_array($rs);
	   $Rgstr    = $ln['regdep'];
	   $DtDep    = $ln['dtdep'];
	      $DataF = substr($DtDep,8,2)."/".substr($DtDep,5,2)."/".substr($DtDep,0,4);
	   $HoraF    = $ln['hrdep'];
	   $Envelope = $ln['envelope'];
	   $Valor    = $ln['valor'];
	      $ValorF= number_format($Valor,2,",",".");
	   $MatReceb = $ln['matreceb'];
	      $MatRecebF = substr($MatReceb,0,1).".".substr($MatReceb,1,3).".".substr($MatReceb,4,3)."-".substr($MatReceb,7,1);
	   $Operador = $ln['operador'];
	      $MatU  = substr($Operador,0,1).".".substr($Operador,1,3).".".substr($Operador,4,3)."-".substr($Operador,7,1);
	   $SdFinal  = trim($ln['autentica']);

      // Obtendo o PC
	 $sqlo = "select pc, ape from inicial order by dtaltera desc ";
	 $rso  = mysqli_query($conec, $sqlo) or die ("Não foi possível Acessar Filiais");
	 $lno  = mysqli_fetch_array($rso);
	   $PCf = $lno['pc'];
	   $Apef= $lno['ape'];
	 

      // Obtendo Dados do Recebedor
	 include "dblog.php";

	 $sqlR = "select nome from pessoal where mat = '$Operador' ";
	 $rsR  = mysqli_query($conec, $sqlR) or die ("Não foi possível Acessar o Cadastro");
	 $lnR  = mysqli_fetch_array($rsR);
	    $NomeR = $lnR['nome'];

	 $sqlU = "select nome from pessoal where mat = '$MatReceb' ";
	 $rsU  = mysqli_query($conec, $sqlU) or die ("Não foi possível Acessar o Cadastro");
	 $lnU  = mysqli_fetch_array($rsU);
	    $NomeRec = $lnU['nome'];

	     // Reimprimindo os Dados
		$traco = "------------------------------------------------";
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '------------- RECOLHIMENTO DE CAIXA ------------' > /dev/lp0");
		shell_exec("echo PC: '$PCf - $Apef' > /dev/lp0");
		shell_exec("echo Envelope: '$Envelope' > /dev/lp0");
		shell_exec("echo Data/Hora: '$DataF - $HoraF' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo -------- VALOR RECOLHIDO: R$ '$ValorF' -------- > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '------------------------------------------' > /dev/lp0");
		shell_exec("echo '$MatU - $NomeR' > /dev/lp0");
		shell_exec("echo '      (Responsavel pelo Recolhimento)' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '------------------------------------------' > /dev/lp0");
		shell_exec("echo '$MatRecebF - $NomeRec' > /dev/lp0");
		shell_exec("echo '      (Responsavel pelo Recebimento)' > /dev/lp0");

		for ($K = 0; $K <= $TamSd; $K++)
		   {
		    $D[] = substr($SdCaixaF, $K, 1);
		   }

		for ($K = 0; $K < $TamSd; $K++)
		   {
		    switch ($D[$K])
			  {
			   case 0:
				$D[$K] = "A";
				break;
			   case 1:
				$D[$K] = "B";
				break;
			   case 2:
				$D[$K] = "C";
				break;
			   case 3:
				$D[$K] = "D";
				break;
			   case 4:
				$D[$K] = "E";
				break;
			   case 5:
				$D[$K] = "F";
				break;
			   case 6:
				$D[$K] = "G";
				break;
			   case 7:
				$D[$K] = "H";
				break;
			   case 8:
				$D[$K] = "I";
				break;
			   case 9:
				$D[$K] = "J";
				break;
			  }
		    $SdFinal = "$SdFinal"."$D[$K]";
		   }
		$SdFinal = "$SdFinal"."$trash";

		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\t\tAutenticacao' > /dev/lp0");
		shell_exec("echo '$SdFinal' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo $traco > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0");
		shell_exec("echo '\n' > /dev/lp0"); ?>

       <meta http-equiv="refresh" content="0;URL=pgtos.php?c_s=<?php echo $lg_user; ?>"><?php

      // Encerrando a Conexão
	 /* mysqli_free_result($rs);
	 mysqli_free_result($rso);
	 mysqli_free_result($rsGr); */
	 $SisRot = "S-7.3.3.1.1";
	 include "../rodape.php"; ?>
  </body>
</html>

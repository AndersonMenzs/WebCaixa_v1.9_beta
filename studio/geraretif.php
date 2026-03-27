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
	  .campos {
	   background-color:#C0C0C0;
	   font: 12px sans-serif;
	   color:#000000;
		  }
	</style>

<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
</script>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
      // Importando os Dados do Formulário
	 $Sis       = "S7";
	 $Rot       = "S7R0.6.1.1";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $userF     = substr($user,0,1).".".substr($user,1,3).".".substr($user,4,3)."-".substr($user,7,1);
	 $Autent    = trim($_POST['txtaut']);
	 $Fita      = trim($_POST['txtFita']);
	 $Valor	    = trim($_POST['txtvalor']);
	 $De        = trim($_POST['txtde']);
	 $Para      = trim($_POST['txtpara']);
	 $MatF      = trim($_POST['txtresp']);
	 $Ape       = trim($_POST['txtape']);
	 $Data	    = date('Y-m-d');

     // Atualizando o Saldos
	 include "conexao.php";
	 include "dbselect.php";

	 switch ($De)
	       {
		case 10:
		     $cashi = $Valor;
		     break;
		case 20:
		     $cdebi = $Valor;
		     break;
		case 30:
		     $ccredvi = $Valor;
		     break;
		case 31:
		     $ccredpli = $Valor;
		     break;
		case 32:
		     $ccredpai = $Valor;
		     break;
		case 40:
		     $cheqvi = $Valor;
		     break;
		case 50:
		     $cheqpi = $Valor;
		     break;
		case 60:
		     $depclii = $Valor;
		     break;
	       }

	 switch ($Para)
	       {
		case 10:
		     $casho = $Valor;
		     break;
		case 20:
		     $cdebo = $Valor;
		     break;
		case 30:
		     $ccredvo = $Valor;
		     break;
		case 31:
		     $ccredplo = $Valor;
		     break;
		case 32:
		     $ccredpao = $Valor;
		     break;
		case 40:
		     $cheqvo = $Valor;
		     break;
		case 50:
		     $cheqpo = $Valor;
		     break;
		case 60:
		     $depclio = $Valor;
		     break;
	       }

        if ($cashi == NULL)
          {
           $cashi = '0';
          }

        if ($cdebi == NULL)
          {
           $cdebi = '0';
          }

        if ($ccredvi == NULL)
          {
           $ccredvi = '0';
          }

        if ($ccredpli == NULL)
          {
           $ccredpli = '0';
          }

        if ($ccredpai == NULL)
        {
           $ccredpai = '0';
          }

        if ($cheqvi == NULL)
          {
           $cheqvi = '0';
          }

        if ($cheqpi == NULL)
          {
           $cheqpi = '0';
          }

        if ($depclii == NULL)
          {
           $depclii = '0';
          }

        if ($casho == NULL)
          {
           $casho = '0';
          }

        if ($cdebo == NULL)
          {
           $cdebo = '0';
          }

        if ($ccredvo == NULL)
          {
           $ccredvo = '0';
          }

        if ($ccredplo == NULL)
          {
           $ccredplo = '0';
          }

        if ($ccredpao == NULL)
          {
           $ccredpao = '0';
          }

        if ($cheqvo == NULL)
          {
           $cheqvo = '0';
          }

        if ($cheqpo == NULL)
          {
           $cheqpo = '0';
          }

        if ($depclio == NULL)
          {
           $depclio = '0';
          }

      // Alterando Valores
	 $sql = "insert into errlanc (cashi, cdebi, ccredvi, ccredpli, ccredpai, cheqvi, cheqpi, depclii, dataop, casho, cdebo, ccredvo, ccredplo, ccredpao, cheqvo, cheqpo, depclio) values ('$cashi', '$cdebi', '$ccredvi', '$ccredpli', '$ccredpai', '$cheqvi', '$cheqpi', '$depclii', '$Data', '$casho', '$cdebo', '$ccredvo', '$ccredplo', '$ccredpao', '$cheqvo', '$cheqpo', '$depclio')";
	 $rs  = mysqli_query($conec, $sql) or die ("File geraretif Error #1. Contate seu Administrador.");

	 $sql = "select cashin, cashout from caixa where dtclose IS NULL";
	 $rs  = mysqli_query($conec, $sql) or die ("File geraretif Error #2. Contate seu Administrador.");
	 $ln  = mysqli_fetch_array($rs);
	  $Cashin = $ln['cashin'];
	  $Cashout = $ln['cashout'];

	 if ($Cashin == NULL)
	   {
        $Cashin = 0;
       }

	 if ($Cashout == NULL)
	   {
        $Cashout = 0;
       }

	 if ($De == 10 or $Para == 10)
	   {
	    if ($De == 10)
	      {
	       $Cashout = $Cashout + $Valor;
	      }

	    if ($Para == 10)
	      {
	       $Cashin = $Cashin + $Valor;
	      }

	    $sql = "update caixa set cashin = $Cashin,
				     cashout= $Cashout where dtclose IS NULL";
	    $rs  = mysqli_query($conec, $sql) or die ("File geraretif Error #3. Contate seu Administrador.");
	   }

      // Obtendo o PC
	 $sql = "select pc, ape from inicial order by dtaltera desc";
	 $rs  =  mysqli_query($conec, $sql) or die ("File geraretif Error #4. Contate seu Administrador.");
	 $ln  = mysqli_fetch_array($rs);
	   $PC   = $ln['pc'];
	   $Apl  = $ln['ape'];

      // Obtendo a Forma de Pagamento
	 $sql = "select modpag from fpagimp where codpag = '$De' ";
	 $rs  =  mysqli_query($conec, $sql) or die ("File geraretif Error #5. Contate seu Administrador.");
	 $ln  = mysqli_fetch_array($rs);
	   $ModDe= $ln['modpag'];

	 $sql = "select modpag from fpagimp where codpag = '$Para' ";
	 $rs  =  mysqli_query($conec, $sql) or die ("File geraretif Error #6. Contate seu Administrador.");
	 $ln  = mysqli_fetch_array($rs);
	   $ModPara= $ln['modpag'];

  for ($I=0; $I<=1; $I++)
     {
      // Gerando Comprovantes
         $traco = "------------------------------------------------";
         shell_exec("echo 'Estrella Photo Studio' > /dev/lp0");
         shell_exec("echo $traco > /dev/lp0");

         shell_exec("echo '                DOCUMENTO DE                 ' > /dev/lp0");
         shell_exec("echo ' * * * ALTERACAO DE FECHAMENTO ANTERIOR * * *' > /dev/lp0");
         shell_exec("echo ' ----- (Retificando Forma de Pagamento) -----' > /dev/lp0");
         shell_exec("echo $traco > /dev/lp0");
         shell_exec("echo PC: '$PC - $Apl ' > /dev/lp0");

	 $Data = date('d/m/Y');
	 $Hora = date('H:i');
	 $Ano  = date('Y');
         shell_exec("echo Data: '$Data\t\tHora: $Hora' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo 'DADOS DA AUTENTICACAO INCORRETA' > /dev/lp0");
         shell_exec("echo '-------------------------------' > /dev/lp0");
         shell_exec("echo 'FITA: . . . . . . . . . . . . $Fita/$Ano' > /dev/lp0");
         shell_exec("echo 'AUTENTIC. NUMERO: . . . . . . $Autent' > /dev/lp0");
         shell_exec("echo 'VALOR AUTENTICADO:. . . . . . R$ $Valor' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");

         shell_exec("echo 'FORMA DE PAGAMENTO - RETIFICADA' > /dev/lp0");
         shell_exec("echo '-------------------------------' > /dev/lp0");
         shell_exec("echo 'DE:   $ModDe' > /dev/lp0");
         shell_exec("echo 'PARA: $ModPara' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\tRESPONSAVEL PELA AUTENTICACAO' > /dev/lp0");
         shell_exec("echo '\t-----------------------------' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\t------------------------------' > /dev/lp0");
         shell_exec("echo '\t     $MatF - $Ape' > /dev/lp0");

	 include "dblog.php";
	 $sql = "select ape from pessoal where mat = '$user' ";
	 $rs  =  mysqli_query($conec, $sql) or die ("File geraretif Error #7. Contate seu Administrador.");
	 $ln  = mysqli_fetch_array($rs);
	   $ApeFunc= $ln['ape'];
	 mysqli_free_result($rs);
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\tRESPONSAVEL PELA RETIFICACAO' > /dev/lp0");
         shell_exec("echo '\t------------------------------' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\t------------------------------' > /dev/lp0");
         shell_exec("echo '\t     $userF - $ApeFunc' > /dev/lp0");
         shell_exec("echo $traco > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
         shell_exec("echo '\n' > /dev/lp0");
     } ?>

      <meta http-equiv="refresh" content="0;URL=aud.php?c_s=<?php echo $lg_user; ?>"><?php

   // Encerrando
      $SisRot = "S-7.0.6.1.1";
      include "rodape.php"; ?>

  </body>
</html>

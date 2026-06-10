<html>

  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 3%;
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
	 $Rot       = "S7R3.1.2";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Aut       = trim($_POST['txtreg']);
	   $AutFull = 10000 + $Aut;
	 $Reg       = substr($AutFull,1,4);
	 $Cod       = trim($_POST['txtcod']);
	 $Cod2      = trim($_POST['txtcod2']);
	 $TipoRec   = trim($_POST['tiporec']);
	 $TipoDesp  = trim($_POST['txttipodesp']);
	 $FPag      = trim($_POST['formapag']);
	 $dtRec     = trim($_POST['dtrec']);
	   $aRec    = substr($dtRec,2,2);
	   $mRec    = substr($dtRec,5,2);
	   $dRec    = substr($dtRec,8,2);
	 $dtAut     = $dRec.$mRec.$aRec;
	 $hora      = trim($_POST['txthora']);
	   $h1 = substr($hora,0,2);
	   $h2 = substr($hora,3,2);
	 $horaaut   = $h1.$h2;
	 $Valor     = trim($_POST['txtvalor']);
	 $VrF       = number_format($Valor,2,',','.');
	 $ValorF   = "R$ ".$VrF;
	 $Mat       = trim($_POST['txtmat']);
	 $FmRec  = "DIN";

      // Pesquisando PC
	 include "conexao.php";
	 include "dbselect.php";
	 $sqlPC = "select pc from inicial";
	 $rsPC  = mysqli_query($conec, $sqlPC) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");
	 $lnPC  = mysqli_fetch_array($rsPC);
	   $PC  = $lnPC['pc'];

      // Obtendo o Tipo de Recebimento
	 $sqlRec = "select siglapag from pgtos where codpag = '$TipoDesp' ";
	 $rsRec = mysqli_query($conec, $sqlRec) or die ("Erro de Banco de Dados #2. Contate seu Administrador.");
	 $lnRec = mysqli_fetch_array($rsRec);
	   $SgRec  = $lnRec['siglapag'];
	 
       // Reduzindo a Matrícula
	  $MatRec = substr($Mat,1,6)."-".substr($Mat,7,1); ?>

      <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Imprimindo Via Cliente
       $Aut1 = $Reg;
       if ($Cod2 == "")
	 {
	  $Aut2 = "$Reg$Cod $horaaut$dtAut $ValorF$SgRec$FmRec$MatRec";
	 } else {
		 $Aut2 = "$Reg$Cod$Cod2$horaaut$dtAut$ValorF$SgRec$MatRec";
		}
       shell_exec("echo $Aut2 > /dev/lp0");

    // Gravando a Spool
       include "dbselect.php";
       $sql = "insert into spool2 values ('$Aut1', '$Aut2')";
       $rs  = mysqli_query($conec, $sql) or die ("Erro de Banco de Dados #4. Contate seu Administrador.");

    // Retornando ao Sistema ?>
       <meta http-equiv="refresh" content="0;URL=index.php?c_s=<?php echo $lg_user; ?>"><?php

    // Encerrando a Conexão
       mysqli_free_result($rs);
       mysqli_free_result($rsPC);
       mysqli_free_result($rsRec);
       mysqli_free_result($rsApe);
       $SisRot = "S-7.3.1.2";
       include "rodape.php"; ?>

  </body>

</html>

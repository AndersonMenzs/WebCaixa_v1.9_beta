<html>

  <head>
    <title>WebCaixa v1.19_beta</title>
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
	 $Rot       = "S7R5.1.1.2";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Aut       = trim($_POST['txtreg']);
	   $AutFull = 10000 + $Aut;
	 $Reg       = substr($AutFull,1,4);
	 $NDoc      = trim($_POST['txtdoc']);
	 $TipoRec   = trim($_POST['tiporec']);
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
	 $TaxaChavF = trim($_POST['taxachav']);
	 $Mat       = trim($_POST['txtmat']);

      // Pesquisando PC
	 include "conexao.php";
	 include "dbselect.php";

	 $sqlPC = "select pc from inicial";
	 $rsPC  = mysqli_query($conec, $sqlPC) or die ("Não foi possível caessar o PC");
	 $lnPC  = mysqli_fetch_array($rsPC);
	   $PC  = $lnPC['pc'];

      // Obtendo o Tipo de Recebimento
	 $sqlRec = "select siglarec from tiporec where codrec = '$TipoRec' ";
	 $rsRec = mysqli_query($conec, $sqlRec) or die ("Não foi possível acessar o Tipo de Recebimento");
	 $lnRec = mysqli_fetch_array($rsRec);
	   $SgRec  = $lnRec['siglarec'];
	 
       // Obtendo a Forma de Recebimento
	  $sqlFm = "select siglapag from formapag where codpag = '$FPag' ";
	  $rsFm  = mysqli_query($conec, $sqlFm) or die ("Não foi possível acessar o Forma de Pagamento");
	  $lnFm  = mysqli_fetch_array($rsFm);
	    $FmRec  = $lnFm['siglapag'];

	  if ($FmRec == "")
	    {
	     $FmRec = "DIV";
	    }

       // Reduzindo a Matrícula
	  $MatRec = substr($Mat,1,6)."-".substr($Mat,7,1); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Imprimindo Via Cliente
       $Aut1 = $Reg;
       $Aut2 = "$Reg$PC$horaaut$NDoc $dtAut"."R$ "."$TaxaChavF$SgRec$FmRec$MatRec";
       shell_exec("echo $Aut2 > /dev/lp0");

    // Preparando Ficha Cliente ?>
       <form name="via1chav" method="post" action="via2chav.php">
	   <input type="hidden" name="txtuser"  value="<?php echo $lg_user; ?>">
	   <input type="hidden" name="txtreg"   value="<?php echo $Reg; ?>">
	   <input type="hidden" name="txtpc"    value="<?php echo $PC; ?>">
	   <input type="hidden" name="horaaut"  value="<?php echo $horaaut; ?>">
	   <input type="hidden" name="txtdoc"   value="<?php echo $NDoc; ?>">
	   <input type="hidden" name="dtaut"    value="<?php echo $dtAut; ?>">
	   <input type="hidden" name="tiporec"  value="<?php echo $TipoRec; ?>">
	   <input type="hidden" name="taxachav" value="<?php echo $TaxaChavF; ?>">
	   <input type="hidden" name="siglarec" value="<?php echo $SgRec; ?>">
	   <input type="hidden" name="formapag" value="<?php echo $FmRec; ?>">
	   <input type="hidden" name="txtmat" value="<?php echo $MatRec; ?>">
	   <br><br><br><br>
	   <font size='6'><b><center>Coloque a <font color='gold'><blink>Segunda Via</blink><font color='#FFFFFF'> na Autenticadora
	    e <br>
	   <p>Clique no <font color='gold'><blink>botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	   <center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
	   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
       </form><?php

    // Gravando a Spool
       include "dbselect.php";
       $sql = "insert into spool2 values ('$Aut1', '$Aut2')";
       $rs  = mysqli_query($conec, $sql) or die ("Não foi possível gravar a Spool");

    // Encerrando a Conexão
       /* mysqli_free_result($rs);
       mysqli_free_result($rsPC);
       mysqli_free_result($rsRec);
       mysqli_free_result($rsFm);
       mysqli_free_result($rsApe); */
       $SisRot = "S-7.5.1.1.2";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>

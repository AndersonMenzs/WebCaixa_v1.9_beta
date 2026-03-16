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
	 $Rot       = "S7R8.2.1.1";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $Aut       = trim($_POST['txtreg']);
	   $AutFull = 10000 + $Aut;
	 $Reg       = substr($AutFull,1,4);
	 $NDoc      = trim($_POST['txtdoc']);
	 $TipoRec   = trim($_POST['tiporec']);
	 $SubTipo   = trim($_POST['subfpag']);
	 $dtRec     = trim($_POST['dtrec']);
	   $aRec    = substr($dtRec,2,2);
	   $mRec    = substr($dtRec,4,2);
	   $dRec    = substr($dtRec,6,2);
	 $dtAut     = $dRec.$mRec.$aRec;
	 $hora      = trim($_POST['txthora']);
	   $h1 = substr($hora,0,2);
	   $h2 = substr($hora,3,2);
	 $horaaut   = $h1.$h2;
	 $VrVenda   = trim($_POST['vrvenda']);
	 $VlVenda   = number_format($VrVenda,2,",",".");

	 if (strlen($VlVenda) < 7)
	   {
	    $VlVendaF = " $VlVenda";
	   } else {
		   $VlVendaF = $VlVenda;
		  }
	 $Mat       = trim($_POST['txtmat']);
	 $dtHoje    = date('Ymd');

      // Pesquisando PC
	 include "conexao.php";
	 include "dbselect.php";
	 $sqlPC = "select pc from inicial";
	 $rsPC  = mysqli_query($conec, $sqlPC) or die ("Não foi possível acessar o PC");
	 $lnPC  = mysqli_fetch_array($rsPC);
	   $PC  = $lnPC['pc'];
	 
      // Obtendo o Tipo de Recebimento
	 $sqlRec = "select siglarec from tiporec where codrec = '$TipoRec' ";
	 $rsRec = mysqli_query($conec, $sqlRec) or die ("Não foi possível acessar o Tipo de Recebimento");
	 $lnRec = mysqli_fetch_array($rsRec);
	   $SgRec  = $lnRec['siglarec'];
	 
       // Reduzindo a Matrícula
	  $MatRec = substr($Mat,4,4);

       // Concluindo a Venda
	  $sqlVd = "update orcamento set vndok = 's' where orcam = $NDoc ";
	  $rsVd  = mysqli_query($conec, $sqlVd) or die ("Não foi possível Atualizar os Dados");

       // Pesquisando Apelido
	  include "dblog.php";
	  $sqlApe = "select ape from pessoal where mat = '$Mat'";
	  $rsApe  = mysqli_query($conec, $sqlApe) or die("Não foi possível acessar o Cadastro");
	  $lnApe  = mysqli_fetch_array($rsApe);
	    $Apef = $lnApe['ape'];
	    $Ape  = strtoupper(substr($Apef,0,4)); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><?php

    // Imprimindo Via Cliente
       shell_exec("echo '$Reg$PC$horaaut$NDoc $dtAut$VlVendaF$SubTipo$MatRec$Ape' > /dev/lp0");

    // Preparando Ficha Cliente ?>
       <form name="via1prod" method="post" action="via2aut.php">
	   <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	   <input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
	   <input type="hidden" name="txtpc" value="<?php echo $PC; ?>">
	   <input type="hidden" name="horaaut" value="<?php echo $horaaut; ?>">
	   <input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
	   <input type="hidden" name="dtaut" value="<?php echo $dtAut; ?>">
	   <input type="hidden" name="txtvendaf" value="<?php echo $VlVendaF; ?>">
	   <input type="hidden" name="siglarec" value="<?php echo $SubTipo; ?>">
	   <input type="hidden" name="txtmat" value="<?php echo $MatRec; ?>">
	   <input type="hidden" name="txtape" value="<?php echo $Ape; ?>">
	   <br><br><br><br>
	   <font size='6'><b><center><blink>Finalizar Operação</blink></b></font></p><br><br>
	   <center><input id="ghost_click" type="submit" name="btimprime" value="Concluir"></center><br>
       </form><?php

    // Encerrando a Conexão
       /* mysqli_free_result($rsPC);
       mysqli_free_result($rsRec);
       mysqli_free_result($rsVd);
       mysqli_free_result($rsApe); */
       $SisRot = "S-7.8.2.1.1";
       include "./rodape.php"; ?>

  </body>

</html>

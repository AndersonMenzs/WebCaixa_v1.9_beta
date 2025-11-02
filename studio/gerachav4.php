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
	 $Rot       = "S7R2.5.1.1";
	 $dtRec     = date('Y-m-d');
	 $dtComp    = date('Y-m-d');
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $NDoc      = trim($_POST['txtdoc']);
	 	$NDoc_a	= trim($_POST['txtdoc']);
	 $FPag1     = trim($_POST['lsPr1']);
	 $FPag2     = trim($_POST['lsPr2']);
	 $FPag3     = trim($_POST['lsPr3']);
	 $txt1      = trim($_POST['txt1']);
	 $txt2      = trim($_POST['txt2']);
	 $txt3      = trim($_POST['txt3']);
	 $Qtde      = trim($_POST['qtde']);
	 $Pass      = strtolower(trim($_POST['txtsen']));
	 $Senha     = sha1($Pass);

      // Criando Variáveis
	 $fps = 0;
	 $TaxaChav  = $txt1 + $txt2 + $txt3;
	 $TaxaChavF = number_format($TaxaChav,2,",",".");
	 $TipoRec   = '9';
	 $SubTipo   = 'CHV';

	 include "conexao.php";
	 include "dbselect.php";

      // Obtendo Dados
	 $sqlo = "select * from operador where pass = '$Senha' ";
	 $rso  = mysqli_query($conec, $sqlo);
	 $regso= mysqli_num_rows($rso); ?>

  <font color="gold" size="6">
  <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><br><br><?php

  include "us_cad.php";

  if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm')
    {
     if ($regso > 0)
       {
	$lno  = mysqli_fetch_array($rso);
	  $Mat = $lno['mat'];

	// Gravando os Registros
	   $sqlr = "select * from registro order by datarec desc, reg desc";
	   $rsr  = mysqli_query($conec, $sqlr) or die ("Erro de Banco de Dados #1. Contate seu Administrador.");
	   $regsr= mysqli_num_rows($rsr);
	   $lnr = mysqli_fetch_array($rsr);
	     $Reg     = $lnr['reg'];
	     $dtReceb = $lnr['datarec'];

	     //include "comp_numdoc2.php";

	   if (($nd == 'ok' and $regsr == 0) or ($nd == 'ok' and $dtComp <> $dtReceb))
	     {
	      $Reg = 0;
	     }
	 $Reg  = $Reg + 1;

	 if ($FPag1 <> "00")
	   {
	    $fps = $fps + 1;
	    $sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag1', '0', '$dtRec', '$hora', '$txt1', '$Mat', '')";
	    $rsGr  = mysqli_query($conec, $sqlGr) or die ("Erro de Banco de Dados #2. Contate seu Administrador.");
	   }

	 if ($FPag2 <> "00")
	   {
	    $fps = $fps + 1;
	    $sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag2', '0', '$dtRec', '$hora', '$txt2', '$Mat', '')";
	    $rsGr  = mysqli_query($conec, $sqlGr) or die ("Erro de Banco de Dados #5. Contate seu Administrador.");
	   }

	 if ($FPag3 <> "00")
	   {
	    $fps = $fps + 1;
	    $sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag3', '0', '$dtRec', '$hora', '$txt3', '$Mat', '')";
	    $rsGr  = mysqli_query($conec, $sqlGr) or die ("Erro de Banco de Dados #8. Contate seu Administrador.");
	   }

	 // Preparando a Via Cliente
	    if ($fps ==  1)
	      {
	       if ($FPag1 <> "00")
		 {
		  $FPag = $FPag1;
		 } else if ($FPag2 <> "00")
			  {
			   $FPag = $FPag2;
			  } else {
				  $FPag = $FPag3;
				 }
	      } else {
		      $FPag = "05";
		     }

	 // Preparando a Via Cliente ?>
	    <form name="gerachav1" method="post" action="via1newchav.php">
	       <input type="hidden" name="txtuser"  value="<?php echo $lg_user; ?>">
	       <input type="hidden" name="txtreg"   value="<?php echo $Reg; ?>">
	       <input type="hidden" name="tiporec"  value="<?php echo $TipoRec; ?>">
	       <input type="hidden" name="txtdoc"   value="<?php echo $NDoc; ?>">
	       <input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
	       <input type="hidden" name="dtrec"    value="<?php echo $dtRec; ?>">
	       <input type="hidden" name="txthora"  value="<?php echo $hora; ?>">
	       <input type="hidden" name="taxachav" value="<?php echo $TaxaChavF; ?>">
	       <input type="hidden" name="txtmat"   value="<?php echo $Mat; ?>"><br>
	   <font size='6'><b><center>Coloque a <font color='gold'><blink>Primeira Via</blink><font color='#FFFFFF'> na Autenticadora
	    e <br>
	   <p>Clique no <font color='gold'><blink>botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	       <center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
		   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
	    </form><?php

	} else { ?>
	    <font size='6'><b><center>Senha <font color='gold'><blink>Incorreta</blink><br>
	    <font color='#FFFFFF'>ou<br>
	    Usuário <font color='gold'><blink>Não Autorizado</blink><font color='#FFFFFF'>!!!</center></b></font><br>
	    <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><?php
	       }
    }

    // Encerrando a Conexão
       /* mysqli_free_result($rso);
       mysqli_free_result($rsGr);
       mysqli_free_result($rsx); */
       $SisRot = "S-7.5.1.1.1";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>
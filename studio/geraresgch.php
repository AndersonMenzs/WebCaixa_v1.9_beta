<html>

  <head>
    <title>WebCaixa v1.20.21_beta</title>
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
	 $Rot       = "S7R2.2.1.1";
	 $dtRec     = date('Y-m-d');
	 $dtComp    = date('Y-m-d');
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $NDoc      = trim($_POST['txtdoc']);
	 $NDoc_a	= trim($_POST['txtdoc']);
	 $VrEntr    = trim($_POST['txtvalor']);
	 $FPag      = trim($_POST['txtmodpag']);
	 $Pass      = strtolower(trim($_POST['txtsen']));
	 $Senha     = sha1($Pass);

      // Variáveis
	 $TipoRec   = '5';
	 $SubTipo   = 'RCH';
	 $DataHoje = date('Y-m-d');

	 include "conexao.php";
	 include "dbselect.php";
	 include "valida_caixa.php";

	 bloquear_se_caixa_anterior_aberto($conec, $lg_user);

      // Obtendo Dados
	 $sqlo = "select * from operador where mat = '$user' and pass = '$Senha' ";
	 $rso  = mysqli_query($conec, $sqlo);
	 $regso= mysqli_num_rows($rso); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><br><?php

  include "us_cad.php";
  //include "comp_numdoc.php";

    if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm')
  //if (($nd == 'ok' and $ch == 'ok') or ($nd == 'ok' and $ch == 'ok-enc') or ($nd == 'ok' and $ch == 'ok-cai') or ($nd == 'ok' and $ch == 'ok-adm'))
    {
     if ($regso > 0)
       {
	$lno  = mysqli_fetch_array($rso);
	  $Mat = $lno['mat'];
	// Gravando o Registro
	   $sqlr = "select * from registro order by datarec desc, reg desc";
	   $rsr  = mysqli_query($conec, $sqlr) or die ("Não foi possível acessar os Dados");
	   $regsr= mysqli_num_rows($rsr);
	   $lnr = mysqli_fetch_array($rsr);
	     $Reg     = $lnr['reg'];
	     $dtReceb = $lnr['datarec'];

	   if ($regsr == 0 or $dtComp <> $dtReceb)
	     {
	      $Reg = 0;
	     }
	 $Reg  = $Reg + 1;
	 $sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag', '0', '$dtRec', '$hora', '$VrEntr', '$Mat', '')";
	 $rsGr  =mysqli_query($conec, $sqlGr) or die ("Não foi possível salvar os Dados");

	 // Preparando a Via Cliente ?>
	    <form name="geracntentr" method="post" action="via1entr.php">
	       <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	       <input type="hidden" name="txtreg" value="<?php echo $Reg; ?>">
	       <input type="hidden" name="tiporec" value="<?php echo $TipoRec; ?>">
	       <input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
	       <input type="hidden" name="formapag" value="<?php echo $FPag; ?>">
	       <input type="hidden" name="dtrec" value="<?php echo $dtRec; ?>">
	       <input type="hidden" name="txthora" value="<?php echo $hora; ?>">
	       <input type="hidden" name="txtvalor" value="<?php echo $VrEntr; ?>">
	       <input type="hidden" name="txtmat" value="<?php echo $Mat; ?>"><br>
	   <font size='6'><b><center>Coloque a <font color='gold'><blink>Via do Cliente</blink><font color='#FFFFFF'> na Autenticadora
	    e <br>
	   <p>Clique no <font color='gold'><blink>botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	       <center><input type="submit" name="btimprime" value="Autenticar"></center><br>
	    </form><?php

	} else { ?>
	    <font size='6'><b><center>Senha <font color='gold'><blink>Incorreta</blink><br>
	    <font color='#FFFFFF'>ou<br>
	    Usuário <font color='gold'><blink>Não Autorizado</blink><font color="#FFFFFF">!!!</center></b></font><br>
	    <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><?php
	       }
    }

    // Encerrando a Conexão
       mysqli_free_result($rso);
       mysqli_free_result($rsGr);
       mysqli_free_result($rsx);
       $SisRot = "S-7.2.2.1.1";
       include "rodape.php"; ?>

  </body>

</html>

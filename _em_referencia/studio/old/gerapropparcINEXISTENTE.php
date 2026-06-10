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
	 $Rot       = "S7R2.7.1.1";
	 $dtRec     = date('Y-m-d');
	 $dtComp    = date('Y-m-d');
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $NDoc      = trim($_POST['txtdoc']);
	 $NDoc_a	= trim($_POST['txtdoc']);
	 $QtdeParc  = trim($_POST['txtparc']);
	 $VrEntr    = trim($_POST['txtvalor']);
	 $Parc      = trim($_POST['txtvrparc']);
	 $PIni      = trim($_POST['txtparci']);
	 $FPag      = trim($_POST['txtmodpag']);
	 $Pass      = strtolower(trim($_POST['txtsen']));
	 $Senha     = sha1($Pass);

      // Variáveis
	 $TipoRec   = '4';
	 $SubTipo   = 'PVDP';
	 $DataHoje = date('Y-m-d');

      include "conexao.php";
      include "dbselect.php";

      // Obtendo Dados
	 $sqlo = "select * from operador where pass = '$Senha' ";
	 $rso  = mysqli_query($conec, $sqlo);
	 $regso= mysqli_num_rows($rso); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>Sistema de Autenticação</i></u></center></b></font><br><?php

  include "us_cad.php";

    if ($ch == 'ok' or $ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok-adm')
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

	// Gravando Várias Parcelas
	   $ParcUlt = $VrEntr - $Parc * ($QtdeParc -1);
	   $Reg  = $Reg + 1;
	   for ($K=1; $K <= $QtdeParc; $K++)
	      {
	       if ($K == $QtdeParc)
		 {
		  $sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag', '$PIni', '$dtRec', '$hora', '$ParcUlt', '$Mat', '')";
		 } else {
			$sqlGr = "insert into registro values($Reg, '$NDoc', '$TipoRec', '$SubTipo', '$FPag', '$PIni', '$dtRec', '$hora', '$Parc', '$Mat', '')";
			}
	       $rsGr  = mysqli_query($conec, $sqlGr) or die ("Não foi possível salvar os Dados");
	       $PIni = $PIni + 1;
	      }

	       // Criando o spoll
		  $RegFull  = 10000 + $Reg;
		  $RegSp    = substr($RegFull,1,4);
		  $sqlPC  = "select pc from inicial";
		  $rsPC  = mysqli_query($conec, $sqlPC) or die ("Não foi possível consultar o PC");
		  $lnPC = mysqli_fetch_array($rsPC);
		  $PCSp    = $lnPC['pc'];
		  $hSp     = substr($hora,0,2);
		  $mSp     = substr($hora,3,2);
		  $HoraSp  = $hSp.$mSp;
		  $NDocSp  = $NDoc;
		  $dtAutSp = date('dmy');
		  $VrEntrF = number_format($VrEntr,2,',','');
		  $VrEntrSp= "R$ ".$VrEntrF;

	       $sqlSg  = "select siglarec from tiporec where codrec = '$TipoRec' ";
	       $rsSg   = mysqli_query($conec, $sqlSg) or die ("Não foi possível consultar o Tipo");
	       $lnSg = mysqli_fetch_array($rsSg);
	       $SgRecSp = $lnSg['siglarec'];

	       $sqlSgpag  = "select siglapag from formapag where codpag = '$FPag' ";
	       $rsSgpag   = mysqli_query($conec, $sqlSgpag) or die ("Não foi possível consultar o Tipo");
	       $lnSgpag = mysqli_fetch_array($rsSgpag);
	       $FmRecSp = $lnSgpag['siglapag'];

	       // Reduzindo a Matrícula
		  $MatRecSp = substr($Mat,1,6)."-".substr($Mat,7,1);

	       include "dbselect.php";
	       $Spo = $RegSp.$PCSp.$HoraSp.$NDocSp.$dtAutSp.$VrEntrSp.$SgRecSp.$FmRecSp.$MatRecSp;

	       $sqlSp1 = "insert into spool values('$RegSp', '$Spo')";
	       $rsSp1  = mysqli_query($conec, $sqlSp1) or die ("Não foi possível salvar os Dados");

	       $sqlSp2 = "insert into spool2 values('$RegSp', '$Spo')";
	       $rsSp2  = mysqli_query($conec, $sqlSp2) or die ("Não foi possível salvar os Dados");

	 // Preparando a Via Cliente ?>
	    <form name="geracntparc" method="post" action="via1parc.php">
	       <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	   <font size='6'><b><center>Coloque a <font color='gold'><blink>Via do Cliente</blink><font color='#FFFFFF'> na Autenticadora
	    e <br>
	   <p>Clique no <font color='gold'><blink>botão Abaixo</blink><font color='#FFFFFF'>.</center></b></font></p><br>
	       <center><input id="ghost_click" type="submit" name="btimprime" value="Autenticar"></center><br>
		   <center><font color='#FFFFFF' size='3'><span id="msg"></span></font></center>
	    </form><?php

	} else { ?>
	    <font size='6'><b><center>Senha <font color='gold'><blink>Incorreta</blink><br>
	    <font color='#FFFFFF'>ou<br>
	    Usuário <font color='gold'><blink>Não Autorizado</blink><font color="#FFFFFF">!!!</center></b></font><br>
	    <center><a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a></center><br><?php
	       }
    }

    // Encerrando a Conexão
       /* mysqli_free_result($rso);
       mysqli_free_result($rsGr);
       mysqli_free_result($rsx); */

       $SisRot = "S-7.2.7.1.1";
       include "./rodape.php"; ?>

	   <script src="./js/ghost_click.js"></script>

  </body>

</html>
<html>
  <head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 7%;
		margin-left: 5%;
		margin-right: 5%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 14px sans-serif;
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

	<SCRIPT LANGUAGE="JavaScript">
	 function putFocus(formInst, elementInst) {
	  if (document.forms.length > 0) {
	   document.forms[formInst].elements[elementInst].focus();
	  }
	 }
	</script>

	<Script>
	function validate(field) {
	var valid = ".0123456789"
	var ok = "yes";
	var temp;
	for (var i=0; i<field.value.length; i++) {
	temp = "" + field.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
	alert("Entrada Incorreta! \n  Digite apenas algarismos!");
	field.focus();
	field.select();
	   }
	}
	</script>

	<script> 
	  function FormataValor(Formulario, Campo, TeclaPres) 
	  { 
	    var tecla = TeclaPres.keyCode; 
	    var strCampo; 
	    var vr; 
	    var tam; 
	    var TamanhoMaximo = 10; 
 
	    eval("strCampo = document." + Formulario + "." + Campo); 

	    vr = strCampo.value; 
	    vr = vr.replace("/", ""); 
	    vr = vr.replace("/", ""); 
	    vr = vr.replace("/", ""); 
	    vr = vr.replace(",", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace(".", ""); 
	    vr = vr.replace("-", ""); 
	    vr = vr.replace("-", ""); 
	    vr = vr.replace("-", ""); 
	    vr = vr.replace("-", ""); 
	    vr = vr.replace("-", ""); 
	    tam = vr.length; 

	    if (tam < TamanhoMaximo && tecla != 8) 
	    { 
	      tam = vr.length + 1; 
	    } 

	    if (tecla == 8) 
	    { 
	      tam = tam - 1; 
	    } 

	    if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) 
	    { 
	      if (tam <= 3) 
	      { 
	        strCampo.value = vr; 
	      } 
	       if ((tam > 3) && (tam <= 10)) 
	       { 
        	 strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam); 
	       } 
	    } 
	  }
	</script>

	<script type="text/javascript" src="val_difer.js" charset="utf-8">
	</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php
     include "../cabecprs.php";

     // Obtendo o Login
       $Sis        = "S7";
	$Rot       = "S7R0.7";
	$lg_user   = $_REQUEST['c_s'];
	  $user    = substr($lg_user,0,8);
	     $mat1 = substr($user,0,1);
	     $mat2 = substr($user,1,3);
	     $mat3 = substr($user,4,3);
	     $dv   = substr($user,7,1);
	$userF     = "$mat1.$mat2.$mat3-$dv";
	  $pss     = substr($lg_user,8,40);
	$Data      = date('Y-m-d');

     // Criando o Código de Acesso
	$Ac1        = date('is');
	$Ac2        = date('si');
	$AccessCode = $Ac1 * $Ac2;

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  }

     if ($ch == 'ok')
       { ?>
	<form name="auddifer" method="post" action="incdifer.php" OnSubmit="JavaScript:return checkdata()"><br>
	<font size='6' color='gold'><b><i><center>RETIFICAÇÃO DO SALDO INICIAL DO CAIXA</center></i></b></font><br><br><?php

     // Obtendo Dados Anteriores
	include "dbselect.php";
	$sql = "select dtopen, numerario from caixa order by dtopen desc";
	$rs  = mysqli_query ($conec, $sql) or die ("Não foi possível acessar o Cadastro.");
	$ln = mysqli_fetch_array($rs);
	  $DtOpen    = $ln['dtopen'];
	  $Numer     = $ln['numerario'];
	  $NumerF    = number_format($Numer,2,",",".");
	mysqli_free_result($rs);

     if ($DtOpen <> $Data)
       { ?>
	<br><br><font size='6'><b><center>Primeiro é Preciso<font color='gold'><blink><u>Abrir o Caixa</u>
	</blink><font color='#FFFFFF'>!!!</center></b></font><br>
	<center><a href='aud.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><?php
       } else { ?>
	       <table border="10" cellpadding="10" cellspacing="10" align="center">
		  <tr>
		     <td colspan="2" align='center'>
			<font color="aqua" size="5"><b></i>Saldo Inicial: R$ <?php echo $NumerF; ?></i></b></font>
		     </td>
		  </tr>

		  <tr>
		     <td align='center'>
			<font size="4"><b></i>Valor: R$ </i></b></font>
			<input type="text" name="txtdifer" size="7" maxlength="7" class="campos" OnKeyUp="validate(this);FormataValor('auddifer', 'txtdifer', event);">
		     </td>
		     <td align='center'>
			<select name="lsOp" class="campos">
			   <option value="S" class="campos">Operação</option>
			   <option value="D" class="campos">Debitar</option>
			   <option value="C" class="campos">Creditar</option>
			</select>
		     </td>
		  </tr>

		  <tr>
		     <td align='center'>
			<font size="4"><b></i>Código: <font color='gold'><?php echo $AccessCode; ?></i></b></font>
		     </td>
		     <td align='center'>
			<font size="4"><b></i>Contra-Senha: </i></b></font>
			<input type="text" name="txtwa" size="6" maxlength="6" class="campos" OnKeyUp="validate(this);FormataValor('auddifer', 'txtdifer', event);">
		     </td>
		  </tr>

		  <tr>
		     <td colspan="2" align='center'>
			<input type="hidden" name="txtcodex" value="<?php echo $AccessCode; ?>">
			<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
			<input type="hidden" name="txtopen" value="<?php echo $DtOpen; ?>">
			<input type="hidden" name="txtnumer" value="<?php echo $Numer; ?>">
			<input type="submit" name="btOK" value="Confirmar">&nbsp;&nbsp;
			<input type="reset" name="btReset" value="Limpar">
		     </td>
		  </tr>
	       </table><br>
	</form>

	<center><a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></center>
	<meta http-equiv="refresh" content="120;URL=./acaud.php?c_s=<?php echo $lg_user; ?>"><?php
	        }
       } else { ?>
	       <br><br><br><font size='5'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	       </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	       <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	      }

     // Encerrando
        $SisRot = "S-7.0.7";
        include "rodape.php"; ?>
  </body>
</html>

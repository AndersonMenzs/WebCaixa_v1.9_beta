<html>
  <head>
    <title>WebCaixa v1.20.17_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 2%;
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

	<SCRIPT LANGUAGE="JavaScript">
	<!-- Begin
	 function putFocus(formInst, elementInst) {
	  if (document.forms.length > 0) {
	   document.forms[formInst].elements[elementInst].focus();
	  }
	 }
	//  End -->
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
	//  End -->
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

	<script type="text/javascript" src="validar.js" charset="utf-8">
	</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php
     include "../cabecprs.php";

     // Obtendo o Login
       $Sis     = "S7";
	$Rot     = "S7R0.1";
	$lg_user = $_REQUEST['c_s'];
	  $user  = substr($lg_user,0,8);
	     $mat1 = substr($user,0,1);
	     $mat2 = substr($user,1,3);
	     $mat3 = substr($user,4,3);
	     $dv   = substr($user,7,1);
	$userF    = "$mat1.$mat2.$mat3-$dv";
	  $pss   = substr($lg_user,8,40);
	$hif    =' - ';
	$hif2   =' em ';

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       }

     if ($ch == 'ok')
       { ?>
	<form name="audit" method="post" action="auditinc.php" OnSubmit="JavaScript:return checkdata()">
	<font size='5' color='gold'><b><u><i><center>ESTRUTURAÇÃO INICIAL DO CAIXA</center></i></u></b></font><?php

     // Obtendo Dados Anteriores
	include "dbselect.php";
	$sqlI = "select * from inicial order by dtaltera desc";
	$rsI  = mysqli_query ($conec, $sqlI) or die ("Não foi possível acessar os dados da Auditoria.");
	$regsI= mysqli_num_rows($rsI);

	If ($regsI == 0)
	  {
	   include "dblog.php";
	   $sqlCF = "select mat, nome from pessoal where mat = '$user' ";
	   $rsCF  = mysqli_query ($conec, $sqlCF) or die ("Não foi possível acessar o Cadastro.");
	   $lnCF = mysqli_fetch_array($rsCF);
	     $MatCF = $lnCF['mat'];
	       $m1   = substr($MatCF,0,1);
	       $m2   = substr($MatCF,1,3);
	       $m3   = substr($MatCF,4,3);
	       $dv   = substr($MatCF,7,1);
	     $MatF   = "$m1.$m2.$m3-$dv";
	     $NomeP = $lnCF['nome'];
	   $dtAltF  = date('d/m/Y');
	  } else {
		  $lnI    = mysqli_fetch_array($rsI);
		  $Mat    = $lnI['mat'];
		    $m1   = substr($Mat,0,1);
		    $m2   = substr($Mat,1,3);
		    $m3   = substr($Mat,4,3);
		    $dv   = substr($Mat,7,1);
		  $MatF   = "$m1.$m2.$m3-$dv";
		  $dtAlt  = $lnI['dtaltera'];
		    $dtAy = substr($dtAlt,0,4);
		    $dtAm = substr($dtAlt,5,2);
		    $dtAd = substr($dtAlt,8,2);
		  $dtAltF = "$dtAd/$dtAm/$dtAy";
		  $Cofre  = $lnI['cofre'];
		  $Troco  = $lnI['troco'];
		  $Gaveta = $lnI['gaveta'];
		  $Tot    = $lnI['tot'];
		  $PC     = $lnI['pc'];
		  $Ape    = $lnI['ape'];
		  mysqli_free_result($rsI);

		  // Consultando Cadastro de Funcionários
		     include "dblog.php";
		     $sqlP = "select nome from pessoal where mat = '$Mat' ";
		     $rsP  = mysqli_query ($conec, $sqlP) or die ("Não foi possível acessar os dados de Pessoal.");
		     $lnP  = mysqli_fetch_array($rsP);
		       $MatP   = $lnP['mat'];
		       $NomeP  = $lnP['nome'];
		     mysqli_free_result($rsP);
		 }
	$CofreF  = number_format($Cofre,2,".","");
	$TrocoF  = number_format($Troco,2,".","");
	$GavetaF = number_format($Gaveta,2,".","");
	$TotF    = number_format($Tot,2,".",""); ?>

	<p><center><font size="5"><b><?php echo "$MatF $hif $NomeP $hif2 $dtAltF"; ?></b></font></center></p>
	<table width="40%" border="05" cellpadding="05" cellspacing="0" align="center">
	   <tr>
	      <td width='35%'>
		 <font size="4"><b></i>PC: </i></b></font>
	      </td>
	      <td width='65%'>
		 <input type="text" name="txtpc" size="3" maxlength="3" class="campos"  onKeyUp="validate(this)" value="<?php echo $PC; ?>">
	      </td>
	   </tr>

	   <tr>
	      <td width='35%'><font size="4">
		 <b></i>Apelido: </i></b></font>
	      </td>
	      <td width='65%'>
		 <input type="text" name="txtape" size="25" maxlength="25" class="campos" value="<?php echo $Ape; ?>" onkeypress="fPassaAlfaNumerico('an')" onkeyup="this.value=this.value.toUpperCase(); validacarac(this)">
	      </td>
	   </tr>

	   <tr>
	      <td width='35%'>
		 <font size="4"><b></i>Cofre: </i></b></font>
	      </td>
	      <td width='65%'>
		 <input type="text" name="txtcofre" size="7" maxlength="10" class="campos" OnKeyUp="FormataValor('audit', 'txtcofre', event); validate(this)" value="<?php echo $CofreF; ?>">
	      </td>
	   </tr>

	   <tr>
	      <td width='35%'>
		 <font size="4"><b></i>Troco: </i></b></font>
	      </td>
	      <td width='65%'>
		 <input type="text" name="txttroco" size="7" maxlength="10" class="campos" OnKeyUp="FormataValor('audit', 'txttroco', event); validate(this)" value="<?php echo $TrocoF; ?>">
	      </td>
	   </tr>

	   <tr>
	      <td width='35%'>
		 <font size="4"><b></i>Gaveta: </i></b></font>
	      </td>
	      <td width='65%'>
		 <input type="text" name="txtgav" size="7" maxlength="10" class="campos" OnKeyUp="FormataValor('audit', 'txtgav', event); validate(this)" value="<?php echo $GavetaF; ?>">
	      </td>
	   </tr>
	</table>

	<p><center><font color="gold" size="5"><b><blink>(Não utilize "Acentos" ou "Cedilha")</blink></b></font></center></p>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	   <tr>
	      <td width='33%'>
		 <a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	      </td>
	      <td width='34%' align='center'>
		 <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		 <input type="hidden" name="txtnome" value="<?php echo $NomeP; ?>">
		 <input type="submit" name="btOK" value="Confirmar">&nbsp;&nbsp;
		 <input type="reset" name="btReset" value="Limpar">
	      </td>
	      <td width='33%' align='right'>
		 <a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	      </td>
	   </tr>
	</table></p>
	</form>

	<meta http-equiv="refresh" content="180;URL=./acaud.php?c_s=<?php echo $lg_user; ?>"><?php
       } else { ?>
	       <br><br><br><font size='5'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	       </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	       <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	      }

     // Encerrando
        $SisRot = "S-7.0.1";
        include "rodape.php"; ?>

  </body>
</html>

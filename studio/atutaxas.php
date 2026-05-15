<html>
  <head>
    <title>WebCaixa v1.20.10_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 2%;
		margin-left: 2%;
		margin-right: 2%;
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
	
    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>

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
function validata(field) {
var valid = "/0123456789"
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

<Script>
function validvalor(field) {
var valid = ".,0123456789"
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
  function FormataData(Formulario, Campo, TeclaPres) 
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
      if (tam <= 4) 
      { 
        strCampo.value = vr; 
      } 
       if ((tam > 4) && (tam <= 7)) 
       { 
         strCampo.value = vr.substr(0, tam - 2) + '/' + vr.substr(tam - 2, tam); 
       } 
       if ((tam > 7) && (tam <= 10)) 
       { 
         strCampo.value = vr.substr(0, tam - 7) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 5, tam); 
//         strCampo.value = vr.substr(0, tam - 8) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 4, tam); 
      } 
    } 
  } 
</script>

<html>
<script> 
  function FormataValor(Formulario, Campo, TeclaPres) 
  { 
    var tecla = TeclaPres.keyCode; 
    var strCampo; 
    var vr; 
    var tam; 
    var TamanhoMaximo = 6; 
  
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
       if ((tam > 3) && (tam <= 6)) 
       { 
         strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam); 
       } 
    } 
  } 

</script>

<script type="text/javascript" src="val_taxas.js" charset="utf-8">
</script>

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php
    // Obtendo o Login
       $Sis     = "S7";
       $Rot     = "S7R8.1";
       $lg_user = $_REQUEST['c_s'];
	  $user = substr($lg_user,0,8);
	  $pss  = substr($lg_user,8,40);
       $dtHoje  = date('d/m/Y');

       include "us_sist.php";
       if ($ch == 'no')
         {
	  include "us_cad.php";
         }

    // Obtendo Valores dos Serviços
       include "conexao.php";
       include "dbselect.php";

       $sqlP = "select vltx from taxas where codigo = 'TXP' order by datalt desc";
       $rsP  = mysqli_query($conec, $sqlP) or die ("Erro de Banco de Dados #1. Contate seu Administrador");
       $lnP  = mysqli_fetch_array($rsP);
	 $VrProd = $lnP['vltx'];
       $VrProdF  = number_format($VrProd,2,',','.');

       $sqlC = "select vltx from taxas where codigo = 'TXC' order by datalt desc";
       $rsC  = mysqli_query($conec, $sqlC) or die ("Erro de Banco de Dados #2. Contate seu Administrador");
       $lnC  = mysqli_fetch_array($rsC);
	 $VrConc = $lnC['vltx'];
       $VrConcF  = number_format($VrConc,2,',','.');

       $sqlX = "select vltx from taxas where codigo = 'CHV' order by datalt desc";
       $rsX  = mysqli_query($conec, $sqlX) or die ("Erro de Banco de Dados #2A. Contate seu Administrador");
       $lnX  = mysqli_fetch_array($rsX);
	 $VrChav = $lnX['vltx'];
       $VrChavF  = number_format($VrChav,2,',','.');

       $sqlB = "select vltx from taxas where codigo = 'BEB' order by datalt desc";
       $rsB  = mysqli_query($conec, $sqlB) or die ("Erro de Banco de Dados #2B. Contate seu Administrador");
       $lnB  = mysqli_fetch_array($rsB);
	 $VrBebe = $lnB['vltx'];
       $VrBebeF  = number_format($VrBebe,2,',','.'); ?>

       <font color="gold" size="6"><br><b><center><u><i>Atualização de Valores</i></u></center></b></font><br><br><br><?php

       if ($ch == 'ok-enc' or $ch == 'ok')
	 { ?>
	  <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
	     <form name="frmatual" method="post" action="gravatual.php" OnSubmit="JavaScript:return checkdata()">
	     <tr>
		<td align="center">
		   <font color='gold' size='4'><b><i>Data</i></b></font>
		</td>
		<td align="center">
		   <font color='gold' size='4'><b><i>Serviço</i></b></font>
		</td>
		<td align="center">
		   <font color='gold' size='4'><b><i>Valor Atual &nbsp;</i></b></font>
		</td>
		<td align="center">
		   <font color='gold' size='4'><b><i>Novo Valor &nbsp;</i></b></font>
		</td>
	     </tr>

	     <tr>
		<td align="center">
		   <input type="text" name="txtdtprod" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp = "FormataData('frmatual', 'txtdtprod', event); validata(this)">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i>Taxa de Produção</i></b></font>
		   <input type="hidden" name="txtprod" value="TXP">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i><?php echo "R$ $VrProdF"; ?></i></b></font>
		   <input type="hidden" name="txtvrprod" value="<?php echo $VrProdF; ?>">
		</td>
		<td align="center">
		   <input type="text" name="txtvrprodn" size="5" maxlength="6" class="campos" OnKeyUp="FormataValor('frmatual', 'txtvrprodn', event); validvalor(this)">
		</td>
	     </tr>

	     <tr>
		<td align="center">
		   <input type="text" name="txtdtconc" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp = "FormataData('frmatual', 'txtdtconc', event); validata(this)">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i>Inscrição no Concurso</i></b></font>
		   <input type="hidden" name="txtconc" value="TXC">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i><?php echo "R$ $VrConcF"; ?></i></b></font>
		   <input type="hidden" name="txtvrconc" value="<?php echo $VrConcF; ?>">
		</td>
		<td align="center">
		   <input type="text" name="txtvrconcn" size="5" maxlength="6" class="campos" OnKeyUp="FormataValor('frmatual', 'txtvrconcn', event); validvalor(this)">
		</td>
	     </tr>

	     <tr>
		<td align="center">
		   <input type="text" name="txtdtchav" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp = "FormataData('frmatual', 'txtdtchav', event); validata(this)">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i>Chaveiro</i></b></font>
		   <input type="hidden" name="txtchav" value="CHV">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i><?php echo "R$ $VrChavF"; ?></i></b></font>
		   <input type="hidden" name="txtvrchav" value="<?php echo $VrChavF; ?>">
		</td>
		<td align="center">
		   <input type="text" name="txtvrchavn" size="5" maxlength="6" class="campos" OnKeyUp="FormataValor('frmatual', 'txtvrchavn', event); validvalor(this)">
		   <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		</td>
	     </tr>
	     <tr>
		<td align="center">
		   <input type="text" name="txtdtbebe" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp = "FormataData('frmatual', 'txtdtbebe', event); validata(this)">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i>Bebê Estrella</i></b></font>
		   <input type="hidden" name="txtbebe" value="BEB">
		</td>
		<td align="center">
		   <font color='#FFFFFF' size='4'><b><i><?php echo "R$ $VrBebeF"; ?></i></b></font>
		   <input type="hidden" name="txtvrbebe" value="<?php echo $VrBebeF; ?>">
		</td>
		<td align="center">
		   <input type="text" name="txtvrbeben" size="5" maxlength="6" class="campos" OnKeyUp="FormataValor('frmatual', 'txtvrbeben', event); validvalor(this)">
		   <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
		</td>
	     </tr>
	  </table><br>

	  <table width="100%" border="0" cellspacing="0">
	     <tr>
		<td width="9%"><a href="vendback.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></td>
		<td width="82%" align="center">
		   <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
		   <input type="reset" name="btreset" value="Limpar">
		<td width="9%" align="right"><a href="vendback.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
		</td>
	     </tr>
	   </table>
	     </form><br><br><?php
	 } else { ?>
	         <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
		 </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	         <center><a href='vendback.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		}

      // Encerrando as Conexões
	 $SisRot = "S-7.8.1";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>

</html>

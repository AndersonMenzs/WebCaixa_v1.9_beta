<html>
  <head>
    <title>WebCaixa v1.20.20_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 5%;
		margin-left: 3%;
		margin-right: 3%;
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

<SCRIPT LANGUAGE="JavaScript">
 function putFocus(formInst, elementInst) {
  if (document.forms.length > 0) {
   document.forms[formInst].elements[elementInst].focus();
  }
 }
</script>

<script>
function F5(event) {
var tecla = document.all ? window.event.keyCode : event.which;
if (document.all) { window.event.keyCode = 0; window.event.returnValue = false; }
if (tecla == 116) return false;
}

document.onkeydown = F5;
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
alert("Entrada Incorreta!\nDigite apenas algarismos!");
field.value = "";
field.focus();
field.select();
   }
}
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
      } 
    } 
  } 
</script>

<script type="text/javascript" src="val_data.js" charset="utf-8">
</script>

    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php" ;
    ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R1.1";
	$lg_user = $_REQUEST['c_s'];
	   $user = substr($lg_user,0,8);
	   $pss  = substr($lg_user,8,40);

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?>

    <font color="gold" size="6"><br>
      <b><center><u><i>AUTENTICAÇÕES</i></u></center></b></font><br><br><br><?php

  if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
    { ?>
     <form name="frmcnt" method="post" action="cntaut_aud.php" OnSubmit="JavaScript:return checkdados()">
     <table border="10" cellpadding="10" cellspacing="0" align="center">
	<tr>
	  <td>
	      <font size='4'><b><i>Autenticações do Dia </i></b></font>
	  </td>
	  <td>
	      <input type='text' name='txtdata' size='12' maxlength='10' class='campos' OnKeyUp="validata(this); FormataData('frmcnt', 'txtdata', event)">
	      <input type='hidden' name='txtuser' value='<?php echo $lg_user; ?>'>
	  </td>
	  <td align='center'>
	     <input type='submit' value='Enviar'>&nbsp;&nbsp;
	     <input type='reset'  value='Limpar'>
	  </td>
	</tr>
    </table>
    </form>
    <br><br><center><a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></center><br><?php
    } else { ?>
	    <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	    </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	    <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	   }

   // Encerrando
      $SisRot = "S-7.1.1";
      include "rodape.php";

      // Encerrando as Conexões
	 mysqli_close($conec); ?>

  </body>

</html>

<html>
  <head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
		margin-top: 7%;
		margin-left: 2%;
		margin-right: 2%;
		border: 3px solid gray;
		padding: 10px 10px 10px 10px;
		font-family:sans-serif;
	       }
	  .campos {
	   background-color:#C0C0C0;
	   font: 16px sans-serif;
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
<!-- Begin
 function putFocus(formInst, elementInst) {
  if (document.forms.length > 0) {
   document.forms[formInst].elements[elementInst].focus();
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

<script type="text/javascript" src="val_rec.js" charset="utf-8">
</script>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R8.4.2";
	$lg_user = $_REQUEST['c_s'];
	   $user   = substr($lg_user,0,8);
	   $pss    = substr($lg_user,8,40);

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       } ?>

    <font color="gold" size="6">
      <br><br><b><center><u><i>Entrada de Produtos</i></u></center></b></font><br><br><?php

  if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
    { ?>
     <table width="30%" border="5" cellpadding="6" cellspacing="0" align="center">
     <form name="Form" method="post" action="imprec.php" OnSubmit="JavaScript:return checkdata()">
	<tr>
	  <td align="center">
	     <font color='gold' size='5'><b><i>Data da Inclusão</i></b></font>
	  </td>
	</tr>

	<tr>
	  <td align="center">
	     <input type="text" name="txtdtinc" size="10" maxlength="10" class="campos" OnKeyUp="FormataData('Form', 'txtdtinc', event);">
	     <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	  </td>
	</tr>
     </table></p><br>

     <table width="85%" border="0" cellspacing="0" align="center">
        <tr>
	   <td width="9%">
	      <a href="ctrlest.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a>
	   </td>
	   <td width="82%" align="center">
	     <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
	     <input type="reset" name="btreset" value="Limpar">
	   </td>
	   <td width="9%" align="right">
	      <a href="ctrlest.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
	   </td>
	 </tr>
      </table><br>
      </form><?php
    } else { ?>
	    <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	    </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	    <center><a href='ctrlest.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	   }

      // Encerrando as Conexões
	 $SisRot = "S-7.8.4.2";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>

</html>

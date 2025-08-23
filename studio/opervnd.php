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
<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function validate(field) {
var valid = "0123456789"
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

<script type="text/javascript" src="checkuser.js" charset="utf-8">
</script>

  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
     include "../cabecprs.php";

     // Obtendo o Login
        $Sis     = "S7";
	$Rot     = "S7R6.3";
	$lg_user = $_REQUEST['c_s'];
	  $user  = substr($lg_user,0,8);
	  $pss   = substr($lg_user,8,40);

	include "us_sist.php";
	if ($ch == 'no')
	  {
	   include "us_cad.php";
	  }

	if ($ch == 'ok' or $ch == 'ok-enc')
	  {
    ?><br><br>
    <font color='gold' size='5'><b><u><i><center>CADASTRAR/EXCLUIR VENDEDORA</center></i></u></b></font><br><br><br>

    <table width="30%" border="10" cellpadding="0" cellspacing="0" align="center">
       <tr>
	  <td align="center">
	     <form name="opr" method="post" action="cadvnd.php" OnSubmit="JavaScript:return checkop()">
		<p><font size="4"><b><i>Matrícula:</i></b></font>
		<input type="text" name="txtmat" size="8" maxlength="8" class="campos" OnKeyUp="validate(this)">
		<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>"></p>
	  </td>
       </tr>
    </table><br><br>

	<center><input type="submit" name="btsub" value="Consultar">&nbsp;&nbsp;&nbsp;
'		<input type="reset" name="btrst" value="Limpar"></center>
	      </form><br><br>

    <center><a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a></center><?php
	  } else { ?>
		  <br><br><br><font size='5'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
		  </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
		  <center><a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		 }

   // Encerranso
      $SisRot = "S-7.6.3";
      include "../rodape.php"; ?>

    </body>

</html>

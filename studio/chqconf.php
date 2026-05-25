<html>

  <head>
    <title>WebCaixa v1.20.12_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	  body {
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

/*
Auto tabbing script- By JavaScriptKit.com
http://www.javascriptkit.com
This credit MUST stay intact for use
*/

function autotab(original,destination){
if (original.getAttribute&&original.value.length==original.getAttribute("maxlength"))
destination.focus()
}

</script>

<Script>
function validpag(field) {
var valid = "SN"
var ok = "yes";
var temp;
for (var i=0; i<field.value.length; i++) {
temp = "" + field.value.substring(i, i+1);
if (valid.indexOf(temp) == "-1") ok = "no";
}
if (ok == "no") {
alert("Entrada Incorreta! \n  Digite apenas \"S\" ou \"N\".");
field.value = "";
field.focus();
field.select();
   }
}
</script>

<script type="text/javascript" src="val_pgto.js" charset="utf-8">
</script>

	<?php
	  // Inserindo Cabeçalho
	     include "../cabecprs.php";
	?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
      // Importando os Dados do Formul�rio
	 $Sis       = "S7";
	 $Rot       = "S7R2.4.1";
	 $lg_user   = trim($_POST['txtuser']);
	   $user    = substr($lg_user,0,8);
	   $pss     = substr($lg_user,8,40);
	 $NumDoc    = trim($_POST['txtdoc']);
	   $NumDocF = 1000000 + $NumDoc;
	 $NDoc      = substr($NumDocF,1,6);
	 $VrEntr    = trim($_POST['txtvalor']);
	 $EntrForm  = number_format($VrEntr,2,',','.');
	 $FPag      = trim($_POST['lsPr']);
	 include "conexao.php";
	 include "dbselect.php";

      // Obtendo Dados
	 $sql = "select * from formapag where codpag = '$FPag' ";
	 $rs  = mysqli_query($conec, $sql);
	 $ln  = mysqli_fetch_array($rs);
	   $ModPag = $ln['modpag'];
	 mysqli_free_result($rs); ?>

    <font color="gold" size="6">
      <br><b><center><u><i>RESGATE DE CHEQUES</i></u></center></b></font><br><?php

     include "us_sist.php";
     if ($ch == 'no')
       {
	include "us_cad.php";
       }

 if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
   { ?>
    <table width="85%" border="5" cellpadding="10" cellspacing="0" align="center">
    <form name="confentr" method="post" action="geraresgch.php" OnSubmit="JavaScript:return checkdata()">
	<tr>
	  <td width="30%" align="center">
	     <font color='gold' size='5'><b><i>Nº Documento</i></b></font>
	  </td>
	  <td width="70%" align="center">
	     <font color='#FFFFFF' size='5'><b><i><?php echo $NDoc; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="30%" align="center">
	     <font color='gold' size='5'><b><i>Valor Cobrado</i></b></font>
	  </td>
	  <td width="70%" align="center">
	     <font color='#FFFFFF' size='5'><b><i><?php echo "R$ ".$EntrForm; ?></i></b></font>
	  </td>
	</tr>

	<tr>
	  <td width="30%" align="center">
	     <font color='gold' size='5'><b><i>Forma de Pagamento</i></b></font>
	  </td>
	  <td width="70%" align="center">
	     <font size='6'><b><i>Pagamento em <font color='gold'><blink>Dinheiro</blink>&nbsp;
	     <font size="5"><font color="#FFFFFF">(<font color="lime">S&nbsp;/&nbsp;<font color="red">N<font color="gold"><font color="#FFFFFF">)<font size="6">?</i></b></font>&nbsp;&nbsp;
	     <input type="text" name="txtconfirm" size="2" maxlength="1" class="campos" onKeyPress="fPassaAlfaNumerico('an')" onKeyUp="this.value=this.value.toUpperCase(); validpag(this); autotab(this, txtsen)">
	  </td>
	</tr>

	<tr>
	  <td width="30%" align="center">
	     <font color='gold' size='5'><b><i>Senha</i></b></font>
	  </td>
	  <td width="70%" align="center">
	     <input type='password' name='txtsen' size='6' maxlength='6' class="campos">
	  </td>
	</tr>
    </table>
	<input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
	<input type="hidden" name="txtvalor" value="<?php echo $VrEntr; ?>">
	<input type="hidden" name="txtdoc" value="<?php echo $NDoc; ?>">
	<input type="hidden" name="txtmodpag" value="<?php echo $FPag; ?>">
	<p><center><input type="submit" name="btenvia" value="Continuar">
	<input type="button" name="btret" value="Retornar" OnClick="JavaScript:window.history.back()"></center></p>
    </form><?php
   } else { ?>
	   <br><br><br><br><br><font size='6'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u>
	   </blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br>
	   <center><a href='servrec.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
	  }

    // Encerrando
       $SisRot = "S-7.2.4.1";
       include "rodape.php"; ?>

  </body>

</html>

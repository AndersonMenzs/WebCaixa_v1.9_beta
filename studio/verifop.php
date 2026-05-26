<html>
   <head>
      <title>WebCaixa v1.20.16_beta</title>
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
	   font: 16px sans-serif;
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
	field.value = "";
	field.focus();
	field.select();
	   }
	}
	//  End -->
	</script>

	<Script>
	<!-- This script and many more are available free online at -->
	<!-- The JavaScript Source!! http://javascript.internet.com -->

	<!-- Begin
	function validcpf(field) {
	var valid = ".-0123456789"
	var ok = "yes";
	var temp;
	for (var i=0; i<field.value.length; i++) {
	temp = "" + field.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
	alert("Entrada Incorreta! \n  Digite apenas algarismos!");
	field.value = "";
	field.focus();
	field.select();
	   }
	}
	//  End -->
	</script>

	<script> 
	  function FormataCPF(Formulario, Campo, TeclaPres) 
	  { 
	    var tecla = TeclaPres.keyCode; 
	    var strCampo; 
	    var vr; 
	    var tam; 
	    var TamanhoMaximo = 11; 

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
	      if (tam <= 2) 
	      { 
	       strCampo.value = vr; 
	      } 
	       if ((tam > 2) && (tam <= 5)) 
	       { 
	         strCampo.value = vr.substr(0, tam - 2) + '-' + vr.substr(tam - 2, tam); 
	       } 
	       if ((tam > 5) && (tam <= 8)) 
	       { 
	         strCampo.value = vr.substr(0, tam - 5) + '.' + vr.substr(tam - 5, 3) + '-' + vr.substr(tam - 2, tam); 
	      } 
	       if ((tam > 8) && (tam <= 11)) 
	       { 
	         strCampo.value = vr.substr(0, tam - 8) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + '-' + vr.substr(tam - 2, tam); 
	      } 
	    } 
	  } 
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

	<script type="text/javascript" src="checkinc.js" charset="utf-8">
	</script>
   </head>

   <body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)"><?php
      include "../cabecprs.php";

      // Obtendo o Login E Iniciando Variáveis
	 $Sis     = "S7";
	 $Rot     = "S7R6.1.1";
	 $lg_user = $_POST['txtuser'];
	   $user  = substr($lg_user,0,8);
	   $pss   = substr($lg_user,8,40);

	 $Mat     = $_POST['txtmat'];
	   $MatFull = 100000000 + $Mat;
           $MatOp   = substr($MatFull,1,8);
           $MatForm = substr($MatOp,0,1).".".substr($MatOp,1,3).".".substr($MatOp,4,3)."-".substr($MatOp,7,1);

	 $lsCargo  = trim($_POST['lsCargo']);
	   $CCargo = substr($lsCargo,0,2);
	   $NCargo = substr($lsCargo,2,30);
	   $iniCgo = substr($NCargo,0,1).strtolower(substr($NCargo,1,2));


	 include "us_sist.php";
	 if ($ch == 'no')
	   {
	    include "us_cad.php";
	   }

      // Variáveis do Sistema
	 $Data = date('Y-m-d'); ?><br>

      <font color='gold' size='5'><b><u><i><center>CADASTRAR O FUNCIONÁRIO</center></i></u></b></font><br><br><?php

      if (($ch == 'ok-enc' or $ch == 'ok') and $MatOp <> '00000000')
	{
	 // Abrindo a Conexão
	    include "conexao.php";

	// Validando a Matrícula
	   include "dblog.php";
	   $sqls = "select mat, nome, ape,cpf from pessoal where mat = '$MatOp' ";
	   $rss = mysqli_query($conec, $sqls) or die("Não foi possível acessar o Cadastro de Pessoal");
	   $regss = mysqli_num_rows($rss);

	   $sqlf = "select pass, funcao from funcionarios where mat = '$MatOp' ";
	   $rsf = mysqli_query($conec, $sqlf) or die("Não foi possível acessar o Cadastro de Funcionários");

	   if ($regss > 0)
	     {
	      $lns = mysqli_fetch_array($rss);
		$MatF  = $lns['mat'];
		  $mat1 = substr($MatF,0,1);
		  $mat2 = substr($MatF,1,3);
		  $mat3 = substr($MatF,4,3);
		  $dv   = substr($MatF,7,1);
		$MatForm = "$mat1.$mat2.$mat3-$dv";
		$NomeF = $lns['nome'];
		$ApeF  = $lns['ape'];
		$cpfF  = $lns['cpf'];
		$cpfForm = substr($cpfF,0,3).".".substr($cpfF,3,3).".".substr($cpfF,6,3)."-".substr($cpfF,9,2);
	      $lnf = mysqli_fetch_array($rsf);
		$Passf = $lnf['pass'];
		$Funcao = $lnf['funcao'];

	      $sqlFu = "select * from cargos where ccargo = '$Funcao' ";
	      $rsFu  = mysqli_query($conec, $sqlFu) or die("Não foi possível acessar o Cadastro de Cargos");
	      $lnFu  = mysqli_fetch_array($rsFu);
		$CodCg  = $lnFu['ccargo'];
		$NomCg  = $lnFu['ncargo'];

	      // Abrindo Tabela de Operadores
		 include "dbselect.php";

	      // Selecionando Tabela Operador
		 $sql = "select * from operador where mat = '$MatOp' ";

	      // Consultando registros
		 $rs = mysqli_query($conec, $sql) or die("Não foi possível acessar o Cadastro");

	      // Verificando Existência do Operador
		 $regs = mysqli_num_rows($rs);

	      // Obtendo os Dados
		 if ($regs > 0 and $regss > 0 or $regs == 0 and $regss > 0)
		   {
		    $ln = mysqli_fetch_array($rs);
		      $matOp = $ln['mat'];
		      $pssOp = $ln['pass'];
		      $cgoOp = $ln['cargo'];
			switch ($cgoOp)
			      {
			       case "Aud":
				$cgoOpF = "Auditora";
				break;
			       case "Enc":
				$cgoOpF = "Encarregada";
				break;
			       case "Cai":
				$cgoOpF = "Caixa";
				break;
			      }
		      $dtaOp = $ln['dataop'];
		      $hraOp = $ln['horaop'];
		      $freOp = $ln['freeop'];
		      $rspOp = $ln['resp'];

		    // Exibindo Dados ?>
		       <form name="cadop" method="post" action="cadopexist.php">
		       <table align="center" border="10" cellpadding="10" cellspacing="0">
			  <tr>
			     <td colspan="2">
				<font size="4"><b><i>Matrícula: <font color='gold'><?php echo "$MatForm"; ?></i></b></font>
				<input type='hidden' name='txtmat' value='<?php echo "$MatF" ?>'>
			     </td>
			     <td>
				<font size="4"><b><i>CPF: <font color='gold'><?php echo "$cpfForm"; ?></i></b></font>
				<input type='hidden' name='txtcpf' value='<?php echo "$cpfF" ?>'>
			     </td>
			  </tr>

			  <tr>
			     <td colspan="2">
				<font size="4"><b><i>Nome: <font color='gold'><?php echo "$NomeF"; ?></i></b></font>
				<input type='hidden' name='txtnome' value='<?php echo "$NomeF" ?>'>
			     </td>
			     <td>
				<font size="4"><b><i>Apelido: <font color='gold'><?php echo "$ApeF"; ?></i></b></font>
				<input type='hidden' name='txtape' value='<?php echo "$ApeF" ?>'>
			     </td>
			  </tr>

			  <tr>
			     <td colspan="3">
				<font size="4"><b><i>Cargo Atual: <font color='gold'><?php echo "$NomCg"; ?></i></b></font>
			     </td>
			  </tr>

			  <tr>
			     <td colspan="3">
				<font size="4"><b><i>Para a Funcão de: <font color='gold'><?php echo "$NCargo"; ?></i></b></font>
				<input type='hidden' name='txtfuncao' value='<?php echo $iniCgo; ?>'>
				<input type='hidden' name='txtuser' value='<?php echo "$lg_user" ?>'>
			     </td>
			  </tr>
		       </table><br><?php
		   }
	     } else {
		     // Exibindo Dados ?>
			<form name="cadop" method="post" action="cadopnew.php" OnSubmit="JavaScript:return checkop()">
			<table align="center" border="10" cellpadding="10" cellspacing="0">
			   <tr>
			      <td colspan="2">
				 <font size="4"><b><i>Matrícula: <font color='gold'><?php echo "$MatForm"; ?></i></b></font>
				<input type='hidden' name='txtmat' value='<?php echo "$MatOp" ?>'>
			      </td>
			      <td align='right'>
				 <font size="4"><b><i>CPF: 
				 <input type='text' name='txtcpf' size='15' maxlength='14' class='campos' onKeyUp="validcpf(this); FormataCPF('cadop', 'txtcpf', event);">
			      </td>
			   </tr>

			   <tr>
			      <td colspan="2">
				 <font size="4"><b><i>Nome: 
				 <input type='text' name='txtnome' size='45' maxlength='40' class='campos' onkeypress="fPassaAlfaNumerico('an')" onkeyup="this.value=this.value.toUpperCase()">
			      </td>
			      <td align='right'>
				 <font size="4"><b><i>Apelido:
				 <input type='text' name='txtape' size='15' maxlength='12' class='campos' onkeyup="this.value=this.value.toUpperCase()">

			      </td>
			   </tr>

			   <tr>
			      <td colspan="3">
				 <font size="4"><b><i>Para a Funcão de: <font color='gold'><?php echo "$NCargo"; ?></i></b></font>
				<input type='hidden' name='txtfuncao' value='<?php echo $iniCgo; ?>'>
				 <input type='hidden' name='txtuser' value='<?php echo "$lg_user" ?>'>
			      </td>
			   </tr>
			</table><br><?php
		    }

		 if ($regs > 0 and $regss > 0)
		   { ?>
		    <center><font size='5'><b><i>Funcionário já Cadastrado na Função de <font  color='lime'><blink><?php echo "$cgoOpF"; ?></blink></i></b></font></cemter><br><br><?php
		   } else if ($regs > 0 and $regss == 0)
			    { ?>
			     <center><font size='5'><b><i>Funcionário <font  color='lime'><blink>Não Cadastrado</blink> <font color='#FFFFFF'>no Sistema!!!</i></b></font></cemter><br><br><?php
			    }
	} else if (($ch == 'ok-enc' or $ch == 'ok') and $MatOp == '00000000')
		 {
		  include "conexao.php";
		  include "dblog.php";

		  $sql = "select mat from funcionarios where mat >= 90000000 and mat <= 99000000 order by mat desc";
		  $rs  = mysqli_query($conec, $sql) or die ("Erro na Consulta Free Lancer. Contate seu Administrador");
		  $reg = mysqli_num_rows($rs);

		  If ($reg == 0)
		    {
		     $MFree = 8999999;
		    } else {
			    $ln = mysqli_fetch_array($rs);
			    $MFree = substr($ln['mat'],0,7);
			   }
		  $MFree  = $MFree + 1;

		  $f1 = substr($MFree,0,1) * 8;
		  $f2 = substr($MFree,1,1) * 7;
		  $f3 = substr($MFree,2,1) * 6;
		  $f4 = substr($MFree,3,1) * 5;
		  $f5 = substr($MFree,4,1) * 4;
		  $f6 = substr($MFree,5,1) * 3;
		  $f7 = substr($MFree,6,1) * 2;
		  $soma = $f1+$f2+$f3+$f4+$f5+$f6+$f7;
		  $dv = $soma %10;

		  $MatFree = $MFree.$dv;
		  $MatFreF = substr($MFree,0,1).".".substr($MFree,1,3).".".substr($MFree,4,3)."-".$dv;

		     // Exibindo Dados ?>
			<form name="cadop" method="post" action="cadopfree.php" OnSubmit="JavaScript:return checkop()">
			<table align="center" border="10" cellpadding="10" cellspacing="0">
			   <tr>
			      <td colspan="2">
				 <font size="4"><b><i>Matrícula: <font color='gold'><?php echo "$MatFreF"; ?><font color='lightgreen'> <blink>(Free-Lancer)</blink></i></b></font>
				 <input type='hidden' name='txtmat' value='<?php echo $MatFree; ?>'>
			      </td>
			      <td align='right'>
				 <font size="4"><b><i>CPF: 
				 <input type='text' name='txtcpf' size='15' maxlength='14' class='campos' onKeyUp="validcpf(this); FormataCPF('cadop', 'txtcpf', event);">
			      </td>
			   </tr>

			   <tr>
			      <td colspan="2">
				 <font size="4"><b><i>Nome: 
				 <input type='text' name='txtnome' size='45' maxlength='40' class='campos' onkeyup="this.value=this.value.toUpperCase()">
			      </td>
			      <td align='right'>
				 <font size="4"><b><i>Apelido:
				 <input type='text' name='txtape' size='15' maxlength='12' class='campos' onkeyup="this.value=this.value.toUpperCase()">

			      </td>
			   </tr>

			   <tr>
			      <td colspan="3">
				 <font size="4"><b><i>Para a Funcão de: <font color='gold'><?php echo "$NCargo"; ?></i></b></font>
				<input type='hidden' name='txtfuncao' value='<?php echo $iniCgo; ?>'>
				 <input type='hidden' name='txtuser' value='<?php echo "$lg_user" ?>'>
			      </td>
			   </tr>
			</table><br><?php

		 } ?>

		 <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		       <td>
			  <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
		       </td>
		       <td align="center"><?php
			 if ($regs > 0 and $regss > 0)
			   { ?>
			    <input type="submit" value="CADASTRAR ASSIM MESMO"><?php
			   } else { ?>
				   <input type="submit" value="CADASTRAR"><?php
				  } ?>
		       </td>
		       <td align="right">
			  <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
		       </td>
		    </tr>
		 </table>
		 </form><br><?php

    // Gravando Operadores Cadastrados
       include "./conexao.php";
       include "./dbselect.php";

       if ($MatFree == '')
         {
          $MatFree = "$MatOp";
         }
       $sql = "insert into cadastro values ('$MatFree', '$Data') ";
       $rs = mysqli_query($conec, $sql) or die("Não foi possível Gravar o Cadastramento");

    // Encerrando a Conexão
       mysqli_free_result($rss);
       mysqli_free_result($rsf);
       mysqli_free_result($rs);
       mysqli_free_result($rsFu);

      if ($ch <> 'ok-enc' and $ch <> 'ok')
	{ ?>
	 <br><br><br><br><font size='5'><b><center>Acesso <font color='gold'><blink><u>não Autorizado</u></blink><font color='#FFFFFF'>!!!</center></b></font><br><br><br><br><br><?php
	} ?>

    <meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>"><?php

      $SisRot = "S-7.6.1.1";
      include "rodape.php"; ?>

    </body>

</html>

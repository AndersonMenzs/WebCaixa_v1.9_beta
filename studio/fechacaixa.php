<html>

<head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
    body {
        margin-top: 7%;
        margin-left: 5%;
        margin-right: 5%;
        border: 3px solid gray;
        padding: 10px 10px 10px 10px;
        font-family: sans-serif;
    }

    .campos {
        background-color: #C0C0C0;
        font: 12px sans-serif;
        color: #000000;
    }
    </style>

    <script>
    function F5(event) {
        var tecla = document.all ? window.event.keyCode : event.which;
        if (document.all) {
            window.event.keyCode = 0;
            window.event.returnValue = false;
        }
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
    //  End 
    -->
    </script>

    <script>
    function FormataValor(Formulario, Campo, TeclaPres) {
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

        if (tam < TamanhoMaximo && tecla != 8) {
            tam = vr.length + 1;
        }

        if (tecla == 8) {
            tam = tam - 1;
        }

        if (tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105) {
            if (tam <= 3) {
                strCampo.value = vr;
            }
            if ((tam > 3) && (tam <= 10)) {
                strCampo.value = vr.substr(0, tam - 3) + '.' + vr.substr(tam - 3, tam);
            }
        }
    }
    </script>

    <script type="text/javascript" src="valrec.js" charset="utf-8">
    </script>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php include "../cabecprs.php";

    // Obtendo o Login
       $Sis     = "S7";
       $Rot       = "S7R5.2";
       $lg_user   = trim($_POST['txtuser']);

       if ($lg_user == '')
	 {
	  $lg_user   = trim($_REQUEST['c_s']);
	 }
       $user    = substr($lg_user,0,8);
	 $mat1 = substr($user,0,1);
	 $mat2 = substr($user,1,3);
	 $mat3 = substr($user,4,3);
	 $dv   = substr($user,7,1);
       $userF   = "$mat1.$mat2.$mat3-$dv";
       $pss     = substr($lg_user,8,40);
       $dtAbre  = trim($_POST['dtabre']);
       $ch        = '';
       $erro = 'n';
       echo $dtAbre;

       include "us_sist.php";
       if ($ch == 'no')
	 {
	  include "us_cad.php";
	 }
       if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
	 { ?><br><br>
    <font size='4' color='gold'><b><u><i>
                    <center>FECHAMENTO DO CAIXA</center>
                </i></u></b></font><br><br><?php

	  // Verificando a Abertura do Caixa
	     include "conexao.php";
	     include "dbselect.php";

	     $sql = "select dtopen from caixa order by dtopen desc";
	     $rs  = mysqli_query($conec, $sql) or die ("File fechacaixa.php Error #1. Contate seu Administrador");
	     $ln  = mysqli_fetch_array($rs);
		$dtOpen = $ln['dtopen'];

	  // Verificando Datas e Horas
	     $data = date("Y-m-d");
	     $hora = date("H:i");
	     $dia  = date("w");

	     if ($dtOpen == $data)
	       {
		if ($dia >= 1 and $dia <= 5 and $hora <= "17:00" or $dia == 6 and $hora <= "13:00")
		  {
		   $erro = 'y';
		  }
	       }

	 if ($erro == 'n')
	   {
	    // Recolhimento em Dinheiro ?>
    <form name="recolhe" method="post" action="fccxant.php" OnSubmit="JavaScript:return checkdata()" autocomplete="off">
        <table width="25%" border="05" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td width='50%' align='center'>
                    <font color="gold"><b><i>GAVETA</b></i></font>
                </td>
                <td width='50%' align='center'>
                    <b><i>R$ </b></i>
                    <input type="text" name="txtcash" size="7" maxlength="7" class="campos"
                        onKeyUp="FormataValor('recolhe', 'txtcash', event);">
                    <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                    <input type="hidden" name="dtabre" value="<?php echo $dtAbre; ?>">
                </td>
            </tr>
        </table><br><br>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td width=24%>
                    <a href="http://localhost/caixa"><img src="../images/voltar.gif">
                </td>
                <td width=52% align="center">
                    <input type="submit" name="btapl" value="Continuar">&nbsp;&nbsp;
                    <input type="reset" name="btcanc" value="Limpar"></a>
                </td>
                <td width=24% align="right">
                    <a href="http://localhost/caixa"><img src="../images/voltar.gif">
                </td>
            </tr>
            <table><br>
    </form><?php
	   } else { ?>
    <br><br><br>
    <font size='6'><b>
            <center>
                <font color='gold'>
                    <blink><u>Você Não Pode Fechar o Caixa Neste Horário!!!</u></blink>
                    <font color='#FFFFFF'>
            </center>
        </b></font><br><br><br>
    <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		  }
	 } else { ?>
    <br><br><br>
    <font size='6'><b>
            <center>Acesso <font color='gold'>
                    <blink><u>não Autorizado</u></blink>
                    <font color='#FFFFFF'>!!!</center>
        </b></font><br><br><br>
    <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
		}

   // Encerrando
      $SisRot = "S-7.5.2";
      include "rodape.php"; ?>

</body>

</html>
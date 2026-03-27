<html>

<head>
    <title>WebCaixa v1.20.0_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    body {
        margin-left: 3%;
        margin-right: 3%;
        border: 3px solid gray;
        padding: 10px 10px 10px 10px;
        font-family: sans-serif;
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

    <script>
	function validcomplemento(field) {
		var valid = "ABCDEFGHIJKLMNOPQRSTUVWXYZ.-/1234567890 "
		var ok = "yes";
		var temp;
		for (var i=0; i<field.value.length; i++) {
			temp = "" + field.value.substring(i, i+1);
			if (valid.indexOf(temp) == "-1") ok = "no";
			}
			
			if (ok == "no") {
				alert("Entrada Incorreta! \n  Digite Apenas Letras, Pontos, Traços e Barras!");
				field.value = "";
				field.focus();
				field.select();
			}
	}
    </script>


</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
     include "../cabecprs.php";

          // Obtendo o Login
          $Sis     = "S7";
          $Rot     = "S7R6.4";
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

?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td width=15% align='center'>
                <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
            </td>
            <td width=70% align='center'>
                <font color='gold' size='5'><b><u><i>PESQUISAR COLABORADORES</i></u></b></font>
            </td>
            <td width=15% align='center'>
                <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
            </td>
        </tr>
    </table>
    <br>
    <table width="80%" border="1" cellpadding="5" cellspacing="0" align="center">
        <form action="" method="POST" id="form-pesquisa">
            <tr>
                <td width="20%" align="center">
                    <font color='gold' size='4'><b><i>Colaborador</i></b></font>
                </td>
                <td width="80%" align="left">
                    &nbsp;<input type="text" name="pesquisa" id="pesquisa" size="70" maxlength="70"
                        onkeypress="fPassaAlfaNumerico('an')"
                        onkeyup='this.value=this.value.toUpperCase(); validnome(this)' required>
        </form>
        </td>
        </tr>
    </table><br>

    <table width="80%" border="1" cellpadding="0" cellspacing="0" align="center">
        <tr>
            <td width=12% align='center'>
                <font color='gold' size='4'><b><i>Matrícula</i></b>
                    <font>
            </td>
            <td width=43% align='center'>
                <font color='gold' size='4'><b><i>Funcionário</i></b>
                    <font>
            </td>
            <td width=30% align='center'>
                <font color='gold' size='4'><b><i>Funcão</i></b>
                    <font>
            </td>
            <td width=15% align='center'>
                <font color='gold' size='4'><b><i>CPF</i></b>
                    <font>
            </td>
        </tr>
    </table><br>

    <table class="resultado" width="80%" border="1" cellpadding="0" cellspacing="0" align="center">

    </table><br><br>

    <script type="text/javascript" src="google_api.js"></script>
    <script type="text/javascript" src="personalizado.js"></script>

    <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a></center><?php
} else { ?>
    <br><br><br>
    <font size='5'><b>
            <center>Acesso <font color='gold'>
                    <blink><u>não Autorizado</u>
                    </blink>
                    <font color='#FFFFFF'>!!!</center>
        </b></font><br><br><br>
    <center><a href='operador.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br><?php
       } ?>
    <meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>"><?php

// Encerrando
   $SisRot = "S-7.6.4";
   include "rodape.php"; 
   ?>

</body>

</html>
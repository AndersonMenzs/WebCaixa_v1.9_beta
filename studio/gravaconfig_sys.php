<html>
  <head>
    <title>WebCaixa v1.20.21_beta</title>
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
	  .retorno-config {
		text-align: center;
		width: 100%;
		margin-top: 8%;
		margin-bottom: 10%;
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

    <?php
      // Inserindo o Cabeçalho
	 include "../cabecprs.php";

      function dataBanco($data)
        {
         $dia = substr($data, 0, 2);
         $mes = substr($data, 3, 2);
         $ano = substr($data, 6, 4);
         return "$ano-$mes-$dia";
        }

      function valorBanco($valor)
        {
         $valor = trim($valor);
         if ($valor == "") {
             return "";
         }

         if (strpos($valor, ",") !== false) {
             $valor = str_replace(".", "", $valor);
             $valor = str_replace(",", ".", $valor);
         } else {
             $valor = str_replace(",", "", $valor);
         }

         return $valor;
        }
    ?>
  </head>

  <body background="../images/bg1.jpg" text="#FFFFFF"><?php
    // Obtendo o Login
       $Sis      = "S7";
       $Rot      = "S7R8.1.1";
       $lg_user  = $_POST['txtuser'];
	  $user  = substr($lg_user,0,8);
	  $pss   = substr($lg_user,8,40);

       $DtSeniorGr = dataBanco($_POST['txtdtsenior']);
       $Senior     = $_POST['txtsenior'];
       $ValSenior  = trim($_POST['txtvrsenior']);
       $ValSeniorN = trim($_POST['txtvrseniorn']);

       $DtAghataGr = dataBanco($_POST['txtdtaghata']);
       $Aghata     = $_POST['txtaghata'];
       $ValAghata  = trim($_POST['txtvraghata']);
       $ValAghataN = trim($_POST['txtvraghatan']);

       $DtRecolhGr = dataBanco($_POST['txtdtrecolh']);
       $Recolh     = $_POST['txtrecolh'];
       $ValRecolh  = valorBanco($_POST['txtvrrecolh']);
       $ValRecolhN = valorBanco($_POST['txtvrrecolhn']);

       include "conexao.php";
       include "dbselect.php";
       ?>
       <div class="retorno-config"><?php

       if (($ValSeniorN == "" or $ValSenior == $ValSeniorN) and ($ValAghataN == "" or $ValAghata == $ValAghataN) and ($ValRecolhN == "" or $ValRecolh == $ValRecolhN))
         { ?>
	  <font size='6'><b>Valores  <font color='gold'><blink><u>Incorretos</u>
	  </blink><font color='#FFFFFF'>!!!</b></font><br><br><br>
	  <a href='JavaScript:window.history.back()'><img src='images/voltar.gif'></a><br><br><?php
	 } else {
		 if ($ValSeniorN > 0 and $ValSenior <> $ValSeniorN)
		   {
		    $sql = "insert into config_sys (dt_config, cod_config, vlr_config, num_config, operador) values('$DtSeniorGr', '$Senior', 0.00, '$ValSeniorN', '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #2. Contate seu Administrador"); ?>
		    <font size='6'><b>Gratuidade Sênior <font color='gold'><blink><u>Atualizada com Sucesso</u></blink><font color='#FFFFFF'>!!!</b></font><br><?php
		   }

		 if ($ValAghataN > 0 and $ValAghata <> $ValAghataN)
		   {
		    $sql = "insert into config_sys (dt_config, cod_config, vlr_config, num_config, operador) values('$DtAghataGr', '$Aghata', 0.00, '$ValAghataN', '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #3. Contate seu Administrador");  ?>
		    <br><font color='#FFFFFF' size='6'><b>Gratuidade Aghata <font color='gold'><blink><u>Atualizada com Sucesso</u></blink><font color='#FFFFFF'>!!!</b></font><br><?php
		   }

		 if ($ValRecolhN > 0 and $ValRecolh <> $ValRecolhN)
		   {
		    $sql = "insert into config_sys (dt_config, cod_config, vlr_config, num_config, operador) values('$DtRecolhGr', '$Recolh', $ValRecolhN, '0', '$user')";
		    $rs  = mysqli_query($conec, $sql) or die ("Erro de Sistema #2A. Contate seu Administrador"); ?>
		    <br><font size='6' color='#FFFFFF'><b>Faixa Recolhimento <font color='gold'><blink><u>Atualizada com Sucesso</u></blink><font color='#FFFFFF'>!!!</b></font><br><?php
		   } ?>
		 <meta http-equiv="refresh" content="2;aud.php?c_s=<?php echo $lg_user; ?>"><?php
		}
       ?></div><?php

      // Encerrando as Conexões
	 $SisRot = "S-7.8.1.1";
	 include "rodape.php";
	 mysqli_close($conec); ?>

  </body>

</html>

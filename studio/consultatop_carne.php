<html>

<head>
    <title>WebCaixa v1.20.9_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
    <!--
    body {
        margin-top: 2%;
        margin-left: 1%;
        margin-right: 1%;
        border: 3px solid gray;
        padding: 10px 10px 10px 10px;
        font-family: sans-serif;
    }

    a:link {
        text-decoration: none
    }

    a:visited {
        text-decoration: none
    }

    a:hover {
        text-decoration: underline;
        color: #FF0000;
    }

    a:active {
        text-decoration: none
    }
    -->
    </style>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" link='aqua' vlink='aqua' alink='aqua' onLoad="putFocus(0,0)"><?php
      include "../cabecprs.php";

      // Obtendo o Login E Iniciando Variáveis
      $Sis     = "S7";
      $Rot     = "S7R2";
      $lg_user = $_REQUEST['c_s'];
        $user  = substr($lg_user,0,8);
        $pss   = substr($lg_user,8,40);
	 $Modelo   = trim($_POST['txtmod']);
	 $Respon   = trim($_POST['txtresp']);
	 $CodCli   = trim($_POST['txtcodcli']);
	 $SitFotog = trim($_POST['rdnovo']);
	 $dtFotog  = trim($_POST['dtfotog']);
	   $FotReal= substr($dtFotog,6,4)."-".substr($dtFotog,3,2)."-".substr($dtFotog,0,2);
	 $CPF      = trim($_POST['txtcpf']);
	   $CPFReal= substr($CPF,0,3).substr($CPF,4,3).substr($CPF,8,3).substr($CPF,12,2);
	 $Vend     = trim($_POST['txtvend']);
	   $Vended = $Vend; //substr(100000000 + $Vend,1,8);
       
    include "us_sist.php";

      // Preparando Variáveis
	 $dtHoje   = date('Y-m-d');
	 $DataBase = date('Y').'-01-01'; ?>

    <p>
        <font color='gold' size='6'><b><u><i>
                        <center>LISTAGEM CARNES</center>
                    </i></u></b></font>
    </p><?php

      if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
	{
	 // Conectar ao Banco de Dados WebDigital
	    include "./conexao_digital.php";
	    include "./dbselect_digital.php";

	 // Exibindo Resultados
	    if ("$SitFotog" == 's')
	      {
	    if ($Modelo <> '')
	      {
	       $sql = "select * from fotog where modelo like '%$Modelo%' and datafot >= '$DataBase' order by datafot desc";
	      } else if ($Respon <> '')
		       {
			$sql = "select * from fotog where cliente like '%$Respon%' and datafot >= '$DataBase' order by datafot desc";
		       } else if ($CodCli <> '' and $CodCli <> '0000')
				{
				 $sql = "select * from fotog where codcli = '$CodCli' and datafot >= '$DataBase' order by datafot desc";
				} else if ($dtFotog <> '')
					 {
					  $sql = "select * from fotog where datafot = '$FotReal' and datafot >= '$DataBase' order by datafot desc";
					 } else if ($CPF <> '')
						  {
						   $sql = "select * from fotog where cpf = '$CPFReal' and datafot >= '$DataBase' order by datafot desc";
						  } else {
							  $sql = "select * from fotog where operador = '$Vended' and datafot >= '$DataBase' order by datafot desc";
							 }
	 $rs  = mysqli_query($conec_digital, $sql) or die ("File consultop Error #1. Contate seu Administrador");
	 $regs= mysqli_num_rows($rs);
	      } else {
		      include 'consultatop2_carne.php';
		     }

	 if ($regs == 0)
	   { ?>
    <br><br><br><br>
    <font size='7'><b>
            <center>
                <blink>Nenhum Registro Encontrado</blink>
                <font color='#FFFFFF'>!!!
            </center>
        </b></font><br><br><?php
	   } else { ?>
    <font size='4'><b><i>
                <center>Clique na Modelo Correspondente</center>
            </i></b></font><br>

    <table border='5' cellpadding='2' cellspacing='0' align='center'>
        <tr>
            <!--<td align='center'>
                <font size='4' color='gold'><b>Cód. Modelo</b></font>
            </td>-->
            <td align='center'>
                <font size='4' color='gold'><b>Fotografado</b></font>
            </td>
            <td align='center'>
                <font size='4' color='gold'><b>Modelo</b></font>
            </td>
            <td align='center'>
                <font size='4' color='gold'><b>Responsável</b></font>
            </td>
        </tr><?php

		      // Obtendo Informações
			 while ($ln = mysqli_fetch_array($rs))
			      {
			            $CC = $ln['codcli'];
			            $DF = $ln['datafot'];
			        $DFinv = substr($DF,8,2)."/".substr($DF,5,2)."/".substr($DF,0,4);			       
                        $MD = $ln['modelo'];
			            $CL = $ln['cliente'];
			            $CP = $ln['cpf'];
				    $fCP = substr($CP,0,3).".".substr($CP,3,3).".".substr($CP,6,3)."-".substr($CP,9,2);
			            $OP = $ln['operador'];
				    $fOP = substr($OP,0,1).".".substr($OP,1,3).".".substr($OP,4,3)."-".substr($OP,7,1);

			       if ($regsE > 0)
				 {
				  while ($lnE = mysqli_fetch_array($rsE))
				       {?>
        <tr>
            <!--<td align='center'>
                <b><?php echo $CC; ?></b>
            </td>-->
            <td align='center'>
                <b><?php echo $DFinv; ?></b>
            </td>
            <td align='left'>
                <a href="carneform.php?c_s=<?php echo $lg_user.$CC.$CP; ?>"><b><?php echo "&nbsp;" . $MD; ?></b>
            </td>
            <td align='left'>
                <b><?php echo "&nbsp;" . $CL; ?></b>
            </td>
        </tr><?php
				       }
				 } else { ?>
        <tr>
            <!--<td align='center'>
                <b><?php echo $CC; ?></b>
            </td>-->
            <td align='center'>
                <b><?php echo $DFinv; ?></b>
            </td>
            <td align='left'>
                <a href="carneform.php?c_s=<?php echo $lg_user.$CC.$CP; ?>"><b><?php echo "&nbsp;" . $MD; ?></b>
            </td>
            <td align='left'>
                <b><?php echo "&nbsp;" . $CL; ?></b>
            </td>
        </tr><?php

			}
			      } ?>
    </table><br><?php
		  }
	} else { ?>
    <br><br><br><br>
    <font size='5'><b>
            <center>Acesso <font color='gold'>
                    <blink><u>não Autorizado</u></blink>
                    <font color='#FFFFFF'>!!!</center>
        </b></font><br><br><br><br><br><?php
	       } ?>
    <center><a href='consulta_carne.php?c_s=<?php echo $lg_user; ?>'><img src='../images/voltar.gif'></a></center><br><?php

        //$SisRot = "Off-2.4.1";
     include "../rodape.php"; ?>

</body>

</html>
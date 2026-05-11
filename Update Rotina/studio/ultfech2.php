<html>

<head>
    <title>WebCaixa v1.20.6_beta</title>
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

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    include "../cabecprs.php";

    // Obtendo o Login
    $Sis     = "S7";
    $Rot     = "S7R5.2";
    $txtmat = trim($_POST['txtmat'] ?? '');
    $txtsen = trim($_POST['txtsen'] ?? '');
    $c_s = trim($_REQUEST['c_s'] ?? '');

    $user = substr(100000000 + $txtmat, 1, 8);
    $pass = strtolower($txtsen);
    $pss  = sha1($pass);
    $lg_user = $user . $pss;
    $userpss = substr($c_s, 0, 48);

    if ($user == '' or $user == 0) {
        $lg_user = $c_s;
        $user = substr($lg_user, 0, 8);
        $pss     = substr($lg_user, 8, 40);
    }

    if ($userpss == '') {
        $userpss = $lg_user;
    }

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }

    if ($ch == 'ok' or $ch == 'ok-enc') {
        include "conexao.php";
        include "dbselect.php";

        $sqlP = "select * from antfech WHERE YEAR(STR_TO_DATE(datafch, '%d/%m/%Y')) = YEAR(CURDATE()) order by fita desc";
        $rsP  = mysqli_query($conec, $sqlP) or die("Não foi Possível Consultar o Fechamento Anterior");

    ?>

        <br><br>

        <table width="100%" border="0" cellpadding="05" cellspacing="0" align="center">
            <tr>
                <td align='center'>
                    <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
                </td>
                <td align='center'>
                    <font color='gold' size='5'><b><u><i>FECHAMENTOS FINAIS ANTERIORES</i></u></b></font>
                </td>
                <td align='center'>
                    <a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a>
                </td>
            </tr>
        </table>

        <br><br><br>

        <table border="1" cellpadding="5" cellspacing="0" align="center">
            <tr>
                <td align='center'>
                    <font color='aqua' size='4'><b><i>Fita</i></b>
                        <font>
                </td>
                <td align='center'>
                    <font color='aqua' size='4'><b><i>Matrícula</i></b>
                        <font>
                </td>
                <td align='center'>
                    <font color='aqua' size='4'><b><i>Funcionário</i></b>
                        <font>
                </td>
                <td align='center'>
                    <font color='aqua' size='4'><b><i>Função</i></b>
                        <font>
                </td>
                <td align='center'>
                    <font color='aqua' size='4'><b><i>Data Fechamento</i></b>
                        <font>
                </td>
            </tr>

            <?php

            $K = 0;

            while ($lnP  = mysqli_fetch_array($rsP) and $K < 5) {
                $K = $K + 1;

                $Fita = $lnP['fita'];
                $Mat  = $lnP['user'];
                $m1 = substr($Mat, 0, 1);
                $m2 = substr($Mat, 2, 3);
                $m3 = substr($Mat, 6, 3);
                $dv = substr($Mat, 10, 1);
                $MatF  = "$m1$m2$m3$dv";
                $datafech = $lnP['datafecha'];

            ?>

                <tr>
                    <td align='center'>
                        <font color='yellow'><b><i><?php echo $Fita; ?></a></i></b>
                            <font>
                    </td>
                    <td align='center'>
                        <font color='#FFFFFF'><b><i><?php echo $Mat; ?></i></b>
                            <font>
                    </td>
                    <td align='left'>

                        <?php

                        // Seleciona Nome Completo

                        include "dblog.php";

                        $sqlR = "SELECT nome FROM pessoal WHERE mat = '$MatF' ";
                        $rsR = mysqli_query($conec, $sqlR) or die("Não foi Possível Consultar");
                        $lnR = mysqli_fetch_array($rsR);
                        $Nome = $lnR['nome'];

                        ?>
                        <font color='#FFFFFF'><b><i><?php echo $Nome; ?></i></b>
                            <font>
                    </td>
                    <td align='center'>

                        <?php

                        // Selecionando Função

                        $sqlS = "SELECT mat, funcao FROM funcionarios WHERE mat = '$MatF'";
                        $rsS = mysqli_query($conec, $sqlS) or die("Não foi Possível Consultar");
                        $lnS = mysqli_fetch_array($rsS);
                        $Funcao = $lnS['funcao'];

                        $sqlT = "select ncargo from cargos where ccargo = '$Funcao' ";
                        $rsT = mysqli_query($conec, $sqlT) or die("Não foi Possível Consultar");
                        $lnT = mysqli_fetch_array($rsT);
                        $FName = $lnT['ncargo'];

                        ?>

                        <font color='yellow'><b><i><?php echo $FName; ?></i></b>
                            <font>
                    </td>

                    <form name="datafech" method="post" target="_blank" action="impultfech3.php?c_s=<?php echo $lg_user; ?>" onsubmit="setTimeout(function(){ window.location.href='index.php?c_s=<?php echo $lg_user; ?>'; }, 300);">
                        <td align='center'>
                            <input type="submit" name="datafech" id="datafech" value="<?php echo $datafech; ?>">
                            <input type="hidden" name='user_pss' id='user_pss' value="<?php echo $userpss; ?>">
                        </td>
                    </form>

                </tr>
            <?php

            }
            mysqli_free_result($rsP);

            ?>

        </table><br><br>

        <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='./images/voltar.gif' border='0'></a></center><br>
    <?php
    } else { ?>
        <br><br><br>
        <font size='5'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u>
                        </blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br><br>
        <center><a href='index.php'><img src='images/voltar.gif'></a></center><br><br>
    <?php
    } ?>
    <meta http-equiv="refresh" content="60;URL=./index.php?c_s=<?php echo $lg_user; ?>">

    <?php

    // Encerrando
    $SisRot = "S-7.5.2";
    include "rodape.php";
    ?>

</body>

</html>

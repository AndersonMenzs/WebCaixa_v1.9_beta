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
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 12px sans-serif;
            color: #000000;
        }
    </style>

    <?php
    // Inserindo o Cabeçalho
    include "../cabecprs.php";
    ?>

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
        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }
    </script>

    <Script>
        function validata(field) {
            var valid = "/0123456789"
            var ok = "yes";
            var temp;
            for (var i = 0; i < field.value.length; i++) {
                temp = "" + field.value.substring(i, i + 1);
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

    <Script>
        function validvalor(field) {
            var valid = ".,0123456789"
            var ok = "yes";
            var temp;
            for (var i = 0; i < field.value.length; i++) {
                temp = "" + field.value.substring(i, i + 1);
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

    <script>
        function FormataData(Formulario, Campo, TeclaPres) {
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
                if (tam <= 4) {
                    strCampo.value = vr;
                }
                if ((tam > 4) && (tam <= 7)) {
                    strCampo.value = vr.substr(0, tam - 2) + '/' + vr.substr(tam - 2, tam);
                }
                if ((tam > 7) && (tam <= 10)) {
                    strCampo.value = vr.substr(0, tam - 7) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 5, tam);
                    //         strCampo.value = vr.substr(0, tam - 8) + '/' + vr.substr(tam - 7, 2) + '/' + vr.substr(tam - 4, tam); 
                }
            }
        }
    </script>

    <html>
    <script>
        function FormataValor(Formulario, Campo, TeclaPres) {
            var strCampo;
            var vr;

            eval("strCampo = document." + Formulario + "." + Campo);

            vr = strCampo.value;
            vr = vr.replace(/\D/g, "");

            if (vr.length == 0) {
                strCampo.value = "";
                return;
            }

            vr = vr.replace(/^0+/, "");
            if (vr.length == 0) {
                vr = "0";
            }

            while (vr.length < 3) {
                vr = "0" + vr;
            }

            strCampo.value = vr.substr(0, vr.length - 2) + "." + vr.substr(vr.length - 2, 2);
        }
    </script>

    <script type="text/javascript" src="val_config_sys.js" charset="utf-8">
    </script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
    // Obtendo o Login
    $Sis     = "S7";
    $Rot     = "S7R8.1";
    $lg_user = $_REQUEST['c_s'];
    $user = substr($lg_user, 0, 8);
    $pss  = substr($lg_user, 8, 40);
    $dtHoje  = date('d/m/Y');

    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }

    // Obtendo Valores dos Serviços
    include "conexao.php";
    include "dbselect.php";

    $sqlConfigSys = "CREATE TABLE IF NOT EXISTS config_sys (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        dt_config DATE NOT NULL,
                        cod_config CHAR(10) NOT NULL,
                        vlr_config DECIMAL(7,2) NOT NULL,
                        num_config CHAR(5) DEFAULT NULL,
                        operador CHAR(8) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    mysqli_query($conec, $sqlConfigSys) or die("Erro de Banco de Dados #0. Contate seu Administrador");

    $sqlP = "select num_config from config_sys where cod_config = 'SENIOR' order by id desc";
    $rsP  = mysqli_query($conec, $sqlP) or die("Erro de Banco de Dados #1. Contate seu Administrador");
    $lnP  = mysqli_fetch_array($rsP);
    $VrSenior = $lnP['num_config'];

    $sqlC = "select num_config from config_sys where cod_config = 'AGHATA' order by id desc";
    $rsC  = mysqli_query($conec, $sqlC) or die("Erro de Banco de Dados #2. Contate seu Administrador");
    $lnC  = mysqli_fetch_array($rsC);
    $VrAghata = $lnC['num_config'];

    $sqlX = "select vlr_config from config_sys where cod_config = 'RECOLH' order by id desc";
    $rsX  = mysqli_query($conec, $sqlX) or die("Erro de Banco de Dados #2A. Contate seu Administrador");
    $lnX  = mysqli_fetch_array($rsX);
    $VrRecolh = $lnX['vlr_config'];
    $VrRecolhF  = number_format($VrRecolh, 2, ',', ''); ?>

    <font color="gold" size="6"><br><b>
            <center><u><i>Configuração do Sistema</i></u></center>
        </b></font><br><br><br>
    <?php

    if ($ch == 'ok-enc' or $ch == 'ok') { ?>
        <table width="70%" border="5" cellpadding="10" cellspacing="0" align="center">
            <form name="frmatual" method="post" action="gravaconfig_sys.php" OnSubmit="JavaScript:return checkdata()">
                <tr>
                    <td align="center">
                        <font color='gold' size='4'><b><i>Data</i></b></font>
                    </td>
                    <td align="center">
                        <font color='gold' size='4'><b><i>Serviço</i></b></font>
                    </td>
                    <td align="center">
                        <font color='gold' size='4'><b><i>Valor Atual &nbsp;</i></b></font>
                    </td>
                    <td align="center">
                        <font color='gold' size='4'><b><i>Novo Valor &nbsp;</i></b></font>
                    </td>
                </tr>

                <tr>
                    <td align="center">
                        <input type="text" name="txtdtsenior" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp="FormataData('frmatual', 'txtdtsenior', event); validata(this)">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i>Gratuidade Sênior</i></b></font>
                        <input type="hidden" name="txtsenior" value="SENIOR">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i><?php echo $VrSenior; ?></i></b></font>
                        <input type="hidden" name="txtvrsenior" value="<?php echo $VrSenior; ?>">
                    </td>
                    <td align="center">
                        <input type="text" name="txtvrseniorn" size="5" maxlength="5" class="campos" onKeyUp="validata(this)">
                    </td>
                </tr>

                <tr>
                    <td align="center">
                        <input type="text" name="txtdtaghata" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp="FormataData('frmatual', 'txtdtaghata', event); validata(this)">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i>Gratuidade Aghata</i></b></font>
                        <input type="hidden" name="txtaghata" value="AGHATA">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i><?php echo $VrAghata; ?></i></b></font>
                        <input type="hidden" name="txtvraghata" value="<?php echo $VrAghata; ?>">
                    </td>
                    <td align="center">
                        <input type="text" name="txtvraghatan" size="5" maxlength="5" class="campos" onKeyUp="validata(this)">
                    </td>
                </tr>

                <tr>
                    <td align="center">
                        <input type="text" name="txtdtrecolh" size="10" maxlength="10" class="campos" value="<?php echo $dtHoje; ?>" onKeyUp="FormataData('frmatual', 'txtdtrecolh', event); validata(this)">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i>Faixa Recolhimento</i></b></font>
                        <input type="hidden" name="txtrecolh" value="RECOLH">
                    </td>
                    <td align="center">
                        <font color='#FFFFFF' size='4'><b><i><?php echo "R$ $VrRecolhF"; ?></i></b></font>
                        <input type="hidden" name="txtvrrecolh" value="<?php echo $VrRecolhF; ?>">
                    </td>
                    <td align="center">
                        <input type="text" name="txtvrrecolhn" size="8" maxlength="8" class="campos" OnKeyUp="FormataValor('frmatual', 'txtvrrecolhn', event); validvalor(this)">
                        <input type="hidden" name="txtuser" value="<?php echo $lg_user; ?>">
                    </td>
                </tr>
        </table><br>

        <table width="100%" border="0" cellspacing="0">
            <tr>
                <td width="9%"><a href="aud.php?c_s=<?php echo $lg_user ?>"><img src="./images/voltar.gif"></a></td>
                <td width="82%" align="center">
                    <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
                    <input type="reset" name="btreset" value="Limpar">
                <td width="9%" align="right"><a href="aud.php?c_s=<?php echo $lg_user; ?>"><img src="./images/voltar.gif"></a>
                </td>
            </tr>
        </table>
        </form><br><br>
    <?php
    } else { ?>
        <br><br><br><br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u>
                        </blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br><br>
        <center><a href='vendback.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center><br><br>
    <?php
    }

    // Encerrando as Conexões
    $SisRot = "S-7.8.1";
    include "rodape.php";
    mysqli_close($conec); ?>

</body>

</html>

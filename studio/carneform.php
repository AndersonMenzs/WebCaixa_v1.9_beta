<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>WebCaixa v1.20.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="./css/style.css">
    <script type="text/javascript" src="./js/script.js" charset="utf-8"></script>
    <script type="text/javascript" src="checkcons.js" charset="utf-8"></script>

</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">

    <?php
    // Inserindo o Cabeçalho
    include "../cabecprs.php" ;

    // Obtendo o Login
    $Sis     = "S7";
	$Rot     = "S7R2.4.1";
	$lg_user = $_REQUEST['c_s'];
        $user = substr($lg_user,0,8);
        $pss  = substr($lg_user,8,40);
    $CodCli = substr($lg_user,48,-11);
    $CPF = substr($lg_user,52,62);
    $dataAtual = time();
    $dataFinal = strtotime('+45 days', $dataAtual);
    $dataFinal_1 = date('d/m/Y', $dataFinal);
    $dataFinal_2 = date('Y-m-d', $dataFinal);

    include "us_sist.php";
    
    if ($ch == 'no')
    {
	    include "us_cad.php";
    } 
	
    // Conectar ao Banco de Dados WebDigital
    include "./conexao_digital.php";
    include "./dbselect_digital.php";
	?>

    <font color="gold" size="6"><br>
        <b>
            <center><u><i>Gerador de Carnê</i></u></center>
        </b>
    </font><br><br><?php

    $ch = 'ok';

  if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok')
    {         
        $sql = "SELECT * FROM fotog WHERE codcli = '$CodCli' AND cpf = '$CPF' ";
        $rs = mysqli_query($conec_digital, $sql) or die ("Erro ao consultar WebDigital. Contate seu administrador.");
        $regs= mysqli_num_rows($rs);
        $ln = mysqli_fetch_array($rs);
        $CodCli     = $ln['codcli'];
        $Modelo     = $ln['modelo'];
        $Cliente    = $ln['cliente'];
        //$Pct_Produto    = $ln['pct_produto'];
        $Pct_Produto    = 'PACOTE FOTOGRÁFICO UNIVERSAL';
        $CPF        = $ln['cpf'];
            $CPFReal    = substr($CPF,0,3). "." .substr($CPF,3,3) . "." . substr($CPF,6,3) . "-" .substr($CPF,9,2);
        $TelFixo    = $ln['telfix'];
            $Tel_Fixo   = "(" . substr($TelFixo,0,2) . ") " . substr($TelFixo,3,4) . "-" . substr($TelFixo,6,4);
        $TelCel     = $ln['telcel'];
            $Tel_Cel    = "(" . substr($TelCel,0,2) . ") " . substr($TelCel,3,4) . "-" . substr($TelCel,6,4);
        $TelRec     = $ln['telrec'];
            $Tel_Rec    = "(" . substr($TelRec,0,2) . ") " . substr($TelRec,3,4) . "-" . substr($TelRec,6,4);
        $vendor       = $ln['operador'];

        ?>
    <table width="75%" border="5" cellpadding="10" cellspacing="0" align="center">
        <form id="carneform" name="carneform" method="post" action="carneimpress1.php?c_s=<?php echo $lg_user; ?>"
            autocomplete="off" OnSubmit="JavaScript:return validarFormulario()">
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Nome Cliente</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" name="txtnome_cli" id="txtnome_cli" size="50" maxlength="50" class="campos"
                        value="<?php echo $Cliente; ?>" onkeypress="fPassaAlfaNumerico('an')"
                        onkeyup='this.value=this.value.toUpperCase(); validNome(this)' disabled>

                    <input type="checkbox" name="txtnome_cli_edit" id="txtnome_cli_edit"
                        onchange="toggleNomeClienteEdit()">
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Nome Modelo</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" name="txtnome_mod" id="txtnome_mod" size="50" maxlength="50" class="campos"
                        value="<?php echo $Modelo; ?>" onkeypress="fPassaAlfaNumerico('an')"
                        onkeyup='this.value=this.value.toUpperCase(); validNome(this)' disabled>

                    <input type="checkbox" name="txtnome_mod_edit" id="txtnome_mod_edit"
                        onchange="toggleNomeModeloEdit()">
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>CPF</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" name="txt_cpf" id="txt_cpf" size="18" maxlength="14" class="campos"
                        value="<?php if (!$CPF == '') { echo $CPFReal; } ?>"
                        onkeyup="FormataCPF('carneform', 'txt_cpf', event)" disabled>
                    <input type="checkbox" name="txtcpf_edit" id="txtcpf_edit" onchange="toggleCpfEdit()">
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Telefones Contatos</i></b></font>
                </td>
                <td width="15%" align="left">
                    <font color='gold' size='4'><b><i>Fixo:</i></b></font>
                    <input type="text" name="txt_tel_fixo" id="txt_tel_fixo" size="13" maxlength="13" class="campos"
                        value="<?php if (!$TelFixo == '') { echo $Tel_Fixo; } ?>" onkeyup='validNumero()'
                        oninput="formatarTelefone('txt_tel_fixo')" disabled>

                    <input type="checkbox" name="txt_tel_fixo_edit" id="txt_tel_fixo_edit"
                        onchange="toggleTelFixoEdit()">&nbsp;&nbsp;&nbsp;

                    <font color='gold' size='4'><b><i>Celular *:</i></b></font>
                    <input type="text" name="txt_cel" id="txt_cel" size="13" maxlength="13" class="campos"
                        value="<?php if (!$TelCel == '') { echo $Tel_Cel; } ?>" onkeyup='validNumero()'
                        oninput="formatarTelefone('txt_cel')" disabled>

                    <input type="checkbox" name="txt_tel_cel_edit" id="txt_tel_cel_edit"
                        onchange="toggleTelCelEdit()">&nbsp;&nbsp;&nbsp;

                    <font color='gold' size='4'><b><i>Recado:</i></b></font>
                    <input type="text" name="txt_rec" id="txt_cel_rec" size="13" maxlength="13" class="campos"
                        value="<?php if (!$TelRec == '') { echo $Tel_Rec; } ?>" onkeyup='validNumero()'
                        oninput="formatarTelefone('txt_cel_rec')" disabled>

                    <input type="checkbox" name="txt_tel_rec_edit" id="txt_tel_rec_edit"
                        onchange="toggleTelCelRecEdit()">
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Nº do Carnê</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="password" id="txt_num_carne" name="txt_num_carne" size="25" maxlength="6"
                        class="campos" onkeyup="showConfirmationInput(this)">
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Pacote Fotográfico</i></b></font>
                </td>
                <td width="40%" align="left">
                    <font color='gold' size='4'><b><i><?php echo $Pct_Produto; ?></i></b></font>
                    <input type="hidden" id="txt_pct_produto" name="txt_pct_produto"
                        value="<?php echo $Pct_Produto; ?>">
                </td>
            </tr>

            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Vlr. Total da Compra R$</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" id="txt_vlr_total" name="txt_vlr_total" size="8" maxlength="8" class="campos"
                        onkeyup='FormataValor("carneform", "txt_vlr_total", event)'>
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Vlr. Entrada R$</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" id="txt_vlr_entr" name="txt_vlr_entr" size="8" maxlength="8" class="campos" 
                        onkeyup="FormataValor('carneform', 'txt_vlr_entr', event)" onblur="validarEntrada();">

                    <input type="radio" name="tipo_pag" id="tipo_pag" value="pg_dinheiro">
                    <font color='gold' size='4'><b><i>Dinheiro</i></b></font>&nbsp;&nbsp;&nbsp;

                    <input type="radio" name="tipo_pag" id="tipo_pag" value="pg_pix">
                    <font color='gold' size='4'><b><i>Pix</i></b></font>&nbsp;&nbsp;&nbsp;

                    <input type="radio" name="tipo_pag" id="tipo_pag" value="pg_cdebito">
                    <font color='gold' size='4'><b><i>C. Débito</i></b></font>&nbsp;&nbsp;&nbsp;

                    <input type="radio" name="tipo_pag" id="tipo_pag" value=pg_ccredito>
                    <font color='gold' size='4'><b><i>C. Crédito</i></b></font>
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Vlr. Prestação</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" id="txt_vlr_prest_ini_1" name="txt_vlr_prest_ini_1" size="8" maxlength="8"
                        class="campos" onkeyup="FormataValor('carneform', 'txt_vlr_prest_ini_1', event)" onblur="calcule_parcelas()">
                    <font color='gold' size='4'><b><i>&nbsp;1º Prestação</i></b></font>&nbsp;&nbsp;&nbsp;

                    <input type="text" id="txt_vlr_prest_ini_2" name="txt_vlr_prest_ini_2" size="8" maxlength="8"
                        class="campos" onkeyup="FormataValor('carneform', 'txt_vlr_prest_ini_2', event)" onblur="calcule_parcelas()">
                    <font color='gold' size='4'><b><i>&nbsp;2º Prestação</i></b></font>
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Quant. de Parcelas</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" id="txt_qtd_parc" name="txt_qtd_parc" max="12" size="2" maxlength="3"
                        class="campos" onkeyup='validarParcelas(this)'>
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <?php
                    // Calcular a data mínima permitida (até 45 dias da data atual)
                    $dataAtual = date('Y-m-d');
                    $dataLimite = date('Y-m-d', strtotime('+45 days', strtotime($dataAtual)));
                    ?>
                    <font color='gold' size='4'><b><i>Dia de Vencimento</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="date" id="txt_venc" name="txt_venc" size="10" maxlength="10" class="campos"
                        onchange='validateDate()' onkeyup='validateDate()' min="<?php echo $dataAtual; ?>"
                        max="<?php echo $dataLimite; ?>">
                    <font color='gold' size='4'><b><i>&nbsp;Prazo máximo para a primeira prestação
                                <?php echo $dataFinal_1; ?>.</i></b></font>
                </td>
            </tr>
            <tr>
                <td width="15%" align="right">
                    <font color='gold' size='4'><b><i>Observação</i></b></font>
                </td>
                <td width="15%" align="left">
                    <input type="text" id="txt_obs" name="txt_obs" size="50" maxlength="200" class="campos"
                        onkeypress="fPassaAlfaNumerico('an')"
                        onkeyup='this.value=this.value.toUpperCase(); validcomplemento(this)'>
                </td>
            </tr>

            <input type="hidden" id="txt_vendor" name="txt_vendor" value="<?php echo $vendor; ?>">

            <table width="100%" border="0" cellspacing="0"><br><br>
                <tr>
                    <td width="9%"><a href="consulta_carne.php?c_s=<?php echo substr($lg_user,0,48); ?>"><img
                                src="./images/voltar.gif"></a>
                    </td>
                    <td width="82%" align="center">
                        <input type="submit" name="btenviar" value="Continuar">&nbsp;&nbsp;
                        <input type="reset" name="btreset" value="Limpar">
                    <td width="9%" align="right"><a href="consulta_carne.php?c_s=<?php echo substr($lg_user,0,48); ?>"><img
                                src="./images/voltar.gif"></a>
                    </td>
                </tr>
            </table>
        </form><?php
    } else { ?><br><br><br><br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>não Autorizado</u></blink>
                        <font color='#FFFFFF'>!!!</center>
            </b></font><br><br><br>
        <center><a href='consulta_carne.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif'></a></center>
        <br><br><?php
	   } ?>

        <script>
        document.getElementById('carneform').addEventListener('submit', function() {
            // Verifica se o checkbox está marcado
            if (!document.getElementById('txtnome_cli_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txtnome_cli').disabled = false;
            }
            if (!document.getElementById('txtnome_mod_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txtnome_mod').disabled = false;
            }
            if (!document.getElementById('txtcpf_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txt_cpf').disabled = false;
            }
            if (!document.getElementById('txt_tel_fixo_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txt_tel_fixo').disabled = false;
            }
            if (!document.getElementById('txt_tel_cel_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txt_cel').disabled = false;
            }
            if (!document.getElementById('txt_tel_rec_edit').checked) {
                // Se não estiver marcado, habilita o campo antes do envio
                document.getElementById('txt_cel_rec').disabled = false;
            }
        });
        </script>

        <?php
    $SisRot = "S-7.2.4.1";
	include "rodape.php"; ?>

</body>

</html>
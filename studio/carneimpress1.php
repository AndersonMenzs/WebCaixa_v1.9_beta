<?php

// Obtendo o Login
$lg_user = $_REQUEST['c_s'];
$user = substr($lg_user, 0, 8);
$pss = substr($lg_user, 8, 40);

function lerPorExtenso($valor)
{
    $unidades = array(
        '',
        'um',
        'dois',
        'três',
        'quatro',
        'cinco',
        'seis',
        'sete',
        'oito',
        'nove',
        'dez',
        'onze',
        'doze',
        'treze',
        'quatorze',
        'quinze',
        'dezesseis',
        'dezessete',
        'dezoito',
        'dezenove'
    );

    $dezenas = array(
        '',
        'vinte',
        'trinta',
        'quarenta',
        'cinquenta',
        'sessenta',
        'setenta',
        'oitenta',
        'noventa'
    );

    $centenas = array(
        '',
        'cento',
        'duzentos',
        'trezentos',
        'quatrocentos',
        'quinhentos',
        'seiscentos',
        'setecentos',
        'oitocentos',
        'novecentos'
    );

    $valorPorExtenso = '';

    // Verifica se o valor é zero
    if ($valor == 0) {
        $valorPorExtenso = 'zero';
    }

    // verifica se o valor é negatino e adiniona "menos" no início
    if ($valor < 0) {
        $valorPorExtenso = 'menos ';
        $valor = abs($valor);
    }

    // Verifica se o valor está na escala dos bilhões
    $bilhoes = floor($valor / 1000000000);

    if ($bilhoes > 0) {
        $valorPorExtenso .= lerPorExtenso($bilhoes) . ' bilhão ';
        $valor %= 1000000000;
    }

    // Verifica se o valor está na escala dos milhões
    $milhoes = floor($valor / 1000000);

    if ($milhoes > 0) {
        $valorPorExtenso .= lerPorExtenso($milhoes) . ' milhão ';
        $valor %= 1000000;
    }

    // Verifica se o valor está na escala dos milhares
    $milhares = floor($valor / 1000);

    if ($milhares > 0) {
        $valorPorExtenso .= lerPorExtenso($milhares) . ' mil ';
        $valor %= 1000;
    }

    // Verifica se o valor está na escala das centenas
    $centena = floor($valor / 100);

    if ($centena > 0) {
        $valorPorExtenso .= lerPorExtenso($centena) . ' ';
        $valor %= 100;
    }

    // Verifica se o valor está na escala das dezenas
    $dezena = floor($valor / 10);

    if ($dezena > 0) {
        // Para dezenas entre 10 e 19, uzamos os valores pré-definidos no array $unidades
        if ($dezena == 1 && $valor % 10 > 0) {
            $valorPorExtenso .= $unidades[$valor % 10] . ' ';
            $valor = 0;
        } else {
            $valorPorExtenso .= $dezenas[$dezena] . ' ';
            $valor %= 10;
        }
    }
    // Verifica se o valor está na escala das unidades
    if ($valor > 0) {
        $valorPorExtenso .= $unidades[$valor] . ' ';
    }

    return trim($valorPorExtenso);
}

// Conexão
include './conexao.php';
include './dblog.php';

// Consultar colaboradora da caixa
$sql_A = "SELECT mat, ape FROM pessoal WHERE mat = '$user' ";
$rs_A = mysqli_query($conec, $sql_A);
$regs_A = mysqli_num_rows($rs_A);
$ln_A = mysqli_fetch_array($rs_A);

$UserCaixa = $ln_A['mat'];
//$UserCaixaApelido = $ln_A['ape'];

$UserCaixa = (string) $UserCaixa;
$UserCaixa = ltrim($UserCaixa, '0');

// Selecionar banco de dados studio
include './dbselect.php';

$sql_B = "SELECT pc FROM inicial";
$rs_B = mysqli_query($conec, $sql_B);
$regs_B = mysqli_num_rows($rs_B);
$ln_B = mysqli_fetch_array($rs_B);

$cod_pc = $ln_B['pc'];

// Conectar ao Banco de Dados WebDigital
include "./conexao_digital.php";
include "./dblog_digital.php";

// Consulta colaboradora de vendas
$vendor = $_POST['txt_vendor'];

$sql_C = "SELECT mat, nome FROM pessoal WHERE mat = '$vendor' ";
$rs_C = mysqli_query($conec_digital, $sql_C);
$regs_C = mysqli_num_rows($rs_C);
$ln_C = mysqli_fetch_array($rs_C);

$UserVenda = $ln_C['mat'];
$UserVendaNome = $ln_C['nome'];

// Formatação do nome do colaborador
$UserVenda = (string) $UserVenda;
$UserVenda = ltrim($UserVenda, '0');
$limite = 10;
$UserVendaNome = substr(ucwords(strtolower($UserVendaNome)), 0, $limite);
$UserVendaNome .= ".";

// Calculo da data da segunda após os dias escolhidos da primeira parcela
$dt_primeira_parcela = $_POST['txt_venc'];
$dt_segunda_parcela = date('d/m/Y', strtotime('+30 days', strtotime($dt_primeira_parcela)));

// Calculos e formatções da entrada, 1ª e 2ª parcelas e demais parcelas
$vlr_total = (float) str_replace(',', '.', str_replace('.', '', $_POST['txt_vlr_total']));
$vlr_entrada = (float) str_replace(',', '.', str_replace('.', '', $_POST['txt_vlr_entr']));
$vlr_restante_1 = $vlr_total - $vlr_entrada;
$vlr_prest_ini_1 = (float) str_replace(',', '.', str_replace('.', '', $_POST['txt_vlr_prest_ini_1']));
$vlr_prest_ini_2 = (float) str_replace(',', '.', str_replace('.', '', $_POST['txt_vlr_prest_ini_2']));
$vlr_restante_2 = $vlr_restante_1 - ($vlr_prest_ini_1 + $vlr_prest_ini_2);
$qtd_parc = $_POST['txt_qtd_parc'] - 2; // Subtrai as parcelas $vlr_prest_ini_1 e $vlr_prest_ini_2
$vlr_prest = round(($vlr_restante_2 / $qtd_parc), 2); // Vlr das prestações restantes

// Dados do Contrato
$dados_contrato = array(
    'nome_produto' => $_POST['txt_pct_produto'],
    'cod_carne' => $_POST['txt_num_carne'],
    'cliente' => $_POST['txtnome_cli'],
    'modelo' => $_POST['txtnome_mod'],
    'endereco_cliente' => 'NULL',
    'cpf_cliente' => $_POST['txt_cpf'],
    'tel_fix_cliente' => $_POST['txt_tel_fixo'],
    'tel_cel_cliente' => $_POST['txt_cel'],
    'tel_rec_cliente' => $_POST['txt_rec'],
    'email_cliente' => 'NULL',
    'empresa' => 'Estrella Photo Studio',
    'endereco_empresa' => 'Rua Alfândega, 323 - 2º andar',
    'cnpj_empresa' => '02.708.080/0001-60',
    'tel_fix_empresa' => '(21) 2221-5200',
    'email_empresa' => 'estrella@estrella.com.br',
    'descricao_produto' => 'NULL',
    'valor_total' => $_POST['txt_vlr_total'],
    'valor_entrada' => $_POST['txt_vlr_entr'],
    'tipo_pagamento' => $_POST['tipo_pag'],
    'vlr_prest_ini_1' => $_POST['txt_vlr_prest_ini_1'],
    'vlr_prest_ini_2' => $_POST['txt_vlr_prest_ini_2'],
    'data_primeira_parcela' => $_POST["txt_venc"],
    'data_segunda_parcela' => $dt_segunda_parcela,
    'valor_restante' => $vlr_restante_2,
    'quant_parcela' => $_POST['txt_qtd_parc'],
    'valor_parcela' => $vlr_prest,
    'prazo_entrega' => '30 dias',
    'local' => 'Centro, Rio de Janeiro',
    'data' => date('d/m/Y'),
    'vendor' => $UserVenda,
    'nome_vendor' => $UserVendaNome,
    'caixa' => $UserCaixa,
    'cod_pc' => $cod_pc,
    'obs' => $_POST['txt_obs']
);

// Condição do tipo de pagamento
if ($dados_contrato['tipo_pagamento'] == 'pg_dinheiro') {
    $tipo_pagamento = 'dinheiro';
} elseif ($dados_contrato['tipo_pagamento'] == 'pg_pix') {
    $tipo_pagamento = 'pix';
} elseif ($dados_contrato['tipo_pagamento'] == 'pg_cdebito') {
    $tipo_pagamento = 'cartão de débito';
} else {
    $tipo_pagamento = 'cartão de crédito';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Photovipp Estúdio e Material Fotográfico Ltda.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="./js/script.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style type="text/css">
        body {
            margin-top: 2%;
            margin-left: 1%;
            margin-right: 1%;
            border: 3px solid gray;
            padding: 10px;
            font-family: sans-serif;
        }

        .campos {
            background-color: #C0C0C0;
            font: 12px sans-serif;
            color: #000000;
        }

        a:link,
        a:visited,
        a:active {
            text-decoration: none;
            color: gold;
        }

        a:hover {
            text-decoration: underline;
            color: #FF0000;
        }

        .espelho-container {
            display: none;
        }
    </style>
</head>

<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0)">
    <?php
    include "../cabecprs.php";
    include "us_sist.php";
    if ($ch == 'no') {
        include "us_cad.php";
    }
    if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
        <br><br>
        <font size='6' color='gold'>
            <b>
                <u>
                    <i>
                        <center>IMPRESSÃO DO ESPELHO DO CARNÊ</center>
                    </i>
                </u>
            </b>
        </font><br><br>

        <table width="90%" border="1" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <th>
                    <font color='gold'>Nome</font>
                </th>
                <th>
                    <font color='gold'>Nº Contrato</font>
                </th>
                <th>
                    <font color='gold'>Pacote</font>
                </th>
                <th>
                    <font color='gold'>Vlr. Total</font>
                </th>
                <th>
                    <font color='gold'>Vlr. Entrada</font>
                </th>
                <th>
                    <font color='gold'>Vlr. 1ª Prest.</font>
                </th>
                <th>
                    <font color='gold'>Vlr. 2ª Prest.</font>
                </th>
                <th>
                    <font color='gold'>Data</font>
                </th>
            </tr>
            <tr>
                <td width="10%" align="center"><b><a href="#" id="impressEspelho"><?php echo $dados_contrato['cliente']; ?></a></b></td>
                <td width=6% align="center"><b><?php echo $dados_contrato['cod_carne']; ?></b></td>
                <td width=10% align="center"><b><?php echo $dados_contrato['nome_produto']; ?></b></td>
                <td width=6% align="center"><b>R$<?php echo $dados_contrato['valor_total']; ?></b></td>
                <td width=6% align="center"><b>R$<?php echo $dados_contrato['valor_entrada']; ?></b></td>
                <td width=6% align="center"><b>R$<?php echo $dados_contrato['vlr_prest_ini_1']; ?></b></td>
                <td width=6% align="center"><b>R$<?php echo $dados_contrato['vlr_prest_ini_2']; ?></b></td>
                <td width=3% align="center">
                    <b><?php echo date("d/m/Y", strtotime($dados_contrato['data_primeira_parcela'])); ?></b>
                </td>
            </tr>
            <?php

            // Convertendo valores para inserção de dados
            $cpf_cliente        = preg_replace('/[^0-9]/', '', $dados_contrato['cpf_cliente']);
            $tel_fix_cliente    = preg_replace('/[^0-9]/', '', $_POST['txt_tel_fixo']);
            $tel_cel_cliente    = preg_replace('/[^0-9]/', '', $_POST['txt_cel']);
            $tel_rec_cliente    = preg_replace('/[^0-9]/', '', $_POST['txt_rec']);

            $data_primeira_parcela  = $dt_primeira_parcela;
            $data_segunda_parcela   = date('Y-m-d', strtotime($dt_primeira_parcela . ' +30 days'));
            ?>

        </table><br><br>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td width="24%">
                    <a href="carneform.php?c_s=<?php echo $lg_user; ?>"><img src="../images/voltar.gif" alt="Voltar"></a>
                </td>
                <td width="52%" align="center"></td>
                <td width="24%" align="right">
                    <a href="carnaform.php?c_s=<?php echo $lg_user; ?>"><img src="../images/voltar.gif" alt="Voltar"></a>
                </td>
            </tr>
        </table><br>

    <?php
    } else { ?>
        <br><br><br>
        <font size='6'><b>
                <center>Acesso <font color='gold'>
                        <blink><u>Não Autorizado</u></blink>
                    </font>!!!
                </center>
            </b></font><br><br><br>
        <center><a href='index.php?c_s=<?php echo $lg_user; ?>'><img src='images/voltar.gif' alt='Voltar'></a></center>
        <br><br>
    <?php
    }

    // Encerrando
    $SisRot = "S-7.5.2";
    include "rodape.php";
    ?>

    <div class="espelho-container">
        <h2>CONTRATO DE FINANCIAMENTO PARA COMPRA DE <?php echo $dados_contrato['nome_produto']; ?></h2>

        <p>NÚMERO DO CONTRATO: <?php echo $dados_contrato['cod_carne']; ?></p>

        <h3>1. PARTES CONTRATANTES:</h3>

        <p><strong>Comprador:</strong></p>
        <ul>
            <li>Nome: <?php echo $dados_contrato['cliente']; ?></li>
            <li>CPF: <?php echo $dados_contrato['cpf_cliente']; ?></li>
            <li>Telefone: <?php echo $dados_contrato['tel_cel_cliente']; ?></li>
        </ul>

        <p><strong>Vendedor:</strong></p>
        <ul>
            <li>Nome: <?php echo $dados_contrato['empresa']; ?></li>
            <li>Endereço: <?php echo $dados_contrato['endereco_empresa']; ?></li>
            <li>CNPJ: <?php echo $dados_contrato['cnpj_empresa']; ?></li>
            <li>Telefone: <?php echo $dados_contrato['tel_fix_empresa']; ?></li>
            <li>E-mail: <?php echo $dados_contrato['email_empresa']; ?></li>
        </ul>

        <h3>2. DESCRIÇÃO DO PRODUTO:</h3>

        <p>O Comprador concorda em adquirir um <?php echo $dados_contrato['nome_produto']; ?>, detalhado como segue:</p>
        <ul>
            <li>Descrição: <?php echo $dados_contrato['descricao_produto']; ?></li>
            <li>Valor Total: R$<?php echo $dados_contrato['valor_total']; ?></li>
        </ul>

        <h3>3. CONDIÇÕES DE PAGAMENTO:</h3>

        <p>O Comprador efetuará um pagamento inicial como entrada no valor de
            R$<?php echo $dados_contrato['valor_entrada']; ?>
            (<?php echo $dados_contrato['valor_extenso_entrada']; ?>) no
            <?php echo $tipo_pagamento; ?> no
            ato
            da assinatura deste contrato. A primeira parcela no valor de
            R$<?php echo $dados_contrato['vlr_prest_ini_1']; ?>
            (<?php echo $dados_contrato['valor_extenso_prest_ini_1']; ?>)
            com vencimento no dia <?php echo date("d/m/Y", strtotime($dados_contrato['data_primeira_parcela'])); ?>
            e a segunda parcela no valor de R$<?php echo $dados_contrato['vlr_prest_ini_2']; ?>
            (<?php echo $dados_contrato['valor_extenso_prest_ini_2']; ?>)
            com vencimento no dia <?php echo date('d/m/Y', strtotime($data_segunda_parcela)); ?> 
            (<?php echo $dados_contrato['valor_extenso_prest_ini_2']; ?>).
            O restante do valor, R$<?php echo number_format($vlr_restante_2, 2, ',', '.'); ?>
            (<?php echo $dados_contrato['valor_extenso_restante']; ?>), será parcelado em
            <?php echo $dados_contrato['quant_parcela']; ?> (<?php echo $dados_contrato['quant_extenso_parcela']; ?>)
            parcelas mensais consecutivas de R$<?php echo number_format($vlr_prest, 2, ',', '.'); ?>
            (<?php echo $dados_contrato['valor_extenso_parcela']; ?>), as demais parcelas nos meses
            subsequentes.</p>

        <h3>4. GARANTIAS:</h3>

        <p>O Vendedor assegura que o <?php echo $dados_contrato['nome_produto']; ?> será entregue em conformidade com as
            especificações acordadas neste contrato. Em caso de não conformidade, o Vendedor compromete-se a corrigir ou
            substituir o produto, conforme acordado pelas partes.</p>

        <h3>5. PRAZO DE ENTREGA:</h3>

        <p>O Vendedor compromete-se a entregar o <?php echo $dados_contrato['nome_produto']; ?> no prazo de
            <?php echo $dados_contrato['prazo_entrega']; ?>, contado a partir da data de confirmação do pagamento da
            entrada.
        </p>

        <h3>6. RESCISÃO:</h3>

        <p>Qualquer das partes poderá rescindir este contrato mediante aviso prévio por escrito, caso a outra parte
            descumpra as
            condições estabelecidas neste documento.</p>

        <h3>7. LEI APLICÁVEL:</h3>

        <p>Este contrato será regido e interpretado de acordo com as leis vigentes do Brasil.</p>

        <p>As partes, de comum acordo, assinam este Contrato de Financiamento em duas vias de igual teor, na presença de
            testemunhas, para que produza os efeitos legais.</p>

        <p><?php echo $dados_contrato['local']; ?>, <?php echo $dados_contrato['data']; ?></p>

        <p>______________________________<br>[Assinatura do Comprador]</p>

        <p>______________________________<br>[Assinatura do Vendedor]</p>

        <p>Testemunhas:</p>

        <p>1. ______________________________<br>
            Nome: <br>
            CPF: </p>

        <p>2. ______________________________<br>
            Nome: <br>
            CPF: </p>
    </div>

    <script>
        document.getElementById('impressEspelho').addEventListener('click', function() {

            // Obtém o conteúdo da espelho-container
            var conteudoParaImprimir = document.querySelector('.espelho-container').innerHTML;

            // Abre uma nova janela para impressão
            var janelaImprimir = window.open('', '_blank');
            janelaImprimir.document.open();
            janelaImprimir.document.write(
                '<html><head><title><?php echo $dados_contrato['cliente']; ?></title></head><body>' +
                conteudoParaImprimir + '</body></html>');
            janelaImprimir.document.close();
            janelaImprimir.print();

            // Pede confirmação ao usuário após a impressão
            var confirmacao = confirm('Os dados estão corretos?');

            // Se o usuário confirmar, executa a inserção no banco de dados
            if (confirmacao) {

                // Construindo a query de inserção
                var queryInsercao =
                    "INSERT INTO contratos_carnes (cod_carne, cpf_cliente, cliente, modelo, endereco_cliente, email_cliente, " +
                    "tel_fix_cliente, tel_cel_cliente, tel_rec_cliente, descricao_produto, nome_produto, vlr_total, vlr_entrada, " +
                    "tipo_pagamento_entrada, vlr_prest_ini_1, vlr_prest_ini_2, vlr_restante, vlr_parcela, qtd_parcela, dt_primeira_parcela, " +
                    "dt_segunda_parcela, prazo_entrega, vendor, nome_vendor, caixa, cod_pc, obs) VALUES (" +
                    "'" + '<?php echo $dados_contrato['cod_carne']; ?>' + "', " +
                    "'" + '<?php echo $cpf_cliente; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['cliente']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['modelo']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['endereco_cliente']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['email_cliente']; ?>' + "', " +
                    "'" + '<?php echo $tel_fix_cliente; ?>' + "', " +
                    "'" + '<?php echo $tel_cel_cliente; ?>' + "', " +
                    "'" + '<?php echo $tel_rec_cliente; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['descricao_produto']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['nome_produto']; ?>' + "', " +
                    "'" + '<?php echo $vlr_total; ?>' + "', " +
                    "'" + '<?php echo $vlr_entrada; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['tipo_pagamento']; ?>' + "', " +
                    "'" + '<?php echo $vlr_prest_ini_1; ?>' + "', " +
                    "'" + '<?php echo $vlr_prest_ini_2; ?>' + "', " +
                    "'" + '<?php echo $vlr_restante_2; ?>' + "', " +
                    "'" + '<?php echo $vlr_prest; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['quant_parcela']; ?>' + "', " +
                    "'" + '<?php echo $data_primeira_parcela; ?>' + "', " +
                    "'" + '<?php echo $data_segunda_parcela; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['prazo_entrega']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['vendor']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['nome_vendor']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['caixa']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['cod_pc']; ?>' + "', " +
                    "'" + '<?php echo $dados_contrato['obs']; ?>' + "')";

                // Envia uma requisição AJAX para o script PHP no servidor
                var xhr = new XMLHttpRequest();
                xhr.open('POST', './carneimpress1_insercao.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // A inserção no banco de dados foi bem-sucedida
                        window.location.href = 'carneimpress2.php?c_s=<?php echo $lg_user; ?>';
                    } else {
                        // Houve um erro na inserção
                        window.location.href = 'carneform.php?c_s=<?php echo $lg_user; ?>';
                    }
                };
                // Envia os dados para o servidor
                xhr.send('query=' + encodeURIComponent(queryInsercao));
            } else {
                // Volta ao carneform para editar novamente
                window.location.href = 'carneform.php?c_s=<?php echo $lg_user; ?>';
            }
        });
    </script>

</body>

</html>
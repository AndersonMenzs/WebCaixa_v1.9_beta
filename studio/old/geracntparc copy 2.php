<?php
// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Funções auxiliares devem ser definidas antes de serem usadas
function formatarMoeda($valor)
{
    return number_format((float)$valor, 2, ',', '.');
}

function calcularTotalPagamento($detalhes)
{
    $total = 0;
    foreach ($detalhes as $detalhe) {
        $total += (float)($detalhe['valor'] ?? 0);
    }
    return $total;
}

// Função principal movida para antes da execução
function gerarHistoricoPagamentos($contrato, $pagamentos, $parcelaInicial, $vrRec)
{
    $html = "=== HISTÓRICO DE PAGAMENTOS ===<br><br>";
    
    $parcela_atual = (int)$parcelaInicial;
    $total_geral_pago = (float)$vrRec;
    $total_parcelas_pagas = (int)($contrato['qtde_parcelas'] ?? 0);
    
    foreach ($pagamentos as $pagamento) {
        $valor_total_pago = calcularTotalPagamento($pagamento['detalhes'] ?? []);
        $total_geral_pago += $valor_total_pago;
        $total_parcelas_pagas += (int)($pagamento['parcelas_pagas'] ?? 0);
        
        $html .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
        $html .= "📅 MÊS {$pagamento['mes']}<br>";
        $html .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
        $html .= "Pagamento de {$pagamento['parcelas_pagas']} parcela(s)<br>";
        $html .= "Valor total pago: R$ " . formatarMoeda($valor_total_pago) . "<br><br>";
        
        // DETALHAMENTO DO PAGAMENTO
        $html .= "DETALHAMENTO DO PAGAMENTO:<br>";
        $html .= "----------------------------------------<br>";
        
        foreach ($pagamento['detalhes'] as $detalhe) {
            $descricao = $detalhe['descricao'] ?? 'Não especificado';
            $forma = $detalhe['forma'] ?? 'N/A';
            $valor = $detalhe['valor'] ?? 0;
            
            $html .= str_pad($descricao . " (" . $forma . "):", 30, ' ') .
                " R$ " . formatarMoeda($valor) . "<br>";
        }
        $html .= "----------------------------------------<br>";
        
        // TOTAIS POR FORMA DE PAGAMENTO
        $totais_forma = [];
        foreach ($pagamento['detalhes'] as $detalhe) {
            $forma = $detalhe['forma'] ?? 'OUTROS';
            if (!isset($totais_forma[$forma])) {
                $totais_forma[$forma] = [
                    'descricao' => $detalhe['descricao'] ?? 'Outros',
                    'total' => 0
                ];
            }
            $totais_forma[$forma]['total'] += (float)($detalhe['valor'] ?? 0);
        }
        
        foreach ($totais_forma as $forma => $dados) {
            $html .= str_pad($dados['descricao'] . ":", 30, ' ') .
                " R$ " . formatarMoeda($dados['total']) . "<br>";
        }
        $html .= "----------------------------------------<br><br>";
        
        // DISTRIBUIÇÃO NAS PARCELAS
        $html .= "DISTRIBUIÇÃO NAS PARCELAS:<br>";
        
        $parcelas_pagas = (int)($pagamento['parcelas_pagas'] ?? 0);
        $valor_parcela = (float)($contrato['valor_parcela'] ?? 0);
        
        for ($i = 0; $i < $parcelas_pagas; $i++) {
            $num_parcela = $parcela_atual + $i;
            $html .= "Parcela $num_parcela: ";
            
            $composicao = [];
            foreach ($pagamento['detalhes'] as $detalhe) {
                $valor_detalhe = (float)($detalhe['valor'] ?? 0);
                if ($parcelas_pagas > 0) {
                    $valor_por_parcela = $valor_detalhe / $parcelas_pagas;
                    $composicao[] = ($detalhe['forma'] ?? 'N/A') .
                        " R$ " . formatarMoeda($valor_por_parcela);
                }
            }
            
            $html .= implode(" + ", $composicao) .
                " = R$ " . formatarMoeda($valor_parcela) . "<br>";
        }
        
        $parcela_atual += $parcelas_pagas;
        $html .= "<br>";
    }
    
    echo $html;
    
    return [
        'total_pago' => $total_geral_pago,
        'parcelas_pagas' => $total_parcelas_pagas
    ];
}
?>
<html>
<head>
    <title>WebCaixa v1.19_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 5%;
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
    
    <?php
    // Inserindo Cabeçalho
    $caminho_cabecalho = "../cabecprs.php";
    if (file_exists($caminho_cabecalho)) {
        include $caminho_cabecalho;
    }
    ?>
</head>
<body background="../images/bg1.jpg" text="#FFFFFF">
    <?php
    // Validação inicial
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("<font color='red'>Acesso inválido!</font>");
    }
    
    // Importando os Dados do Formulário com validação
    $dados = filter_input_array(INPUT_POST, [
        'txtuser' => FILTER_SANITIZE_STRING,
        'mat_vend' => FILTER_SANITIZE_STRING,
        'vendedora' => FILTER_SANITIZE_STRING,
        'cliente' => FILTER_SANITIZE_STRING,
        'txtsen' => FILTER_SANITIZE_STRING,
        'txtdoc' => FILTER_SANITIZE_STRING,
        'lsPr1' => FILTER_SANITIZE_STRING,
        'lsPr2' => FILTER_SANITIZE_STRING,
        'lsPr3' => FILTER_SANITIZE_STRING,
        'txt1' => ['filter' => FILTER_VALIDATE_FLOAT, 'options' => ['default' => 0]],
        'txt2' => ['filter' => FILTER_VALIDATE_FLOAT, 'options' => ['default' => 0]],
        'txt3' => ['filter' => FILTER_VALIDATE_FLOAT, 'options' => ['default' => 0]],
        'vrprest' => FILTER_SANITIZE_STRING,
        'qtdeparc' => ['filter' => FILTER_VALIDATE_INT, 'options' => ['default' => 1, 'min_range' => 1]],
        'txtparc_ini' => ['filter' => FILTER_VALIDATE_INT, 'options' => ['default' => 1]],
        'txtparc_ult' => FILTER_SANITIZE_STRING,
        'parc_card_cred' => FILTER_SANITIZE_STRING,
        'ref_std' => FILTER_SANITIZE_STRING,
        'vrentr' => ['filter' => FILTER_VALIDATE_FLOAT, 'options' => ['default' => 0]]
    ]);
    
    // Atribuição dos valores com operador de coalescência nula
    $Sis       = "S7";
    $Rot       = "S7R2.2.1.1";
    $lg_user   = trim($dados['txtuser'] ?? '');
    $user      = substr($lg_user, 0, 8);
    $pss       = substr($lg_user, 8, 40);
    
    $Mat_Vend = trim($dados['mat_vend'] ?? '');
    $Vendedora_full = trim($dados['vendedora'] ?? '');
    $Vendedora = $Vendedora_full;
    $Cliente   = trim($dados['cliente'] ?? '');
    $rdAut     = 'c';
    $Pass      = strtolower(trim($dados['txtsen'] ?? ''));
    $Senha     = sha1($Pass);
    
    $dtRec     = date('Y-m-d');
    $dtComp    = date('Y-m-d');
    $hora      = date('H:i');
    
    $NDoc      = trim($dados['txtdoc'] ?? '');
    $NDoc_a    = $NDoc;
    
    $FPag_1    = trim($dados['lsPr1'] ?? '');
    $FPag_2    = trim($dados['lsPr2'] ?? '');
    $FPag_3    = trim($dados['lsPr3'] ?? '');
    
    $txt1 = (float)($dados['txt1'] ?? 0);
    $txt2 = (float)($dados['txt2'] ?? 0);
    $txt3 = (float)($dados['txt3'] ?? 0);
    
    $VrPrest  = (float)trim($dados['vrprest'] ?? 0);
    $VrEntr   = (float)($dados['vrentr'] ?? 0);
    $VrRec = $txt1 + $txt2 + $txt3;
    $VrRecF    = number_format($VrRec, 2, ',', '.');
    
    $QtdeParc  = (int)($dados['qtdeparc'] ?? 1);
    $Parc      = (float)trim($dados['vrprest'] ?? 0);
    $PIni      = (int)($dados['txtparc_ini'] ?? 1);
    $PUlt      = trim($dados['txtparc_ult'] ?? '');
    $Parc_card_cred = trim($dados['parc_card_cred'] ?? '');
    $ref_std = trim($dados['ref_std'] ?? '');
    
    // Calcular parcela final (vlrec)
    $VlRec = $VrRec; // Valor total do recebimento
    
    // Truncar o nome da vendedora
    if (!empty($Vendedora)) {
        $Vendedora = strtoupper($Vendedora);
        $primeiro_espaco = strpos($Vendedora, ' ');
        if ($primeiro_espaco !== false) {
            $Vendedora = substr($Vendedora, 0, $primeiro_espaco + 1) .
                substr($Vendedora, $primeiro_espaco + 1, 1) . '.';
        }
    }
    
    // Variáveis
    $TipoRec   = '3';
    $SubTipo   = 'CNTP';
    $DataHoje = date('Y-m-d');
    
    // Inclusão de arquivos com verificação de existência
    $caminho_conexao = "conexao.php";
    $caminho_dbselect = "dbselect.php";
    $caminho_us_cad = "us_cad.php";
    
    if (file_exists($caminho_conexao)) {
        include $caminho_conexao;
    } else {
        die("Erro: Arquivo de conexão não encontrado!");
    }
    
    if (file_exists($caminho_dbselect)) {
        include $caminho_dbselect;
    }
    
    // Inicializar $Reg
    $Reg = 0;
    
    // Obtendo Dados - COM PREPARED STATEMENT
    if (isset($conec)) {
        $sqlo = "SELECT * FROM operador WHERE pass = ?";
        $stmt = mysqli_prepare($conec, $sqlo);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $Senha);
            mysqli_stmt_execute($stmt);
            $rso = mysqli_stmt_get_result($stmt);
            $regso = mysqli_num_rows($rso);
        } else {
            $regso = 0;
        }
    } else {
        $regso = 0;
    }
    ?>
    
    <font color="gold" size="6">
        <br><b>
            <center><u><i>Sistema de Autenticação</i></u></center>
        </b>
    </font><br>
    
    <?php
    // Inclusão condicional do us_cad.php
    if (file_exists($caminho_us_cad)) {
        include $caminho_us_cad;
    }
    
    if (isset($ch) && in_array($ch, ['ok', 'ok-enc', 'ok-cai', 'ok-adm'])) {
        if ($regso > 0 && isset($rso)) {
            $lno  = mysqli_fetch_array($rso);
            $Mat = $lno['mat'];
            
            // Sanitizar a matrícula lida do banco: manter apenas dígitos e garantir 8 caracteres
            $MatClean = preg_replace('/\D/', '', $Mat);
            $MatClean = str_pad($MatClean, 8, '0', STR_PAD_LEFT);
            
            // Fechar o statement após usar
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }

            // Gravando o Registro - BUSCAR ÚLTIMO REGISTRO
            $sqlr = "SELECT * FROM registro ORDER BY datarec DESC, reg DESC LIMIT 1";
            $rsr  = mysqli_query($conec, $sqlr);
            
            if (!$rsr) {
                die("File geracntparc Error #1. Contate seu Administrador. Erro: " . mysqli_error($conec));
            }
            
            $regsr = mysqli_num_rows($rsr);
            
            if ($regsr > 0) {
                $lnr = mysqli_fetch_array($rsr);
                $Reg     = (int)$lnr['reg'];
                $dtReceb = $lnr['datarec'];
                
                if ($dtComp != $dtReceb) {
                    $Reg = 0;
                }
            } else {
                $Reg = 0;
            }
            
            // IMPORTANTE: Guardar o valor original de PIni para o histórico
            $PIniOriginal = $PIni;
            
            // Calcular valor por parcela
            $valorPorParcela = $QtdeParc > 0 ? $VlRec / $QtdeParc : 0;
            
            // Gravar no banco de dados
            if ($rdAut == 'c') {
                // COM AUTENTICAÇÃO
                for ($K = 1; $K <= $QtdeParc; $K++) {
                    $Reg++;
                    
                    // Array para armazenar as formas de pagamento não vazias
                    $formasPagamento = [];
                    if ($FPag_1 != "00" && $FPag_1 != "") $formasPagamento[] = $FPag_1;
                    if ($FPag_2 != "00" && $FPag_2 != "") $formasPagamento[] = $FPag_2;
                    if ($FPag_3 != "00" && $FPag_3 != "") $formasPagamento[] = $FPag_3;
                    
                    // Se não houver nenhuma forma de pagamento, pular
                    if (empty($formasPagamento)) {
                        continue;
                    }
                    
                    foreach ($formasPagamento as $forma) {
                        // Calcular o valor proporcional para esta forma de pagamento
                        $valorForma = 0;
                        if ($forma == $FPag_1) $valorForma = $txt1;
                        if ($forma == $FPag_2) $valorForma = $txt2;
                        if ($forma == $FPag_3) $valorForma = $txt3;
                        
                        // Valor por parcela para esta forma
                        $valorPorParcelaForma = $QtdeParc > 0 ? $valorForma / $QtdeParc : 0;
                        
                        // Usar prepared statement para segurança
                        $sqlGr = "INSERT INTO registro (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno, mat_vend, vendedora, cliente) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt_gr = mysqli_prepare($conec, $sqlGr);
                        
                        if ($stmt_gr) {
                            $estorno = '0'; // Valor padrão para não estornado
                            
                            mysqli_stmt_bind_param($stmt_gr, "issssisssdssss", 
                                $Reg,                    // reg
                                $NDoc,                   // numdoc
                                $TipoRec,                // tiporec
                                $SubTipo,                // subtipo
                                $forma,                  // modpgto
                                $PIni,                   // parcela
                                $dtRec,                  // datarec
                                $hora,                   // horarec
                                $valorPorParcelaForma,   // vlrec (valor por parcela)
                                $MatClean,               // operador
                                $estorno,                // estorno
                                $Mat_Vend,               // mat_vend
                                $Vendedora_full,         // vendedora
                                $Cliente                 // cliente
                            );
                            
                            $result = mysqli_stmt_execute($stmt_gr);
                            
                            if (!$result) {
                                echo "<font color='red'>Erro ao inserir registro: " . mysqli_stmt_error($stmt_gr) . "</font><br>";
                            }
                            
                            mysqli_stmt_close($stmt_gr);
                        } else {
                            echo "<font color='red'>Erro ao preparar statement: " . mysqli_error($conec) . "</font><br>";
                        }
                    }
                    
                    // Criando o spool
                    $RegFull  = 10000 + $Reg;
                    $RegSp    = substr($RegFull, 1, 4);
                    
                    // Buscar PC
                    $sqlPC  = "SELECT pc FROM inicial LIMIT 1";
                    $rsPC   = mysqli_query($conec, $sqlPC);
                    
                    if (!$rsPC) {
                        die("File geracntparc Error #3. Contate seu Administrador. Erro: " . mysqli_error($conec));
                    }
                    
                    $lnPC   = mysqli_fetch_array($rsPC);
                    $PCSp   = $lnPC['pc'] ?? '0000';
                    
                    $hSp     = substr($hora, 0, 2);
                    $mSp     = substr($hora, 3, 2);
                    $HoraSp  = $hSp . $mSp;
                    $NDocSp  = $NDoc;
                    $dtAutSp = date('dmy');
                    $VrTot   = $VlRec;
                    
                    // Evitar divisão por zero
                    if ($QtdeParc > 0) {
                        $PParc   = number_format($VrTot / $QtdeParc, 2, ',', '');
                        $PParcUlt = number_format($VrTot - (($QtdeParc - 1) * ($VrTot / $QtdeParc)), 2, ',', '');
                    } else {
                        $PParc = number_format(0, 2, ',', '');
                        $PParcUlt = number_format(0, 2, ',', '');
                    }
                    
                    $ParcSp  = "R$ " . $PParc;
                    $PParcUltF = "R$ " . $PParcUlt;
                    
                    // Buscar sigla do tipo de recebimento
                    $sqlSg  = "SELECT siglarec FROM tiporec WHERE codrec = ? LIMIT 1";
                    $stmt_sg = mysqli_prepare($conec, $sqlSg);
                    $SgRecSp = '';
                    
                    if ($stmt_sg) {
                        mysqli_stmt_bind_param($stmt_sg, "s", $TipoRec);
                        mysqli_stmt_execute($stmt_sg);
                        $rsSg = mysqli_stmt_get_result($stmt_sg);
                        $lnSg = mysqli_fetch_array($rsSg);
                        $SgRecSp = $lnSg['siglarec'] ?? '';
                        mysqli_stmt_close($stmt_sg);
                    }
                    
                    // Buscar sigla da forma de pagamento
                    $FmRec_a = '';
                    if (!empty($formasPagamento)) {
                        $sqlFm = "SELECT siglapag FROM formapag WHERE codpag = ? AND codpag <> '---' LIMIT 1";
                        $stmt_fm = mysqli_prepare($conec, $sqlFm);
                        
                        if ($stmt_fm) {
                            mysqli_stmt_bind_param($stmt_fm, "s", $formasPagamento[0]);
                            mysqli_stmt_execute($stmt_fm);
                            $rsFm = mysqli_stmt_get_result($stmt_fm);
                            $lnFm = mysqli_fetch_assoc($rsFm);
                            $FmRec_a = $lnFm['siglapag'] ?? '';
                            mysqli_stmt_close($stmt_fm);
                        }
                    }
                    
                    // Formatar matrícula para spool
                    $MatRec = '';
                    if (strlen($MatClean) >= 8) {
                        $MatRec = substr($MatClean, 1, 6) . "-" . substr($MatClean, 7, 1);
                    }
                    
                    $Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $ParcSp . $SgRecSp . $FmRec_a . $MatRec;
                    
                    // Inserir spool
                    $sqlSp1 = "INSERT INTO spool (reg, spo) VALUES (?, ?)";
                    $stmt_sp1 = mysqli_prepare($conec, $sqlSp1);
                    if ($stmt_sp1) {
                        mysqli_stmt_bind_param($stmt_sp1, "ss", $RegSp, $Spo);
                        mysqli_stmt_execute($stmt_sp1);
                        mysqli_stmt_close($stmt_sp1);
                    }
                    
                    $sqlSp2 = "INSERT INTO spool2 (reg, spo) VALUES (?, ?)";
                    $stmt_sp2 = mysqli_prepare($conec, $sqlSp2);
                    if ($stmt_sp2) {
                        mysqli_stmt_bind_param($stmt_sp2, "ss", $RegSp, $Spo);
                        mysqli_stmt_execute($stmt_sp2);
                        mysqli_stmt_close($stmt_sp2);
                    }
                    
                    $PIni++;
                }
            } else {
                // SEM AUTENTICAÇÃO
                $Reg++;
                
                for ($K = 1; $K <= $QtdeParc; $K++) {
                    // Array para armazenar as formas de pagamento não vazias
                    $formasPagamento = [];
                    if ($FPag_1 != "00" && $FPag_1 != "") $formasPagamento[] = $FPag_1;
                    if ($FPag_2 != "00" && $FPag_2 != "") $formasPagamento[] = $FPag_2;
                    if ($FPag_3 != "00" && $FPag_3 != "") $formasPagamento[] = $FPag_3;
                    
                    if (empty($formasPagamento)) {
                        continue;
                    }
                    
                    foreach ($formasPagamento as $forma) {
                        // Calcular o valor proporcional para esta forma de pagamento
                        $valorForma = 0;
                        if ($forma == $FPag_1) $valorForma = $txt1;
                        if ($forma == $FPag_2) $valorForma = $txt2;
                        if ($forma == $FPag_3) $valorForma = $txt3;
                        
                        // Valor por parcela para esta forma
                        $valorPorParcelaForma = $QtdeParc > 0 ? $valorForma / $QtdeParc : 0;
                        
                        $sqlGr = "INSERT INTO registro (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno, mat_vend, vendedora, cliente) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt_gr = mysqli_prepare($conec, $sqlGr);
                        
                        if ($stmt_gr) {
                            $estorno = '0';
                            
                            mysqli_stmt_bind_param($stmt_gr, "issssisssdssss", 
                                $Reg,                    // reg
                                $NDoc,                   // numdoc
                                $TipoRec,                // tiporec
                                $SubTipo,                // subtipo
                                $forma,                  // modpgto
                                $PIni,                   // parcela
                                $dtRec,                  // datarec
                                $hora,                   // horarec
                                $valorPorParcelaForma,   // vlrec (valor por parcela)
                                $MatClean,               // operador
                                $estorno,                // estorno
                                $Mat_Vend,               // mat_vend
                                $Vendedora_full,         // vendedora
                                $Cliente                 // cliente
                            );
                            
                            $result = mysqli_stmt_execute($stmt_gr);
                            
                            if (!$result) {
                                echo "<font color='red'>Erro ao inserir registro: " . mysqli_stmt_error($stmt_gr) . "</font><br>";
                            }
                            
                            mysqli_stmt_close($stmt_gr);
                        }
                    }
                    
                    $PIni++;
                }
                
                // Criando o spool (apenas uma vez)
                $RegFull  = 10000 + $Reg;
                $RegSp    = substr($RegFull, 1, 4);
                
                $sqlPC  = "SELECT pc FROM inicial LIMIT 1";
                $rsPC   = mysqli_query($conec, $sqlPC);
                
                if (!$rsPC) {
                    die("File geracntparc Error #9. Contate seu Administrador. Erro: " . mysqli_error($conec));
                }
                
                $lnPC   = mysqli_fetch_array($rsPC);
                $PCSp   = $lnPC['pc'] ?? '0000';
                
                $hSp     = substr($hora, 0, 2);
                $mSp     = substr($hora, 3, 2);
                $HoraSp  = $hSp . $mSp;
                $NDocSp  = $NDoc;
                $dtAutSp = date('dmy');
                $VrEntrF = number_format($VrEntr, 2, ',', '');
                
                if (strlen($VrEntrF) < 7) {
                    $VrEntrSp   = "R$ " . $VrEntrF;
                } else {
                    $VrEntrSp   = "R$" . $VrEntrF;
                }
                
                // Buscar sigla do tipo de recebimento
                $sqlSg  = "SELECT siglarec FROM tiporec WHERE codrec = ? LIMIT 1";
                $stmt_sg = mysqli_prepare($conec, $sqlSg);
                $SgRecSp = '';
                
                if ($stmt_sg) {
                    mysqli_stmt_bind_param($stmt_sg, "s", $TipoRec);
                    mysqli_stmt_execute($stmt_sg);
                    $rsSg = mysqli_stmt_get_result($stmt_sg);
                    $lnSg = mysqli_fetch_array($rsSg);
                    $SgRecSp = $lnSg['siglarec'] ?? '';
                    mysqli_stmt_close($stmt_sg);
                }
                
                // Usar a primeira forma de pagamento para o spool
                $FPag = $FPag_1;
                $sqlSgpag  = "SELECT siglapag FROM formapag WHERE codpag = ? LIMIT 1";
                $stmt_sgpag = mysqli_prepare($conec, $sqlSgpag);
                $FmRecSp = '';
                
                if ($stmt_sgpag) {
                    mysqli_stmt_bind_param($stmt_sgpag, "s", $FPag);
                    mysqli_stmt_execute($stmt_sgpag);
                    $rsSgpag = mysqli_stmt_get_result($stmt_sgpag);
                    $lnSgpag = mysqli_fetch_array($rsSgpag);
                    $FmRecSp = $lnSgpag['siglapag'] ?? '';
                    mysqli_stmt_close($stmt_sgpag);
                }
                
                // Reduzindo a Matrícula para spool
                $MatRecSp = '';
                if (strlen($MatClean) >= 8) {
                    $MatRecSp = substr($MatClean, 1, 6) . "-" . substr($MatClean, 7, 1);
                }
                
                $Spo = $RegSp . $PCSp . $HoraSp . $NDocSp . $dtAutSp . $VrEntrSp . $SgRecSp . $FmRecSp . $MatRecSp;
                
                $sqlSp1 = "INSERT INTO spool (reg, spo) VALUES (?, ?)";
                $stmt_sp1 = mysqli_prepare($conec, $sqlSp1);
                if ($stmt_sp1) {
                    mysqli_stmt_bind_param($stmt_sp1, "ss", $RegSp, $Spo);
                    mysqli_stmt_execute($stmt_sp1);
                    mysqli_stmt_close($stmt_sp1);
                }
                
                $sqlSp2 = "INSERT INTO spool2 (reg, spo) VALUES (?, ?)";
                $stmt_sp2 = mysqli_prepare($conec, $sqlSp2);
                if ($stmt_sp2) {
                    mysqli_stmt_bind_param($stmt_sp2, "ss", $RegSp, $Spo);
                    mysqli_stmt_execute($stmt_sp2);
                    mysqli_stmt_close($stmt_sp2);
                }
            }
            
            // Exibir o histórico de pagamentos (usar PIniOriginal)
            $contrato = [
                'total' => $VlRec,
                'qtde_parcelas' => $QtdeParc,
                'valor_parcela' => $QtdeParc > 0 ? $VlRec / $QtdeParc : 0
            ];
            
            $pagamentos = []; // Resetar array
            $pagamentos[] = [
                'mes' => (int)date('n'),
                'parcelas_pagas' => $QtdeParc,
                'detalhes' => [
                    ['forma' => $FPag_1, 'descricao' => 'Dinheiro', 'valor' => $txt1],
                    ['forma' => $FPag_2, 'descricao' => 'Cartão Débito', 'valor' => $txt2],
                    ['forma' => $FPag_3, 'descricao' => 'Cartão Crédito Parc. Loja', 'valor' => $txt3]
                ]
            ];
            
            // Gerar extrato completo
            $resumo = gerarHistoricoPagamentos($contrato, $pagamentos, $PIniOriginal, $VlRec);
            
            echo "<br><font color='green' size='4'><b>Contrato gerado com sucesso! Registro: $Reg</b></font><br>";
            
        } else {
            echo "<font color='red'>Erro: Usuário não autorizado!</font>";
        }
    } else {
        echo "<font color='red'>Acesso negado!</font>";
    }
    
    // Encerrando a Conexão
    if (isset($conec)) {
        mysqli_close($conec);
    }
    
    // Inserindo Rodapé
    $SisRot = "S-7.2.2.1.1";
    $caminho_rodape = "./rodape.php";
    if (file_exists($caminho_rodape)) {
        include $caminho_rodape;
    }
    ?>
    
    <script src="./js/ghost_click.js"></script>
    
</body>
</html>
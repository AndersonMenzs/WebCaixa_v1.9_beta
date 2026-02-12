<?php
// ========== DADOS DO CONTRATO ==========
$contrato = [
    'total' => 300.00,
    'qtde_parcelas' => 10,
    'valor_parcela' => 300.00 / 10
];

// ========== ARRAY DE PAGAMENTOS ==========
$pagamentos = [];

// MÊS 1 - Pagou 1 parcela
$pagamentos[] = [
    'mes' => 1,
    'parcelas_pagas' => 1,
    'detalhes' => [
        ['forma' => 'DIN', 'descricao' => 'Dinheiro', 'valor' => 10.00],
        ['forma' => 'CD', 'descricao' => 'Cartão Débito', 'valor' => 10.00],
        ['forma' => 'CC', 'descricao' => 'Cartão Crédito', 'valor' => 10.00]
    ]
];

// MÊS 2 - Pagou 4 parcelas
$pagamentos[] = [
    'mes' => 2,
    'parcelas_pagas' => 4,
    'detalhes' => [
        ['forma' => 'DIN', 'descricao' => 'Dinheiro', 'valor' => 50.00],
        ['forma' => 'CC', 'descricao' => 'Cartão Crédito', 'valor' => 50.00],
        ['forma' => 'CD', 'descricao' => 'Cartão Débito', 'valor' => 20.00]
    ]
];

// MÊS 3 - Pagou 2 parcelas (exemplo)
$pagamentos[] = [
    'mes' => 3,
    'parcelas_pagas' => 2,
    'detalhes' => [
        ['forma' => 'PIX', 'descricao' => 'PIX', 'valor' => 40.00],
        ['forma' => 'DIN', 'descricao' => 'Dinheiro', 'valor' => 20.00]
    ]
];

// ========== FUNÇÕES ==========

function formatarMoeda($valor) {
    return number_format($valor, 2, ',', '.');
}

function calcularTotalPagamento($detalhes) {
    $total = 0;
    foreach ($detalhes as $detalhe) {
        $total += $detalhe['valor'];
    }
    return $total;
}

function gerarExtratoContrato($contrato, $pagamentos) {
    echo "=== EXTRATO DO CONTRATO ===<br>";
    echo "Valor total: R$ " . formatarMoeda($contrato['total']) . "<br>";
    echo "Parcelas: {$contrato['qtde_parcelas']}x de R$ " . formatarMoeda($contrato['valor_parcela']) . "<br><br>";
}

function gerarHistoricoPagamentos($contrato, $pagamentos) {
    echo "=== HISTÓRICO DE PAGAMENTOS ===<br><br>";
    
    $parcela_atual = 1;
    $total_geral_pago = 0;
    $total_parcelas_pagas = 0;
    
    foreach ($pagamentos as $pagamento) {
        $valor_total_pago = calcularTotalPagamento($pagamento['detalhes']);
        $total_geral_pago += $valor_total_pago;
        $total_parcelas_pagas += $pagamento['parcelas_pagas'];
        
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
        echo "📅 MÊS {$pagamento['mes']}<br>";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
        echo "Pagamento de {$pagamento['parcelas_pagas']} parcela(s)<br>";
        echo "Valor total pago: R$ " . formatarMoeda($valor_total_pago) . "<br><br>";
        
        // DETALHAMENTO DO PAGAMENTO
        echo "DETALHAMENTO DO PAGAMENTO:<br>";
        echo "----------------------------------------<br>";
        
        foreach ($pagamento['detalhes'] as $detalhe) {
            echo str_pad($detalhe['descricao'] . " (" . $detalhe['forma'] . "):", 30) . 
                 " R$ " . formatarMoeda($detalhe['valor']) . "<br>";
        }
        echo "----------------------------------------<br>";
        
        // TOTAIS POR FORMA DE PAGAMENTO
        $totais_forma = [];
        foreach ($pagamento['detalhes'] as $detalhe) {
            $forma = $detalhe['forma'];
            if (!isset($totais_forma[$forma])) {
                $totais_forma[$forma] = [
                    'descricao' => $detalhe['descricao'],
                    'total' => 0
                ];
            }
            $totais_forma[$forma]['total'] += $detalhe['valor'];
        }
        
        foreach ($totais_forma as $forma => $dados) {
            echo str_pad($dados['descricao'] . ":", 30) . 
                 " R$ " . formatarMoeda($dados['total']) . "<br>";
        }
        echo "----------------------------------------<br><br>";
        
        // DISTRIBUIÇÃO NAS PARCELAS
        echo "DISTRIBUIÇÃO NAS PARCELAS:<br>";
        
        for ($i = 0; $i < $pagamento['parcelas_pagas']; $i++) {
            $num_parcela = $parcela_atual + $i;
            echo "Parcela $num_parcela: ";
            
            $composicao = [];
            foreach ($pagamento['detalhes'] as $detalhe) {
                $valor_por_parcela = $detalhe['valor'] / $pagamento['parcelas_pagas'];
                $composicao[] = $detalhe['forma'] . " R$ " . formatarMoeda($valor_por_parcela);
            }
            
            echo implode(" + ", $composicao) . 
                 " = R$ " . formatarMoeda($contrato['valor_parcela']) . "<br>";
        }
        
        $parcela_atual += $pagamento['parcelas_pagas'];
        echo "<br>";
    }
    
    return [
        'total_pago' => $total_geral_pago,
        'parcelas_pagas' => $total_parcelas_pagas
    ];
}

function gerarFechamentoCaixa($pagamentos) {
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "=== FECHAMENTO DO CAIXA POR MÊS ===<br>";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br><br>";
    
    foreach ($pagamentos as $pagamento) {
        echo "📆 MÊS {$pagamento['mes']}<br>";
        echo "----------------------------------------<br>";
        
        $totais_mes = [];
        foreach ($pagamento['detalhes'] as $detalhe) {
            $forma = $detalhe['forma'];
            if (!isset($totais_mes[$forma])) {
                $totais_mes[$forma] = [
                    'descricao' => $detalhe['descricao'],
                    'total' => 0
                ];
            }
            $totais_mes[$forma]['total'] += $detalhe['valor'];
        }
        
        foreach ($totais_mes as $forma => $dados) {
            echo str_pad($dados['descricao'] . ":", 30) . 
                 " R$ " . formatarMoeda($dados['total']) . "<br>";
        }
        echo "----------------------------------------<br>";
        echo "TOTAL DO DIA: R$ " . formatarMoeda(calcularTotalPagamento($pagamento['detalhes'])) . "<br><br>";
    }
}

function gerarResumoContrato($contrato, $total_pago, $parcelas_pagas) {
    $saldo_devedor = $contrato['total'] - $total_pago;
    $parcelas_restantes = $contrato['qtde_parcelas'] - $parcelas_pagas;
    $percentual_pago = ($total_pago / $contrato['total']) * 100;
    
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "=== RESUMO DO CONTRATO ===<br>";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "✅ Parcelas pagas: $parcelas_pagas de {$contrato['qtde_parcelas']}<br>";
    echo "💰 Total pago: R$ " . formatarMoeda($total_pago) . "<br>";
    echo "📊 Saldo devedor: R$ " . formatarMoeda($saldo_devedor) . "<br>";
    echo "⏳ Parcelas restantes: $parcelas_restantes<br>";
    echo "📈 Percentual pago: " . number_format($percentual_pago, 1) . "%<br>";
}

function gerarEvolucaoMensal($pagamentos, $contrato) {
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "=== EVOLUÇÃO MENSAL ===<br>";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "----------------------------------------<br>";
    
    $acumulado = 0;
    foreach ($pagamentos as $pagamento) {
        $valor_pago = calcularTotalPagamento($pagamento['detalhes']);
        $acumulado += $valor_pago;
        $percentual = ($acumulado / $contrato['total']) * 100;
        
        echo "Mês {$pagamento['mes']}: R$ " . formatarMoeda($valor_pago) . 
             " | Acumulado: R$ " . formatarMoeda($acumulado) . 
             " | " . number_format($percentual, 1) . "%<br>";
    }
}

function gerarRelatorioFormasPagamento($pagamentos) {
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    echo "=== TOTAL POR FORMA DE PAGAMENTO ===<br>";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    
    $totais_gerais = [];
    foreach ($pagamentos as $pagamento) {
        foreach ($pagamento['detalhes'] as $detalhe) {
            $forma = $detalhe['forma'];
            if (!isset($totais_gerais[$forma])) {
                $totais_gerais[$forma] = [
                    'descricao' => $detalhe['descricao'],
                    'total' => 0
                ];
            }
            $totais_gerais[$forma]['total'] += $detalhe['valor'];
        }
    }
    
    echo "----------------------------------------<br>";
    foreach ($totais_gerais as $forma => $dados) {
        echo str_pad($dados['descricao'] . " (" . $forma . "):", 30) . 
             " R$ " . formatarMoeda($dados['total']) . "<br>";
    }
    echo "----------------------------------------<br>";
}

// ========== EXECUTAR ==========

// Gerar extrato completo
gerarExtratoContrato($contrato, $pagamentos);
$resumo = gerarHistoricoPagamentos($contrato, $pagamentos);
gerarFechamentoCaixa($pagamentos);
gerarResumoContrato($contrato, $resumo['total_pago'], $resumo['parcelas_pagas']);
gerarEvolucaoMensal($pagamentos, $contrato);
gerarRelatorioFormasPagamento($pagamentos);

// ========== SIMULAÇÃO DE NOVO PAGAMENTO ==========
echo "<br><br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
echo "=== SIMULAÇÃO DE NOVO PAGAMENTO ===<br>";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";

$novo_pagamento = [
    'mes' => 4,
    'parcelas_pagas' => 3,
    'detalhes' => [
        ['forma' => 'DIN', 'descricao' => 'Dinheiro', 'valor' => 30.00],
        ['forma' => 'PIX', 'descricao' => 'PIX', 'valor' => 40.00],
        ['forma' => 'CC', 'descricao' => 'Cartão Crédito', 'valor' => 20.00]
    ]
];

echo "Novo pagamento - Mês 4: 3 parcelas<br>";
echo "Dinheiro: R$ 30,00 | PIX: R$ 40,00 | Cartão Crédito: R$ 20,00<br>";
echo "Total: R$ 90,00<br>";
?>
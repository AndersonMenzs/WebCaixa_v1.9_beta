<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechamento de Caixa - Estrella Photo Studio</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Personalizado -->
    <style>
        /* ESTILOS PARA IMPRESSÃO */
        @media print {
            body {
                font-size: 8pt !important;
                line-height: 1 !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            
            .print-container {
                max-width: 100% !important;
                padding: 0.4cm !important;
                margin: 0 !important;
            }
            
            .no-print {
                display: none !important;
            }
            
            /* FONTES PARA IMPRESSÃO */
            .fs-print-6 { font-size: 6pt !important; }
            .fs-print-7 { font-size: 7pt !important; }
            .fs-print-8 { font-size: 8pt !important; }
            .fs-print-9 { font-size: 9pt !important; }
            .fs-print-10 { font-size: 10pt !important; }
            
            /* ESPAÇAMENTOS REDUZIDOS */
            .p-print-0 { padding: 0 !important; }
            .p-print-1 { padding: 1px !important; }
            .p-print-2 { padding: 2px !important; }
            .m-print-0 { margin: 0 !important; }
            .mb-print-1 { margin-bottom: 2px !important; }
            .mb-print-2 { margin-bottom: 4px !important; }
            
            /* EVITAR QUEBRAS */
            .avoid-break {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            
            /* TRÊS COLUNAS PARA AUTENTICAÇÕES */
            .auth-three-columns {
                column-count: 3 !important;
                column-gap: 10px !important;
            }
        }
        
        @page {
            size: A4 portrait;
            margin: 0.4cm;
        }
        
        /* ESTILOS PARA TELA */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 15px 0;
        }
        
        .print-container {
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin: 0 auto;
            max-width: 21cm;
            padding: 15px;
        }
        
        /* CABEÇALHO */
        .header-section {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        
        .titulo-principal {
            font-size: 10pt;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
        }
        
        /* LINHA DE TÍTULO (UMA COLUNA) */
        .linha-titulo {
            background-color: #e9ecef;
            padding: 5px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #dee2e6;
            margin-bottom: 3px;
            border-radius: 3px;
        }
        
        /* LINHA DE CONTEÚDO */
        .linha-conteudo {
            margin-bottom: 3px;
        }
        
        /* COLUNAS */
        .coluna {
            padding: 0 3px;
        }
        
        /* TABELAS COMPACTAS */
        .tabela-compacta {
            font-size: 7pt;
            margin-bottom: 0;
        }
        
        .tabela-compacta th {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 2px 4px !important;
            border: 1px solid #dee2e6;
        }
        
        .tabela-compacta td {
            padding: 1px 3px !important;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        
        .valor-cell {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        
        /* LINHA DE TOTAL */
        .linha-total {
            margin-top: 3px;
            margin-bottom: 8px;
        }
        
        .card-total {
            border: 1px solid #28a745;
            background-color: #f8fff9;
            padding: 4px;
            height: 100%;
        }
        
        /* BADGES */
        .badge-info {
            font-size: 6pt;
            padding: 1px 4px;
        }
        
        /* RODAPÉ */
        .rodape {
            font-size: 6pt;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 4px;
            margin-top: 8px;
        }
        
        /* UTILITÁRIOS */
        .text-monospace {
            font-family: 'Courier New', monospace;
        }
        
        /* AUTENTICAÇÕES - TRÊS COLUNAS */
        .auth-column {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .auth-line {
            font-family: 'Courier New', monospace;
            font-size: 6.5pt;
            line-height: 1;
            margin: 0;
            padding: 1px 0;
            white-space: nowrap;
        }
        
        .auth-header {
            font-size: 7pt;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 2px 4px;
            border-radius: 2px;
            margin-bottom: 2px;
            text-align: center;
        }
        
        /* ASSINATURAS */
        .assinatura-area {
            border-top: 1px dashed #666;
            padding-top: 6px;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <!-- CONTROLES PARA TELA -->
    <div class="container-fluid no-print text-center py-2">
        <div class="btn-group btn-group-sm" role="group">
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="bi bi-printer"></i> Imprimir
            </button>
            <button onclick="exportarPDF()" class="btn btn-success btn-sm">
                <i class="bi bi-file-pdf"></i> PDF
            </button>
        </div>
        <div class="mt-1">
            <small class="text-muted fs-print-8">Autenticações em 3 colunas (15 linhas cada)</small>
        </div>
    </div>
    
    <!-- CONTEÚDO PRINCIPAL -->
    <div class="container-fluid print-container">
        
        <!-- CABEÇALHO -->
        <div class="row header-section avoid-break">
            <div class="col-12 text-center">
                <div class="titulo-principal">ESTRELLA PHOTO STUDIO</div>
                <div class="fs-print-8">PC 217 - Nova Iguaçu</div>
                <div class="fs-print-9 fw-bold">FECHAMENTO DE CAIXA - 06/02/2026 - 10:47</div>
            </div>
            <div class="col-6">
                <span class="badge bg-secondary badge-info">Operador: CARLOS</span>
            </div>
            <div class="col-6 text-end">
                <span class="badge bg-dark badge-info">Fita: 031/2026</span>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- SEÇÃO 1: RECEBIMENTOS -->
        <!-- ============================================ -->
        
        <!-- LINHA 1: TÍTULO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="linha-titulo bg-primary text-white">
                    RECEBIMENTOS
                </div>
            </div>
        </div>
        
        <!-- LINHA 2: CONTEÚDO -->
        <div class="row linha-conteudo avoid-break">
            <div class="col-md-6 coluna">
                <div class="fs-print-9 fw-bold mb-1">TIPO DE SERVIÇO</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered tabela-compacta">
                        <thead>
                            <tr>
                                <th width="60%">SERVIÇO</th>
                                <th width="15%" class="text-center">QTD</th>
                                <th width="25%" class="text-end">VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Chaveiros</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Taxa de Produção</td><td class="text-center">3</td><td class="valor-cell">29,70</td></tr>
                            <tr><td>Inscrição Concurso</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Contrato (Entrada)</td><td class="text-center">8</td><td class="valor-cell">650,00</td></tr>
                            <tr><td>Contrato (Parcela)</td><td class="text-center">8</td><td class="valor-cell">1.374,00</td></tr>
                            <tr><td>Proposta (Entrada)</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Proposta (Parcela)</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Produtos (Exc. Books)</td><td class="text-center">3</td><td class="valor-cell">59,40</td></tr>
                            <tr><td>Books à Vista</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Despesas</td><td class="text-center">4</td><td class="valor-cell">10.113,14</td></tr>
                            <tr><td>Estorno</td><td class="text-center">0</td><td class="valor-cell">0,00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-6 coluna">
                <div class="fs-print-9 fw-bold mb-1">FORMA DE RECEBIMENTO</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered tabela-compacta">
                        <thead>
                            <tr>
                                <th width="80%">FORMA DE PAGAMENTO</th>
                                <th width="20%" class="text-end">VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Dinheiro</td><td class="valor-cell">1.893,30</td></tr>
                            <tr><td>Cartão de Débito</td><td class="valor-cell">200,00</td></tr>
                            <tr><td>Cartão Crédito (à Vista)</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Cartão Crédito (Parcelado Loja)</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Cartão Crédito (Parc. Admnist.)</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Pix QR Code</td><td class="valor-cell">19,80</td></tr>
                            <tr><td>Pix CNPJ</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Depósito de Clientes</td><td class="valor-cell">0,00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- LINHA 3: TOTAIS -->
        <div class="row linha-total avoid-break">
            <div class="col-md-6 coluna">
                <div class="card-total">
                    <div class="text-center">
                        <strong class="fs-print-9">TOTAL TIPO DE SERVIÇO</strong>
                        <div class="fs-print-10 fw-bold text-monospace mt-1">R$ 12.226,24</div>
                        <div class="fs-print-7 text-muted">26 transações</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 coluna">
                <div class="card-total">
                    <div class="text-center">
                        <strong class="fs-print-9">TOTAL RECEBIMENTOS</strong>
                        <div class="fs-print-10 fw-bold text-monospace mt-1">R$ 2.113,10</div>
                        <div class="fs-print-7 text-muted">8 formas de pagamento</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- SEÇÃO 2: PAGAMENTOS -->
        <!-- ============================================ -->
        
        <!-- LINHA 1: TÍTULO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="linha-titulo bg-danger text-white">
                    PAGAMENTOS
                </div>
            </div>
        </div>
        
        <!-- LINHA 2: CONTEÚDO -->
        <div class="row linha-conteudo avoid-break">
            <div class="col-md-6 coluna">
                <div class="fs-print-9 fw-bold mb-1">TIPO DE DESPESA</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered tabela-compacta">
                        <thead>
                            <tr>
                                <th width="80%">DESCRIÇÃO</th>
                                <th width="20%" class="text-end">VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>De Pessoal</td><td class="valor-cell">10.058,17</td></tr>
                            <tr><td>Material de Consumo</td><td class="valor-cell">42,97</td></tr>
                            <tr><td>Material de Divulgação</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Material de Produção</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Reembolso de Clientes</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Serviços Prestados</td><td class="valor-cell">0,00</td></tr>
                            <tr><td>Vale Transporte</td><td class="valor-cell">12,00</td></tr>
                            <tr><td>Outros</td><td class="valor-cell">0,00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-6 coluna">
                <div class="fs-print-9 fw-bold mb-1">RECOLHIMENTOS</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered tabela-compacta">
                        <thead>
                            <tr>
                                <th width="80%">DESCRIÇÃO</th>
                                <th width="20%" class="text-end">VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Total Recolhido</td><td class="valor-cell">0,00</td></tr>
                            <tr class="table-light"><td colspan="2" class="text-center fs-print-7"><em>Sem recolhimentos</em></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- LINHA 3: TOTAIS -->
        <div class="row linha-total avoid-break">
            <div class="col-md-6 coluna">
                <div class="card-total border-danger">
                    <div class="text-center">
                        <strong class="fs-print-9">TOTAL DESPESAS</strong>
                        <div class="fs-print-10 fw-bold text-monospace mt-1">R$ 10.113,14</div>
                        <div class="fs-print-7 text-muted">8 tipos de despesa</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 coluna">
                <div class="card-total border-danger">
                    <div class="text-center">
                        <strong class="fs-print-9">PAGAMENTOS + RECOLHIMENTOS</strong>
                        <div class="fs-print-10 fw-bold text-monospace mt-1">R$ 10.113,14</div>
                        <div class="fs-print-7 text-muted">Total geral de saídas</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- SEÇÃO 3: SALDO DE CAIXA -->
        <!-- ============================================ -->
        
        <!-- LINHA 1: TÍTULO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="linha-titulo bg-warning text-dark">
                    SALDO DE CAIXA
                </div>
            </div>
        </div>
        
        <!-- LINHA 2: CONTEÚDO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered tabela-compacta">
                        <tbody>
                            <tr><td width="60%"><strong>Valor de Abertura</strong></td><td class="valor-cell">8.439,29</td></tr>
                            <tr><td><strong>+ Total Recebimentos</strong></td><td class="valor-cell">2.113,10</td></tr>
                            <tr><td><strong>- Total Pagamentos</strong></td><td class="valor-cell">10.113,14</td></tr>
                            <tr class="table-primary"><td><strong>SALDO TEÓRICO FINAL</strong></td><td class="valor-cell"><strong>219,45</strong></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- LINHA 3: CONFERÊNCIA -->
        <div class="row linha-total avoid-break">
            <div class="col-md-6 coluna">
                <div class="card border-info">
                    <div class="card-header bg-info text-white p-1 text-center">
                        <strong class="fs-print-9">VALOR REAL CALCULADO</strong>
                    </div>
                    <div class="card-body text-center p-1">
                        <div class="fs-print-10 fw-bold text-monospace">R$ 219,45</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 coluna">
                <div class="card border-success">
                    <div class="card-header bg-success text-white p-1 text-center">
                        <strong class="fs-print-9">VALOR NA GAVETA</strong>
                    </div>
                    <div class="card-body text-center p-1">
                        <div class="fs-print-10 fw-bold text-monospace">R$ 221,95</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- LINHA 4: DIFERENÇA -->
        <div class="row avoid-break mb-print-2">
            <div class="col-12">
                <div class="text-center p-1" style="border: 1px solid #28a745; border-radius: 3px; background-color: #f8fff9;">
                    <div class="fs-print-8 text-muted">DIFERENÇA DO CAIXA</div>
                    <div class="fs-print-10 fw-bold text-success text-monospace">R$ 2,50 (SOBRA)</div>
                    <div class="fs-print-7 text-muted">Caixa conferido e aprovado</div>
                </div>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- SEÇÃO 4: AUTENTICAÇÕES DO DIA (TRÊS COLUNAS) -->
        <!-- ============================================ -->
        
        <!-- LINHA 1: TÍTULO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="linha-titulo bg-dark text-white">
                    AUTENTICAÇÕES DO DIA
                </div>
            </div>
        </div>
        
        <!-- LINHA 2: CONTEÚDO (TRÊS COLUNAS - 15 LINHAS CADA) -->
        <div class="row linha-conteudo avoid-break">
            <!-- COLUNA 1: AUTENTICAÇÕES 1-15 -->
            <div class="col-md-4 coluna auth-column">
                <div class="auth-header">AUTENTICAÇÕES 1-15</div>
                <div class="auth-line">000121710101011707060226R$185,00CNTDIN000371-5</div>
                <div class="auth-line">00022171011221913060226R$19,80PRDDIN001123-1</div>
                <div class="auth-line">000321710161012605060226R$107,00CNTDIN001123-1</div>
                <div class="auth-line">0004217105121700635060226R$0,00TXPGRT000233-3</div>
                <div class="auth-line">000521711531012986060226R$100,00CNTDIN001123-1</div>
                <div class="auth-line">0006217120121700636060226R$9,90TXPPXQ001123-1</div>
                <div class="auth-line">000721712071011740060226R$165,00CNTDIN001123-1</div>
                <div class="auth-line">000821712111012893060226R$50,00CNTDIN000233-3</div>
                <div class="auth-line">0009217122021700637060226R$0,00TXPGRT001123-1</div>
                <div class="auth-line">0010217122021700638060226R$0,00TXPGRT001123-1</div>
                <div class="auth-line">0011217122221700639060226R$0,00TXPGRT001123-1</div>
                <div class="auth-line">001221712321012911060226R$200,00CNTCTD000233-3</div>
                <div class="auth-line">001321712561012983060226R$50,00CNTDIN001123-1</div>
                <div class="auth-line">0014217130021700640060226R$0,00TXPGRT001123-1</div>
                <div class="auth-line">001521713091012293060226R$70,00CNTDIN000233-3</div>
            </div>
            
            <!-- COLUNA 2: AUTENTICAÇÕES 16-30 -->
            <div class="col-md-4 coluna auth-column">
                <div class="auth-header">AUTENTICAÇÕES 16-30</div>
                <div class="auth-line">0016217131721700641 060226 R$ 0,00 TXPGRT001123-1</div>
                <div class="auth-line">001721713191012903 060226 R$ 50,00 CNTDIN001123-1</div>
                <div class="auth-line">0018217134521700642 060226 R$ 0,00 TXPGRT000233-3</div>
                <div class="auth-line">001921714191012913 060226 R$ 50,00 CNTDIN000233-3</div>
                <div class="auth-line">0020217143021700643 060226 R$ 0,00 TXPGRT001123-1</div>
                <div class="auth-line">0021217143121700644 060226 R$ 0,00 TXPGRT001123-1</div>
                <div class="auth-line">00222171451223473 060226 R$ 19,80 PRDDIN001123-1</div>
                <div class="auth-line">002321715041011711 060226 R$ 142,00 CNTDIN001123-1</div>
                <div class="auth-line">002421715311010464 060226 R$ 250,00 CNTDIN001123-1</div>
                <div class="auth-line">00242171010464 060226 R$ 250,00 DIN001123-1-BOOK-</div>
                <div class="auth-line">00252171010464 060226 R$ 135,00 DIN001123-1-BOOK-</div>
                <div class="auth-line">002521715441010464 060226 R$ 135,00 CNTDIN001123-1</div>
                <div class="auth-line">0026217155821700645 060226 R$ 0,00 TXPGRT001123-1</div>
                <div class="auth-line">002721716161011510 060226 R$ 200,00 CNTDIN000233-3</div>
                <div class="auth-line">0028217162621700646 060226 R$ 0,00 TXPGRT001123-1</div>
            </div>
            
            <!-- COLUNA 3: AUTENTICAÇÕES 31-39 -->
            <div class="col-md-4 coluna auth-column">
                <div class="auth-header">AUTENTICAÇÕES 31-39</div>
                <div class="auth-line">00292171631223458 060226 R$ 19,80 PRDDIN001123-1</div>
                <div class="auth-line">003021716431009144 060226 R$ 120,00 CNTDIN000233-3</div>
                <div class="auth-line">0031217164621700647 060226 R$ 0,00 TXPGRT000233-3</div>
                <div class="auth-line">003221717021012990 060226 R$ 100,00 CNTDIN001123-1</div>
                <div class="auth-line">0033WG0010 1729 060226 R$ 42,97 MCSDIN001123-1</div>
                <div class="auth-line">0034WG0010 1737 060226 R$ 12,00 VTRDIN001123-1</div>
                <div class="auth-line">0035217174221700648 060226 R$ 9,90 TXPPXQ001123-1</div>
                <div class="auth-line">0036WG0010 1745 060226 R$ 5.000,00 DDPDIN001123-1</div>
                <div class="auth-line">0037WG0010 1746 060226 R$ 5.058,17 DDPDIN001123-1</div>
                <div class="auth-line">0038217174721700649 060226 R$ 9,90 TXPDIN001123-1</div>
                <div class="auth-line">003921718191012902 060226 R$ 50,00 CNTDIN000233-3</div>
                <!-- Espaço vazio para completar 15 linhas -->
                <div class="auth-line" style="visibility: hidden;">---</div>
                <div class="auth-line" style="visibility: hidden;">---</div>
                <div class="auth-line" style="visibility: hidden;">---</div>
                <div class="auth-line" style="visibility: hidden;">---</div>
            </div>
        </div>
        
        <!-- LINHA 3: TOTAIS (TRÊS COLUNAS) -->
        <div class="row linha-total avoid-break">
            <div class="col-md-4 coluna">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white p-1 text-center">
                        <strong class="fs-print-8">QUANTIDADE</strong>
                    </div>
                    <div class="card-body text-center p-1">
                        <div class="fs-print-10 fw-bold">39</div>
                        <div class="fs-print-7 text-muted">autenticações</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 coluna">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white p-1 text-center">
                        <strong class="fs-print-8">VALOR TOTAL</strong>
                    </div>
                    <div class="card-body text-center p-1">
                        <div class="fs-print-10 fw-bold text-monospace">R$ 12.345,94</div>
                        <div class="fs-print-7 text-muted">soma total</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 coluna">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white p-1 text-center">
                        <strong class="fs-print-8">STATUS</strong>
                    </div>
                    <div class="card-body text-center p-1">
                        <div class="fs-print-9 fw-bold text-success">CONCLUÍDAS</div>
                        <div class="fs-print-7 text-muted">processadas</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================ -->
        <!-- SEÇÃO 5: ASSINATURAS E DOCUMENTO DE SOBRA -->
        <!-- ============================================ -->
        
        <!-- LINHA 1: TÍTULO -->
        <div class="row avoid-break mb-print-1">
            <div class="col-12">
                <div class="linha-titulo bg-secondary text-white">
                    DOCUMENTO DE SOBRA E ASSINATURAS
                </div>
            </div>
        </div>
        
        <!-- LINHA 2: CONTEÚDO (TRÊS COLUNAS) -->
        <div class="row linha-conteudo avoid-break">
            <!-- COLUNA 1: DOCUMENTO DE SOBRA -->
            <div class="col-md-4 coluna">
                <div class="fs-print-9 fw-bold mb-1">DOCUMENTO DE SOBRA</div>
                <div class="border p-2" style="border-radius: 3px;">
                    <div class="fs-print-8"><strong>PC:</strong> 217 - Nova Iguaçu</div>
                    <div class="fs-print-8"><strong>Data:</strong> 06/02/2026</div>
                    <div class="fs-print-8"><strong>Hora:</strong> 10:47</div>
                    <hr class="my-1">
                    <div class="fs-print-8">Saldo Fechamento: <span class="float-end">219,45</span></div>
                    <div class="fs-print-8">Valor Informado: <span class="float-end">221,95</span></div>
                    <hr class="my-1">
                    <div class="fs-print-9 fw-bold">Sobra de Numerário: <span class="float-end text-success">2,50</span></div>
                </div>
            </div>
            
            <!-- COLUNA 2: ASSINATURAS -->
            <div class="col-md-4 coluna">
                <div class="fs-print-9 fw-bold mb-1">ASSINATURAS</div>
                <div class="border p-2" style="border-radius: 3px;">
                    <div class="text-center mb-2">
                        <div class="border-bottom pb-1 mb-1">
                            <div class="fs-print-9 fw-bold">OPERADOR DE CAIXA</div>
                            <div class="fs-print-8 text-muted">Carlos (0.000.035-9)</div>
                        </div>
                        <div style="height: 30px; margin-top: 5px;"></div>
                    </div>
                    <div class="text-center">
                        <div class="border-bottom pb-1 mb-1">
                            <div class="fs-print-9 fw-bold">AUDITOR/RESPONSÁVEL</div>
                            <div class="fs-print-8 text-muted">Contabilidade</div>
                        </div>
                        <div style="height: 30px; margin-top: 5px;"></div>
                    </div>
                </div>
            </div>
            
            <!-- COLUNA 3: INFORMAÇÕES FINAIS -->
            <div class="col-md-4 coluna">
                <div class="fs-print-9 fw-bold mb-1">INFORMAÇÕES FINAIS</div>
                <div class="border p-2" style="border-radius: 3px;">
                    <div class="fs-print-8"><strong>Sistema:</strong> Estrella v3.05</div>
                    <div class="fs-print-8"><strong>Capa de Lote:</strong> 1047-1893.3-4710</div>
                    <div class="fs-print-8"><strong>Recolhimentos:</strong> 0 - R$ 0,00</div>
                    <hr class="my-1">
                    <div class="text-center">
                        <div class="fs-print-8 fw-bold">TERMINO DA FITA</div>
                        <div class="fs-print-9 text-monospace">031/2026</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- RODAPÉ -->
        <div class="row">
            <div class="col-12">
                <div class="rodape">
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <strong>Estrella Photo Studio</strong><br>
                            PC 217 - Nova Iguaçu
                        </div>
                        <div class="col-md-6 text-end">
                            <strong>Data:</strong> 06/02/2026<br>
                            <strong>Hora:</strong> 10:47
                        </div>
                        <div class="col-12 text-center mt-1">
                            <span class="fs-print-7 text-muted">
                                Documento gerado em: <span id="data-atual"></span> | Fechamento concluído e conferido
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div> <!-- FIM DO CONTAINER -->
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Scripts Personalizados -->
    <script>
        // Data atual
        document.getElementById('data-atual').textContent = new Date().toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Exportar PDF
        function exportarPDF() {
            alert("Para salvar como PDF, clique em Imprimir e selecione 'Salvar como PDF' como destino.");
            setTimeout(() => window.print(), 100);
        }
        
        // Auto-impressão
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            window.addEventListener('load', () => {
                setTimeout(() => window.print(), 500);
            });
        }
        
        console.log("✅ ESTRUTURA COM 3 COLUNAS:");
        console.log("Coluna 1: Autenticações 1-15 (15 linhas)");
        console.log("Coluna 2: Autenticações 16-30 (15 linhas)");
        console.log("Coluna 3: Autenticações 31-39 (9 linhas + 4 vazias)");
    </script>
</body>
</html>
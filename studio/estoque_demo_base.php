<?php

if (defined('ESTOQUE_DEMO_BASE_CARREGADA')) {
    return;
}

define('ESTOQUE_DEMO_BASE_CARREGADA', true);

$Sis = 'S7';
$Rot = 'S7R0';

$txtmat = trim($_POST['txtmat'] ?? '');
$txtsen = trim($_POST['txtsen'] ?? '');
$credencial = trim($_REQUEST['c_s'] ?? '');

$user = $txtmat !== '' ? substr((string) (100000000 + (int) $txtmat), 1, 8) : '';
$pass = strtolower($txtsen);
$pss = $pass !== '' ? sha1($pass) : '';
$lg_user = $user . $pss;

if ($user === '') {
    $lg_user = substr($credencial, 0, 48);
    $user = substr($lg_user, 0, 8);
    $pss = substr($lg_user, 8, 40);
}

$userF = substr($user, 0, 1) . '.' . substr($user, 1, 3) . '.' .
    substr($user, 4, 3) . '-' . substr($user, 7, 1);
$hif = ' - ';
$hif2 = ' em ';

include 'us_sist.php';

if ($ch === 'no') {
    include 'us_cad.php';
}

if ($ch === 'no') {
    http_response_code(403);
    exit('Acesso não autorizado ao estoque.');
}

$estoquePerfis = ['administrador', 'auditoria', 'encarregada', 'caixa'];
$perfilDemo = strtolower(trim($_REQUEST['perfil_demo'] ?? 'administrador'));

if (!in_array($perfilDemo, $estoquePerfis, true)) {
    $perfilDemo = 'administrador';
}

$perfilNomes = [
    'administrador' => 'Administrador',
    'auditoria' => 'Auditoria',
    'encarregada' => 'Encarregada',
    'caixa' => 'Caixa',
];

$estoquePermissoes = [
    'administrador' => [
        'cadastrar', 'editar', 'visualizar', 'inativar', 'movimentar',
        'solicitar', 'analisar', 'entregar', 'confirmar_divergencia', 'historico',
    ],
    'auditoria' => ['editar', 'visualizar', 'solicitar', 'receber', 'historico'],
    'encarregada' => ['visualizar', 'solicitar', 'receber'],
    'caixa' => ['visualizar'],
];

function estoqueDemoPode(string $acao): bool
{
    global $estoquePermissoes, $perfilDemo;
    return in_array($acao, $estoquePermissoes[$perfilDemo] ?? [], true);
}

function estoqueDemoExigir(string $acao): void
{
    if (!estoqueDemoPode($acao)) {
        http_response_code(403);
        exit('Seu perfil demonstrativo não possui acesso a esta rotina.');
    }
}

function estoqueDemoUrl(string $arquivo, array $parametros = []): string
{
    global $lg_user, $perfilDemo;

    $query = array_merge([
        'c_s' => $lg_user,
        'perfil_demo' => $perfilDemo,
    ], $parametros);

    return $arquivo . '?' . http_build_query($query);
}

$estoqueItensDemo = [
    1 => [
        'id' => 1, 'codigo' => 'EST-001', 'nome' => 'Detergente neutro',
        'categoria' => 'Limpeza', 'finalidade' => 'Consumo interno',
        'quantidade' => 18, 'minimo' => 10, 'unidade' => 'FR',
        'localizacao' => 'Prateleira A1', 'custo' => 3.50,
        'preco' => null, 'situacao' => 'normal', 'validade' => '—',
        'descricao' => 'Detergente neutro para limpeza geral do estabelecimento.',
    ],
    2 => [
        'id' => 2, 'codigo' => 'EST-002', 'nome' => 'Shampoo profissional',
        'categoria' => 'Beleza', 'finalidade' => 'Uso misto',
        'quantidade' => 3, 'minimo' => 5, 'unidade' => 'UN',
        'localizacao' => 'Armário B2', 'custo' => 24.90,
        'preco' => 49.90, 'situacao' => 'baixo', 'validade' => '18/10/2026',
        'descricao' => 'Shampoo profissional para uso interno e venda.',
    ],
    3 => [
        'id' => 3, 'codigo' => 'EST-003', 'nome' => 'Papel sulfite A4',
        'categoria' => 'Escritório', 'finalidade' => 'Consumo interno',
        'quantidade' => 0, 'minimo' => 2, 'unidade' => 'PC',
        'localizacao' => 'Armário ADM', 'custo' => 29.90,
        'preco' => null, 'situacao' => 'zerado', 'validade' => '—',
        'descricao' => 'Papel branco A4 para atividades administrativas.',
    ],
    4 => [
        'id' => 4, 'codigo' => 'EST-004', 'nome' => 'Máscara de hidratação',
        'categoria' => 'Beleza', 'finalidade' => 'Venda',
        'quantidade' => 12, 'minimo' => 4, 'unidade' => 'UN',
        'localizacao' => 'Vitrine 2', 'custo' => 18.75,
        'preco' => 39.90, 'situacao' => 'normal', 'validade' => '30/11/2027',
        'descricao' => 'Máscara de hidratação capilar destinada à venda.',
    ],
    5 => [
        'id' => 5, 'codigo' => 'EST-005', 'nome' => 'Álcool 70%',
        'categoria' => 'Limpeza', 'finalidade' => 'Consumo interno',
        'quantidade' => 7, 'minimo' => 5, 'unidade' => 'FR',
        'localizacao' => 'Prateleira A2', 'custo' => 8.40,
        'preco' => null, 'situacao' => 'vencendo', 'validade' => '12/07/2026',
        'descricao' => 'Álcool líquido 70% para higienização de superfícies.',
    ],
    6 => [
        'id' => 6, 'codigo' => 'EST-006', 'nome' => 'Sacola personalizada',
        'categoria' => 'Embalagem', 'finalidade' => 'Consumo interno',
        'quantidade' => 250, 'minimo' => 100, 'unidade' => 'UN',
        'localizacao' => 'Depósito C1', 'custo' => 0.85,
        'preco' => null, 'situacao' => 'normal', 'validade' => '—',
        'descricao' => 'Sacola institucional para entrega de produtos vendidos.',
    ],
    7 => [
        'id' => 7, 'codigo' => 'EST-007', 'nome' => 'Luva descartável',
        'categoria' => 'Descartáveis', 'finalidade' => 'Consumo interno',
        'quantidade' => 4, 'minimo' => 5, 'unidade' => 'CX',
        'localizacao' => 'Armário Técnico', 'custo' => 22.60,
        'preco' => null, 'situacao' => 'baixo', 'validade' => '05/03/2028',
        'descricao' => 'Luvas descartáveis para procedimentos e higienização.',
    ],
    8 => [
        'id' => 8, 'codigo' => 'EST-008', 'nome' => 'Kit tratamento capilar',
        'categoria' => 'Beleza', 'finalidade' => 'Venda',
        'quantidade' => 9, 'minimo' => 3, 'unidade' => 'KT',
        'localizacao' => 'Vitrine 1', 'custo' => 65.00,
        'preco' => 119.90, 'situacao' => 'normal', 'validade' => '21/01/2028',
        'descricao' => 'Kit de tratamento capilar composto por produtos para venda.',
    ],
];

$estoqueSolicitacoesDemo = [
    101 => [
        'id' => 101, 'numero' => 'SOL-2026-0101', 'solicitante' => 'Mariana A.',
        'perfil' => 'Auditoria', 'setor' => 'Atendimento', 'data' => '21/06/2026 09:20',
        'status' => 'pendente', 'justificativa' => 'Reposição semanal de materiais.',
        'visualizada_em' => null, 'enviada_em' => null, 'recebida_em' => null,
        'eventos' => [
            ['data' => '21/06/2026 09:20', 'titulo' => 'Solicitação criada', 'responsavel' => 'Mariana A. · Estúdio'],
        ],
        'itens' => [
            ['item_id' => 1, 'nome' => 'Detergente neutro', 'solicitada' => 3, 'aprovada' => 0, 'enviada' => 0, 'recebida' => 0, 'unidade' => 'FR'],
            ['item_id' => 6, 'nome' => 'Sacola personalizada', 'solicitada' => 50, 'aprovada' => 0, 'enviada' => 0, 'recebida' => 0, 'unidade' => 'UN'],
        ],
    ],
    102 => [
        'id' => 102, 'numero' => 'SOL-2026-0102', 'solicitante' => 'Carla M.',
        'perfil' => 'Encarregada', 'setor' => 'Produção', 'data' => '20/06/2026 14:35',
        'status' => 'enviado', 'justificativa' => 'Material necessário para atendimento.',
        'visualizada_em' => '20/06/2026 15:02', 'enviada_em' => '21/06/2026 08:40', 'recebida_em' => null,
        'eventos' => [
            ['data' => '20/06/2026 14:35', 'titulo' => 'Solicitação criada', 'responsavel' => 'Carla M. · Estúdio'],
            ['data' => '20/06/2026 15:02', 'titulo' => 'Visualizada pelo almoxarifado', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '20/06/2026 15:18', 'titulo' => 'Itens aprovados e separados', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '21/06/2026 08:40', 'titulo' => 'Pedido enviado ao estúdio', 'responsavel' => 'João P. · Almoxarifado'],
        ],
        'itens' => [
            ['item_id' => 2, 'nome' => 'Shampoo profissional', 'solicitada' => 2, 'aprovada' => 2, 'enviada' => 2, 'recebida' => 0, 'unidade' => 'UN'],
        ],
    ],
    103 => [
        'id' => 103, 'numero' => 'SOL-2026-0103', 'solicitante' => 'Mariana A.',
        'perfil' => 'Auditoria', 'setor' => 'Administração', 'data' => '19/06/2026 11:10',
        'status' => 'divergencia', 'justificativa' => 'Reposição de material administrativo.',
        'visualizada_em' => '19/06/2026 11:32', 'enviada_em' => '19/06/2026 14:10', 'recebida_em' => '19/06/2026 16:25',
        'eventos' => [
            ['data' => '19/06/2026 11:10', 'titulo' => 'Solicitação criada', 'responsavel' => 'Mariana A. · Estúdio'],
            ['data' => '19/06/2026 11:32', 'titulo' => 'Visualizada pelo almoxarifado', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '19/06/2026 14:10', 'titulo' => 'Pedido enviado ao estúdio', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '19/06/2026 16:25', 'titulo' => 'Recebimento com divergência', 'responsavel' => 'Mariana A. · Estúdio'],
        ],
        'itens' => [
            ['item_id' => 6, 'nome' => 'Sacola personalizada', 'solicitada' => 50, 'aprovada' => 50, 'enviada' => 50, 'recebida' => 48, 'unidade' => 'UN'],
        ],
    ],
    104 => [
        'id' => 104, 'numero' => 'SOL-2026-0104', 'solicitante' => 'Carla M.',
        'perfil' => 'Encarregada', 'setor' => 'Limpeza', 'data' => '18/06/2026 08:15',
        'status' => 'concluido', 'justificativa' => 'Reposição de material de limpeza.',
        'visualizada_em' => '18/06/2026 08:30', 'enviada_em' => '18/06/2026 10:05', 'recebida_em' => '18/06/2026 11:20',
        'eventos' => [
            ['data' => '18/06/2026 08:15', 'titulo' => 'Solicitação criada', 'responsavel' => 'Carla M. · Estúdio'],
            ['data' => '18/06/2026 08:30', 'titulo' => 'Visualizada pelo almoxarifado', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '18/06/2026 10:05', 'titulo' => 'Pedido enviado ao estúdio', 'responsavel' => 'João P. · Almoxarifado'],
            ['data' => '18/06/2026 11:20', 'titulo' => 'Recebimento confirmado pelo estúdio', 'responsavel' => 'Carla M. · Estúdio'],
            ['data' => '18/06/2026 11:21', 'titulo' => 'Solicitação concluída automaticamente', 'responsavel' => 'Sistema'],
        ],
        'itens' => [
            ['item_id' => 1, 'nome' => 'Detergente neutro', 'solicitada' => 2, 'aprovada' => 2, 'enviada' => 2, 'recebida' => 2, 'unidade' => 'FR'],
        ],
    ],
];

function estoqueDemoItem(int $id): array
{
    global $estoqueItensDemo;
    return $estoqueItensDemo[$id] ?? reset($estoqueItensDemo);
}

function estoqueDemoSolicitacao(int $id): array
{
    global $estoqueSolicitacoesDemo;
    return $estoqueSolicitacoesDemo[$id] ?? reset($estoqueSolicitacoesDemo);
}

function estoqueDemoStatus(string $status): string
{
    $nomes = [
        'normal' => 'Normal',
        'baixo' => 'Estoque baixo',
        'zerado' => 'Sem estoque',
        'vencendo' => 'Vencendo',
        'pendente' => 'Pendente',
        'aprovada' => 'Aprovada',
        'visualizado' => 'Visualizada',
        'separacao' => 'Em separação',
        'enviado' => 'Enviado',
        'recebido' => 'Recebido',
        'divergencia' => 'Com divergência',
        'concluido' => 'Concluído',
        'parcial' => 'Parcial',
        'atendida' => 'Atendida',
        'recusada' => 'Recusada',
    ];

    return $nomes[$status] ?? ucfirst($status);
}

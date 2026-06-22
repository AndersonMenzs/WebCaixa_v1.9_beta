<?php
// Protótipo da área de estoque com dados fictícios.
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

$perfisPermitidos = ['administrador', 'auditoria', 'encarregada', 'caixa'];
$perfilDemo = strtolower(trim($_GET['perfil_demo'] ?? 'administrador'));

if (!in_array($perfilDemo, $perfisPermitidos, true)) {
    $perfilDemo = 'administrador';
}

$perfilNomes = [
    'administrador' => 'Administrador',
    'auditoria' => 'Auditoria',
    'encarregada' => 'Encarregada',
    'caixa' => 'Caixa',
];

$permissoes = [
    'administrador' => ['cadastrar', 'editar', 'visualizar', 'excluir', 'solicitar'],
    'auditoria' => ['editar', 'visualizar', 'solicitar'],
    'encarregada' => ['visualizar', 'solicitar'],
    'caixa' => ['visualizar'],
];

$pode = static function (string $acao) use ($permissoes, $perfilDemo): bool {
    return in_array($acao, $permissoes[$perfilDemo], true);
};

$itens = [
    [
        'codigo' => 'EST-001',
        'nome' => 'Detergente neutro',
        'categoria' => 'Limpeza',
        'finalidade' => 'Consumo interno',
        'quantidade' => 18,
        'minimo' => 10,
        'unidade' => 'FR',
        'localizacao' => 'Prateleira A1',
        'custo' => 3.50,
        'situacao' => 'normal',
        'validade' => '—',
    ],
    [
        'codigo' => 'EST-002',
        'nome' => 'Shampoo profissional',
        'categoria' => 'Beleza',
        'finalidade' => 'Uso misto',
        'quantidade' => 3,
        'minimo' => 5,
        'unidade' => 'UN',
        'localizacao' => 'Armário B2',
        'custo' => 24.90,
        'situacao' => 'baixo',
        'validade' => '18/10/2026',
    ],
    [
        'codigo' => 'EST-003',
        'nome' => 'Papel sulfite A4',
        'categoria' => 'Escritório',
        'finalidade' => 'Consumo interno',
        'quantidade' => 0,
        'minimo' => 2,
        'unidade' => 'PC',
        'localizacao' => 'Armário ADM',
        'custo' => 29.90,
        'situacao' => 'zerado',
        'validade' => '—',
    ],
    [
        'codigo' => 'EST-004',
        'nome' => 'Máscara de hidratação',
        'categoria' => 'Beleza',
        'finalidade' => 'Venda',
        'quantidade' => 12,
        'minimo' => 4,
        'unidade' => 'UN',
        'localizacao' => 'Vitrine 2',
        'custo' => 18.75,
        'situacao' => 'normal',
        'validade' => '30/11/2027',
    ],
    [
        'codigo' => 'EST-005',
        'nome' => 'Álcool 70%',
        'categoria' => 'Limpeza',
        'finalidade' => 'Consumo interno',
        'quantidade' => 7,
        'minimo' => 5,
        'unidade' => 'FR',
        'localizacao' => 'Prateleira A2',
        'custo' => 8.40,
        'situacao' => 'vencendo',
        'validade' => '12/07/2026',
    ],
    [
        'codigo' => 'EST-006',
        'nome' => 'Sacola personalizada',
        'categoria' => 'Embalagem',
        'finalidade' => 'Consumo interno',
        'quantidade' => 250,
        'minimo' => 100,
        'unidade' => 'UN',
        'localizacao' => 'Depósito C1',
        'custo' => 0.85,
        'situacao' => 'normal',
        'validade' => '—',
    ],
    [
        'codigo' => 'EST-007',
        'nome' => 'Luva descartável',
        'categoria' => 'Descartáveis',
        'finalidade' => 'Consumo interno',
        'quantidade' => 4,
        'minimo' => 5,
        'unidade' => 'CX',
        'localizacao' => 'Armário Técnico',
        'custo' => 22.60,
        'situacao' => 'baixo',
        'validade' => '05/03/2028',
    ],
    [
        'codigo' => 'EST-008',
        'nome' => 'Kit tratamento capilar',
        'categoria' => 'Beleza',
        'finalidade' => 'Venda',
        'quantidade' => 9,
        'minimo' => 3,
        'unidade' => 'KT',
        'localizacao' => 'Vitrine 1',
        'custo' => 65.00,
        'situacao' => 'normal',
        'validade' => '21/01/2028',
    ],
];

$resumo = [
    'total' => count($itens),
    'baixo' => count(array_filter($itens, static fn(array $item): bool => $item['situacao'] === 'baixo')),
    'zerado' => count(array_filter($itens, static fn(array $item): bool => $item['situacao'] === 'zerado')),
    'vencendo' => count(array_filter($itens, static fn(array $item): bool => $item['situacao'] === 'vencendo')),
];

$situacaoNomes = [
    'normal' => 'Normal',
    'baixo' => 'Estoque baixo',
    'zerado' => 'Sem estoque',
    'vencendo' => 'Vencendo',
];

$stdExibicao = isset($std) && trim((string) $std) !== '' ? $std : ' demonstração';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque | WebCaixa</title>
    <link rel="shortcut icon" href="./images/estrella.ico" type="image/x-icon">
    <link rel="stylesheet" href="/photovippcloud_erp/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/estoque.css">
</head>

<body class="estoque-body" data-perfil="<?php echo htmlspecialchars($perfilDemo); ?>">
    <aside class="erp-sidebar" id="estoqueSidebar">
        <a class="erp-sidebar-brand" href="index.php?c_s=<?php echo rawurlencode($lg_user); ?>">
            <i class="bi bi-cloudy-fill"></i>
            <span>WebCaixa<br><strong>ESTOQUE</strong></span>
        </a>

        <div class="erp-sidebar-section">
            <div class="erp-sidebar-heading">Navegação</div>
            <a class="erp-sidebar-link" href="index.php?c_s=<?php echo rawurlencode($lg_user); ?>">
                <i class="bi bi-house-door"></i><span>Home WebCaixa</span>
            </a>

            <div class="erp-sidebar-heading">Estoque</div>
            <a class="erp-sidebar-link active" href="#listaEstoque">
                <i class="bi bi-box-seam"></i><span>Itens</span>
            </a>
            <?php if ($pode('cadastrar')) { ?>
                <a class="erp-sidebar-link" href="estoque_cadastrar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-plus-square"></i><span>Cadastrar</span>
                </a>
                <a class="erp-sidebar-link" href="estoque_movimentar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-arrow-left-right"></i><span>Movimentações</span>
                </a>
            <?php } ?>
            <?php if ($pode('solicitar')) { ?>
                <a class="erp-sidebar-link" href="estoque_solicitar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-clipboard-plus"></i><span>Solicitar</span>
                </a>
                <a class="erp-sidebar-link" href="estoque_solicitacoes.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-list-check"></i><span>Solicitações</span>
                </a>
            <?php } ?>
            <?php if ($perfilDemo === 'administrador' || $perfilDemo === 'auditoria') { ?>
                <a class="erp-sidebar-link" href="estoque_historico.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-clock-history"></i><span>Histórico</span>
                </a>
            <?php } ?>

            <div class="erp-sidebar-heading">Sistema</div>
            <a class="erp-sidebar-link" href="estoque_manual.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                <i class="bi bi-journal-text"></i><span>Documentação</span>
            </a>
            <button class="erp-sidebar-link acao-demo" type="button" data-acao="Abrir suporte">
                <i class="bi bi-life-preserver"></i><span>Suporte</span>
            </button>
        </div>
    </aside>

    <div class="erp-sidebar-backdrop" id="estoqueSidebarBackdrop"></div>

    <nav class="erp-topbar d-flex align-items-center px-3 px-lg-4">
        <button class="btn btn-outline-primary btn-sm d-lg-none me-3" type="button"
            id="estoqueSidebarToggle" aria-label="Abrir menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="fw-semibold text-primary-emphasis">Estoque</div>
        <div class="dropdown ms-auto">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./images/logo.png" class="erp-photo" alt="">
                <span><?php echo htmlspecialchars($perfilNomes[$perfilDemo]); ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><span class="dropdown-item-text small text-muted">Matrícula <?php echo htmlspecialchars($userF); ?></span></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Conta</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle me-2"></i>Sobre</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
            </ul>
        </div>
    </nav>

    <main class="container-fluid px-4 py-4">
        <section class="page-heading d-flex justify-content-between align-items-center pb-2 mb-4">
            <div>
                <h1 class="h3 text-info-emphasis mb-1">Controle de estoque</h1>
                <div class="text-muted">PC-<?php echo htmlspecialchars((string) $stdExibicao); ?> · Produtos e insumos</div>
            </div>
            <div class="d-flex gap-2">
                <?php if ($pode('solicitar')) { ?>
                    <a class="btn btn-outline-success btn-sm"
                        href="estoque_solicitar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                        <i class="bi bi-clipboard-plus me-1"></i>Solicitar
                    </a>
                <?php } ?>
                <?php if ($pode('cadastrar')) { ?>
                    <a class="btn btn-outline-primary btn-sm"
                        href="estoque_cadastrar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                        <i class="bi bi-plus-lg me-1"></i>Cadastrar
                    </a>
                <?php } ?>
            </div>
        </section>

        <section class="alert alert-info d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4"
            aria-label="Simulação de perfil">
            <div><strong>Interface demonstrativa.</strong> Os dados são fictícios e nenhuma ação será gravada.</div>
            <form method="get" class="d-flex align-items-center gap-2">
                <?php if ($lg_user !== '') { ?>
                    <input type="hidden" name="c_s" value="<?php echo htmlspecialchars($lg_user); ?>">
                <?php } ?>
                <label for="perfil_demo" class="form-label mb-0 text-nowrap">Ver como:</label>
                <select class="form-select form-select-sm" name="perfil_demo" id="perfil_demo"
                    onchange="this.form.submit()">
                    <?php foreach ($perfilNomes as $valor => $nome) { ?>
                        <option value="<?php echo $valor; ?>" <?php echo $perfilDemo === $valor ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nome); ?>
                        </option>
                    <?php } ?>
                </select>
            </form>
        </section>

        <section class="row g-3 mb-4" aria-label="Resumo do estoque">
            <div class="col-sm-6 col-xl-3">
                <article class="card metric-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><div class="text-muted small">Itens ativos</div><div class="display-6 fw-semibold"><?php echo $resumo['total']; ?></div></div>
                        <i class="bi bi-box-seam fs-2 text-primary"></i>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-xl-3">
                <article class="card metric-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><div class="text-muted small">Estoque baixo</div><div class="display-6 fw-semibold"><?php echo $resumo['baixo']; ?></div></div>
                        <i class="bi bi-exclamation-triangle fs-2 text-warning"></i>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-xl-3">
                <article class="card metric-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><div class="text-muted small">Sem estoque</div><div class="display-6 fw-semibold"><?php echo $resumo['zerado']; ?></div></div>
                        <i class="bi bi-x-octagon fs-2 text-danger"></i>
                    </div>
                </article>
            </div>
            <div class="col-sm-6 col-xl-3">
                <article class="card metric-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><div class="text-muted small">Vencendo</div><div class="display-6 fw-semibold"><?php echo $resumo['vencendo']; ?></div></div>
                        <i class="bi bi-hourglass-split fs-2 text-info"></i>
                    </div>
                </article>
            </div>
        </section>

        <section class="card border-0 shadow-sm" id="listaEstoque">
            <div class="content-card-header">
                <div>
                    <h2 class="h5 text-info-emphasis mb-1">Itens em estoque</h2>
                    <p class="text-muted small mb-0" id="resultadoContagem"><?php echo count($itens); ?> itens encontrados</p>
                </div>
            </div>

            <div class="filter-panel">
                <div class="filter-search">
                    <label for="filtroBusca" class="form-label">Pesquisar</label>
                    <input type="search" class="form-control" id="filtroBusca"
                        placeholder="Código ou nome do item">
                </div>
                <div>
                    <label for="filtroCategoria" class="form-label">Categoria</label>
                    <select class="form-select" id="filtroCategoria">
                        <option value="">Todas</option>
                        <option>Beleza</option>
                        <option>Descartáveis</option>
                        <option>Embalagem</option>
                        <option>Escritório</option>
                        <option>Limpeza</option>
                    </select>
                </div>
                <div>
                    <label for="filtroFinalidade" class="form-label">Finalidade</label>
                    <select class="form-select" id="filtroFinalidade">
                        <option value="">Todas</option>
                        <option>Venda</option>
                        <option>Consumo interno</option>
                        <option>Uso misto</option>
                    </select>
                </div>
                <div>
                    <label for="filtroSituacao" class="form-label">Situação</label>
                    <select class="form-select" id="filtroSituacao">
                        <option value="">Todas</option>
                        <option value="normal">Normal</option>
                        <option value="baixo">Estoque baixo</option>
                        <option value="zerado">Sem estoque</option>
                        <option value="vencendo">Vencendo</option>
                    </select>
                </div>
                <div class="filter-action">
                    <button class="btn btn-outline-secondary w-100" id="limparFiltros" type="button">Limpar</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table estoque-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Finalidade</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Situação</th>
                            <th scope="col" class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="estoqueTabela">
                        <?php foreach ($itens as $indiceItem => $item) { ?>
                            <tr data-codigo="<?php echo htmlspecialchars(strtolower($item['codigo'])); ?>"
                                data-nome="<?php echo htmlspecialchars(strtolower($item['nome'])); ?>"
                                data-categoria="<?php echo htmlspecialchars($item['categoria']); ?>"
                                data-finalidade="<?php echo htmlspecialchars($item['finalidade']); ?>"
                                data-situacao="<?php echo htmlspecialchars($item['situacao']); ?>">
                                <td>
                                    <div class="item-name"><?php echo htmlspecialchars($item['nome']); ?></div>
                                    <div class="item-code"><?php echo htmlspecialchars($item['codigo']); ?> · <?php echo htmlspecialchars($item['localizacao']); ?></div>
                                </td>
                                <td><span class="category-pill"><?php echo htmlspecialchars($item['categoria']); ?></span></td>
                                <td><?php echo htmlspecialchars($item['finalidade']); ?></td>
                                <td>
                                    <strong class="stock-value"><?php echo number_format($item['quantidade'], 0, ',', '.'); ?></strong>
                                    <span class="stock-unit"><?php echo htmlspecialchars($item['unidade']); ?></span>
                                    <small>Mín. <?php echo number_format($item['minimo'], 0, ',', '.'); ?></small>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo htmlspecialchars($item['situacao']); ?>">
                                        <span aria-hidden="true"></span>
                                        <?php echo htmlspecialchars($situacaoNomes[$item['situacao']]); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a class="btn btn-sm btn-outline-primary"
                                            title="Visualizar"
                                            href="estoque_visualizar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>&id=<?php echo $indiceItem + 1; ?>">
                                            <i class="bi bi-eye"></i><span class="visually-hidden">Visualizar</span>
                                        </a>
                                        <?php if ($pode('solicitar')) { ?>
                                            <a class="btn btn-sm btn-outline-success"
                                                href="estoque_solicitar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>&item=<?php echo $indiceItem + 1; ?>"
                                                title="Solicitar">
                                                <i class="bi bi-clipboard-plus"></i><span class="visually-hidden">Solicitar</span>
                                            </a>
                                        <?php } ?>
                                        <?php if ($pode('editar')) { ?>
                                            <a class="btn btn-sm btn-outline-warning"
                                                href="estoque_editar.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>&id=<?php echo $indiceItem + 1; ?>"
                                                title="Editar">
                                                <i class="bi bi-pencil"></i><span class="visually-hidden">Editar</span>
                                            </a>
                                        <?php } ?>
                                        <?php if ($pode('excluir')) { ?>
                                            <a class="btn btn-sm btn-outline-danger"
                                                href="estoque_excluir.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>&id=<?php echo $indiceItem + 1; ?>"
                                                title="Inativar">
                                                <i class="bi bi-trash"></i><span class="visually-hidden">Inativar</span>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr id="semResultados" class="d-none">
                            <td colspan="6" class="empty-state">
                                <strong>Nenhum item encontrado</strong>
                                <span>Altere ou limpe os filtros para continuar.</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <?php if ($perfilDemo !== 'caixa') { ?>
            <section class="card border-0 shadow-sm mt-4" id="solicitacoes">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h2 class="h5 text-info-emphasis mb-1">Solicitações</h2>
                    <p class="text-muted mb-0">Existem 3 solicitações fictícias aguardando análise ou entrega.</p>
                </div>
                <a class="btn btn-outline-primary btn-sm"
                    href="estoque_solicitacoes.php?c_s=<?php echo rawurlencode($lg_user); ?>&perfil_demo=<?php echo rawurlencode($perfilDemo); ?>">
                    <i class="bi bi-list-check me-1"></i>Ver solicitações
                </a>
                </div>
            </section>
        <?php } ?>
    </main>

    <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-labelledby="modalDetalhesTitulo" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <div>
                        <span class="eyebrow text-primary">Detalhes do item</span>
                        <h2 class="modal-title fs-4" id="modalDetalhesTitulo">Item</h2>
                        <span class="text-muted" id="detalheCodigo"></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="detail-grid">
                        <div><span>Categoria</span><strong id="detalheCategoria"></strong></div>
                        <div><span>Finalidade</span><strong id="detalheFinalidade"></strong></div>
                        <div><span>Saldo atual</span><strong id="detalheSaldo"></strong></div>
                        <div><span>Estoque mínimo</span><strong id="detalheMinimo"></strong></div>
                        <div><span>Localização</span><strong id="detalheLocalizacao"></strong></div>
                        <div><span>Validade</span><strong id="detalheValidade"></strong></div>
                        <div><span>Custo unitário</span><strong id="detalheCusto"></strong></div>
                        <div><span>Situação</span><strong id="detalheSituacao"></strong></div>
                    </div>

                    <h3 class="fs-6 mt-4 mb-3">Últimas movimentações</h3>
                    <div class="movement-list">
                        <div><span class="movement-icon positive">+</span><div><strong>Entrada de estoque</strong><small>18/06/2026 · Administrador</small></div><b>+10</b></div>
                        <div><span class="movement-icon negative">−</span><div><strong>Consumo interno</strong><small>20/06/2026 · Setor Atendimento</small></div><b>−2</b></div>
                        <div><span class="movement-icon negative">−</span><div><strong>Consumo interno</strong><small>21/06/2026 · Setor Limpeza</small></div><b>−1</b></div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                    <?php if ($pode('solicitar')) { ?>
                        <button type="button" class="btn btn-primary solicitar-do-detalhe"
                            data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalSolicitacao">
                            Solicitar item
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSolicitacao" tabindex="-1" aria-labelledby="modalSolicitacaoTitulo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formSolicitacao">
                    <div class="modal-header border-0">
                        <div>
                            <span class="eyebrow text-success">Nova solicitação</span>
                            <h2 class="modal-title fs-4" id="modalSolicitacaoTitulo">Solicitar item</h2>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="alert alert-light border mb-3">
                            <strong id="solicitacaoItem">Selecione um item</strong>
                            <span class="d-block small text-muted" id="solicitacaoSaldo">Consulte o saldo na listagem.</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-5">
                                <label for="solicitacaoQuantidade" class="form-label">Quantidade *</label>
                                <input type="number" min="1" step="1" class="form-control"
                                    id="solicitacaoQuantidade" required>
                            </div>
                            <div class="col-12 col-sm-7">
                                <label for="solicitacaoSetor" class="form-label">Setor de destino *</label>
                                <select class="form-select" id="solicitacaoSetor" required>
                                    <option value="">Selecione</option>
                                    <option>Administração</option>
                                    <option>Atendimento</option>
                                    <option>Caixa</option>
                                    <option>Limpeza</option>
                                    <option>Produção</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="solicitacaoJustificativa" class="form-label">Justificativa *</label>
                                <textarea class="form-control" id="solicitacaoJustificativa" rows="3"
                                    placeholder="Informe como o item será utilizado" required></textarea>
                            </div>
                        </div>
                        <p class="form-hint">A solicitação não altera o estoque. A baixa ocorrerá somente após a entrega.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Enviar solicitação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="estoqueToast" class="toast border-0" role="status" aria-live="polite" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="estoqueToastTexto">Ação demonstrativa concluída.</div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
        </div>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/estoque.js"></script>
</body>

</html>

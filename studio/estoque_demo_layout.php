<?php

require_once __DIR__ . '/estoque_demo_base.php';

function estoqueDemoCabecalho(string $titulo, string $ativo = 'itens'): void
{
    global $lg_user, $userF, $perfilDemo, $perfilNomes;
    $scriptAtual = basename($_SERVER['PHP_SELF'] ?? 'estoque.php');
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo htmlspecialchars($titulo); ?> | Estoque</title>
        <link rel="shortcut icon" href="./images/estrella.ico" type="image/x-icon">
        <link rel="stylesheet" href="/photovippcloud_erp/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/estoque.css">
    </head>
    <body class="estoque-body" data-perfil="<?php echo htmlspecialchars($perfilDemo); ?>">
        <aside class="erp-sidebar" id="estoqueSidebar">
            <a class="erp-sidebar-brand" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque.php')); ?>">
                <i class="bi bi-cloudy-fill"></i>
                <span>WebCaixa<br><strong>ESTOQUE</strong></span>
            </a>
            <div class="erp-sidebar-section">
                <div class="erp-sidebar-heading">Navegação</div>
                <a class="erp-sidebar-link" href="index.php?c_s=<?php echo rawurlencode($lg_user); ?>">
                    <i class="bi bi-house-door"></i><span>Home WebCaixa</span>
                </a>

                <div class="erp-sidebar-heading">Estoque</div>
                <a class="erp-sidebar-link <?php echo $ativo === 'itens' ? 'active' : ''; ?>"
                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque.php')); ?>">
                    <i class="bi bi-box-seam"></i><span>Itens</span>
                </a>
                <?php if (estoqueDemoPode('cadastrar')) { ?>
                    <a class="erp-sidebar-link <?php echo $ativo === 'cadastrar' ? 'active' : ''; ?>"
                        href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_cadastrar.php')); ?>">
                        <i class="bi bi-plus-square"></i><span>Cadastrar item</span>
                    </a>
                <?php } ?>
                <?php if (estoqueDemoPode('movimentar')) { ?>
                    <a class="erp-sidebar-link <?php echo $ativo === 'movimentar' ? 'active' : ''; ?>"
                        href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_movimentar.php')); ?>">
                        <i class="bi bi-arrow-left-right"></i><span>Movimentações</span>
                    </a>
                <?php } ?>
                <?php if (estoqueDemoPode('solicitar')) { ?>
                    <a class="erp-sidebar-link <?php echo $ativo === 'solicitar' ? 'active' : ''; ?>"
                        href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitar.php')); ?>">
                        <i class="bi bi-clipboard-plus"></i><span>Solicitar itens</span>
                    </a>
                    <a class="erp-sidebar-link <?php echo $ativo === 'solicitacoes' ? 'active' : ''; ?>"
                        href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacoes.php')); ?>">
                        <i class="bi bi-list-check"></i><span>Solicitações</span>
                    </a>
                <?php } ?>
                <?php if (estoqueDemoPode('historico')) { ?>
                    <a class="erp-sidebar-link <?php echo $ativo === 'historico' ? 'active' : ''; ?>"
                        href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_historico.php')); ?>">
                        <i class="bi bi-clock-history"></i><span>Histórico</span>
                    </a>
                <?php } ?>
                <div class="erp-sidebar-heading">Sistema</div>
                <a class="erp-sidebar-link <?php echo $ativo === 'manual' ? 'active' : ''; ?>"
                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_manual.php')); ?>">
                    <i class="bi bi-journal-text"></i><span>Manual</span>
                </a>
            </div>
        </aside>

        <div class="erp-sidebar-backdrop" id="estoqueSidebarBackdrop"></div>

        <nav class="erp-topbar d-flex align-items-center px-3 px-lg-4">
            <button class="btn btn-outline-primary btn-sm d-lg-none me-3" type="button"
                id="estoqueSidebarToggle" aria-label="Abrir menu">
                <i class="bi bi-list"></i>
            </button>
            <div class="fw-semibold text-primary-emphasis"><?php echo htmlspecialchars($titulo); ?></div>
            <div class="dropdown ms-auto">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./images/logo.png" class="erp-photo" alt="">
                    <span><?php echo htmlspecialchars($perfilNomes[$perfilDemo]); ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text small text-muted">Matrícula <?php echo htmlspecialchars($userF); ?></span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque.php')); ?>"><i class="bi bi-box-seam me-2"></i>Estoque</a></li>
                    <li><a class="dropdown-item" href="sair.php"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                </ul>
            </div>
        </nav>

        <main class="container-fluid px-4 py-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pb-2 mb-4">
                <div>
                    <h1 class="h3 text-info-emphasis mb-1"><?php echo htmlspecialchars($titulo); ?></h1>
                    <div class="text-muted">Rotina demonstrativa · nenhum dado será gravado</div>
                </div>
                <form method="get" action="<?php echo htmlspecialchars($scriptAtual); ?>" class="d-flex align-items-center gap-2">
                    <input type="hidden" name="c_s" value="<?php echo htmlspecialchars($lg_user); ?>">
                    <?php foreach ($_GET as $chave => $valor) {
                        if (!in_array($chave, ['c_s', 'perfil_demo'], true) && is_scalar($valor)) { ?>
                            <input type="hidden" name="<?php echo htmlspecialchars($chave); ?>" value="<?php echo htmlspecialchars((string) $valor); ?>">
                        <?php }
                    } ?>
                    <label class="form-label mb-0 text-nowrap" for="perfil_demo">Ver como:</label>
                    <select class="form-select form-select-sm" name="perfil_demo" id="perfil_demo" onchange="this.form.submit()">
                        <?php foreach ($perfilNomes as $valor => $nome) { ?>
                            <option value="<?php echo htmlspecialchars($valor); ?>" <?php echo $perfilDemo === $valor ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($nome); ?>
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>
    <?php
}

function estoqueDemoRodape(): void
{
    ?>
        </main>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="estoqueToast" class="toast border-0" role="status" aria-live="polite" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="estoqueToastTexto">Ação demonstrativa concluída.</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Fechar"></button>
                </div>
            </div>
        </div>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <script src="./js/estoque_demo_paginas.js"></script>
    </body>
    </html>
    <?php
}

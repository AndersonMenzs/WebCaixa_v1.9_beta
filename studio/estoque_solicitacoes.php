<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('solicitar');
estoqueDemoCabecalho('Solicitações de estoque', 'solicitacoes');
$cores = [
    'pendente' => 'warning', 'aprovada' => 'success', 'enviado' => 'info',
    'divergencia' => 'danger', 'concluido' => 'primary', 'recusada' => 'secondary',
];
?>

<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom">
        <div class="row g-2 align-items-end">
            <div class="col-md-4"><label class="form-label">Pesquisar</label><input class="form-control form-control-sm" placeholder="Número ou solicitante"></div>
            <div class="col-md-3"><label class="form-label">Status</label><select class="form-select form-select-sm"><option>Todos</option><option>Pendente</option><option>Enviado</option><option>Com divergência</option><option>Concluído</option></select></div>
            <div class="col-md-3"><label class="form-label">Setor</label><select class="form-select form-select-sm"><option>Todos</option><option>Administração</option><option>Atendimento</option><option>Produção</option></select></div>
            <div class="col-md-2"><button class="btn btn-outline-primary btn-sm w-100" data-demo-action="Filtrar solicitações"><i class="bi bi-search me-1"></i>Filtrar</button></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead><tr><th>Número</th><th>Data</th><th>Solicitante</th><th>Setor</th><th>Itens</th><th>Status</th><th class="text-end">Ações</th></tr></thead>
            <tbody>
                <?php foreach ($estoqueSolicitacoesDemo as $solicitacao) { ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($solicitacao['numero']); ?></strong></td>
                        <td><?php echo htmlspecialchars($solicitacao['data']); ?></td>
                        <td><?php echo htmlspecialchars($solicitacao['solicitante']); ?><small class="d-block text-muted"><?php echo htmlspecialchars($solicitacao['perfil']); ?></small></td>
                        <td><?php echo htmlspecialchars($solicitacao['setor']); ?></td>
                        <td><?php echo count($solicitacao['itens']); ?></td>
                        <td><span class="badge text-bg-<?php echo $cores[$solicitacao['status']] ?? 'secondary'; ?>"><?php echo htmlspecialchars(estoqueDemoStatus($solicitacao['status'])); ?></span></td>
                        <td class="text-end">
                            <a class="btn btn-outline-primary btn-sm" title="Visualizar"
                                href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_visualizar.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-eye"></i></a>
                            <?php if (estoqueDemoPode('analisar') && $solicitacao['status'] === 'pendente') { ?>
                                <a class="btn btn-outline-warning btn-sm" title="Analisar"
                                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_analisar.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-clipboard-check"></i></a>
                            <?php } ?>
                            <?php if (estoqueDemoPode('entregar') && $solicitacao['status'] === 'aprovada') { ?>
                                <a class="btn btn-outline-success btn-sm" title="Entregar"
                                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_entregar.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-box-arrow-up-right"></i></a>
                            <?php } ?>
                            <?php if (estoqueDemoPode('receber') && $solicitacao['status'] === 'enviado') { ?>
                                <a class="btn btn-outline-success btn-sm" title="Confirmar recebimento"
                                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_receber.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-box-arrow-in-down"></i></a>
                            <?php } ?>
                            <?php if (estoqueDemoPode('confirmar_divergencia') && $solicitacao['status'] === 'divergencia') { ?>
                                <a class="btn btn-outline-danger btn-sm" title="Conferir divergência"
                                    href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_divergencia.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-exclamation-diamond"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted"><?php echo count($estoqueSolicitacoesDemo); ?> solicitações fictícias</span>
        <a class="btn btn-outline-success btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitar.php')); ?>"><i class="bi bi-plus-lg me-1"></i>Nova solicitação</a>
    </div>
</div>

<?php estoqueDemoRodape(); ?>

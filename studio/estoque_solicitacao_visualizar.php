<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('solicitar');
$solicitacao = estoqueDemoSolicitacao((int) ($_GET['id'] ?? 101));
$cores = [
    'pendente' => 'warning', 'aprovada' => 'success', 'enviado' => 'info',
    'divergencia' => 'danger', 'concluido' => 'primary', 'recusada' => 'secondary',
];
estoqueDemoCabecalho('Visualizar solicitação', 'solicitacoes');
?>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
        <div><h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($solicitacao['numero']); ?></h2><span class="text-muted"><?php echo htmlspecialchars($solicitacao['data']); ?></span></div>
        <span class="badge text-bg-<?php echo $cores[$solicitacao['status']] ?? 'secondary'; ?>"><?php echo htmlspecialchars(estoqueDemoStatus($solicitacao['status'])); ?></span>
    </div>
    <div class="card-body">
        <?php if (estoqueDemoPode('analisar') && $solicitacao['status'] === 'pendente') { ?>
            <div class="alert alert-info"><i class="bi bi-eye me-1"></i>Ao abrir este pedido, o sistema registrará que ele foi visualizado pelo almoxarifado, com usuário, data e hora.</div>
        <?php } ?>
        <div class="row g-3">
            <div class="col-md-4"><div class="demo-detail"><span>Solicitante</span><strong><?php echo htmlspecialchars($solicitacao['solicitante']); ?></strong></div></div>
            <div class="col-md-4"><div class="demo-detail"><span>Perfil</span><strong><?php echo htmlspecialchars($solicitacao['perfil']); ?></strong></div></div>
            <div class="col-md-4"><div class="demo-detail"><span>Setor</span><strong><?php echo htmlspecialchars($solicitacao['setor']); ?></strong></div></div>
            <div class="col-12"><div class="demo-detail"><span>Justificativa</span><strong><?php echo htmlspecialchars($solicitacao['justificativa']); ?></strong></div></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Itens solicitados</h2></div>
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead><tr><th>Item</th><th>Solicitada</th><th>Aprovada</th><th>Enviada</th><th>Recebida</th><th>Situação</th></tr></thead>
            <tbody>
                <?php foreach ($solicitacao['itens'] as $item) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td><?php echo $item['solicitada'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                        <td><?php echo $item['aprovada'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                        <td><?php echo $item['enviada'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                        <td><?php echo $item['recebida'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                        <td><?php echo $item['recebida'] === $item['enviada'] && $item['recebida'] > 0 ? 'Conferido' : ($item['recebida'] > 0 ? 'Divergente' : ($item['enviada'] > 0 ? 'Em trânsito' : 'Aguardando')); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3"><h2 class="h5 text-info-emphasis mb-0">Rastreamento do pedido</h2></div>
    <div class="card-body">
        <div class="request-timeline">
            <?php foreach ($solicitacao['eventos'] as $evento) { ?>
                <div class="request-timeline-item">
                    <span class="request-timeline-icon"><i class="bi bi-check-lg"></i></span>
                    <div><strong><?php echo htmlspecialchars($evento['titulo']); ?></strong><small><?php echo htmlspecialchars($evento['data'] . ' · ' . $evento['responsavel']); ?></small></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <?php if (estoqueDemoPode('analisar') && $solicitacao['status'] === 'pendente') { ?>
        <a class="btn btn-outline-warning btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_analisar.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-clipboard-check me-1"></i>Analisar</a>
    <?php } ?>
    <?php if (estoqueDemoPode('entregar') && $solicitacao['status'] === 'aprovada') { ?>
        <a class="btn btn-outline-success btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_entregar.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-truck me-1"></i>Registrar envio</a>
    <?php } ?>
    <?php if (estoqueDemoPode('receber') && $solicitacao['status'] === 'enviado') { ?>
        <a class="btn btn-outline-success btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_receber.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-box-arrow-in-down me-1"></i>Conferir recebimento</a>
    <?php } ?>
    <?php if (estoqueDemoPode('confirmar_divergencia') && $solicitacao['status'] === 'divergencia') { ?>
        <a class="btn btn-outline-danger btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_divergencia.php', ['id' => $solicitacao['id']])); ?>"><i class="bi bi-exclamation-diamond me-1"></i>Conferir divergência</a>
    <?php } ?>
    <a class="btn btn-outline-primary btn-sm ms-auto" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacoes.php')); ?>">Voltar</a>
</div>

<?php estoqueDemoRodape(); ?>

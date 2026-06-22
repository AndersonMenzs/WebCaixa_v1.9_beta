<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('analisar');
$solicitacao = estoqueDemoSolicitacao((int) ($_GET['id'] ?? 101));
estoqueDemoCabecalho('Analisar solicitação', 'solicitacoes');
?>

<form data-demo-form data-demo-message="Análise fictícia concluída. A solicitação real não foi alterada.">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($solicitacao['numero']); ?></h2>
            <span class="text-muted"><?php echo htmlspecialchars($solicitacao['solicitante'] . ' · ' . $solicitacao['setor']); ?></span>
        </div>
        <div class="card-body">
            <p><strong>Justificativa:</strong> <?php echo htmlspecialchars($solicitacao['justificativa']); ?></p>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>Item</th><th>Disponível</th><th>Solicitada</th><th style="width:180px">Aprovar</th></tr></thead>
                    <tbody>
                        <?php foreach ($solicitacao['itens'] as $linha) {
                            $item = estoqueDemoItem($linha['item_id']); ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><?php echo $item['quantidade'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                                <td><?php echo $linha['solicitada'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td><input type="number" class="form-control form-control-sm" min="0" max="<?php echo min($linha['solicitada'], $item['quantidade']); ?>" value="<?php echo min($linha['solicitada'], $item['quantidade']); ?>" required></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <label class="form-label" for="observacao">Observação da análise</label>
            <textarea class="form-control" id="observacao" rows="3" placeholder="Registre ajustes ou justificativa para recusa parcial"></textarea>
        </div>
        <div class="card-footer bg-white d-flex flex-wrap gap-2">
            <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-check-lg me-1"></i>Aprovar quantidades</button>
            <button class="btn btn-outline-danger btn-sm" type="button" data-demo-action="Recusar solicitação"><i class="bi bi-x-lg me-1"></i>Recusar</button>
            <a class="btn btn-outline-secondary btn-sm ms-auto" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_visualizar.php', ['id' => $solicitacao['id']])); ?>">Cancelar</a>
        </div>
    </div>
</form>

<?php estoqueDemoRodape(); ?>


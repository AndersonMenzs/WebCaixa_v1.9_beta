<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('entregar');
$solicitacao = estoqueDemoSolicitacao((int) ($_GET['id'] ?? 102));
estoqueDemoCabecalho('Registrar envio', 'solicitacoes');
?>

<form data-demo-form data-demo-message="Envio fictício registrado. O estúdio agora verá o pedido como enviado.">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($solicitacao['numero']); ?></h2>
            <span class="text-muted"><?php echo htmlspecialchars($solicitacao['solicitante'] . ' · ' . $solicitacao['setor']); ?></span>
        </div>
        <div class="card-body">
            <div class="alert alert-info"><i class="bi bi-truck me-1"></i>Ao confirmar, o estúdio será avisado de que o pedido foi enviado e poderá conferir o recebimento.</div>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>Item</th><th>Saldo</th><th>Aprovada</th><th>Já enviada</th><th style="width:180px">Enviar agora</th></tr></thead>
                    <tbody>
                        <?php foreach ($solicitacao['itens'] as $linha) {
                            $item = estoqueDemoItem($linha['item_id']); ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><?php echo $item['quantidade'] . ' ' . htmlspecialchars($item['unidade']); ?></td>
                                <td><?php echo $linha['aprovada'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td><?php echo $linha['enviada'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td><input type="number" class="form-control form-control-sm" min="0" max="<?php echo max(0, $linha['aprovada'] - $linha['enviada']); ?>" value="<?php echo max(0, $linha['aprovada'] - $linha['enviada']); ?>" required></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="transportador">Enviado por *</label><input class="form-control" id="transportador" value="João P. — Almoxarifado" required></div>
                <div class="col-md-6"><label class="form-label" for="documento">Documento/Referência</label><input class="form-control" id="documento" value="<?php echo htmlspecialchars($solicitacao['numero']); ?>"></div>
                <div class="col-12"><label class="form-label" for="observacao">Observação do envio</label><textarea class="form-control" id="observacao" rows="2"></textarea></div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2">
            <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-truck me-1"></i>Confirmar envio</button>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_visualizar.php', ['id' => $solicitacao['id']])); ?>">Cancelar</a>
        </div>
    </div>
</form>

<?php estoqueDemoRodape(); ?>

<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('receber');
$solicitacao = estoqueDemoSolicitacao((int) ($_GET['id'] ?? 102));
estoqueDemoCabecalho('Conferir recebimento', 'solicitacoes');
?>

<form data-demo-form data-demo-message="Recebimento fictício confirmado. Se as quantidades coincidirem, o pedido será concluído; divergências voltarão ao almoxarifado.">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($solicitacao['numero']); ?></h2>
            <span class="text-muted">Enviado em <?php echo htmlspecialchars((string) $solicitacao['enviada_em']); ?> · confira antes de confirmar</span>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-box-arrow-in-down me-1"></i>
                Informe exatamente o que chegou ao estúdio. Quantidades diferentes das enviadas abrirão uma divergência para o almoxarifado.
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr><th>Item</th><th>Quantidade enviada</th><th style="width:210px">Quantidade recebida</th><th>Condição</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($solicitacao['itens'] as $linha) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><?php echo $linha['enviada'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td><input type="number" class="form-control form-control-sm" min="0" max="<?php echo $linha['enviada']; ?>" value="<?php echo $linha['enviada']; ?>" required></td>
                                <td>
                                    <select class="form-select form-select-sm">
                                        <option>Em perfeito estado</option>
                                        <option>Danificado</option>
                                        <option>Embalagem violada</option>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="recebedor">Conferido por *</label>
                    <input class="form-control" id="recebedor" value="<?php echo htmlspecialchars($solicitacao['solicitante']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="dataRecebimento">Data e hora *</label>
                    <input type="datetime-local" class="form-control" id="dataRecebimento" value="2026-06-22T10:30" required>
                </div>
                <div class="col-12">
                    <label class="form-label" for="observacao">Observação da conferência</label>
                    <textarea class="form-control" id="observacao" rows="3" placeholder="Informe faltas, danos ou outras diferenças"></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-wrap gap-2">
            <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-check2-circle me-1"></i>Confirmar recebimento</button>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_visualizar.php', ['id' => $solicitacao['id']])); ?>">Cancelar</a>
        </div>
    </div>
</form>

<?php estoqueDemoRodape(); ?>


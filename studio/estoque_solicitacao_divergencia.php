<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('confirmar_divergencia');
$solicitacao = estoqueDemoSolicitacao((int) ($_GET['id'] ?? 103));
estoqueDemoCabecalho('Conferir divergência', 'solicitacoes');
?>

<form data-demo-form data-demo-message="Tratamento fictício registrado. O almoxarifado e o estúdio receberão a atualização.">
    <div class="card border-danger shadow-sm">
        <div class="card-header bg-danger text-white py-3">
            <h2 class="h5 mb-1"><i class="bi bi-exclamation-diamond me-2"></i><?php echo htmlspecialchars($solicitacao['numero']); ?></h2>
            <span>O estúdio informou diferença entre o que foi enviado e recebido.</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>Item</th><th>Enviado</th><th>Recebido</th><th>Diferença</th></tr></thead>
                    <tbody>
                        <?php foreach ($solicitacao['itens'] as $linha) {
                            $diferenca = $linha['enviada'] - $linha['recebida']; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><?php echo $linha['enviada'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td><?php echo $linha['recebida'] . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                                <td class="text-danger fw-semibold"><?php echo $diferenca . ' ' . htmlspecialchars($linha['unidade']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="tratamento">Tratamento da divergência *</label>
                    <select class="form-select" id="tratamento" required>
                        <option value="">Selecione</option>
                        <option>Aceitar quantidade recebida e encerrar</option>
                        <option>Enviar quantidade faltante</option>
                        <option>Registrar perda no transporte</option>
                        <option>Solicitar devolução para conferência</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="responsavel">Conferido por *</label>
                    <input class="form-control" id="responsavel" value="João P. — Almoxarifado" required>
                </div>
                <div class="col-12">
                    <label class="form-label" for="parecer">Parecer do almoxarifado *</label>
                    <textarea class="form-control" id="parecer" rows="3" required></textarea>
                </div>
            </div>

            <div class="alert alert-warning mt-4 mb-0">
                A solicitação só será encerrada depois desta confirmação. Se houver complemento, ela voltará ao status de envio.
            </div>
        </div>
        <div class="card-footer bg-white d-flex gap-2">
            <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-check-lg me-1"></i>Confirmar tratamento</button>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_solicitacao_visualizar.php', ['id' => $solicitacao['id']])); ?>">Cancelar</a>
        </div>
    </div>
</form>

<?php estoqueDemoRodape(); ?>


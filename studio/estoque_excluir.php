<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('inativar');
$item = estoqueDemoItem((int) ($_GET['id'] ?? 1));
estoqueDemoCabecalho('Inativar item', 'itens');
?>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white py-3">
                <h2 class="h5 mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Confirmação necessária</h2>
            </div>
            <div class="card-body">
                <p>Você está prestes a inativar o item abaixo. Ele deixará de aparecer nas operações normais, mas seu histórico será preservado.</p>
                <div class="border rounded bg-light p-3 mb-3">
                    <strong><?php echo htmlspecialchars($item['nome']); ?></strong>
                    <span class="d-block text-muted"><?php echo htmlspecialchars($item['codigo']); ?> · Saldo atual: <?php echo $item['quantidade']; ?> <?php echo htmlspecialchars($item['unidade']); ?></span>
                </div>
                <form data-demo-form data-demo-message="Item fictício inativado. O cadastro real não foi alterado.">
                    <label for="motivo" class="form-label">Motivo da inativação *</label>
                    <textarea class="form-control" id="motivo" rows="3" required></textarea>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="confirmar" required>
                        <label class="form-check-label" for="confirmar">Confirmo que revisei o item e desejo inativá-lo.</label>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Confirmar inativação</button>
                        <a class="btn btn-outline-secondary btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_visualizar.php', ['id' => $item['id']])); ?>">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php estoqueDemoRodape(); ?>


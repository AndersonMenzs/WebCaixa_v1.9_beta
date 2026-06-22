<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('editar');
$item = estoqueDemoItem((int) ($_GET['id'] ?? 1));
estoqueDemoCabecalho('Editar item', 'itens');
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h2 class="h5 text-info-emphasis mb-1"><?php echo htmlspecialchars($item['nome']); ?></h2>
        <span class="text-muted"><?php echo htmlspecialchars($item['codigo']); ?></span>
    </div>
    <div class="card-body">
        <form data-demo-form data-demo-message="Alterações fictícias salvas. O cadastro real não foi modificado.">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label" for="codigo">Código *</label><input class="form-control" id="codigo" value="<?php echo htmlspecialchars($item['codigo']); ?>" required></div>
                <div class="col-md-6"><label class="form-label" for="nome">Nome *</label><input class="form-control" id="nome" value="<?php echo htmlspecialchars($item['nome']); ?>" required></div>
                <div class="col-md-3"><label class="form-label" for="status">Status *</label><select class="form-select" id="status"><option>Ativo</option><option>Inativo</option></select></div>
                <div class="col-12"><label class="form-label" for="descricao">Descrição</label><textarea class="form-control" id="descricao" rows="3"><?php echo htmlspecialchars($item['descricao']); ?></textarea></div>
                <div class="col-md-4"><label class="form-label" for="categoria">Categoria *</label><select class="form-select" id="categoria"><option selected><?php echo htmlspecialchars($item['categoria']); ?></option><option>Beleza</option><option>Limpeza</option><option>Escritório</option></select></div>
                <div class="col-md-4"><label class="form-label" for="finalidade">Finalidade *</label><select class="form-select" id="finalidade"><option selected><?php echo htmlspecialchars($item['finalidade']); ?></option><option>Venda</option><option>Consumo interno</option><option>Uso misto</option></select></div>
                <div class="col-md-4"><label class="form-label" for="unidade">Unidade *</label><input class="form-control" id="unidade" value="<?php echo htmlspecialchars($item['unidade']); ?>" required></div>
                <div class="col-md-4"><label class="form-label" for="minimo">Estoque mínimo *</label><input type="number" class="form-control" id="minimo" value="<?php echo $item['minimo']; ?>" min="0" step=".01" required></div>
                <div class="col-md-4"><label class="form-label" for="custo">Valor de custo</label><input type="number" class="form-control" id="custo" value="<?php echo $item['custo']; ?>" min="0" step=".01"></div>
                <div class="col-md-4"><label class="form-label" for="preco">Preço de venda</label><input type="number" class="form-control" id="preco" value="<?php echo $item['preco']; ?>" min="0" step=".01"></div>
                <div class="col-md-8"><label class="form-label" for="localizacao">Localização *</label><input class="form-control" id="localizacao" value="<?php echo htmlspecialchars($item['localizacao']); ?>" required></div>
                <div class="col-md-4"><label class="form-label" for="validade">Validade</label><input class="form-control" id="validade" value="<?php echo htmlspecialchars($item['validade']); ?>"></div>
            </div>
            <div class="alert alert-secondary mt-4"><i class="bi bi-lock me-1"></i>O saldo atual não pode ser editado aqui. Utilize uma movimentação de ajuste.</div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-check-lg me-1"></i>Salvar alterações</button>
                <a class="btn btn-outline-secondary btn-sm" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque_visualizar.php', ['id' => $item['id']])); ?>">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php estoqueDemoRodape(); ?>


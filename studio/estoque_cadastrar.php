<?php
require_once __DIR__ . '/estoque_demo_layout.php';
estoqueDemoExigir('cadastrar');
estoqueDemoCabecalho('Cadastrar item', 'cadastrar');
?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h2 class="h5 text-info-emphasis mb-0">Dados do item</h2>
    </div>
    <div class="card-body">
        <form data-demo-form data-demo-message="Item fictício cadastrado com sucesso. Nenhum dado foi gravado.">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="codigo">Código *</label>
                    <input class="form-control" id="codigo" value="EST-009" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="nome">Nome *</label>
                    <input class="form-control" id="nome" placeholder="Nome do item" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="status">Status *</label>
                    <select class="form-select" id="status" required>
                        <option value="A">Ativo</option>
                        <option value="I">Inativo</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="descricao">Descrição</label>
                    <textarea class="form-control" id="descricao" rows="3"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="categoria">Categoria *</label>
                    <select class="form-select" id="categoria" required>
                        <option value="">Selecione</option>
                        <option>Beleza</option>
                        <option>Descartáveis</option>
                        <option>Embalagem</option>
                        <option>Escritório</option>
                        <option>Limpeza</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="finalidade">Finalidade *</label>
                    <select class="form-select" id="finalidade" required>
                        <option value="">Selecione</option>
                        <option>Venda</option>
                        <option>Consumo interno</option>
                        <option>Uso misto</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="unidade">Unidade *</label>
                    <select class="form-select" id="unidade" required>
                        <option>UN</option>
                        <option>FR</option>
                        <option>CX</option>
                        <option>PC</option>
                        <option>KG</option>
                        <option>L</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h3 class="h6 text-info-emphasis mb-3">Controle do estoque</h3>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="quantidade">Quantidade inicial *</label>
                    <input type="number" class="form-control" id="quantidade" min="0" step=".01" value="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="minimo">Estoque mínimo *</label>
                    <input type="number" class="form-control" id="minimo" min="0" step=".01" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="custo">Valor de custo</label>
                    <div class="input-group"><span class="input-group-text">R$</span><input type="number" class="form-control" id="custo" min="0" step=".01"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="preco">Preço de venda</label>
                    <div class="input-group"><span class="input-group-text">R$</span><input type="number" class="form-control" id="preco" min="0" step=".01"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="localizacao">Localização física *</label>
                    <input class="form-control" id="localizacao" placeholder="Ex.: Prateleira A1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="validade">Controla validade?</label>
                    <select class="form-select" id="validade"><option>Não</option><option>Sim</option></select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="produto">Vínculo comercial</label>
                    <select class="form-select" id="produto">
                        <option value="">Sem vínculo</option>
                        <option>Produto 01</option>
                        <option>Produto 02</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-outline-success btn-sm" type="submit"><i class="bi bi-check-lg me-1"></i>Cadastrar</button>
                <button class="btn btn-outline-secondary btn-sm" type="reset">Limpar</button>
                <a class="btn btn-outline-primary btn-sm ms-auto" href="<?php echo htmlspecialchars(estoqueDemoUrl('estoque.php')); ?>">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php estoqueDemoRodape(); ?>


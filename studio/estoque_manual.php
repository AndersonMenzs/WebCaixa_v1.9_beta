<?php
require_once __DIR__ . '/estoque_demo_layout.php';

function manualInline(string $texto): string
{
    $texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    $texto = preg_replace('/!\[([^\]]*)\]\(([^)]+)\)/', '<button class="manual-image-button" type="button" data-bs-toggle="modal" data-bs-target="#manualImageModal" data-image="../$2" data-title="$1"><img src="../$2" alt="$1" loading="lazy"></button>', $texto);
    $texto = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $texto);
    $texto = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $texto);
    $texto = preg_replace('/`([^`]+)`/', '<code>$1</code>', $texto);
    return $texto;
}

function manualSlug(string $texto, array &$usados): string
{
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
    $slug = strtolower((string) $slug);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');
    $slug = $slug !== '' ? $slug : 'secao';
    $base = $slug;
    $contador = 2;

    while (isset($usados[$slug])) {
        $slug = $base . '-' . $contador++;
    }

    $usados[$slug] = true;
    return $slug;
}

function renderizarManual(string $markdown): array
{
    $linhasOriginais = preg_split('/\R/', $markdown);
    $linhas = [];
    $emBlocoCodigo = false;

    for ($i = 0, $total = count($linhasOriginais); $i < $total; $i++) {
        $linha = $linhasOriginais[$i];

        if (substr($linha, 0, 3) === '```') {
            $emBlocoCodigo = !$emBlocoCodigo;
            $linhas[] = $linha;
            continue;
        }

        if ($emBlocoCodigo || trim($linha) === '') {
            $linhas[] = $linha;
            continue;
        }

        if (substr($linha, 0, 1) === '>') {
            $partes = [trim(substr($linha, 1))];
            while ($i + 1 < $total && substr($linhasOriginais[$i + 1], 0, 1) === '>') {
                $i++;
                $partes[] = trim(substr($linhasOriginais[$i], 1));
            }
            $linhas[] = '> ' . implode(' ', $partes);
            continue;
        }

        $especial = preg_match('/^(#{1,4}\s|---$|\s*-\s|\s*\d+\.\s|\s*\||!\[)/', $linha);
        if (!$especial) {
            $partes = [trim($linha)];
            while ($i + 1 < $total) {
                $proxima = $linhasOriginais[$i + 1];
                if (
                    trim($proxima) === '' ||
                    preg_match('/^(#{1,4}\s|---$|```|\s*-\s|\s*\d+\.\s|\s*\||>\s?|!\[)/', $proxima)
                ) {
                    break;
                }
                $i++;
                $partes[] = trim($proxima);
            }
            $linhas[] = implode(' ', $partes);
            continue;
        }

        $linhas[] = $linha;
    }

    $html = [];
    $sumario = [];
    $idsUsados = [];
    $lista = null;
    $emCodigo = false;
    $codigo = [];
    $emTabela = false;

    $fecharLista = static function () use (&$html, &$lista): void {
        if ($lista !== null) {
            $html[] = '</' . $lista . '>';
            $lista = null;
        }
    };

    foreach ($linhas as $indice => $linha) {
        if (substr($linha, 0, 3) === '```') {
            $fecharLista();
            if ($emCodigo) {
                $html[] = '<pre><code>' . htmlspecialchars(implode("\n", $codigo), ENT_QUOTES, 'UTF-8') . '</code></pre>';
                $codigo = [];
                $emCodigo = false;
            } else {
                $emCodigo = true;
            }
            continue;
        }

        if ($emCodigo) {
            $codigo[] = $linha;
            continue;
        }

        if (preg_match('/^(#{1,4})\s+(.+)$/', $linha, $cabecalho)) {
            $fecharLista();
            $nivel = strlen($cabecalho[1]);
            $titulo = trim($cabecalho[2]);
            $id = manualSlug($titulo, $idsUsados);
            $html[] = sprintf('<h%d id="%s">%s</h%d>', $nivel, $id, manualInline($titulo), $nivel);
            if ($nivel <= 2) {
                $sumario[] = ['nivel' => $nivel, 'id' => $id, 'titulo' => $titulo];
            }
            continue;
        }

        if (trim($linha) === '---') {
            $fecharLista();
            $html[] = '<hr>';
            continue;
        }

        if (preg_match('/^>\s?(.*)$/', $linha, $citacao)) {
            $fecharLista();
            $html[] = '<blockquote>' . manualInline($citacao[1]) . '</blockquote>';
            continue;
        }

        $proxima = $linhas[$indice + 1] ?? '';
        if (strpos($linha, '|') !== false && preg_match('/^\s*\|?[\s:|-]+\|[\s:|-]+/', $proxima)) {
            $fecharLista();
            $celulas = array_values(array_filter(array_map('trim', explode('|', trim($linha, " \t|"))), static fn($v) => $v !== ''));
            $html[] = '<div class="table-responsive"><table class="table table-striped table-hover align-middle manual-table"><thead><tr>';
            foreach ($celulas as $celula) {
                $html[] = '<th>' . manualInline($celula) . '</th>';
            }
            $html[] = '</tr></thead><tbody>';
            $emTabela = true;
            continue;
        }

        if ($emTabela && preg_match('/^\s*\|?[\s:|-]+\|[\s:|-]+/', $linha)) {
            continue;
        }

        if ($emTabela && strpos($linha, '|') !== false) {
            $celulas = array_map('trim', explode('|', trim($linha, " \t|")));
            $html[] = '<tr>';
            foreach ($celulas as $celula) {
                $html[] = '<td>' . manualInline($celula) . '</td>';
            }
            $html[] = '</tr>';
            continue;
        }

        if ($emTabela) {
            $html[] = '</tbody></table></div>';
            $emTabela = false;
        }

        if (preg_match('/^\s*-\s+(.+)$/', $linha, $item)) {
            if ($lista !== 'ul') {
                $fecharLista();
                $html[] = '<ul>';
                $lista = 'ul';
            }
            $html[] = '<li>' . manualInline($item[1]) . '</li>';
            continue;
        }

        if (preg_match('/^\s*\d+\.\s+(.+)$/', $linha, $item)) {
            if ($lista !== 'ol') {
                $fecharLista();
                $html[] = '<ol>';
                $lista = 'ol';
            }
            $html[] = '<li>' . manualInline($item[1]) . '</li>';
            continue;
        }

        if (trim($linha) === '') {
            $fecharLista();
            continue;
        }

        $fecharLista();
        $html[] = '<p>' . manualInline(trim($linha)) . '</p>';
    }

    $fecharLista();
    if ($emTabela) {
        $html[] = '</tbody></table></div>';
    }

    return ['html' => implode("\n", $html), 'sumario' => $sumario];
}

$manualPath = dirname(__DIR__) . '/MANUAL_ESTOQUE.md';
$markdown = is_file($manualPath) ? file_get_contents($manualPath) : '# Manual não encontrado';
$manual = renderizarManual((string) $markdown);

estoqueDemoCabecalho('Manual do estoque', 'manual');
?>

<div class="row g-4 manual-layout">
    <div class="col-xl-3">
        <aside class="card border-0 shadow-sm manual-toc">
            <div class="card-header bg-white py-3">
                <h2 class="h6 text-info-emphasis mb-0"><i class="bi bi-list-ul me-2"></i>Neste manual</h2>
            </div>
            <nav class="list-group list-group-flush">
                <?php foreach ($manual['sumario'] as $secao) { ?>
                    <a class="list-group-item list-group-item-action manual-toc-level-<?php echo $secao['nivel']; ?>"
                        href="#<?php echo htmlspecialchars($secao['id']); ?>">
                        <?php echo htmlspecialchars($secao['titulo']); ?>
                    </a>
                <?php } ?>
            </nav>
        </aside>
    </div>

    <div class="col-xl-9">
        <article class="card border-0 shadow-sm">
            <div class="card-body manual-content">
                <?php echo $manual['html']; ?>
            </div>
        </article>
    </div>
</div>

<button type="button" class="btn btn-primary manual-top-button" id="manualTopButton" title="Voltar ao início">
    <i class="bi bi-arrow-up"></i>
</button>

<div class="modal fade" id="manualImageModal" tabindex="-1" aria-labelledby="manualImageTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="manualImageTitle">Imagem do manual</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center bg-light">
                <img id="manualImagePreview" class="img-fluid rounded border" src="" alt="">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('manualImageModal');
    const preview = document.getElementById('manualImagePreview');
    const title = document.getElementById('manualImageTitle');
    const topButton = document.getElementById('manualTopButton');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        preview.src = button.dataset.image;
        preview.alt = button.dataset.title;
        title.textContent = button.dataset.title || 'Imagem do manual';
    });

    window.addEventListener('scroll', function () {
        topButton.classList.toggle('show', window.scrollY > 500);
    });

    topButton.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>

<?php estoqueDemoRodape(); ?>

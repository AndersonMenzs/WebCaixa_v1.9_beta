<?php
// Debug - DESABILITADO EM PRODUÇÃO
// 
// error_reporting(0);

// Iniciar sessão e incluir configurações necessárias
session_start();
include "../cabecprs.php";

// Verificar se o usuário está autenticado
if (!isset($_REQUEST['c_s']) || empty($_REQUEST['c_s'])) {
    header('Location: index.php');
    exit;
}

// Validar e sanitizar entrada
$lg_user = trim($_REQUEST['c_s']);
$user = substr($lg_user, 0, 8);
$pss = substr($lg_user, 8, 40);

// Incluir verificação de usuário

include "us_sist.php";
if ($ch == 'no') {
    include "us_cad.php";
}

// Definir permissões baseadas no resultado da verificação
$permitido = ($ch == 'ok-enc' || $ch == 'ok-cai' || $ch == 'ok');

// Arquivo para contar impressões
$contadorImpressoes = 'contador_impressoes.txt';

// Função para formatar nome do arquivo (APENAS PARA EXIBIÇÃO)
function formatarNomeArquivo($nomeArquivo)
{
    // Remover extensão
    $nomeSemExtensao = pathinfo($nomeArquivo, PATHINFO_FILENAME);
    // Substituir underscores por espaços
    $nomeComEspacos = str_replace('_', ' ', $nomeSemExtensao);
    // Converter para caixa alta
    return strtoupper($nomeComEspacos);
}

// Função para registrar impressão
function registrarImpressao($arquivo, $quantidade, $contadorFile)
{
    $contador = [];

    if (file_exists($contadorFile)) {
        $contador = json_decode(file_get_contents($contadorFile), true) ?: [];
    }

    if (!isset($contador[$arquivo])) {
        $contador[$arquivo] = 0;
    }

    $contador[$arquivo] += intval($quantidade);
    file_put_contents($contadorFile, json_encode($contador));

    return $contador[$arquivo];
}

// Função para obter contagem de impressões
function obterContagemImpressoes($arquivo, $contadorFile)
{
    if (file_exists($contadorFile)) {
        $contador = json_decode(file_get_contents($contadorFile), true) ?: [];
        return isset($contador[$arquivo]) ? $contador[$arquivo] : 0;
    }
    return 0;
}

// Processar impressão se solicitado
if ($permitido && isset($_POST['imprimir']) && !empty($_POST['arquivo_selecionado'])) {
    $arquivoSelecionado = basename($_POST['arquivo_selecionado']);
    $quantidade = 1; // Sempre 1 impressão
    $caminhoCompleto = "./impressos/" . $arquivoSelecionado;

    // Validar segurança
    $extensoesPermitidas = ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($arquivoSelecionado, PATHINFO_EXTENSION));

    if (in_array($ext, $extensoesPermitidas) && file_exists($caminhoCompleto)) {
        // Registrar impressão
        $totalImpressoes = registrarImpressao($arquivoSelecionado, $quantidade, $contadorImpressoes);

        // Determinar o tipo de conteúdo
        $tiposConteudo = [
            'pdf' => 'application/pdf',
            'txt' => 'text/plain',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];

        $contentType = isset($tiposConteudo[$ext]) ? $tiposConteudo[$ext] : 'application/octet-stream';

        // Enviar arquivo para impressão
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: inline; filename="' . $arquivoSelecionado . '"');
        header('Content-Length: ' . filesize($caminhoCompleto));
        readfile($caminhoCompleto);
        exit;
    } else {
        // Se o arquivo não for encontrado, redirecionar de volta com erro
        header('Location: ' . $_SERVER['PHP_SELF'] . '?c_s=' . urlencode($lg_user) . '&erro=arquivo_nao_encontrado');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>WebCaixa v1.20.4_beta - Impressões</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
        body {
            margin: 5% 3% 0 3%;
            border: 3px solid gray;
            padding: 10px;
            font-family: sans-serif;
            background-image: url('../images/bg1.jpg');
            color: #FFFFFF;
        }

        .container {
            text-align: center;
        }

        .document-list {
            margin: 20px auto;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            max-width: 600px;
        }

        .form-group {
            margin: 20px 0;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: gold;
        }

        select,
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 1.1em;
            background-color: white;
            color: #333;
        }

        select:focus,
        input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-imprimir {
            padding: 15px 40px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.2em;
            margin-top: 20px;
            font-weight: bold;
        }

        .btn-imprimir:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .btn-imprimir:hover:not(:disabled) {
            background-color: #218838;
            transform: scale(1.05);
            transition: transform 0.2s;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 1.2em;
            margin: 20px 0;
        }

        .success-message {
            color: #28a745;
            font-size: 1.2em;
            margin: 20px 0;
        }

        .blink {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .instrucoes {
            margin: 15px 0;
            color: #ccc;
            font-style: normal;
            text-align: center;
            font-weight: bold;
        }

        .quantidade-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantidade-group input {
            width: 120px;
            flex-shrink: 0;
        }

        .arquivo-info {
            font-size: 0.9em;
            color: #ccc;
            margin-top: 5px;
        }
    </style>

    <script>
        // Array para armazenar informações dos arquivos
        const arquivosInfo = {
            <?php
            // Preparar informações dos arquivos para JavaScript
            if (is_dir("./impressos/") && $handle = opendir("./impressos/")) {
                $infoArray = [];
                while (($file = readdir($handle)) !== false) {
                    if (
                        $file != "." && $file != ".." &&
                        $file != "index.php" && $file != "index.html" && $file != "index.htm"
                    ) {

                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $extensoesPermitidas = ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];

                        if (in_array($ext, $extensoesPermitidas)) {
                            $quantidadeImpressoes = obterContagemImpressoes($file, $contadorImpressoes);
                            $infoArray[] = "'" . $file . "': {total: " . $quantidadeImpressoes . ", nomeReal: '" . $file . "'}";
                        }
                    }
                }
                closedir($handle);
                echo implode(", ", $infoArray);
            }
            ?>
        }

        function atualizarInfo() {
            const select = document.getElementById('arquivo_selecionado');
            const arquivoReal = select.value;
            const infoBox = document.getElementById('info-impressoes');

            const btnImprimir = document.getElementById('btnImprimir');

            if (arquivoReal && arquivosInfo[arquivoReal]) {
                btnImprimir.disabled = false;
                infoBox.innerHTML = ""; // Remove as informações
                infoBox.style.display = 'none'; // Opcional: esconde o box
            } else {
                btnImprimir.disabled = true;
                infoBox.style.display = 'none';
            }
        }

        // Ajuste a função imprimirDocumento para não usar quantidade
        function imprimirDocumento() {
            const select = document.getElementById('arquivo_selecionado');

            if (!select.value) {
                alert('Selecione um documento para impressão!');
                select.focus();
                return;
            }

            if (!arquivosInfo[select.value]) {
                alert('Arquivo não encontrado ou não permitido!');
                return;
            }

            // Abrir o arquivo em uma nova janela para visualização
            window.open('./impressos/' + encodeURIComponent(select.value), '_blank');
        }

        // Prevenir F5
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F5' || event.keyCode === 116) {
                event.preventDefault();
                return false;
            }
        });

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            atualizarInfo();

            <?php if (isset($_GET['erro']) && $_GET['erro'] == 'arquivo_nao_encontrado'): ?>
                alert('Erro: Arquivo não encontrado. Verifique se o arquivo existe na pasta de impressões.');
            <?php endif; ?>
        });
    </script>
</head>

<body>
    <div class="container">
        <font color="gold" size="6">
            <b>
                <center><u><i>DOCUMENTOS PARA IMPRESSÕES</i></u></center>
            </b>
        </font>

        <br><br>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="success-message">
                <center>✅ Documento impresso com sucesso!</center>
            </div>
        <?php endif; ?>

        <?php if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
            <form id="formImpressao" method="post" action="">
                <input type="hidden" name="imprimir" value="1">

                <div class="document-list">
                    <div class="instrucoes">
                        Selecione o documento para impressão
                    </div>

                    <div class="form-group">
                        <label for="arquivo_selecionado">Selecione o Documento:</label>
                        <select name="arquivo_selecionado" id="arquivo_selecionado" onchange="atualizarInfo()">
                            <option value="">-- Selecione um documento --</option>
                            <?php
                            // Ler documentos na pasta para impressão com validação
                            $dir = "./impressos/";
                            $arquivos = [];

                            if (is_dir($dir) && is_readable($dir)) {
                                $arquivosPermitidos = ['pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];

                                if ($handle = opendir($dir)) {
                                    while (($file = readdir($handle)) !== false) {
                                        if (
                                            $file != "." && $file != ".." &&
                                            $file != "index.php" && $file != "index.html" && $file != "index.htm"
                                        ) {

                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            if (in_array($ext, $arquivosPermitidos)) {
                                                $arquivos[] = $file;
                                            }
                                        }
                                    }
                                    closedir($handle);

                                    // Ordenar arquivos alfabeticamente pelo nome formatado
                                    usort($arquivos, function ($a, $b) {
                                        return strcmp(formatarNomeArquivo($a), formatarNomeArquivo($b));
                                    });

                                    if (!empty($arquivos)) {
                                        foreach ($arquivos as $arquivo) {
                                            $nomeFormatado = formatarNomeArquivo($arquivo);
                                            $quantidadeImpressoes = obterContagemImpressoes($arquivo, $contadorImpressoes);

                                            echo '<option value="' . htmlspecialchars($arquivo, ENT_QUOTES, 'UTF-8') . '" 
                                                    data-total="' . $quantidadeImpressoes . '">' .
                                                htmlspecialchars($nomeFormatado, ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">-- Nenhum documento encontrado --</option>';
                                    }
                                }
                            } else {
                                echo '<option value="">-- Erro ao acessar diretório --</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="button" id="btnImprimir" class="btn-imprimir" onclick="imprimirDocumento()" disabled>
                        🖨️ IMPRIMIR DOCUMENTO
                    </button>

                    <div id="info-impressoes" style="display:none; margin-top:20px;"></div>
                </div>
            </form>

            <br><br>
            <center>
                <a href="index.php?c_s=<?php echo urlencode($lg_user); ?>">
                    <img src="./images/voltar.gif" alt="Voltar">
                </a>
            </center>

        <?php } else { ?>
            <div class="error-message">
                <br><br><br><br><br>
                <font size='6'><b>
                        <center>Acesso <font color='gold'>
                                <span class="blink"><u>não Autorizado</u></span>
                                <font color='#FFFFFF'>!!!</font>
                        </center>
                    </b></font>
                <br><br><br>

                <center>
                    <a href='index.php?c_s=<?php echo urlencode($lg_user); ?>'>
                        <img src='images/voltar.gif' alt='Voltar'>
                    </a>
                </center>
            </div>
        <?php } ?>

        <?php
        // Incluir rodapé
        $SisRot = "S-7.3";
        include "rodape.php";

        // Encerrar conexões se existirem
        if (isset($conec) && $conec) {
            mysqli_close($conec);
        }
        ?>
    </div>
</body>

</html>
<?php

function pedido_maleta_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function pedido_maleta_digits($value)
{
    return preg_replace('/\D+/', '', (string) $value);
}

function pedido_maleta_codigo_dls_valido($value)
{
    $anoAtual = date('y');

    return preg_match('/^DLS[0-9]+\/' . preg_quote($anoAtual, '/') . '$/', (string) $value) === 1;
}

function pedido_maleta_fetch_assoc($conec, $sql, $types = '', $params = array())
{
    $stmt = mysqli_prepare($conec, $sql);

    if (!$stmt) {
        throw new RuntimeException(mysqli_error($conec));
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    return $row ?: null;
}

function pedido_maleta_db_exists($conec, $dbselect)
{
    $stmt = mysqli_prepare($conec, 'SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $dbselect);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $exists = $result && mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return (bool) $exists;
}

function pedido_maleta_digital_db($conec, $std)
{
    $preferred = 'dig' . pedido_maleta_digits($std);

    if (pedido_maleta_db_exists($conec, $preferred)) {
        return $preferred;
    }

    return pedido_maleta_db_exists($conec, 'dig'.$std) ? 'dig'.$std : $preferred;
}

function pedido_maleta_consultar_digital($conecDigital, $dbselect, $envelope)
{
    if (!mysqli_select_db($conecDigital, $dbselect)) {
        throw new RuntimeException('Banco WebDigital indisponivel: ' . $dbselect);
    }

    $escolha = pedido_maleta_fetch_assoc(
        $conecDigital,
        'SELECT pasta, envelope FROM escolha WHERE envelope = ? LIMIT 1',
        's',
        array($envelope)
    );

    if (!$escolha) {
        throw new RuntimeException('Envelope nao encontrado no WebDigital.');
    }

    $pastaEscolha = trim($escolha['pasta']);
    $pastaFotog = $pastaEscolha;

    if (substr($pastaFotog, 0, 1) === 'L') {
        $pastaFotog = 'T' . substr($pastaFotog, 1);
    }

    $fotog = pedido_maleta_fetch_assoc(
        $conecDigital,
        'SELECT pc, pasta, modelo, cliente, cpf FROM fotog WHERE pasta = ? LIMIT 1',
        's',
        array($pastaFotog)
    );

    if (!$fotog) {
        throw new RuntimeException('Pasta encontrada, mas dados da tabela fotog nao foram localizados.');
    }

    return array(
        'envelope' => trim($escolha['envelope']),
        'pasta' => $pastaFotog,
        'pastaEscolha' => $pastaEscolha,
        'pc' => trim($fotog['pc']),
        'nomeModelo' => trim($fotog['modelo']),
        'nomeCliente' => trim($fotog['cliente']),
        'cpf' => trim($fotog['cpf']),
    );
}

function pedido_maleta_colaboradora($conec, $matricula)
{
    $dbAtual = pedido_maleta_fetch_assoc($conec, 'SELECT DATABASE() AS db');

    mysqli_select_db($conec, 'cadfunc');
    $row = pedido_maleta_fetch_assoc(
        $conec,
        'SELECT nome FROM pessoal WHERE mat = ? LIMIT 1',
        's',
        array($matricula)
    );

    if ($dbAtual && $dbAtual['db']) {
        mysqli_select_db($conec, $dbAtual['db']);
    }

    return $row ? trim($row['nome']) : '';
}

function pedido_maleta_consultar_registro($conec, $numdoc)
{
    return pedido_maleta_fetch_assoc(
        $conec,
        'SELECT reg, numdoc, datarec, horarec, operador, mat_vend, vendedora, cliente FROM registro WHERE numdoc = ? AND estorno <> "x" ORDER BY datarec DESC, reg DESC LIMIT 1',
        's',
        array($numdoc)
    );
}

function pedido_maleta_consultar_codigo_dls($conec, $codigoAutorizacaoDls)
{
    return pedido_maleta_fetch_assoc(
        $conec,
        'SELECT idPedidoMaleta, envelope, dt_pedido FROM tb_pedido_maleta WHERE codigoAutorizacaoDls = ? LIMIT 1',
        's',
        array($codigoAutorizacaoDls)
    );
}

function pedido_maleta_config()
{
    $config = include __DIR__ . '/pedido_maleta_config.php';
    $localFile = __DIR__ . '/pedido_maleta_config.local.php';

    if (is_readable($localFile)) {
        $localConfig = include $localFile;
        $config = array_replace_recursive($config, is_array($localConfig) ? $localConfig : array());
    }

    return $config;
}

function pedido_maleta_api_key($std)
{
    $config = pedido_maleta_config();
    $std = (string) $std;

    return $config['api_keys'][$std] ?? getenv('PEDIDO_MALETA_API_KEY_' . $std) ?: getenv('PEDIDO_MALETA_API_KEY') ?: '';
}

function pedido_maleta_enviar_erp($conec, $idPedidoMaleta, $std)
{
    $config = pedido_maleta_config();
    $apiKey = pedido_maleta_api_key($std);

    if ($apiKey == '') {
        return array('success' => false, 'message' => 'Chave da API do ERP nao configurada no WebCaixa.');
    }

    if (empty($config['erp_url'])) {
        return array('success' => false, 'message' => 'URL do ERP nao configurada no WebCaixa.');
    }

    $pedido = pedido_maleta_fetch_assoc(
        $conec,
        'SELECT * FROM tb_pedido_maleta WHERE idPedidoMaleta = ? LIMIT 1',
        'i',
        array($idPedidoMaleta)
    );

    if (!$pedido) {
        return array('success' => false, 'message' => 'Pedido local nao encontrado para envio.');
    }

    $payload = array(
        'idPedidoWebCaixa' => (int) $pedido['idPedidoMaleta'],
        'chaveIntegracao' => $pedido['chaveIntegracao'],
        'envelope' => $pedido['envelope'],
        'pasta' => $pedido['pasta'],
        'pc' => $pedido['pc'],
        'nomeModelo' => $pedido['nomeModelo'],
        'nomeCliente' => $pedido['nomeCliente'],
        'cpf' => $pedido['cpf'],
        'codigoEstudio' => $pedido['codigoEstudio'],
        'numdoc' => $pedido['numdoc'],
        'contrato' => $pedido['contrato'],
        'cor' => $pedido['cor'],
        'codigoAutorizacaoDls' => $pedido['codigoAutorizacaoDls'],
        'matricula' => $pedido['matricula'],
        'colaboradora' => $pedido['colaboradora'],
        'observacoesWebCaixa' => $pedido['observacoesWebCaixa'],
        'dt_pedido' => $pedido['dt_pedido'],
    );

    $url = rtrim($config['erp_url'], '/') . '/modules/lab/api/pedido_maleta/criar.php';
    $ch = curl_init($url);

    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'X-Api-Key: ' . $apiKey,
            'X-Codigo-Estudio: ' . $std,
        ),
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT => 20,
    ));

    $responseBody = curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    mysqli_query($conec, 'UPDATE tb_pedido_maleta SET tentativasEnvioErp = tentativasEnvioErp + 1 WHERE idPedidoMaleta = ' . (int) $idPedidoMaleta);

    if ($responseBody === false || $curlError != '') {
        return array('success' => false, 'message' => 'Falha ao conectar ao ERP: ' . $curlError);
    }

    $response = json_decode($responseBody, true);

    if (!is_array($response)) {
        return array('success' => false, 'message' => 'Resposta invalida do ERP. HTTP ' . $httpCode);
    }

    if ($httpCode < 200 || $httpCode >= 300 || empty($response['success'])) {
        return array('success' => false, 'message' => $response['message'] ?? ('Erro HTTP ' . $httpCode));
    }

    $data = $response['data'] ?? array();
    $idPedidoErp = isset($data['idPedidoMaleta']) ? (int) $data['idPedidoMaleta'] : 0;
    $statusPedido = $data['statusPedido'] ?? 'aguardando_labdigital';

    $stmt = mysqli_prepare($conec, 'UPDATE tb_pedido_maleta SET idPedidoErp = ?, statusPedido = ?, statusEnvioErp = "enviado", ultimoErroEnvioErp = NULL, dt_envioErp = CURRENT_TIMESTAMP, dt_confirmacaoErp = CURRENT_TIMESTAMP WHERE idPedidoMaleta = ?');
    mysqli_stmt_bind_param($stmt, 'isi', $idPedidoErp, $statusPedido, $idPedidoMaleta);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return array('success' => true, 'message' => $response['message'] ?? 'Pedido enviado ao ERP.');
}

function pedido_maleta_registrar_erro_envio($conec, $idPedidoMaleta, $erro)
{
    $status = 'erro_envio';
    $erro = substr((string) $erro, 0, 1000);
    $stmt = mysqli_prepare($conec, 'UPDATE tb_pedido_maleta SET statusEnvioErp = ?, ultimoErroEnvioErp = ? WHERE idPedidoMaleta = ?');
    mysqli_stmt_bind_param($stmt, 'ssi', $status, $erro, $idPedidoMaleta);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$mensagem = '';
$tipoMensagem = 'lime';
$dados = null;
$registro = null;

include "../cabecprs.php";

$Sis = 'S7';
$Rot = 'S7R-PM';
$lg_user = $_REQUEST['c_s'] ?? '';
$user = substr($lg_user, 0, 8);
$pss = substr($lg_user, 8, 40);
$ch = '';

include "us_sist.php";
if ($ch == 'no') {
    include "us_cad.php";
}
include "dbselect.php";
include "valida_caixa.php";

$codigoEstudio = isset($std) ? (string) $std : '';
$dbselectDigital = pedido_maleta_digital_db($conec, $codigoEstudio);
$envelope = trim($_POST['envelope'] ?? $_GET['envelope'] ?? '');
$numdoc = trim($_POST['numdoc'] ?? '');
$contrato = trim($_POST['contrato'] ?? '');
$cor = strtoupper(trim($_POST['cor'] ?? 'AZUL'));
$codigoAutorizacaoDls = strtoupper(trim($_POST['codigoAutorizacaoDls'] ?? ''));
$usarCodigoDls = ($_POST['usarCodigoDls'] ?? '') === 'S';
$observacoesWebCaixa = trim($_POST['observacoesWebCaixa'] ?? '');
$action = $_POST['action'] ?? '';

if ($usarCodigoDls) {
    $numdoc = '';
    $contrato = '';
}

if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $envelope != '') {
    try {
        include "conexao_digital.php";
        $dados = pedido_maleta_consultar_digital($conec_digital, $dbselectDigital, $envelope);
    } catch (Throwable $error) {
        $mensagem = $error->getMessage();
        $tipoMensagem = 'red';
    }
}

if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and !$usarCodigoDls and $numdoc != '') {
    try {
        $registro = pedido_maleta_consultar_registro($conec, $numdoc);
        if ($registro and $contrato == '') {
            $contrato = $registro['numdoc'];
        }
    } catch (Throwable $error) {
        $mensagem = $error->getMessage();
        $tipoMensagem = 'red';
    }
}

if (($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') and $action == 'salvar') {
    try {
        if (!$dados) {
            throw new RuntimeException('Consulte um envelope valido antes de salvar.');
        }
        if ($usarCodigoDls) {
            if ($codigoAutorizacaoDls == '') {
                throw new RuntimeException('Informe o Codigo DLS.');
            }
            if (!pedido_maleta_codigo_dls_valido($codigoAutorizacaoDls)) {
                throw new RuntimeException('Codigo DLS invalido. Use o formato DLS200/' . date('y') . '.');
            }
            $pedidoDlsExistente = pedido_maleta_consultar_codigo_dls($conec, $codigoAutorizacaoDls);
            if ($pedidoDlsExistente) {
                throw new RuntimeException('Codigo DLS ja utilizado no Pedido Maleta ' . $pedidoDlsExistente['idPedidoMaleta'] . '. Nao foi possivel salvar e enviar.');
            }
        } else {
            if ($numdoc == '') {
                throw new RuntimeException('Informe o recibo.');
            }
            if (!$registro) {
                throw new RuntimeException('Recibo nao encontrado no WebCaixa.');
            }
        }
        if (!in_array($cor, array('AZUL', 'VERMELHO', 'PINK'), true)) {
            throw new RuntimeException('Cor invalida.');
        }

        $matricula = $user;
        $colaboradora = pedido_maleta_colaboradora($conec, $user);
        if ($colaboradora == '' and $registro) {
            $colaboradora = trim($registro['vendedora'] ?? '');
        }

        $referenciaIntegracao = $usarCodigoDls ? ('DLS-' . $codigoAutorizacaoDls) : $numdoc;
        $chaveIntegracao = 'MAL-' . $referenciaIntegracao . '-' . $dados['envelope'];
        $statusPedido = 'pedido_aberto';
        $statusEnvioErp = 'pendente_envio';
        $dtPedido = date('Y-m-d H:i:s');
        $numdocPedido = $usarCodigoDls ? null : $numdoc;
        $contratoPedido = $usarCodigoDls ? null : $contrato;

        $stmt = mysqli_prepare($conec, '
            INSERT INTO tb_pedido_maleta
                (chaveIntegracao, envelope, pasta, pc, nomeModelo, nomeCliente, cpf, codigoEstudio,
                 numdoc, contrato, cor, codigoAutorizacaoDls, matricula, colaboradora,
                 statusPedido, statusEnvioErp, observacoesWebCaixa, dt_pedido)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                pasta = VALUES(pasta),
                pc = VALUES(pc),
                nomeModelo = VALUES(nomeModelo),
                nomeCliente = VALUES(nomeCliente),
                cpf = VALUES(cpf),
                codigoEstudio = VALUES(codigoEstudio),
                contrato = VALUES(contrato),
                cor = VALUES(cor),
                codigoAutorizacaoDls = VALUES(codigoAutorizacaoDls),
                matricula = VALUES(matricula),
                colaboradora = VALUES(colaboradora),
                observacoesWebCaixa = VALUES(observacoesWebCaixa),
                dt_atualizacao = CURRENT_TIMESTAMP
        ');

        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssssssssssss',
            $chaveIntegracao,
            $dados['envelope'],
            $dados['pasta'],
            $dados['pc'],
            $dados['nomeModelo'],
            $dados['nomeCliente'],
            $dados['cpf'],
            $codigoEstudio,
            $numdocPedido,
            $contratoPedido,
            $cor,
            $codigoAutorizacaoDls,
            $matricula,
            $colaboradora,
            $statusPedido,
            $statusEnvioErp,
            $observacoesWebCaixa,
            $dtPedido
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $rowPedido = pedido_maleta_fetch_assoc(
            $conec,
            'SELECT idPedidoMaleta FROM tb_pedido_maleta WHERE chaveIntegracao = ? LIMIT 1',
            's',
            array($chaveIntegracao)
        );
        $idPedidoMaleta = (int) $rowPedido['idPedidoMaleta'];

        $envio = pedido_maleta_enviar_erp($conec, $idPedidoMaleta, $codigoEstudio);
        if (!$envio['success']) {
            pedido_maleta_registrar_erro_envio($conec, $idPedidoMaleta, $envio['message']);
            $mensagem = 'Pedido salvo localmente, mas ainda nao enviado ao ERP: ' . $envio['message'];
            $tipoMensagem = 'gold';
        } else {
            $mensagem = 'Pedido Maleta salvo e enviado ao ERP.';
            $tipoMensagem = 'lime';
        }
    } catch (Throwable $error) {
        $mensagem = $error->getMessage();
        $tipoMensagem = 'red';
    }
}
?>
<html>
<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
            border: 3px solid gray;
            padding: 10px 10px 10px 10px;
            font-family: sans-serif;
        }
        .campos {
            background-color: #C0C0C0;
            font: 16px sans-serif;
            color: #000000;
        }
    </style>
    <script>
        function putFocus(formInst, elementInst) {
            if (document.forms.length > 0) {
                document.forms[formInst].elements[elementInst].focus();
            }
        }

        function F5(event) {
            var tecla = document.all ? window.event.keyCode : event.which;
            if (document.all) {
                window.event.keyCode = 0;
                window.event.returnValue = false;
            }
            if (tecla == 116) return false;
        }

        document.onkeydown = F5;

        var anoCodigoDls = '<?php echo date('y'); ?>';

        function mascararCodigoDls(campo) {
            var partes = campo.value.toUpperCase().replace(/^DLS/, '').split('/');
            var numero = partes[0].replace(/\D+/g, '');
            var anoDigitado = partes.length > 1 ? partes[1].replace(/\D+/g, '') : '';

            if (anoDigitado.indexOf(anoCodigoDls) === 0) {
                numero += anoDigitado.substring(anoCodigoDls.length).replace(/\D+/g, '');
            }

            campo.value = numero == '' ? 'DLS' : 'DLS' + numero + '/' + anoCodigoDls;

            if (numero != '' && campo.setSelectionRange) {
                var posicaoBarra = campo.value.indexOf('/');
                campo.setSelectionRange(posicaoBarra, posicaoBarra);
            }
        }

        function alternarCodigoDls() {
            var usarDls = document.getElementById('usarCodigoDls').checked;
            var numdoc = document.getElementById('numdoc');
            var contrato = document.getElementById('contrato');
            var dls = document.getElementById('codigoAutorizacaoDls');

            numdoc.disabled = usarDls;
            contrato.disabled = usarDls;
            dls.disabled = !usarDls;
            numdoc.required = !usarDls;
            dls.required = usarDls;

            if (usarDls) {
                numdoc.value = '';
                contrato.value = '';
                mascararCodigoDls(dls);
                dls.focus();
            } else {
                dls.value = '';
            }
        }
    </script>
</head>
<body background="../images/bg1.jpg" text="#FFFFFF" onLoad="putFocus(0,0); alternarCodigoDls();">
<?php if ($ch == 'ok-enc' or $ch == 'ok-cai' or $ch == 'ok') { ?>
    <font color="gold" size="6"><br>
        <b><center><u><i>PEDIDO MALETA</i></u></center></b>
    </font><br><br>

    <?php if ($mensagem != '') { ?>
        <center><font color="<?php echo pedido_maleta_h($tipoMensagem); ?>" size="4"><b><?php echo pedido_maleta_h($mensagem); ?></b></font></center><br>
    <?php } ?>

    <form name="frmconsulta" method="post" action="pedido_maleta.php?c_s=<?php echo pedido_maleta_h($lg_user); ?>">
        <input type="hidden" name="action" value="consultar">
        <table border="5" cellpadding="10" cellspacing="0" align="center">
            <tr>
                <td><font color="gold" size="5"><b><i>Envelope</i></b></font></td>
                <td><input type="text" name="envelope" size="18" maxlength="20" class="campos" value="<?php echo pedido_maleta_h($envelope); ?>"></td>
                <td align="center">
                    <input type="submit" value="Consultar">&nbsp;&nbsp;
                    <input type="reset" value="Limpar">
                </td>
            </tr>
        </table>
    </form>
    <br><br>

    <form name="frmpedido" method="post" action="pedido_maleta.php?c_s=<?php echo pedido_maleta_h($lg_user); ?>">
            <input type="hidden" name="action" value="salvar">
            <input type="hidden" name="envelope" value="<?php echo pedido_maleta_h($envelope); ?>">

            <table border="5" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <td><font color='gold' size='5'><b><i>Envelope</i></b></font></td>
                    <td><input class="campos" type="text" size="18" value="<?php echo pedido_maleta_h($dados['envelope'] ?? ''); ?>" readonly></td>
                    <td><font color='gold' size='5'><b><i>Pasta</i></b></font></td>
                    <td><input class="campos" type="text" size="24" value="<?php echo pedido_maleta_h($dados['pasta'] ?? ''); ?>" readonly></td>
                </tr>
                <tr>
                    <td><font color='gold' size='5'><b><i>PC</i></b></font></td>
                    <td><input class="campos" type="text" size="18" value="<?php echo pedido_maleta_h($dados['pc'] ?? ''); ?>" readonly></td>
                    <td><font size="4"><b><i>Modelo</i></b></font></td>
                    <td><input class="campos" type="text" size="36" value="<?php echo pedido_maleta_h($dados['nomeModelo'] ?? ''); ?>" readonly></td>
                </tr>
                <tr>
                    <td><font size="4"><b><i>Cliente</i></b></font></td>
                    <td><input class="campos" type="text" size="36" value="<?php echo pedido_maleta_h($dados['nomeCliente'] ?? ''); ?>" readonly></td>
                    <td><font size="4"><b><i>CPF</i></b></font></td>
                    <td><input class="campos" type="text" size="18" value="<?php echo pedido_maleta_h($dados['cpf'] ?? ''); ?>" readonly></td>
                </tr>
                <tr>
                    <td><font size="4"><b><i>Recibo</i></b></font></td>
                    <td><input class="campos" type="text" name="numdoc" id="numdoc" size="18" maxlength="30" value="<?php echo pedido_maleta_h($numdoc); ?>" required></td>
                    <td><font size="4"><b><i>Contrato</i></b></font></td>
                    <td><input class="campos" type="text" name="contrato" id="contrato" size="18" maxlength="30" value="<?php echo pedido_maleta_h($contrato); ?>"></td>
                </tr>
                <tr>
                    <td><font size="4"><b><i>Cor</i></b></font></td>
                    <td>
                        <select class="campos" name="cor">
                            <?php foreach (array('AZUL', 'VERMELHO', 'PINK') as $corOpcao) { ?>
                                <option value="<?php echo $corOpcao; ?>" <?php echo $cor == $corOpcao ? 'selected' : ''; ?>><?php echo $corOpcao; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><font size="4"><b><i>Codigo DLS</i></b></font></td>
                    <td>
                        <label>
                            <input type="checkbox" name="usarCodigoDls" id="usarCodigoDls" value="S" onclick="alternarCodigoDls();" <?php echo $usarCodigoDls ? 'checked' : ''; ?>>
                        </label>
                        <input class="campos" type="text" name="codigoAutorizacaoDls" id="codigoAutorizacaoDls" size="18" maxlength="60" pattern="DLS[0-9]+/<?php echo date('y'); ?>" placeholder="DLS200/<?php echo date('y'); ?>" title="Use o formato DLS200/<?php echo date('y'); ?>" onfocus="mascararCodigoDls(this);" oninput="mascararCodigoDls(this);" value="<?php echo pedido_maleta_h($codigoAutorizacaoDls); ?>">
                        <br><font size="2" color="gold">Marque para usar sem Recibo ou Contrato.</font>
                    </td>
                </tr>
                <tr>
                    <td><font size="4"><b><i>Observacao</i></b></font></td>
                    <td colspan="3"><textarea class="campos" name="observacoesWebCaixa" cols="80" rows="3"><?php echo pedido_maleta_h($observacoesWebCaixa); ?></textarea></td>
                </tr>
                <?php if ($registro) { ?>
                    <tr>
                        <td><font size="4"><b><i>Registro</i></b></font></td>
                        <td colspan="3">
                            <font color="lime">
                                Recibo localizado em <?php echo pedido_maleta_h($registro['datarec']); ?>
                                as <?php echo pedido_maleta_h($registro['horarec']); ?>.
                                Vendedora: <?php echo pedido_maleta_h($registro['vendedora']); ?>
                            </font>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4" align="center">
                        <input type="submit" value="Salvar e Enviar ao ERP" <?php echo $dados ? '' : 'disabled'; ?>>&nbsp;&nbsp;
                        <input type="reset" value="Limpar">
                    </td>
                </tr>
            </table>
        </form>

    <br><br><center><a href="index.php?c_s=<?php echo pedido_maleta_h($lg_user); ?>"><img src="../images/voltar.gif"></a></center><br>
<?php } else { ?>
    <br><br><br><font size="6"><b><center>Acesso <font color="gold"><u>nao Autorizado</u><font color="#FFFFFF">!!!</center></b></font>
    <center><a href="index.php?c_s=<?php echo pedido_maleta_h($lg_user); ?>"><img src="../images/voltar.gif"></a></center><br>
<?php } ?>
<?php
$SisRot = 'S-7.PM';
include "rodape.php";
mysqli_close($conec);
?>
</body>
</html>

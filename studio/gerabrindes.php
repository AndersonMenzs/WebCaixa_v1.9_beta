<html>

<head>
    <title>WebCaixa v1.20.21_beta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body background="../images/bg1.jpg" text="#FFFFFF">

    <?php
    $Sis = "S7";
    $Rot = "S7R2.1.1.1";
    $dtRec = date("Y-m-d");
    $hora = date("H:i");
    $lg_user = isset($_POST['txtuser']) ? trim($_POST['txtuser']) : '';
    $user = substr($lg_user, 0, 8);
    $pss = substr($lg_user, 8, 40);
    $NDoc = isset($_POST['txtdoc']) ? trim($_POST['txtdoc']) : '';
    $Mat_Vend = isset($_POST['mat_vend']) ? trim($_POST['mat_vend']) : '';
    $Vendedora = isset($_POST['vendedora']) ? trim($_POST['vendedora']) : '';
    $Cliente = isset($_POST['cliente']) ? trim($_POST['cliente']) : '';
    $CodBrinde = isset($_POST['cod_brinde']) ? trim($_POST['cod_brinde']) : '';
    $NomeBrinde = isset($_POST['nome_brinde']) ? trim($_POST['nome_brinde']) : '';
    $Senha = sha1(strtolower(trim($_POST['txtsen'] ?? '')));

    if ($lg_user === '' || $NDoc === '' || $Mat_Vend === '' || $Vendedora === '' || $Cliente === '' || $CodBrinde === '' || $NomeBrinde === '') {
        header("Location: brindes.php?c_s=" . urlencode($lg_user));
        exit;
    }

    include "../cabecprs.php";
    include "conexao.php";
    include "dbselect.php";
    include "valida_caixa.php";

    bloquear_se_caixa_anterior_aberto($conec, $lg_user);

    $userEsc = mysqli_real_escape_string($conec, $user);
    $senhaEsc = mysqli_real_escape_string($conec, $Senha);
    $sqlOperador = "SELECT mat FROM operador WHERE mat = '$userEsc' AND pass = '$senhaEsc' LIMIT 1";
    $rsOperador = mysqli_query($conec, $sqlOperador);
    $operador = $rsOperador ? mysqli_fetch_assoc($rsOperador) : null;

    include "conexao.php";
    include "dbselect.php";
    include "us_sist.php";

    if (($ch === 'ok' || $ch === 'ok-enc' || $ch === 'ok-cai' || $ch === 'ok-adm') && $operador) {
        $Mat = $operador['mat'];

        $sqlUltimo = "SELECT reg, datarec FROM registro ORDER BY datarec DESC, reg DESC LIMIT 1";
        $rsUltimo = mysqli_query($conec, $sqlUltimo);
        $ultimo = $rsUltimo ? mysqli_fetch_assoc($rsUltimo) : null;
        $Reg = $ultimo && $ultimo['datarec'] === $dtRec ? (int)$ultimo['reg'] + 1 : 1;

        $TipoRec = '10';
        $SubTipo = 'BRIND';
        $MatVendEsc = mysqli_real_escape_string($conec, $Mat_Vend);
        $VendedoraEsc = mysqli_real_escape_string($conec, $Vendedora);
        $ClienteEsc = mysqli_real_escape_string($conec, $Cliente);
        $NDocEsc = mysqli_real_escape_string($conec, $NDoc);
        $MatEsc = mysqli_real_escape_string($conec, $Mat);
        $CodBrindeEsc = mysqli_real_escape_string($conec, $CodBrinde);
        $sqlBrinde = "SELECT cod_prod FROM produtos WHERE cod_prod = '91'";
        $resBrinde = mysqli_query($conec, $sqlBrinde) or die("Não foi possível localizar o brinde.");

        if (!$resBrinde || !mysqli_fetch_assoc($resBrinde)) {
            die("O brinde selecionado não está mais disponível.");
        }
        mysqli_free_result($resBrinde);

        $sqlInsert = "INSERT INTO registro
        (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno, mat_vend, vendedora, cliente)
        VALUES
        ($Reg, '$NDocEsc', '$TipoRec', '$SubTipo', '99', '0', '$dtRec', '$hora', 0, '$MatEsc', '', '$MatVendEsc', '$VendedoraEsc', '$ClienteEsc')";

        if (!mysqli_query($conec, $sqlInsert)) {
            die("Erro ao registrar a gratuidade do brinde.");
        }

        echo "<br><br><center>";
        echo "<font color='gold' size='6'><b>Brinde registrado como GRATUIDADE</b></font><br><br>";
        echo "<font size='5'><b>Nº Documento: " . htmlspecialchars($NDoc, ENT_QUOTES, 'UTF-8') . "</b></font><br>";
        echo "<font size='5'>Brinde: " . htmlspecialchars($NomeBrinde, ENT_QUOTES, 'UTF-8') . "</font><br>";
        echo "</center>";
        echo "<br><center><a href='brindes.php?c_s=" . urlencode($lg_user) . "'><img src='./images/voltar.gif'></a></center>";
    } else {
        echo "<br><br><center>";
        echo "<font size='6'><b>Senha incorreta ou usuário não autorizado.</b></font>";
        echo "</center><br>";
        echo "<center><a href='brindes.php?c_s=" . urlencode($lg_user) . "'><img src='./images/voltar.gif'></a></center>";
    }

    $SisRot = "S-7.2.1.1.1";
    include "rodape.php";
    mysqli_close($conec);
    ?>

</body>

</html>
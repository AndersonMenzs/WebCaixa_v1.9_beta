<?php
$conec = mysqli_connect('localhost', 'root', 'cpd@cloud');
if ($conec) {
    mysqli_select_db($conec, 'studio');
    $result = mysqli_query($conec, 'SELECT * FROM pgtos ORDER BY codpag');
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['codpag'] . ' - ' . $row['tipopag'] . PHP_EOL;
    }
    mysqli_close($conec);
} else {
    echo 'Erro de conexão';
}
?>
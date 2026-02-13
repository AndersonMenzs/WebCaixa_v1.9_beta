<?php
// Variáveis
$txt1 = 235.00;  // FPag = 10
$txt2 = 315.00;  // FPag = 20
$txt3 = 400.99;  // FPag = 30

$VrRec = $txt1 + $txt2 + $txt3; // 950.99
$QtdeParc = 6;
$Parc = $VrRec / $QtdeParc; // 158.498333... (arredondado para 158.50)
$Parc = number_format($Parc, 2, '.', ''); // 158.50

// Array com as formas de pagamento dos valores originais
$formas_pagamento = [10, 20, 30];
$valores_originais = [235.00, 315.00, 400.99];

echo "VALOR TOTAL: R$ " . number_format($VrRec, 2, ',', '.') . "<br>";
echo "PARCELA FIXA: R$ " . number_format($Parc, 2, ',', '.') . "<br>";
echo "FORMA DE PAGAMENTO POR PARCELA:<br><br>";

// Distribuir as formas de pagamento entre as 6 parcelas
for ($parcela = 1; $parcela <= $QtdeParc; $parcela++) {
    echo "----- PARCELA $parcela -----<br>";
    
    // Determinar qual forma de pagamento usar baseado na parcela atual
    if ($parcela <= 2) {
        // Parcelas 1 e 2: Forma de pagamento 10 (referente ao valor 235.00)
        $FPag = 10;
        $valor_referencia = 235.00;
    } elseif ($parcela <= 4) {
        // Parcelas 3 e 4: Forma de pagamento 20 (referente ao valor 315.00)
        $FPag = 20;
        $valor_referencia = 315.00;
    } else {
        // Parcelas 5 e 6: Forma de pagamento 30 (referente ao valor 400.99)
        $FPag = 30;
        $valor_referencia = 400.99;
    }
    
    echo "Registro: $parcela <br>";
    echo "Forma de Pagamento: $FPag <br>";
    echo "Valor da Parcela: R$ " . number_format($Parc, 2, ',', '.') . "<br>";
    echo "Valor de Referência (original): R$ " . number_format($valor_referencia, 2, ',', '.') . "<br>";
    echo "<br>";
}

// OU, se quiser mostrar TAMBÉM os valores totais por forma de pagamento:
echo "<br>--- RESUMO POR FORMA DE PAGAMENTO ---<br>";

$total_fpag10 = $Parc * 2; // 2 parcelas de R$ 158.50
$total_fpag20 = $Parc * 2; // 2 parcelas de R$ 158.50
$total_fpag30 = $Parc * 2; // 2 parcelas de R$ 158.50

echo "FPag 10 (235.00): 2 parcelas = R$ " . number_format($total_fpag10, 2, ',', '.') . "<br>";
echo "FPag 20 (315.00): 2 parcelas = R$ " . number_format($total_fpag20, 2, ',', '.') . "<br>";
echo "FPag 30 (400.99): 2 parcelas = R$ " . number_format($total_fpag30, 2, ',', '.') . "<br>";
?>
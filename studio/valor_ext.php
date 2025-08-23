<?php
function valorPorExtenso($valor = 0) {
    $singular = ["centavo", "real", "mil"];
    $plural = ["centavos", "reais", "mil"];
    
    $unidades = ["", "um", "dois", "trÊs", "quatro", "cinco", "seis", "sete", "oito", "nove"];
    $dezenas = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", 
                "dezessete", "dezoito", "dezenove"];
    $dezenas2 = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", 
                 "sessenta", "setenta", "oitenta", "noventa"];
    $centenas = ["", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", 
                 "seiscentos", "setecentos", "oitocentos", "novecentos"];

    // Remove formatação
    $valor = str_replace(["R$", ".", ","], ["", "", "."], $valor);
    $valor = (float)$valor;
    $valor = number_format($valor, 2, ".", "");
    
    list($inteiro, $centavo) = explode(".", $valor);
    
    $extenso = [];
    $mil = 0;
    
    // Parte inteira (reais)
    if ($inteiro > 0) {
        // Trata milhares
        if ($inteiro >= 1000) {
            $mil = floor($inteiro / 1000);
            $resto = $inteiro % 1000;
            
            if ($mil == 1) {
                $extenso[] = "mil";
            } else {
                $extenso[] = escreverCentenas($mil, $unidades, $dezenas, $dezenas2, $centenas) . " mil";
            }
            
            $inteiro = $resto;
        }
        
        // Trata centenas, dezenas e unidades
        if ($inteiro > 0) {
            if ($inteiro == 100) {
                $extenso[] = "cem";
            } else {
                $extenso[] = escreverCentenas($inteiro, $unidades, $dezenas, $dezenas2, $centenas);
            }
        }
        
        // Adiciona "reais" ou "real"
        $total = ($mil * 1000) + $inteiro;
        $extenso[] = ($total == 1) ? "real" : "reais";
    }
    
    // Parte decimal (centavos)
    if ($centavo > 0) {
        if (!empty($extenso)) {
            $extenso[] = "e";
        }
        
        $extenso[] = escreverCentenas($centavo, $unidades, $dezenas, $dezenas2, $centenas);
        $extenso[] = ($centavo == 1) ? "centavo" : "centavos";
    }
    
    // Junta tudo e formata
    $texto = implode(" ", $extenso);
    $texto = strtoupper($texto);
    
    return $texto ?: "ZERO REAIS";
}

// Função auxiliar para escrever centenas, dezenas e unidades
function escreverCentenas($valor, $unidades, $dezenas, $dezenas2, $centenas) {
    $valor = (int)$valor;
    $partes = [];

    if ($valor == 100) {
        return "cem";
    }

    $c = floor($valor / 100);
    $resto = $valor % 100;

    if ($c > 0) {
        $partes[] = $centenas[$c];
    }

    if ($resto > 0) {
        if ($resto < 20) {
            if ($resto < 10) {
                $partes[] = $unidades[$resto];
            } else {
                $partes[] = $dezenas[$resto - 10];
            }
        } else {
            $d = floor($resto / 10);
            $u = $resto % 10;
            $partes[] = $dezenas2[$d];
            if ($u > 0) {
                $partes[] = $unidades[$u];
            }
        }
    }

    // Junta as partes com " e " onde necessário
    return implode(" e ", $partes);
}
?>

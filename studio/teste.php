<?php 

$quant_parc = 120;

if ($quant_parc >= 12) {
    $quant_parc = $quant_parc - 12;
    $mes_vence_ult = `echo $quant_parc`;

    if ($quant_parc >= 12) {
        $quant_parc = $quant_parc - 12;
        $mes_vence_ult = "echo $quant_parc";
        
        if ($quant_parc >= 12) {
            $quant_parc = $quant_parc - 12;
            $mes_vence_ult = `echo $quant_parc`; 

            if ($quant_parc >= 12) {
                $quant_parc = $quant_parc - 12;
                $mes_vence_ult = `echo $quant_parc`;

                if ($quant_parc >= 12) {
                    $quant_parc = $quant_parc - 12;
                    $mes_vence_ult = `echo $quant_parc`; 

                    if ($quant_parc >= 12) {
                        $quant_parc = $quant_parc - 12;
                        $mes_vence_ult = `echo $quant_parc`;

                        if ($quant_parc >= 12) {
                            $quant_parc = $quant_parc - 12;
                            $mes_vence_ult = `echo $quant_parc`; 

                            if ($quant_parc >= 12) {
                                $quant_parc = $quant_parc - 12;
                                $mes_vence_ult = `echo $quant_parc`; 
                            
                                if ($quant_parc >= 12) {
                                    $quant_parc = $quant_parc - 12;
                                    $mes_vence_ult = `echo $quant_parc`; 
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

echo $mes_vence_ult;
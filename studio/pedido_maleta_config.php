<?php

return array(
    'erp_url' => getenv('PEDIDO_MALETA_ERP_URL') ?: 'http://localhost/photovippcloud_erp',
    'api_keys' => array(
        // Configure no arquivo pedido_maleta_config.local.php:
        // '217' => 'chave_da_filial_217',
    ),
);

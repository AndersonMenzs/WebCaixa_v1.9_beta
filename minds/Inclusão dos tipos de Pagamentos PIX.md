* Inserir duas novas linhas na tabela formapag
INSERT INTO `formapag` (`codpag`, `modpag`, `siglapag`) VALUES ('70', 'Pix QR Code', 'PXQ'), ('71', 'Pix CNPJ', 'PXC');

* Arquivos alterados:
- contrentr.php
- via1newentr.php
- fechacaixa.php
- fccxant.php
- index.php
- contrentr.php
- fcxparcsem.php
- fcxparc.php

2025-08-27: Alterações realizadas.

> CONTRATO ENTRADA

- Inserção do banco de dados na tabela "formapag" "70" (Pix QR Code) e "71" (Pix CNPJ);

- Inserção da coluna Valor Único no script cntrentr.php;

- Validação nos inputs vlr_unico, txtvalor1, txtvalor2 e txtvalor3. Quando inserir o valor único os campos txtvalor1, txtvalor2 e txtvalor3 precisam dar a soma igual ao valor único, se for maior ou menor que o valor mostra-se um alerta;

- Validação na coluna Forma de Pagamento. Se existir forma de pagamento igual mostra-se um alerta de qual forma de pagamento foi repetida;

- Remoção da confirmação se o pagamento é em Dinheiro no scripttnentr.php;

- Validação na coluna Número do Contrato não pode ser repetido*;


- contrentr.php
- via1newentr.php
- fechacaixa.php
- fccxant.php
- contrentr.php
- fcxparcsem.php
- fcxparc.php
- recibo_cntentr.php
- geracntentr.php
- index.php


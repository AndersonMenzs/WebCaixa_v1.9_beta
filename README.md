# WebCaixa_v1.9_beta
Versão com inserções de Pix QR Code, Pix CNPJ e impressão de recibo em impressora laser

# Alterações Realizadas - CONTRATO ENTRADA

2025-08-27 - Contrato Entrada e Fechamento do Caixa

* Inserir duas novas linhas na tabela formapag
INSERT INTO `formapag` (`codpag`, `modpag`, `siglapag`) VALUES ('70', 'Pix QR Code', 'PXQ'), ('71', 'Pix CNPJ', 'PXC');

- Inserção do banco de dados na tabela "formapag" "70" (Pix QR Code) e "71" (Pix CNPJ);

- Inserção da coluna Valor Único no script cntrentr.php;

- Validação nos inputs vlr_unico, txtvalor1, txtvalor2 e txtvalor3. Quando inserir o valor único os campos txtvalor1, txtvalor2 e txtvalor3 precisam dar a soma igual ao valor único, se for maior ou menor que o valor mostra-se um alerta;

- Validação na coluna Forma de Pagamento. Se existir forma de pagamento igual mostra-se um alerta de qual forma de pagamento foi repetida;

- Remoção da confirmação se o pagamento é em Dinheiro no scripttnentr.php;

- Validação na coluna Número do Contrato não pode ser repetido*;

## Arquivos alterados:

| ARQUIVO | ALTERAÇÃO |
| --- | --- |
| contrentr.php | Inserção da coluna Valor Único |
| via1newentr.php | Inserção da coluna Valor Único |
| fechacaixa.php | Inserção da coluna Valor Único |
| fccxant.php | Inserção da coluna Valor Único |
| contrentr.php | Inserção da coluna Valor Único |
| fcxparcsem.php | Inserção da coluna Valor Único |
| fcxparc.php | Inserção da coluna Valor Único |
| recibo_cntentr.php | Inserção da coluna Valor Único |
| geracntentr.php | Inserção da coluna Valor Único |
| index.php | Inserção da coluna Valor Único |

# Alterações Realizadas - TAXA DE PRODUÇÃO

2025-08-27 - Taxa de Produção 


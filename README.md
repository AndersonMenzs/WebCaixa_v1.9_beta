# WebCaixa_v1.9_beta
Versão com inserções de Pix QR Code, Pix CNPJ e impressão de recibo em impressora laser

2025-10-21

# CONEXÃO COM O BANCO DE DADOS

Antes de tudo é necessário inserir uma linha no arquivo vendas/conexao.php que conecta o banco de dados do estúdio. a linha serve para identificar com uma variável o código do estúdio.

```php
// Código do estúdio
$std = '206';

$conec = mysqli_connect ('localhost', 'root', 'cpd@cloud');
    IF (!$conec) { ?>
		  <br><br><br><font size='5' color='red'><center>Você não conseguiu conectar-se ao Servidor de Banco de Dados<br><br>
		      Por favor, contate seu Administrador Web.</center></font><?php
		 }

```

# FECHAMENTO DO CAIXA

2025-08-27

As alterações desta rotina foram feitas em vários arquivos, removendo linhas nos códigos relacionados a Cheques, Cartão de Crédito (ADM) e inserido as formas de pagamento Pix QR Code e Pix CNPJ.

## Arquivos alterados:

| ARQUIVOS | DESCRIÇÃO DAS ALTERAÇÕES |
| --- | --- |
| fechacaixa.php |
| fccxant.php |
| fcxparcsem.php |
| fcxparc.php |

# CONTRATO ENTRADA

2025-08-27

Esta rotina precisa de algumas alterações no banco de dados studio para acrescentar as formas de pagamento Pix.

## Inserir duas novas linhas na tabela formapag

```sql
INSERT INTO `formapag` (`codpag`, `modpag`, `siglapag`) 
            VALUES ('70', 'Pix QR Code', 'PXQ'), ('71', 'Pix CNPJ', 'PXC');
```

## Arquivos alterados:

| ARQUIVOS | DESCRIÇÃO DAS ALTERAÇÕES |
| --- | --- |
| index.php | - Remoção da tabela "INFORMAÇÕES GERAIS" da quantidade de números de recibos;<br><br> |
| valor_ext.php | - Função para converter alor numérico para o valor por extenso;<br><br> - Função para escrever centenas em extenso;<br><br> |
| contrentr.php | - Inserção no banco de dados na tabela "formapag" o código e a forma de pagamento "70" (Pix QR Code) e "71" (Pix CNPJ);<br><br> - Script que faz o autocompleta o campo da ***Vendedora***;<br><br> - Inserção da coluna Valor Único no script cntrentr.php;<br><br> - Validação nos inputs vlr_unico, txtvalor1, txtvalor2 e txtvalor3. Quando inserir o valor único os campos txtvalor1, txtvalor2 e txtvalor3 precisam dar a soma igual ao valor único, se for maior ou menor que o valor mostra-se um alerta;<br><br> - Validação na coluna Forma de Pagamento. Se existir forma de pagamento igual mostra-se um alerta de qual forma de pagamento foi repetida;<br><br> |
| confcntentr.php | - Remoção da confirmação se o pagamento é em Dinheiro no scripttnentr.php;<br><br> |
| geracntentr.php |
| via1newentr.php | - Reune todos os valores recebidos na rotina de contrato de entrada durante a inserção de dados e envia para o arquivo ***recibo_cntentr.php*** para imprimir o recibo;<br><br> |
| recibo_cntentr.php | - Recebe os valores da rotina de contrato de entrada e imprime o recibo;<br><br> - Imprime ***duas vias*** do recibo, sendo que a primeira para a cliente e a segunda para o caixa;<br><br> |
| buscar_funcionarias.php | - Código onde faz a busca de funcionários para o contrato de entrada;<br><br> |

# TAXA DE PRODUÇÃO

Alterar a quantidade de posições das colunas codrec e siglarec na tabela tiporec do banco de dados studio para 4.

```sql
ALTER TABLE `studio`.`tiporec` 
CHANGE COLUMN `codrec` `codrec` CHAR(2) NULL DEFAULT NULL,
CHANGE COLUMN `siglarec` `siglarec` CHAR(4) NULL DEFAULT NULL;  
```

Alterar a quantidade de posições da coluna nomerec na tabela tiporec do banco de dados studio para 30.

```sql
ALTER TABLE `studio`.`tiporec`
CHANGE COLUMN `nomerec` `nomerec` VARCHAR(30) NULL DEFAULT NULL;
```

Inserir uma linha na tabela tiporec para a coluna nomerec para Gratuidade.

```sql
INSERT INTO tiporec (codrec, nomerec, siglarec) VALUES (10,'Taxa de Produção Gratuidade', 'TXPG');
```

Alterar a quantidade de posições da coluna tiporec na tabela registro do banco de dados studio para 2.

```sql
ALTER TABLE `studio`.`registro` 
CHANGE COLUMN `tiporec` `tiporec` CHAR(2) NULL DEFAULT NULL;
```

2025-08-29

 Alterar a quantidade de posiçẽs da coluna numdoc na tabela registro do banco de dados studio para 8.

```sql
ALTER TABLE `studio`.`registro` 
CHANGE COLUMN `numdoc` `numdoc` CHAR(8) NULL;
``` 

- Inserir uma linha na tabela registro para gerar o número do recibo após este alteração. Lembrando que o número do recibo precisa ser iniciado do código da empresa seguidos por 5 zeros.

```sql
INSERT INTO registro (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno) 
            VALUES (1, '20600000', '1', 'TXP', '20', 0, '2025-08-29', '00:00', 0.00, '00000359', '');
```

Abaixo está a tabela dos números de recibos iniciais.

| STD | NÚMERO DO RECIBO |
| --- | --- |
|206|20600000|
|211|21100000|
|215|21500000|
|217|21700000|
|218|21800000|
|219|21900000|
|220|22000000|
|221|22100000|
|222|22200000|
|223|22300000|


E para que o número do recibo seja gerado precisa verificar o último recibo no banco de dados studio e as rotinas **INSCRIÇÃO CONCURSO**, **PAGAMENTOS À VISTA**.

```sql
SELECT numdoc, datarec FROM registro 
        WHERE numdoc >= 22000000 
        AND datarec >= '2025-08-29' 
        AND subtipo IN ('TXP', 'TXC', 'PROD', 'BOOK') 
        ORDER BY numdoc DESC
```

## ARQUIVOS ALTERADOS

| ARQUIVOS | DESCRIÇÃO DAS ALTERAÇÕES |
| ------- | ------- |
| taxaprod.php | - Script que faz o autocompleta o campo da ***Vendedora***;<br><br> - Alterar a quantidade de posiçẽs daa coluna numdoc na tabela registro do banco de dados studio para 8. O número do recibo terá as seguintes posições de ***1-2*** os dois últimos digitos do ***código do estúdio*** e de ***3-8*** o ***número do recibo***. Ex.: ***22000000***;<br><br> - Condição para gerar o próximo número de recibo;<br><br> - O campo ***Data Nasc.*** deve ser principalmente requerido pois isto garante a gratuidade para ***pessoas >= a 60 anos***;<br><br>
| confprod.php | - No código foi inserido a verificação da data de nascimento do cliente para definir a gratuidade;<br><br>
| geraprod.php |
| via1newprod.php |
| recibo_taxaprod.php |
| val_prod.js | - Validações de campos;<br><br> |


- Geração do número do recibo.

2025-09-05

### Alterar tabela amizpre

Para que seja inserido a ***AMIZADA PREMIADA*** na tabela amizpre, precisará alterar as colunas recib para char(8) e vlrec para decimal(10, 2) e todos o dois nulos.

```sql
ALTER TABLE `studio`.`amizpre` 
CHANGE COLUMN `recib` `recib` CHAR(8) NULL DEFAULT NULL,
CHANGE COLUMN `vlrec` `vlrec` DECIMAL(10,2) NULL DEFAULT NULL;
```

2025-10-11

### Inserir uma linha na tabela formapag para incluir Gratuidade

```sql
INSERT INTO formapag (codpag, modpag, siglapag) VALUES (99, 'Gratuidade', 'GRT');  
```

2025-10-27

### Adicionar colunas na tabela registro

```sql
ALTER TABLE registro ADD COLUMN mat_vend VARCHAR(8);
ALTER TABLE registro ADD COLUMN vendedora VARCHAR(100);
ALTER TABLE registro ADD COLUMN cliente VARCHAR(100);
ALTER TABLE registro ADD COLUMN data_nasc VARCHAR(10);
``` 

Estas adcções irão servir futuramente para impressão da solicitação de books
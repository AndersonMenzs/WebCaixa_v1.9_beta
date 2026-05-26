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
CHANGE COLUMN `numdoc` `numdoc` CHAR(15) NULL;
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

2025-01-01

### Reparado o código relog.php

Foi alterado o código relog.php para que ele possa atualizar a hora corretamente.

```php
$sqlO = "UPDATE datafix SET horaf = 0, minf = 0;";
$rsO  = mysqli_query($conec, $sqlO) or die ("File index.php Error #1. Contate seu Administrador.");
```

# Despesas & Recolhomentos

## Despesas

Criar a tabela despesas

```sql
CREATE TABLE tiporef (
    codref VARCHAR(2) NOT NULL,
    nomeref VARCHAR(50) NOT NULL,
    siglaref VARCHAR(5) NOT NULL,
    ref_tiporec VARCHAR(5) NOT NULL,
    cod_tiporef VARCHAR(2) NOT NULL
);
```
Inserir linhas na tabela tiporef

```sql
INSERT INTO tiporef 
        VALUES 
        ('0', 'Selecione', '---', '---', '00'), 
        ('1', 'Salário', 'SAL', 'DDP', '71'), 
        ('2', 'Adiantamento Salarial', 'ADS', 'DDP', '07'), 
        ('3', 'Férias', 'FER', 'DDP', '12'), 
        ('4', 'Premiação', 'PREM', 'DDP', '43'), 
        ('5', 'Taxa Produção', 'TXP', 'RCL', '00'), 
        ('6', 'Contrato Entrada', 'CNTE', 'RCL', '00'), 
        ('7', 'Cancelamento de Venda', 'CVD', 'RCL', '00'), 
        ('8', 'Devolução PIX', 'DVP', 'RCL', '00'), 
        ('9', 'Carnê', 'CAR', 'RCL', '00'),
        ('10', 'Décimo Terceiro Salário', 'DEC', 'DDP', '47');
```

Ao inserir as linhas já estarão seguindo a sequência da coluna reg atual 

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'CI2222600000',  '0',  '---',  '0',  '0',  CURDATE(),  '00:00',  0.00,  '00000359',  '',  '00000000',  '',  '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'RC2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'MC2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'MD2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'MP2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'VT2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'SP2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'OT2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'EST2222600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

A coluna numdoc segue no seguinte padrão

| Tipo | Estúdio | Ano | Sequẽncia
|---|---|---|---
| CI | 222 | 26 | 00000 |


| Coluna | Descição|
|---|---|
| CI, RC | Comunicação Interna, Reembolso ao Cliente |
| 222 | Código do Estúdio |
| 26 | Ano |
| 00000 | Sequência |

```sql
INSERT INTO registro SELECT IFNULL((SELECT MAX(reg) FROM registro WHERE datarec = CURDATE()), 0) + 1, 'RC2112600000', '0', '---', '0', '0', CURDATE(), '00:00', 0.00, '00000359', '', '00000000', '', '';
```

## Pedidos de Books e Posters

Criar tabela de produtos

```sql
CREATE TABLE studio.produtos (
    cod_prod char(2) NOT NULL,
    nome_prod varchar(100) NOT NULL,
    desc_prod char(1) NOT NULL);
```

Inserção de dados na tabela produtos

```sql
INSERT INTO studio.produtos VALUES
(1, 'Pacote Fotográfico Vipp', ''),
(2, 'Pacote Fotográfico Universal', ''),
(3, 'Pacote Fotográfico Styllo', ''),
(4, 'Pacote Fotográfico Estrelinha', ''),
(5, 'Pacote Fotográfico Diamante (Encadernado)', ''),
(6, 'Pacote Fotográfico Especial', ''),
(7, 'Book Digital', ''),
(8, 'Ensaio Formandas', ''),
(9, 'Ensaio Corporativo', ''),
(10, 'Imagens Digitais', ''),
(11, 'Ampliações 30x40', ''),
(12, 'Ampliações 50x60', ''),
(13, 'Cartela 4x5', ''),
(14, 'Cartela com 4 fotos 4x5', ''),
(15, 'Molduras 10x15', ''),
(16, 'Molduras 15x21', ''),
(17, 'Molduras 20x28', ''),
(18, 'Molduras 30x40', ''),
(19, 'Molduras 50x60', ''),
(20, 'Foto Produto - Caneca', ''),
(21, 'Foto Produto - Caneca Polímero', ''),
(22, 'Foto Produto - Quebra Cabeça', ''),
(23, 'Foto Produto - Mouse Pad', ''),
(24, 'Foto Produto - Azulejo 10x10', ''),
(25, 'Foto Produto - Azulejo 15x15', ''),
(26, 'Foto Produto - Azulejo 20x20', ''),
(27, 'Foto Produto - Camisa Branca', ''),
(28, 'Foto Produto - Albinho (S/ Fotos)', ''),
(29, 'Foto Produto - Body', ''),
(30, 'Foto Produto - Chaveiro 3x4', ''),
(31, 'Foto Produto - Chaveiro de Aço', ''),
(32, 'Foto Produto - Chaveiro A', ''),
(33, 'Foto Produto - Chaveiro B', ''),
(34, 'Foto Produto - Totem (Altura Máxima de 1.60m)', ''),
(35, 'Foto Produto - Caneca de Acrílico', ''),
(36, 'Foto Produto - Porta Copos', ''),
(37, 'Foto Produto - Porta Retrato', ''),
(38, 'Foto Produto - Squeeze', ''),
(39, 'Foto Produto - Almofada 40x40', ''),
(40, 'Foto Produto - Almofada 20x30', ''),
(41, 'Foto Produto - Almofada 15x20', ''),
(42, 'Foto Produto - Maletinha com 6 Albinho 10x15', ''),
(43, 'Foto Produto - Calendário de Mesa', ''),
(44, 'Foto Produto - Necessaire (Tencido)', ''),
(45, 'Foto Produto - Necessaire (Corino)', ''),
(46, 'Foto Produto - Toalha Personalizada', ''),
(47, 'Foto Produto - Pingente Rericário Coração com 2 Fotos', ''),
(48, 'Foto Produto - Banner 30x40', ''),
(49, 'Foto Produto - Banner 40x60', ''),
(50, 'Foto Produto - Banner 50x60', ''),
(51, 'Foto Produto - Banner 60x80', ''),
(52, 'Foto Produto - Banner 70x100', ''),
(53, 'Foto Produto - Banner 80x100', ''),
(54, 'Foto Produto - Banner 90x100', ''),
(55, 'Foto Produto - Banner 80x120', ''),
(56, 'Foto Produto - Banner 100x120', ''),
(57, 'Foto Produto - Banner 100x150', ''),
(58, 'Foto Produto - Banner 140x200', ''),
(59, 'Foto Produto - Banner 140x260', ''),
(60, 'Foto Produto - Banner 180x180', ''),
(61, 'Foto Produto - Banner 100x200', ''),
(62, 'Foto Produto - Banner 200x200', ''),
(63, 'Foto Produto - Banner 300x200', ''),
(64, 'Álbum Fotos - Álbum 10x15 com 12 fotos', ''),
(65, 'Álbum Fotos - Álbum 10x15 com 15 fotos', ''),
(66, 'Álbum Fotos - Álbum Tradicional 20x25', ''),
(67, 'Álbum Fotos - Maleta 20x25 com álbum', ''),
(68, 'Ímã 5x7', ''),
(69, 'Ímã 6x9', ''),
(70, 'Ímã 7x10', ''),
(71, 'Ímã 10x15', ''),
(72, 'Imãs 10x15 3 unidades', ''),
(73, '5 Carinhas - 01 lâmina 20x28', ''),
(74, '5 Carinhas - 02 lâmina 20x28', ''),
(75, '5 Carinhas - 03 lâmina 20x28', ''),
(76, '5 Carinhas - 01 lâmina 15x21 com 16 fotos 3x4', ''),
(77, '7 Carinhas - 01 lâmina 20x28', ''),
(78, '7 Carinhas - 02 lâmina 20x28', ''),
(79, '7 Carinhas - 03 lâmina 20x28', ''),
(80, '7 Carinhas - 01 lâmina 15x21 com 16 fotos 3x4', ''),
(81, 'Tags', ''),
(82, 'Tags 3 unidades', '');
```

# Alteração na tabela registro na coluna numdoc (Recebimentos)

Algumas colunas de algumas tabelas precisam ser alteradas para os valores de 7 caracteres para serem inseridos no banco de dados.

```sql
ALTER TABLE registro MODIFY numdoc CHAR(15);
```
# Alteração na tabela caixa no campo type decimal (Fechamento Caixa)

Na tabela caixa precisa alterar o type decimal.

```sql
START TRANSACTION;

-- Fazer backup da estrutura antes da alteração
CREATE TABLE caixa_backup_20260212 AS SELECT * FROM caixa;

-- Aplicar as alterações
ALTER TABLE caixa
MODIFY COLUMN vrtxprod DECIMAL(8,2),
MODIFY COLUMN vrconcurso DECIMAL(8,2),
MODIFY COLUMN vrbebe DECIMAL(8,2),
MODIFY COLUMN vrchav DECIMAL(8,2),
MODIFY COLUMN vrcontent DECIMAL(8,2),
MODIFY COLUMN vrcontparc DECIMAL(8,2),
MODIFY COLUMN vrpropent DECIMAL(8,2),
MODIFY COLUMN vrpropparc DECIMAL(8,2),
MODIFY COLUMN vrprodsrec DECIMAL(8,2),
MODIFY COLUMN vrbookrec DECIMAL(8,2),
MODIFY COLUMN vrresgate DECIMAL(8,2),
MODIFY COLUMN vrestorno DECIMAL(8,2),
MODIFY COLUMN numerario DECIMAL(8,2),
MODIFY COLUMN despddp DECIMAL(8,2),
MODIFY COLUMN despmcs DECIMAL(8,2),
MODIFY COLUMN despmdv DECIMAL(8,2),
MODIFY COLUMN despmpd DECIMAL(8,2),
MODIFY COLUMN desprcl DECIMAL(8,2),
MODIFY COLUMN despsrv DECIMAL(8,2),
MODIFY COLUMN despvtr DECIMAL(8,2),
MODIFY COLUMN despout DECIMAL(8,2),
MODIFY COLUMN incsobra DECIMAL(8,2);

-- Verificar as colunas alteradas
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    DATA_TYPE,
    NUMERIC_PRECISION,
    NUMERIC_SCALE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'caixa'
    AND DATA_TYPE = 'decimal'
ORDER BY COLUMN_NAME;

-- Se estiver tudo correto:
COMMIT;
SELECT 'Alterações aplicadas com sucesso!' as Status;

-- Se precisar desfazer:
-- ROLLBACK;
-- SELECT 'Alterações desfeitas.' as Status;
```

# Alterar o type da coluna spo e spo2 nas tabelas spool e spool2.

```sql
ALTER TABLE spool MODIFY spo varchar(60);
ALTER TABLE spool2 MODIFY spo2 varchar(60);
```

# Consultas Autenticadas Auditoria

Pelo motivo de não haver mais a fita de autenticações do dia foi necessário alterar o arquivo aud.php para e criar os arquivos cntaud.php e cntaud_aut.php.

## Arquivos modificados e alterados:

| ARQUIVOS | DESCRIÇÃO DAS ALTERAÇÕES |
| --- | --- |
| aud.php | Arquivo de link para o arquivo de consulta autenticada da auditoria; |
| cntaud.php | Arquivo de consulta autenticada da auditoria; |
| cntaud_aut.php | Lista as consultas autenticadas da auditoria; |

# Alteração dos arquivos de recebimento para auditoria:

Foi necessário acrescebtar o regoistro de recebimento para a auditoria nas tabelas.

## Arquivos modificados e alterados:

| ARQUIVOS | DESCRIÇÃO DAS ALTERAÇÕES |
| --- | --- |
| via1newentr.php | |
| via1newprod.php | |
| via1newconc.php | |
| via1newchv.php | |
| via1newprods.php | |
| via1newpag.php | |

# Criação de tabela de estúdios para CONTRATO PARCELA e PRODS

```sql
CREATE TABLE `estudios` (
  `id_std` int(11) NOT NULL AUTO_INCREMENT,
  `cod_std` varchar(3) NOT NULL,
  `nome_std` varchar(50) NOT NULL,
  `status_std` varchar(1) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`id_std`)
);
```
# Inserção de dados na tabela estudios

```sql
INSERT INTO `estudios` (`id_std`, `cod_std`, `nome_std`, `status_std`) VALUES
(1, '201', 'São Gonçalo', 'x'),
(2, '202', '---', 'x'),
(3, '204', '---', 'x'),
(4, '206', 'Campo Grande', ''),
(5, '207', '---', 'x'),
(6, '210', '---', 'x'),
(7, '211', 'Madureira 2', ''),
(8, '212', '---', 'x'),
(9, '213', '---', 'x'),
(10, '214', '---', 'x'),
(11, '215', 'Tijuca', ''),
(12, '216', '---', 'x'),
(13, '217', 'Nova Iguaçu 2', ''),
(14, '218', 'Alcântara 1', ''),
(15, '219', 'Campo Grande Calçadão', ''),
(16, '220', 'Alcântara 2', ''),
(17, '221', 'Caxias 2', ''),
(18, '222', 'Alfândega', ''),
(19, '223', 'Caxias 3', ''),
(20, '221', '---', 'x');
```

# Cadastramento de Vendedoras

Este cadastramento só serve para informação dos contratos e recibos. foi alterado a consulta do arquico cadop.php

```sql
$sqlC = "select * from cargos where ccargo = '03' or ccargo = '04' or ccargo = '05' or ccargo = '08' order by ccargo";
```

# Alterar quantidade de caracter na coluna subtipo da tabela registro

Alterado para comportar os produtos kit na rotina pagamento a vista.


```sql
ALTER TABLE registro MODIFY subtipo CHAR(5);
```

# Alteração e adição de cargo "PRESTADOR DE SERVIÇOS"

```sql
insert into cargos (ccargo, ncargo) value ('32', 'PRESTADOR DE SERVIÇOS');
```

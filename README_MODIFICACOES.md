# Modificacoes no fluxo de despesas

Este documento descreve as alteracoes feitas no fluxo de despesas para enviar e manter o valor de `cod_TipoRef` entre as telas.

## Objetivo

O objetivo principal foi fazer com que o codigo do tipo de referencia selecionado na tela de despesas chegue corretamente em `confdesp.php` e continue sendo repassado nas proximas etapas.

Fluxo esperado:

```text
studio/despesa.php
  -> studio/confdesp.php
  -> studio/geradesp.php
  -> studio/via1newpag.php
  -> comprovante aberto para impressao
```

## Banco de dados

A tabela `tiporef` deve possuir o campo `cod_tiporef`, usado para alimentar o valor enviado como `cod_TipoRef`.

Estrutura considerada:

```sql
CREATE TABLE tiporef (
    codref VARCHAR(2) NOT NULL,
    nomeref VARCHAR(50) NOT NULL,
    siglaref VARCHAR(5) NOT NULL,
    ref_tiporec VARCHAR(5) NOT NULL,
    cod_tiporef VARCHAR(2) NOT NULL
);
```

O campo `nomeref` continua sendo usado como texto exibido e enviado em `lsref_desp` ou `lsref_remb`.

O campo `cod_tiporef` passa a ser usado como codigo complementar da referencia.

## studio/despesa.php

Foram feitas as seguintes alteracoes:

- Adicionado o campo hidden `cod_TipoRef`.
- Os selects `lsref_desp` e `lsref_remb` passaram a carregar o codigo da referencia no atributo `data-cod-tiporef`.
- O valor exibido no select continua sendo o nome da referencia (`nomeref`).
- O valor enviado no hidden `cod_TipoRef` vem de `tiporef.cod_tiporef`.
- Foi criada a funcao JavaScript `atualizarCodTipoRef(selectEl)` para copiar o valor de `data-cod-tiporef` para o hidden.
- A funcao `mostrarTabelaDespesa()` tambem atualiza ou limpa o hidden conforme o tipo de despesa selecionado.
- Foi criada a funcao `prepararEnvioDespesa()` para garantir que o hidden seja atualizado antes do submit.
- O formulario principal foi ajustado para envolver todas as tabelas de entrada, evitando que campos fora da primeira tabela deixem de ser enviados pelo navegador.

Exemplo do envio no HTML:

```html
<option value="Salario" data-cod-tiporef="1">
    Salario
</option>
```

O select envia o nome da referencia, e o hidden envia o codigo:

```html
<input type="hidden" name="cod_TipoRef" id="cod_TipoRef" value="">
```

## studio/confdesp.php

Foram feitas as seguintes alteracoes:

- Recebe `cod_TipoRef` via `$_POST`.
- Repassa `cod_TipoRef` para `geradesp.php` em um campo hidden.
- Possui fallback caso `cod_TipoRef` venha vazio no POST.

Fallback implementado:

- Se `cod_TipoRef` vier vazio, o sistema identifica a referencia selecionada por `lsref_desp` ou `lsref_remb`.
- Depois consulta novamente a tabela `tiporef` pelo campo `nomeref`.
- Se encontrar o registro, preenche `cod_TipoRef` com `cod_tiporef`.
- Se `cod_tiporef` nao existir ou estiver indisponivel, usa `codref` como fallback.

Isso reduz a dependencia do JavaScript e protege o fluxo caso o navegador nao envie o hidden corretamente.

## studio/geradesp.php

Foram feitas as seguintes alteracoes:

- Recebe `cod_TipoRef` via `$_POST`.
- Mantem o valor em `$cod_TipoRef`.
- Repassa o valor para `via1newpag.php` em campo hidden.

Com isso, a etapa de gravacao da despesa nao perde o codigo da referencia.

## studio/via1newpag.php

Foram feitas as seguintes alteracoes:

- Recebe `cod_TipoRef` via `$_POST`.
- Mantem o valor em `$cod_TipoRef`.
- Inclui `cod_TipoRef` nas URLs abertas para impressao dos comprovantes.

O parametro enviado nas URLs fica assim:

```text
&cod_TipoRef=VALOR
```

Esse parametro foi incluido nos caminhos de impressao de:

- Despesa DP
- Reembolso de cliente
- Vale transporte
- Servicos prestados
- Materiais/outros tipos agrupados

## Observacoes importantes

- O nome do campo no banco e `cod_tiporef`.
- O nome do campo enviado entre telas e `cod_TipoRef`.
- O nome enviado entre telas foi mantido com letra maiuscula para preservar o padrao ja usado no PHP.
- O texto da referencia (`nomeref`) continua sendo enviado separadamente por `lsref_desp`, `lsref_remb` ou `tiporef`.
- O codigo da referencia e enviado separadamente por `cod_TipoRef`.

## Validacao

Arquivos validados com `php -l`:

```bash
php -l studio/despesa.php
php -l studio/confdesp.php
php -l studio/geradesp.php
php -l studio/via1newpag.php
```

Resultado esperado:

```text
No syntax errors detected
```

## Como testar manualmente

1. Abrir a tela `studio/despesa.php`.
2. Selecionar um tipo de despesa que mostre o campo `Referente`.
3. Selecionar uma referencia.
4. Clicar em `Continuar`.
5. Em `confdesp.php`, verificar se o POST contem:

```php
[cod_TipoRef] => valor_do_cod_tiporef
```

6. Continuar o fluxo ate a impressao.
7. Confirmar se a URL aberta para impressao contem:

```text
cod_TipoRef=valor_do_cod_tiporef
```

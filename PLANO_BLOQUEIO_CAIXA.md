# Plano para Bloquear Registros com Caixa Anterior Aberto

## Status

- Fase 1 concluída: criado `studio/valida_caixa.php` com funções centrais de validação.
- Fase 2 concluída: `studio/index.php` passou a usar a validação central e a condição `$AtuSen` foi corrigida.
- Fase 3 concluída: páginas de entrada operacional passaram a bloquear caixa anterior aberto.
- Fase 4 concluída: gravações críticas no servidor passaram a revalidar caixa anterior aberto antes de inserir registros/autenticações.
- Fase 5 concluída: exceções necessárias para fechamento, impressão/listagem de fechamento e saída foram conferidas.
- Fase 6 concluída: mensagem de bloqueio padronizada em `studio/valida_caixa.php`.
- Fase 7 concluída parcialmente: sintaxe validada e regra central testada contra caixa anterior aberto real.

## Objetivo

Garantir que o sistema bloqueie novos registros quando existir um caixa de dia anterior ainda aberto, mesmo que o operador feche o navegador e volte diretamente para uma tela interna.

Hoje o aviso "Você não fechou o caixa do dia" aparece no `studio/index.php`, mas a validação não é reaplicada nas páginas que gravam recebimentos, despesas, recolhimentos, estornos ou autenticações.

## Situação Atual

- `studio/index.php` verifica o fechamento anterior e mostra o aviso.
- `studio/sitcaixa.php` define a situação do caixa em `$chcx`.
- As opções do menu só aparecem quando `$chcx == 'f'`.
- O bloqueio é visual/de navegação, não é uma trava de servidor.
- Se o operador acessar uma URL interna ainda válida, pode chegar em páginas que registram dados.

Arquivos principais já identificados:

- `studio/index.php`
- `studio/sitcaixa.php`
- páginas que gravam em `registro`
- páginas que gravam em `depositos`
- páginas que gravam em `spool` e `spool2`
- páginas que alteram `caixa`

## Fase 1: Criar Validação Central

Criar um arquivo novo, por exemplo:

```text
studio/valida_caixa.php
```

Esse arquivo deve ter funções reutilizáveis para responder:

- existe caixa aberto de dia anterior?
- existe caixa aberto hoje?
- o usuário pode registrar movimento?
- o usuário deve ser enviado para fechamento?

Sugestão de funções:

```php
caixa_anterior_aberto($conec): array
caixa_aberto_hoje($conec): bool
bloquear_se_caixa_anterior_aberto($conec, $lg_user): void
```

A função de bloqueio deve:

- consultar a tabela `caixa`;
- detectar `dtopen < hoje` com `dtclose IS NULL`;
- impedir a continuação do script;
- mostrar mensagem clara;
- oferecer caminho para `fechacaixa.php`.

## Fase 2: Usar a Validação no Menu

Atualizar `studio/index.php` para usar a nova função central em vez de manter a regra duplicada.

Também corrigir a condição onde aparece atribuição em vez de comparação:

```php
$AtuSen = 'ok'
```

Deve ficar:

```php
$AtuSen == 'ok'
```

Isso reduz risco de liberar fluxo indevidamente.

## Fase 3: Bloquear Páginas de Entrada Operacional

Incluir a validação nas páginas que abrem áreas de operação.

Prioridade:

- `studio/servrec.php`
- `studio/pgtos.php`
- `studio/estorno.php`
- `studio/consulta.php`, se a consulta depender de caixa aberto
- `studio/contrentr.php`
- `studio/contrparc.php`
- `studio/propentr.php`
- `studio/prods.php`
- `studio/inscconcur.php`

Essas páginas devem barrar acesso se houver caixa anterior aberto.

## Fase 4: Bloquear Gravações no Servidor

Essa é a fase mais importante.

Mesmo que o operador tenha deixado uma tela aberta, o `POST` de gravação precisa consultar novamente a situação do caixa antes de fazer qualquer `INSERT` ou `UPDATE`.

Arquivos críticos encontrados:

- `studio/geracntentr.php`
- `studio/geracntparc.php`
- `studio/gerapropentr.php`
- `studio/geraprods.php`
- `studio/geraprod.php`
- `studio/geraconc.php`
- `studio/geradesp.php`
- `studio/geradep.php`
- `studio/geraest.php`
- `studio/estconf.php`
- `studio/geraresgch.php`
- `studio/via1newentr.php`
- `studio/via1newparc.php`
- `studio/via1newpentr.php`
- `studio/via1newprod.php`
- `studio/via1newprods.php`
- `studio/via1newconc.php`
- `studio/via1newpag.php`
- `studio/via1newest.php`

Regra:

Antes de qualquer gravação em `registro`, `depositos`, `spool`, `spool2` ou alteração de caixa, chamar:

```php
bloquear_se_caixa_anterior_aberto($conec, $lg_user);
```

## Fase 5: Definir Exceções

Algumas páginas devem continuar acessíveis mesmo com caixa anterior aberto, porque servem para resolver o problema.

Exceções definidas:

- `studio/index.php`
- `studio/fechacaixa.php`
- `studio/fccxant.php`
- `studio/fcxparc.php`
- `studio/fcxparcsem.php`
- `studio/fecha.php`
- `studio/ultfech.php`
- `studio/ultfech2.php`
- `studio/impultfech3.php`
- `studio/impfccxant.php`
- `studio/impfechparc.php`
- `studio/sair.php`

Também podem ficar livres páginas puramente administrativas, se a regra do negócio permitir.

Conferência da Fase 5:

- Nenhuma das páginas de fechamento/impressão/saída acima chama `bloquear_se_caixa_anterior_aberto`.
- `studio/index.php` pode incluir `valida_caixa.php`, mas permanece livre porque apenas mostra o aviso e direciona para o fechamento.

## Fase 6: Padronizar a Mensagem de Bloqueio

Criar uma saída padrão para evitar mensagens diferentes em cada arquivo.

Mensagem sugerida:

```text
Você não fechou o caixa do dia DD/MM/AAAA.
Feche o caixa anterior antes de registrar novos movimentos.
```

Botões sugeridos:

- Fechar o Caixa
- Voltar para o início

Implementado em `studio/valida_caixa.php`, na função `mostrar_bloqueio_caixa()`.

## Fase 7: Testes Manuais

Testar os cenários abaixo:

1. Caixa aberto hoje.
   - O menu deve liberar recebimentos, despesas, recolhimentos e estornos.
   - Os registros devem gravar normalmente.

2. Caixa de ontem aberto.
   - `index.php` deve mostrar o aviso.
   - `servrec.php` acessado direto deve bloquear.
   - `pgtos.php` acessado direto deve bloquear.
   - Um `POST` direto para `geracntentr.php` deve bloquear antes do `INSERT`.
   - Um `POST` direto para `geradep.php` deve bloquear antes do `INSERT`.

3. Caixa fechado e nenhum caixa aberto hoje.
   - O sistema deve liberar abertura de caixa.
   - O sistema não deve liberar registros antes da abertura.

4. Fechamento pendente.
   - `fechacaixa.php` deve continuar acessível.
   - A rotina de fechamento deve funcionar normalmente.

Conferência da Fase 7:

- `php -l` passou nos arquivos alterados das Fases 1 a 4.
- Banco consultado em modo somente leitura em 09/06/2026.
- Cenário real encontrado: caixa de `06/06/2026` aberto com `dtclose NULL`.
- `caixa_anterior_aberto($conec)` retornou `06/06/2026`.
- `usuario_pode_registrar_movimento($conec)` retornou bloqueio.
- Não foram alterados dados do banco para simular os demais cenários.

## Fase 8: Melhorias Futuras

Depois da trava inicial, considerar:

- substituir `c_s` em URL por sessão PHP real;
- criar controle de login com `$_SESSION`;
- colocar a validação em um bootstrap comum;
- usar prepared statements nas consultas sensíveis;
- criar uma tabela de auditoria para tentativas bloqueadas.

## Resultado Esperado

Com a validação central aplicada:

- o aviso deixa de depender só do `index.php`;
- acesso direto por URL interna deixa de registrar movimentos;
- formulários antigos deixados abertos no navegador são barrados no envio;
- o fechamento anterior passa a ser obrigatório antes de qualquer novo movimento.

# Plano para Prevenir Duplicidade Durante Lançamentos

## Objetivo

Impedir que um lançamento seja gravado mais de uma vez quando o colaborador:

- clicar repetidamente no botão de confirmação;
- atualizar a página com `F5`, `Ctrl+R` ou pelo navegador;
- voltar para uma etapa anterior e reenviar o formulário;
- restaurar uma página pelo histórico do navegador;
- repetir a mesma requisição por lentidão, falha de rede ou duplo clique.

> Bloquear os botões do navegador melhora a experiência, mas não garante a integridade dos dados. A proteção definitiva deve existir no servidor e no banco.

## Escopo Inicial

O primeiro ciclo deve proteger os lançamentos financeiros que gravam nas tabelas:

- `registro`;
- `depositos`;
- `spool`;
- `spool2`.

Rotinas principais identificadas:

- `studio/geracntentr.php`
- `studio/geracntparc.php`
- `studio/gerapropentr.php`
- `studio/geraprods.php`
- `studio/geraprod.php`
- `studio/geraconc.php`
- `studio/geradesp.php`
- `studio/geradep.php`
- `studio/geraresgch.php`
- `studio/estmultiplo.php`
- `studio/estunico.php`
- páginas `studio/via1new*.php`, que gravam dados de impressão em `spool` e `spool2`

O mesmo padrão poderá ser aplicado depois a abertura, fechamento, correções e rotinas administrativas.

## Fluxo Atual Observado

```text
Formulário de lançamento
        |
        | POST
        v
Página geradora (gera*.php)
        |
        | calcula "último reg + 1"
        | grava em registro/depositos
        v
Tela de autenticação/impressão
        |
        | novo POST
        v
Página via1new*.php
        |
        | grava spool/spool2
        | abre recibo
        v
Retorno ao menu
```

## Diagnóstico

### 1. A gravação responde diretamente a um POST

As páginas `gera*.php` inserem os dados e exibem outra tela na mesma resposta. Se essa resposta for atualizada, o navegador pode reenviar o POST.

Consequência: o script executa novamente e pode criar outro lançamento.

### 2. O número do registro é calculado por consulta

Várias rotinas consultam o registro mais recente e executam:

```text
novo número = último número + 1
```

Em um reenvio, um novo número pode ser calculado e a mesma operação de negócio ser inserida novamente. Em acessos simultâneos, duas requisições também podem disputar o mesmo número.

### 3. As proteções atuais são somente visuais

Foram encontrados:

- bloqueio da tecla `F5` em algumas páginas;
- `window.history.forward(1)` em `studio/index.php`;
- bloqueio temporário do botão em `studio/js/ghost_click.js`;
- tratamento de histórico em uma rotina específica de fechamento.

Essas medidas não cobrem:

- botão de atualizar do navegador;
- `Ctrl+R`;
- reenvio confirmado pelo próprio navegador;
- chamada direta ao endpoint;
- duas abas;
- repetição causada por rede;
- JavaScript desativado ou interrompido;
- concorrência entre duas requisições.

### 4. O botão volta a ser habilitado antes do envio

O `ghost_click.js` desabilita o botão, aguarda aproximadamente um segundo, habilita novamente e chama `form.submit()`.

Isso reduz cliques imediatos, mas ainda deixa janela para repetição e não cria qualquer garantia no servidor.

### 5. A operação está dividida em mais de uma requisição

O lançamento financeiro é gravado em `gera*.php`, enquanto `spool` e `spool2` são gravados depois em `via1new*.php`.

Uma interrupção entre as etapas pode produzir:

- lançamento salvo sem spool;
- spool repetido;
- impressão repetida;
- estado parcial difícil de identificar.

## Solução Recomendada

A solução deve ter quatro camadas complementares.

### Camada 1: Token único de operação

Ao abrir o formulário de lançamento, gerar um identificador aleatório e único, por exemplo:

```text
operation_token = valor aleatório criptograficamente seguro
```

O token deve:

- ficar associado à sessão do usuário;
- ser enviado em campo oculto em todas as etapas;
- representar uma única operação de negócio;
- ser aceito para gravação apenas uma vez;
- continuar identificando a operação durante autenticação e impressão.

Não usar data, hora ou número do documento como token, pois podem se repetir.

### Camada 2: Idempotência no servidor

Antes de inserir qualquer lançamento, o servidor deve verificar atomicamente o token.

Comportamento esperado:

```text
token novo      -> reserva o token, grava e marca como concluído
token em curso  -> informa que o lançamento está sendo processado
token concluído -> não grava novamente e redireciona ao resultado existente
token inválido  -> bloqueia a requisição
```

Essa verificação deve ocorrer antes dos `INSERTs`, independentemente de JavaScript ou histórico do navegador.

Sugestão: criar uma tabela de controle, por exemplo `operacoes_caixa`, com:

- `id`;
- `token`, com índice `UNIQUE`;
- `operador`;
- `tipo_operacao`;
- `status` (`PROCESSANDO`, `CONCLUIDA`, `ERRO`);
- `reg`;
- `numdoc`;
- `criado_em`;
- `concluido_em`;
- informações mínimas para auditoria.

### Camada 3: Transação de banco

Cada operação deve ser executada em transação:

```text
BEGIN
  reservar/validar token
  obter número do registro de forma segura
  inserir todos os registros da operação
  gravar ou preparar os dados de spool
  marcar token como concluído
COMMIT
```

Em qualquer falha:

```text
ROLLBACK
```

O cálculo de `último reg + 1` deve ser revisto para evitar concorrência. Alternativas a avaliar durante a implementação:

1. usar identificador `AUTO_INCREMENT` interno e manter `reg` apenas como número operacional;
2. manter um contador diário bloqueado com `SELECT ... FOR UPDATE`;
3. criar uma tabela de sequência por data/caixa.

A escolha depende das chaves e relações reais do banco de produção.

### Camada 4: Navegação e experiência do usuário

Durante o envio:

- desabilitar todos os botões de envio;
- trocar o texto para `Processando...`;
- impedir novos submits no mesmo formulário;
- exibir uma camada visual de processamento;
- avisar ao tentar sair enquanto a requisição estiver em andamento;
- tratar restauração da página pelo cache de histórico (`pageshow`);
- ao voltar para uma operação concluída, redirecionar ao comprovante ou ao menu.

O bloqueio de `F5` e do botão Voltar pode permanecer como apoio, mas não será tratado como segurança.

## Padrão de Navegação Após a Gravação

Aplicar o padrão POST/Redirect/GET:

```text
POST do formulário
        |
        | valida token e grava
        v
HTTP 303 See Other
        |
        v
GET da página de resultado/comprovante
```

Benefícios:

- atualizar a tela final repete apenas um `GET`;
- o navegador não solicita reenvio do formulário;
- o histórico deixa de apontar diretamente para uma resposta de gravação;
- impressão e reimpressão podem consultar uma operação já concluída.

## Plano de Implementação

### Fase 1: Confirmar banco e fronteiras da operação

- levantar a estrutura, índices e chaves de `registro`, `depositos`, `spool` e `spool2`;
- confirmar se `reg` pode se repetir por forma de pagamento e por data;
- identificar todos os endpoints que fazem gravações financeiras;
- definir quais inserts fazem parte da mesma transação;
- definir por quanto tempo os tokens serão mantidos para auditoria.

### Fase 2: Criar o controle central de operações

- criar a tabela de idempotência;
- criar funções PHP reutilizáveis para gerar, reservar, concluir e consultar tokens;
- exigir usuário autenticado e vincular o token ao operador;
- garantir índice único no token;
- padronizar respostas para operação em andamento, concluída e inválida.

### Fase 3: Proteger um fluxo piloto

Começar por `contrato de entrada`:

```text
contrentr.php
  -> confcntentr.php
  -> geracntentr.php
  -> via1newentr.php
```

No piloto:

- gerar o token no início;
- propagá-lo pelos formulários;
- reservar o token antes do primeiro `INSERT`;
- envolver gravações em transação;
- redirecionar com HTTP 303 após o sucesso;
- permitir reimpressão sem nova gravação;
- testar voltar, atualizar, duplo clique e duas abas.

### Fase 4: Expandir para os demais lançamentos

Aplicar o padrão validado a:

- contrato parcelado;
- proposta de entrada;
- produção e produtos;
- concurso;
- despesas;
- depósitos;
- estornos;
- resgate de cheque;
- demais rotinas financeiras encontradas no inventário final.

### Fase 5: Unificar autenticação, resultado e impressão

- separar gravação financeira de renderização HTML;
- fazer páginas de recibo consultarem a operação concluída;
- evitar novos `INSERTs` apenas para reexibir ou reimprimir;
- decidir se `spool` e `spool2` entram na transação principal ou usam uma fila idempotente;
- registrar falhas de impressão sem repetir o lançamento financeiro.

### Fase 6: Padronizar o JavaScript

- substituir os bloqueios isolados por um script único;
- proteger o evento `submit`, não apenas o clique em um botão específico;
- cobrir Enter no teclado e múltiplos botões;
- manter o botão desabilitado depois do envio;
- adicionar mensagem clara de processamento;
- tratar retorno por cache do navegador.

### Fase 7: Auditoria e observabilidade

- registrar tentativas de reutilização de token;
- registrar falha e rollback;
- permitir localizar a operação original pelo token;
- não armazenar senha, hash de login ou o parâmetro completo `c_s` no log;
- criar consulta administrativa para operações com status `PROCESSANDO` ou `ERRO`.

## Matriz de Testes

| Cenário | Resultado esperado |
|---|---|
| Clique único | Um lançamento e um resultado |
| Duplo clique rápido | Um lançamento |
| Pressionar Enter repetidamente | Um lançamento |
| `F5` durante o processamento | Nenhuma duplicidade |
| Atualizar pelo botão do navegador | Nenhuma duplicidade |
| `Ctrl+R` na tela final | Apenas recarrega o resultado |
| Voltar e avançar | Não regrava; mostra ou redireciona ao resultado |
| Confirmar reenvio de formulário | Token impede nova gravação |
| Duas abas com o mesmo formulário | Apenas a primeira conclui |
| Duas requisições simultâneas | Índice único/transação permite uma gravação |
| Falha antes do `COMMIT` | Nenhum dado parcial |
| Falha após lançamento e antes da impressão | Lançamento permanece único e pode ser reimpresso |
| JavaScript desativado | Servidor ainda impede duplicidade |
| Token de outro operador | Requisição bloqueada |
| Token expirado ou inexistente | Requisição bloqueada com mensagem segura |

## Critérios de Aceite

- uma operação de negócio gera no máximo um lançamento financeiro;
- atualizar ou voltar nunca cria outro registro;
- duplo clique não cria outro registro;
- repetição direta do mesmo POST não cria outro registro;
- falha de impressão não repete o lançamento;
- o usuário recebe indicação clara de processamento e conclusão;
- tentativas duplicadas ficam auditáveis;
- as rotinas continuam permitindo múltiplas formas de pagamento dentro da mesma operação;
- não há dados parciais quando uma etapa falha.

## Riscos e Cuidados

- Não criar restrição única apenas por `numdoc`, pois o mesmo documento pode participar de operações válidas diferentes.
- Não criar restrição única apenas por `reg`, pois hoje várias formas de pagamento podem compartilhar o mesmo número.
- Não confiar exclusivamente em sessão ou JavaScript.
- Não alterar todas as rotinas de uma vez antes de validar o fluxo piloto.
- Não misturar bloqueio de navegação com a regra de integridade: são problemas relacionados, mas a idempotência do servidor é a garantia real.
- Revisar o uso atual de `c_s` na URL para não persistir credenciais ou identificadores sensíveis no novo controle.

## Resultado Esperado

Depois da implementação, o colaborador poderá até tentar atualizar, voltar ou reenviar, mas o sistema reconhecerá que a operação já foi processada e não criará outro lançamento. A interface ajudará a evitar ações acidentais, enquanto servidor, transação e banco garantirão a ausência de duplicidade.

## Status

- Diagnóstico concluído em 23/06/2026.
- Plano criado.
- Nenhuma alteração funcional realizada nesta etapa.
- Próximo passo recomendado: executar a Fase 1 e escolher o fluxo piloto.

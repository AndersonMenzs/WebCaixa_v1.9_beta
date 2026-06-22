# Plano de Desenvolvimento — Estoque

## Objetivo

Criar uma área de estoque segura e responsiva para:

- Cadastrar produtos vendidos, materiais e insumos de uso interno;
- Listar e pesquisar todos os itens armazenados;
- Visualizar os dados completos de cada item;
- Excluir ou inativar itens;
- Controlar entradas, vendas, consumo interno, perdas e ajustes;
- Controlar permissões e registrar as operações realizadas.

Exemplos de itens controlados:

- Produtos destinados à venda;
- Produtos de limpeza;
- Produtos de beleza;
- Materiais de escritório;
- Embalagens;
- Materiais descartáveis;
- Uniformes e outros insumos do estabelecimento.

## Visão geral do estoque

O cadastro mestre do estoque será a tabela `estoque_itens`. A tabela
`produtos`, já utilizada pelas rotinas de venda, continuará sendo o catálogo
comercial e poderá ser vinculada a um item do estoque.

Assim:

- Um item vendável terá cadastro em `estoque_itens` e vínculo com `produtos`;
- Um material de uso interno existirá apenas em `estoque_itens`;
- Apenas itens marcados como vendáveis aparecerão nas rotinas de venda;
- Todos os itens poderão receber entradas, ajustes e inventários;
- Materiais internos terão saídas por consumo, uso, perda ou descarte.

Fluxo de produto vendido:

```text
Cadastro em estoque_itens
        ↓
Vínculo com produtos
        ↓
Seleção dos itens da venda
        ↓
Gravação da venda e dos itens
        ↓
Gravação do recebimento em registro
        ↓
Saída automática em estoque_movimentacoes
        ↓
Atualização do saldo do item
```

Fluxo de material de uso interno:

```text
Cadastro em estoque_itens
        ↓
Entrada por compra ou estoque inicial
        ↓
Retirada para setor, funcionário ou atividade
        ↓
Saída por consumo interno
        ↓
Atualização do saldo do item
```

Em caso de estorno:

```text
Estorno do recebimento
        ↓
Cancelamento da venda
        ↓
Movimentação inversa de devolução
        ↓
Reposição automática do saldo
```

As operações financeiras continuarão registradas em `registro`. As novas
tabelas guardarão os dados comerciais e físicos que hoje não existem de forma
estruturada: venda, produtos vendidos, quantidades e movimentações.

## Fase 1 — Estrutura do banco de dados

### Tabela `estoque_itens`

Criar o cadastro mestre de todos os bens de consumo e produtos armazenados:

- ID;
- Código único do item;
- Nome;
- Descrição completa;
- Categoria;
- Tipo: produto para venda, limpeza, beleza, escritório, embalagem,
  descartável ou outro;
- Finalidade: venda, consumo interno ou ambos;
- Unidade de medida;
- Quantidade atual, permitindo valores fracionados quando necessário;
- Estoque mínimo;
- Localização física;
- Preço de venda, quando aplicável;
- Valor de custo;
- Controle por validade: sim ou não;
- Status ativo ou inativo;
- Usuário responsável pelo cadastro;
- Data de cadastro;
- Data da última atualização.

Criar índices para código, nome, categoria, tipo, finalidade e status.

### Integração com a tabela `produtos`

A tabela `produtos` continuará atendendo às telas comerciais existentes.
Adicionar nela uma referência opcional para `estoque_itens`.

Regras:

- O vínculo será obrigatório para produtos cuja venda baixa estoque;
- Materiais de uso interno não precisam de registro em `produtos`;
- O código atual `cod_prod` será mantido por compatibilidade;
- A tela de venda deverá exibir somente produtos ativos e vendáveis;
- Nome e preço comerciais poderão permanecer em `produtos`;
- Saldo, estoque mínimo e movimentações ficarão em `estoque_itens`.

### Tabela `estoque_lotes`

Para produtos com controle de validade, criar:

- ID;
- ID do item do estoque;
- Número ou identificação do lote;
- Data de fabricação, quando informada;
- Data de validade;
- Quantidade disponível no lote;
- Valor de custo;
- Data de entrada;
- Status.

As saídas deverão priorizar o lote com vencimento mais próximo.

### Tabela `vendas`

Criar a tabela `vendas` com:

- ID da venda;
- Número do documento;
- Número do registro/autenticação do caixa;
- Data e hora;
- Operador do caixa;
- Matrícula da vendedora;
- Nome da vendedora;
- Cliente;
- Valor total;
- Status: pendente, concluída ou estornada;
- Data e usuário do estorno, quando aplicável.

O vínculo com a tabela financeira `registro` deverá considerar o número do
documento, o registro do caixa e a data, pois uma venda pode possuir mais de
uma forma de pagamento.

### Tabela `venda_itens`

Criar a tabela `venda_itens` com:

- ID;
- ID da venda;
- ID ou código do produto;
- Nome do produto no momento da venda;
- Quantidade;
- Valor unitário;
- Valor total do item;
- Data de criação.

O nome e os valores serão armazenados também no item para preservar o
histórico, mesmo que o cadastro do produto seja alterado futuramente.

### Tabela `estoque_movimentacoes`

- ID;
- ID do item do estoque;
- ID do item da venda, quando a origem for uma venda;
- Tipo: entrada, saída, ajuste ou devolução;
- Origem: cadastro inicial, compra, venda, estorno, consumo interno, perda,
  descarte, vencimento, devolução ou inventário;
- ID do registro de origem;
- Quantidade movimentada;
- Quantidade anterior;
- Quantidade posterior;
- Valor unitário, quando aplicável;
- Motivo ou observação;
- Setor de destino, quando for consumo interno;
- Funcionário solicitante ou responsável pela retirada;
- Número do documento ou referência, quando aplicável;
- ID da movimentação original, no caso de devolução ou correção;
- Usuário responsável pela movimentação;
- Data e hora da movimentação.

Regras da tabela de movimentações:

- Relacionar todas as movimentações à tabela `estoque_itens`;
- Relacionar a saída de venda ao respectivo registro em `venda_itens`;
- Criar índices para produto, tipo e data da movimentação;
- Não permitir quantidade movimentada igual ou inferior a zero;
- Não permitir que uma saída deixe o saldo negativo;
- Não alterar nem excluir movimentações já concluídas;
- Registrar correções por meio de uma nova movimentação de ajuste;
- Impedir que a mesma venda baixe o estoque duas vezes;
- Impedir que o mesmo estorno devolva o estoque duas vezes;
- Atualizar o saldo do item e registrar a movimentação na mesma transação.

### Tabela `estoque_categorias`

Criar uma tabela configurável para categorias, evitando categorias fixas no
código:

- ID;
- Nome;
- Descrição;
- Status.

Exemplos iniciais: venda, limpeza, beleza, escritório, embalagem e
descartáveis.

### Tabela `estoque_setores`

Criar uma tabela para identificar o destino dos materiais de uso interno:

- ID;
- Nome do setor;
- Descrição;
- Status.

Exemplos: limpeza, atendimento, administração, caixa, produção e banheiro.

### Tabela `estoque_solicitacoes`

Criar uma tabela para controlar os pedidos de materiais:

- ID;
- Número da solicitação;
- Matrícula e perfil do solicitante;
- Setor solicitante;
- Justificativa;
- Status: pendente, aprovada, parcialmente atendida, atendida, recusada ou
  cancelada;
- Usuário responsável pela análise;
- Observação da análise;
- Data e hora da solicitação;
- Data, hora e usuário da primeira visualização pelo almoxarifado;
- Data e hora da análise;
- Data, hora e usuário do envio;
- Data, hora e usuário do recebimento;
- Data, hora e usuário da confirmação de divergência, quando necessária.

### Tabela `estoque_solicitacao_itens`

Criar uma tabela para os itens de cada solicitação:

- ID;
- ID da solicitação;
- ID do item do estoque;
- Quantidade solicitada;
- Quantidade aprovada;
- Quantidade enviada;
- Quantidade recebida;
- Condição do item recebido;
- Quantidade divergente;
- Observação;
- Status do item.

Regras:

- Uma solicitação não deverá alterar o saldo do estoque;
- O estúdio deverá ver quando o pedido foi visualizado pelo almoxarifado;
- O estúdio deverá ser notificado quando o pedido for enviado;
- O almoxarifado deverá ver quando o estúdio confirmou o recebimento;
- Cada envio gerará o registro da saída ou separação em trânsito;
- A quantidade recebida deverá ser conferida pelo estúdio;
- A movimentação deverá guardar o ID da solicitação;
- Não permitir envio superior à quantidade aprovada;
- Não permitir envio que resulte em saldo negativo;
- Concluir automaticamente quando enviado e recebido forem iguais;
- Encaminhar ao almoxarifado quando houver diferença, dano ou falta;
- Exigir uma confirmação do almoxarifado para encerrar divergências;
- Manter o histórico de visualizações, aprovações, envios, recebimentos e
  divergências;
- Solicitações atendidas não poderão ser apagadas.

### Estados da solicitação

```text
Solicitada
    ↓
Visualizada pelo almoxarifado
    ↓
Em análise / separação
    ↓
Enviada ao estúdio
    ↓
Recebida e conferida pelo estúdio
    ├── Sem divergência → Concluída
    └── Com divergência → Aguardando almoxarifado
                              ↓
                    Divergência tratada
                              ↓
                          Concluída
```

## Fase 2 — Segurança e controle de acesso

- Executar a autenticação antes de gerar o HTML;
- Bloquear o acesso de usuários sem permissão;
- Validar os dados recebidos por `GET` e `POST`;
- Utilizar consultas preparadas no banco de dados;
- Adicionar proteção CSRF ao cadastro e à exclusão;
- Evitar o envio de credenciais pela URL;
- Aplicar as permissões no servidor, não apenas ocultar botões na tela;
- Identificar o perfil real do usuário, pois o valor atual `$ch = 'ok'` pode
  representar mais de um tipo de acesso.

### Matriz de permissões

| Operação | Administrador | Auditoria | Encarregada | Caixa |
|---|---:|---:|---:|---:|
| Cadastrar item | Sim | Não | Não | Não |
| Editar item | Sim | Sim | Não | Não |
| Listar itens | Sim | Sim | Sim | Sim |
| Visualizar item | Sim | Sim | Sim | Sim |
| Excluir ou inativar item | Sim | Não | Não | Não |
| Solicitar itens | Sim | Sim | Sim | Não |
| Consultar próprias solicitações | Sim | Sim | Sim | Não |
| Analisar e aprovar solicitações | Sim | Não | Não | Não |
| Registrar envio | Sim | Não | Não | Não |
| Confirmar recebimento | Não | Sim | Sim | Não |
| Tratar divergência | Sim | Não | Não | Não |
| Consultar histórico completo | Sim | Sim | Não | Não |

### Regras por perfil

#### Administrador

- Cadastrar, editar, listar, visualizar e inativar itens;
- Administrar categorias, setores e localizações;
- Registrar entradas, ajustes, perdas e inventários;
- Analisar, aprovar, recusar e entregar solicitações;
- Consultar todas as movimentações e solicitações.

#### Auditoria

- Editar, listar e visualizar itens;
- Criar e acompanhar solicitações;
- Consultar o histórico completo para conferência;
- Não cadastrar, excluir ou inativar itens;
- Não aprovar a própria solicitação;
- Não alterar diretamente a quantidade disponível.

#### Encarregada

- Listar e visualizar os itens;
- Criar e acompanhar as próprias solicitações;
- Não cadastrar, editar, excluir ou movimentar diretamente o estoque.

#### Caixa

- Listar e visualizar os itens;
- Não cadastrar, editar, excluir, solicitar ou movimentar o estoque.

Alterações de quantidade, inclusive pelo administrador ou pela auditoria,
deverão sempre gerar uma movimentação. O saldo nunca será editado diretamente
no cadastro do item.

## Fase 3 — Listagem dos itens

Usar `studio/estoque.php` como página principal da área.

Funcionalidades:

- Exibir todos os itens em uma tabela responsiva;
- Pesquisar por código ou nome;
- Filtrar por categoria, tipo, finalidade, setor e status;
- Distinguir visualmente itens vendáveis e materiais de uso interno;
- Destacar itens com estoque baixo, zerado ou próximos do vencimento;
- Adicionar paginação;
- Exibir as ações conforme o perfil autenticado;
- Mostrar **Novo item** e **Excluir/Inativar** somente ao administrador;
- Mostrar **Editar** ao administrador e à auditoria;
- Mostrar **Solicitar item** ao administrador, à auditoria e à encarregada;
- Manter apenas **Visualizar** para o perfil caixa;
- Apresentar mensagens de sucesso e erro.

## Fase 4 — Cadastro dos itens

Criar o formulário de cadastro com:

- Código;
- Nome;
- Descrição;
- Categoria;
- Tipo;
- Finalidade;
- Unidade de medida;
- Quantidade inicial;
- Estoque mínimo;
- Localização;
- Valor de custo;
- Preço de venda, quando o item for vendável;
- Controle de validade;
- Vínculo com o catálogo `produtos`, quando aplicável;
- Status.

Regras:

- Validar os campos obrigatórios;
- Impedir códigos duplicados;
- Validar quantidades e valores monetários;
- Não aceitar valores negativos;
- Registrar o usuário, a data e a hora do cadastro;
- Exibir uma mensagem após salvar;
- Retornar à listagem após o cadastro.

## Fase 5 — Visualização do item

### Tela principal

Usar `studio/estoque.php` como painel geral:

```text
┌────────────────────────────────────────────────────────────┐
│ Estoque                           [Solicitações] [Novo item]│
├────────────────────────────────────────────────────────────┤
│ Pesquisar  Categoria  Finalidade  Situação  [Filtrar]      │
├────────────────────────────────────────────────────────────┤
│ Total: 120 │ Baixo: 8 │ Zerado: 3 │ Vencendo: 4            │
├──────┬────────────────┬──────────┬───────┬─────────┬────────┤
│ Cód. │ Item           │ Categoria│ Saldo │ Situação│ Ações  │
├──────┼────────────────┼──────────┼───────┼─────────┼────────┤
│ 001  │ Detergente     │ Limpeza  │ 18 UN │ Normal  │ Ver    │
│ 002  │ Shampoo        │ Beleza   │  3 UN │ Baixo   │ Ver    │
│ 003  │ Papel A4       │ Escrit.  │  0 PC │ Zerado  │ Ver    │
└──────┴────────────────┴──────────┴───────┴─────────┴────────┘
```

Exibir indicadores resumidos:

- Total de itens ativos;
- Itens com estoque baixo;
- Itens com estoque zerado;
- Itens próximos do vencimento;
- Solicitações pendentes, quando o perfil possuir acesso.

Usar cores e textos em conjunto, sem depender somente da cor:

- Verde: estoque normal;
- Amarelo: estoque baixo;
- Vermelho: estoque zerado;
- Laranja: próximo do vencimento;
- Cinza: item inativo.

### Tela detalhada

Criar `studio/estoque_visualizar.php` para apresentar:

- Dados completos do item;
- Categoria, tipo e finalidade;
- Quantidade disponível;
- Estoque mínimo;
- Localização física;
- Vínculo com produto comercial, quando existir;
- Situação atual;
- Responsável pelo cadastro;
- Datas de criação e atualização;
- Histórico de movimentações, quando disponível.

A página será organizada em abas:

- **Dados gerais:** cadastro, finalidade, localização e situação;
- **Movimentações:** entradas, saídas, ajustes e devoluções;
- **Lotes e validade:** lotes disponíveis e datas de vencimento;
- **Solicitações:** pedidos relacionados ao item;
- **Vendas:** vendas relacionadas, somente para itens vendáveis.

Exemplo do resumo:

```text
Detergente Neutro — Código 001

Categoria: Limpeza
Finalidade: Consumo interno
Unidade: Frasco
Saldo atual: 18
Estoque mínimo: 10
Localização: Almoxarifado — Prateleira A
Custo unitário: R$ 3,50
Situação: Normal
```

Exemplo do histórico:

```text
Data        Operação          Quantidade  Saldo  Responsável/Destino
22/06/2026  Entrada              +20       25    Administrador
23/06/2026  Consumo interno       -5       20    Setor Limpeza
24/06/2026  Consumo interno       -2       18    Atendimento
```

Cada movimentação deverá permitir consultar sua origem, como venda,
solicitação, compra, ajuste ou estorno.

### Ações conforme o perfil

- **Administrador:** visualizar, editar, movimentar, inativar e analisar
  solicitações;
- **Auditoria:** visualizar, editar, solicitar e consultar o histórico;
- **Encarregada:** visualizar e solicitar;
- **Caixa:** somente visualizar.

Os botões serão exibidos conforme o perfil, mas a autorização também deverá
ser validada no servidor.

### Formulário de solicitação

Ao selecionar **Solicitar item**, apresentar:

```text
Item: Detergente Neutro
Disponível: 18 frascos
Quantidade solicitada: [    ]
Setor de destino:      [ Selecione ]
Justificativa:          [                         ]

                         [Cancelar] [Enviar solicitação]
```

Regras da interface:

- Informar o saldo disponível sem prometer reserva;
- Exigir quantidade, setor e justificativa;
- Exibir confirmação após o envio;
- Registrar a solicitação como pendente;
- Não alterar o saldo até a confirmação da entrega;
- Permitir que o solicitante acompanhe o status.

### Responsividade e acessibilidade

- Adaptar a tabela para cartões ou rolagem horizontal em celulares;
- Usar textos e ícones com descrição;
- Manter contraste suficiente entre texto e fundo;
- Permitir navegação por teclado;
- Identificar claramente campos obrigatórios e mensagens de erro;
- Solicitar confirmação nas ações críticas.

## Fase 6 — Exclusão ou inativação

- Realizar a operação exclusivamente por `POST`;
- Solicitar confirmação antes da exclusão;
- Verificar a permissão do usuário;
- Adotar preferencialmente a exclusão lógica, alterando o status para inativo;
- Impedir exclusões acidentais;
- Registrar o usuário, a data e a hora da operação;
- Permitir uma futura reativação do item.

## Fase 7 — Movimentações manuais de estoque

Implementar:

- Entrada por compra, doação ou estoque inicial;
- Saída para consumo interno;
- Retirada por setor ou funcionário;
- Perda, avaria, vencimento e descarte;
- Devolução ao estoque;
- Ajustes de inventário;
- Motivo da movimentação;
- Quantidade anterior e posterior;
- Data, hora e usuário responsável.

O saldo deverá ser atualizado por meio de transações no banco de dados. Após
esta fase, a quantidade não deverá ser alterada diretamente no cadastro.

Para consumo interno, exigir:

- Item e quantidade;
- Setor de destino;
- Funcionário solicitante ou responsável;
- Motivo da retirada;
- Usuário que autorizou e registrou a operação.

### Fluxo das solicitações

```text
Auditoria ou encarregada cria a solicitação
                    ↓
Administrador analisa disponibilidade
                    ↓
Administrador aprova, aprova parcialmente ou recusa
                    ↓
Administrador separa e registra o envio
                    ↓
Estúdio recebe uma notificação de envio
                    ↓
Estúdio informa as quantidades recebidas
                    ↓
Sistema compara o envio com o recebimento
        ├── Iguais: conclui a solicitação
        └── Diferentes: solicita confirmação do almoxarifado
```

Uma solicitação pendente poderá ser cancelada pelo próprio solicitante. Depois
da entrega, qualquer correção deverá ocorrer por uma movimentação de devolução
ou ajuste, sem apagar o pedido original.

## Fase 8 — Integração com as vendas existentes

### Seleção dos produtos

Alterar as telas de seleção para enviar o ID do produto comercial e o ID do
item de estoque vinculado, e não apenas o nome. O nome continuará sendo
exibido para o usuário.

Materiais destinados somente ao uso interno não aparecerão nessas telas.

Rotinas inicialmente envolvidas:

- `studio/prods_select.php`;
- `studio/confprods.php`;
- `studio/geraprods.php`;
- `studio/via1newprods.php`.

A rotina `geraprod.php`, usada para taxa de produção, somente deverá baixar
estoque se representar de fato a entrega de um item físico.

### Conclusão da venda

Ao confirmar uma venda, executar em uma única transação:

1. Validar novamente o saldo de todos os itens vendidos;
2. Criar o registro em `vendas`;
3. Criar os registros em `venda_itens`;
4. Gravar as formas de pagamento em `registro`;
5. Criar uma saída em `estoque_movimentacoes` para cada item;
6. Atualizar a quantidade atual de cada item de estoque;
7. Confirmar a transação.

Se qualquer etapa falhar, nenhuma parte da venda deverá permanecer gravada.

### Estorno

Integrar as rotinas de estorno existentes:

- `studio/estunico.php`;
- `studio/estmultiplo.php`.

Quando a venda contiver itens físicos:

1. Marcar a venda como estornada;
2. Manter os itens originais para auditoria;
3. Criar uma movimentação de devolução para cada item;
4. Repor as quantidades no estoque;
5. Marcar os registros financeiros como estornados;
6. Executar todas as etapas na mesma transação.

Não excluir a venda, os itens ou as movimentações originais.

### Kits e produtos compostos

Definir se cada kit representa:

- Um produto próprio com saldo independente; ou
- Um conjunto de produtos componentes.

No segundo caso, criar futuramente `produto_composicao`, contendo o produto
kit, o produto componente e a quantidade consumida. A venda de um kit baixará
automaticamente cada componente.

## Fase 9 — Auditoria e relatórios

- Histórico de movimentações por item;
- Itens abaixo do estoque mínimo;
- Itens com estoque zerado;
- Entradas e saídas por período;
- Consumo interno por categoria, setor e funcionário;
- Perdas, avarias, descartes e vencimentos;
- Custo do consumo interno por período;
- Vendas e respectivos itens;
- Movimentações originadas por venda;
- Estornos e devoluções ao estoque;
- Divergências entre vendas e estoque;
- Registro de cadastros, alterações e exclusões;
- Exportação futura para PDF ou planilha.

## Fase 10 — Testes e implantação

- Testar usuários autorizados e não autorizados;
- Testar todas as operações da matriz de permissões;
- Testar acesso direto por URL a uma ação não autorizada;
- Testar campos vazios e dados inválidos;
- Testar códigos duplicados;
- Testar cadastro, listagem, visualização e exclusão;
- Testar pesquisas, filtros e paginação;
- Testar movimentações simultâneas;
- Testar venda com uma e várias formas de pagamento;
- Testar venda com vários produtos;
- Testar retirada de material para consumo interno;
- Testar solicitação, aprovação, recusa e entrega;
- Testar aprovação e entrega parciais;
- Testar registro da visualização pelo almoxarifado;
- Testar notificação de envio para o estúdio;
- Testar conferência do recebimento pelo estúdio;
- Testar recebimento igual ao envio e conclusão automática;
- Testar falta, excesso e item danificado;
- Testar confirmação e tratamento da divergência pelo almoxarifado;
- Confirmar que uma solicitação pendente não altera o saldo;
- Confirmar que somente a entrega baixa o estoque;
- Testar perdas, vencimentos e devoluções;
- Testar item apenas vendável, apenas interno e de uso misto;
- Testar clique ou envio duplicado da venda;
- Testar estorno único e múltiplo;
- Conferir se cada venda baixa o estoque apenas uma vez;
- Conferir se cada estorno devolve o estoque apenas uma vez;
- Testar a interface em computadores e celulares;
- Fazer backup do banco antes da implantação.

## Estrutura de arquivos sugerida

```text
studio/
├── estoque.php
├── estoque_cadastrar.php
├── estoque_editar.php
├── estoque_salvar.php
├── estoque_visualizar.php
├── estoque_excluir.php
├── estoque_movimentar.php
├── estoque_consumo.php
├── estoque_solicitar.php
├── estoque_solicitacoes.php
├── estoque_solicitacao_visualizar.php
├── estoque_solicitacao_analisar.php
├── estoque_solicitacao_entregar.php
├── estoque_solicitacao_receber.php
├── estoque_solicitacao_divergencia.php
├── estoque_historico.php
├── estoque_servico.php
└── venda_estoque_servico.php
```

## Progresso atual

### Interface demonstrativa concluída

Foi criada a primeira versão visual com dados fictícios:

- Painel principal responsivo em `studio/estoque.php`;
- Identidade visual alinhada ao sistema `photovippcloud_erp`;
- Menu lateral azul fixo, com adaptação para dispositivos móveis;
- Barra superior branca com identificação do módulo e do perfil;
- Indicadores de itens ativos, estoque baixo, estoque zerado e vencimento;
- Pesquisa por código ou nome;
- Filtros por categoria, finalidade e situação;
- Tabela responsiva com oito itens fictícios;
- Visualização detalhada em janela modal;
- Histórico fictício de movimentações;
- Formulário demonstrativo de solicitação;
- Mensagens informando que nenhuma ação é gravada;
- Simulação dos perfis administrador, auditoria, encarregada e caixa;
- Botões e ações exibidos de acordo com a matriz de permissões;
- Estilos próprios em `studio/css/estoque.css`;
- Comportamentos da interface em `studio/js/estoque.js`.

Esta etapa valida apenas a experiência visual. Cadastro, edição, exclusão,
solicitações e movimentações ainda não estão conectados ao banco de dados.

A interface foi validada com os quatro perfis demonstrativos: administrador,
auditoria, encarregada e caixa.

### Fluxos demonstrativos concluídos

Também foram criadas telas navegáveis, com formulários e dados fictícios:

- Cadastro em `studio/estoque_cadastrar.php`;
- Edição em `studio/estoque_editar.php`;
- Visualização detalhada em `studio/estoque_visualizar.php`;
- Inativação em `studio/estoque_excluir.php`;
- Entrada, saída, ajuste e devolução em `studio/estoque_movimentar.php`;
- Retirada para consumo interno em `studio/estoque_consumo.php`;
- Histórico de movimentações em `studio/estoque_historico.php`;
- Nova solicitação em `studio/estoque_solicitar.php`;
- Listagem de solicitações em `studio/estoque_solicitacoes.php`;
- Detalhes da solicitação em `studio/estoque_solicitacao_visualizar.php`;
- Análise e aprovação em `studio/estoque_solicitacao_analisar.php`;
- Registro de envio em `studio/estoque_solicitacao_entregar.php`;
- Conferência do recebimento em `studio/estoque_solicitacao_receber.php`;
- Tratamento de divergência em `studio/estoque_solicitacao_divergencia.php`;
- Linha do tempo mostrando visualização, análise, envio e recebimento.

Foi criada uma base compartilhada para manter o layout e os dados fictícios
consistentes:

- `studio/estoque_demo_base.php`;
- `studio/estoque_demo_layout.php`;
- `studio/js/estoque_demo_paginas.js`.

Os arquivos de serviço ainda são apenas respostas demonstrativas e não fazem
alterações:

- `studio/estoque_salvar.php`;
- `studio/estoque_servico.php`;
- `studio/venda_estoque_servico.php`.

### Manual de utilização concluído

Foi criado `MANUAL_ESTOQUE.md`, contendo:

- Visão geral da interface;
- Instruções específicas por perfil;
- Fluxo completo de solicitação e rastreamento;
- Procedimentos de envio, recebimento e divergência;
- Regras operacionais e de segurança;
- Perguntas frequentes;
- Solução de problemas;
- Matriz resumida de permissões;
- Imagens reais das telas simuladas.

As imagens estão em `docs/images/estoque-manual/`.

O manual também pode ser consultado dentro da própria rotina por meio de
`studio/estoque_manual.php`, com índice navegável e ampliação das imagens.

O conteúdo foi ampliado para funcionar como treinamento operacional:

- Rotina diária de trabalho por perfil;
- Capturas adicionais de cadastro, edição, visualização, movimentação,
  histórico, solicitação, análise e envio;
- Imagens numeradas com indicação dos campos e botões;
- Instruções ligadas aos números exibidos nas imagens;
- Regra de conferência física antes de registrar envio ou recebimento.

## Ordem de entrega

### Primeira versão

Implementar as fases 1 a 6 para disponibilizar o cadastro, a listagem, a
visualização e a inativação segura dos itens.

### Segunda versão

Implementar as fases 7 e 8 para adicionar movimentações e integrar o estoque
às vendas e aos estornos existentes.

### Finalização

Implementar os relatórios da fase 9, executar os testes da fase 10 e preparar
a implantação.

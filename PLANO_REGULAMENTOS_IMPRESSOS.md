# Plano: Controle de Regulamentos em Impressos

## Objetivo

Evoluir a tela `studio/impressos.php` para controlar regulamentos por período de validade, evitando que arquivos vencidos continuem disponíveis para impressão.

Atualmente, o sistema lista automaticamente todos os arquivos existentes em `studio/impressos/`. Por isso, qualquer regulamento antigo que permanecer na pasta continua aparecendo para o usuário.

## Proposta

Criar um cadastro/controle de documentos impressos com metadados:

- Nome exibido
- Arquivo PDF
- Tipo do documento
- Data inicial de validade
- Data final de validade
- Situação ativo/inativo

Com isso, a tela de impressos passa a exibir somente documentos válidos para a data atual.

## Modelo Sugerido

Tabela sugerida: `impressos_documentos`

Campos:

- `id`
- `nome`
- `arquivo`
- `tipo`
- `data_inicio`
- `data_fim`
- `ativo`
- `criado_em`
- `atualizado_em`

Exemplo:

```sql
CREATE TABLE impressos_documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    arquivo VARCHAR(255) NOT NULL,
    tipo VARCHAR(50) NOT NULL DEFAULT 'documento',
    data_inicio DATE NULL,
    data_fim DATE NULL,
    ativo CHAR(1) NOT NULL DEFAULT 'S',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME NULL
);
```

## Regra de Exibição

Na tela `studio/impressos.php`, listar apenas documentos:

- ativos
- cujo arquivo exista em `studio/impressos/`
- cuja data atual esteja dentro do período configurado

Regra sugerida:

```sql
SELECT *
FROM impressos_documentos
WHERE ativo = 'S'
  AND (data_inicio IS NULL OR data_inicio <= CURDATE())
  AND (data_fim IS NULL OR data_fim >= CURDATE())
ORDER BY nome;
```

## Fluxo Operacional

1. Colocar o novo PDF em `studio/impressos/`.
2. Cadastrar o documento na tabela `impressos_documentos`.
3. Informar o período de validade.
4. Quando o período vencer, o documento deixa de aparecer automaticamente.
5. O arquivo antigo pode permanecer arquivado, mas não será listado se estiver vencido ou inativo.

## Exemplo de Cadastro

```sql
INSERT INTO impressos_documentos
    (nome, arquivo, tipo, data_inicio, data_fim, ativo)
VALUES
    (
        'REGULAMENTO CONCURSO ESTRELAS 1 FASE 2026',
        'REGULAMENTO_CONCURSO_ESTRELAS_1ª_FASE_2026.pdf',
        'regulamento',
        '2026-01-01',
        '2026-06-30',
        'S'
    );
```

## Alterações Futuras no Sistema

Primeira etapa:

- Criar a tabela.
- Migrar os regulamentos atuais para a tabela.
- Alterar `studio/impressos.php` para buscar documentos pelo banco.
- Manter fallback para arquivos sem cadastro, se necessário.

Segunda etapa:

- Criar uma tela administrativa para cadastrar/editar documentos.
- Permitir ativar/inativar documentos.
- Permitir informar datas de validade sem mexer diretamente no banco.

Terceira etapa:

- Registrar histórico de substituição de regulamentos.
- Exibir aviso para regulamentos próximos do vencimento.
- Bloquear impressão de regulamento vencido mesmo por URL direta.

## Decisão Pendente

Definir se documentos comuns, como ficha cadastral e contrato, também entrarão nesse controle ou se somente arquivos do tipo `regulamento` terão validade.

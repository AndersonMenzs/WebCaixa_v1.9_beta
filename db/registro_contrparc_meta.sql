-- Metadados dos recebimentos de contrato/parcelas.
-- Esta tabela complementa o lancamento financeiro sem alterar a tabela registro.

DROP TABLE IF EXISTS registro_contrparc_meta;

CREATE TABLE registro_contrparc_meta (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    -- Vinculo logico com a operacao gravada em registro.
    reg_operacao INT NOT NULL,
    numdoc CHAR(7) NOT NULL,

    -- Identificacao do recebimento.
    datarec DATE NOT NULL,
    horarec CHAR(5) NOT NULL,
    operador CHAR(8) NOT NULL,
    mat_colaborador CHAR(8) NOT NULL,

    -- Controle da parcela.
    parcela_ini INT NOT NULL,
    parcela_ult INT NOT NULL,
    qtdeparc INT NOT NULL,

    -- Marcadores do fluxo.
    parcial CHAR(1) NOT NULL DEFAULT 'N',
    valor_parcial DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    quitacao CHAR(1) NOT NULL DEFAULT 'N',

    dtcad DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uk_registro_contrparc_meta_operacao (reg_operacao, numdoc, datarec),
    KEY idx_registro_contrparc_meta_operacao (reg_operacao),
    KEY idx_registro_contrparc_meta_numdoc (numdoc),
    KEY idx_registro_contrparc_meta_datarec (datarec),
    KEY idx_registro_contrparc_meta_colaborador (mat_colaborador),
    KEY idx_registro_contrparc_meta_flags (parcial, quitacao)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Observacao:
-- A FK fisica deve ser adicionada somente quando a coluna correta da tabela registro
-- for confirmada como PRIMARY KEY ou UNIQUE e a tabela registro estiver em InnoDB.
-- Exemplo, se existir registro.id:
--
-- ALTER TABLE registro_contrparc_meta
--     ADD COLUMN registro_id BIGINT UNSIGNED NULL AFTER id,
--     ADD KEY idx_registro_contrparc_meta_registro_id (registro_id),
--     ADD CONSTRAINT fk_registro_contrparc_meta_registro
--         FOREIGN KEY (registro_id) REFERENCES registro(id);

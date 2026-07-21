-- Migracao da tabela registro_contrparc_meta antiga para a estrutura atual.
-- Preserva os dados existentes e troca a coluna reg para reg_operacao.

ALTER TABLE registro_contrparc_meta
    DROP INDEX uk_registro_contrparc_meta_operacao,
    DROP INDEX idx_registro_contrparc_meta_registro,
    DROP INDEX idx_registro_contrparc_meta_mat_colaborador,
    CHANGE reg reg_operacao INT NOT NULL,
    MODIFY parcela_ini INT NOT NULL,
    MODIFY parcela_ult INT NOT NULL,
    MODIFY qtdeparc INT NOT NULL,
    ADD UNIQUE KEY uk_registro_contrparc_meta_operacao (reg_operacao, numdoc, datarec),
    ADD KEY idx_registro_contrparc_meta_operacao (reg_operacao),
    ADD KEY idx_registro_contrparc_meta_numdoc (numdoc),
    ADD KEY idx_registro_contrparc_meta_datarec (datarec),
    ADD KEY idx_registro_contrparc_meta_colaborador (mat_colaborador);

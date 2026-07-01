CREATE TABLE IF NOT EXISTS despesa_dp (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    numdoc VARCHAR(30) NOT NULL,
    cod_tiporef VARCHAR(2) NOT NULL,
    mat VARCHAR(8) NOT NULL,
    nome_colab VARCHAR(100) NOT NULL,
    dt_cad DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_despesa_dp_numdoc (numdoc),
    KEY idx_despesa_dp_tiporef (cod_tiporef),
    KEY idx_despesa_dp_mat (mat)
);

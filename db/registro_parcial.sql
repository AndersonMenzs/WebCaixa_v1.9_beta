CREATE TABLE IF NOT EXISTS registro_parcial (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    numdoc CHAR(15) NOT NULL,
    parcela CHAR(2) NOT NULL,
    pedido CHAR(1) NOT NULL DEFAULT 'N',
    parcial CHAR(1) NOT NULL DEFAULT 'N',
    quitacao CHAR(1) NOT NULL DEFAULT 'N',
    valor DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    dt_parcial DATE NOT NULL,
    mat CHAR(8) NOT NULL,
    colab VARCHAR(1000) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

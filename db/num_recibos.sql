-- Tabela de numeros de recibos no WebCaixa
CREATE TABLE IF NOT EXISTS num_recibos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numrec VARCHAR(15) NOT NULL,
    status VARCHAR(1) NOT NULL,
    operador INT(8) NOT NULL,
    data_registro DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_numrec ON num_recibos (numrec);

-- Tabela de números de recibos no bd_vipp
CREATE TABLE IF NOT EXISTS tb_lotes_recibos (
    idRec INT AUTO_INCREMENT PRIMARY KEY,
    codRecStd CHAR(3) NOT NULL,
    numRec CHAR(15) NOT NULL,
    operador INT(8) NOT NULL,
    dtcriado DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_numrec ON tb_lote_recibos (numRec);

-- Tabela de início e fim de números de recibos no bd_vipp
CREATE TABLE IF NOT EXISTS tb_lotes_recibos_rel (
    idRelRec INT AUTO_INCREMENT PRIMARY KEY,
    codRecStd CHAR(3) NOT NULL,
    numIniRec CHAR(15) NOT NULL,
    numFimRec CHAR(15) NOT NULL,
    status CHAR(1) NOT NULL,
    operador INT(8) NOT NULL,
    dtcriado DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_numrec ON tb_lotes_recibos_rel (numIniRec);

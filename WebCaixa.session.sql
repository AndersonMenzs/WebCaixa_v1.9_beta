ALTER TABLE `studio`.`tiporec` 
CHANGE COLUMN `codrec` `codrec` CHAR(2) NULL DEFAULT NULL,
CHANGE COLUMN `siglarec` `siglarec` CHAR(4) NULL DEFAULT NULL;

ALTER TABLE `studio`.`tiporec`
CHANGE COLUMN `nomerec` `nomerec` VARCHAR(30) NULL DEFAULT NULL;

INSERT INTO tiporec (codrec, nomerec, siglarec) VALUES (10,'Taxa de Produção Gratuidade', 'TXPG');

ALTER TABLE `studio`.`registro` 
CHANGE COLUMN `tiporec` `tiporec` CHAR(2) NULL DEFAULT NULL;

ALTER TABLE `studio`.`registro` 
CHANGE COLUMN `numdoc` `numdoc` CHAR(8) NULL;

INSERT INTO registro (reg, numdoc, tiporec, subtipo, modpgto, parcela, datarec, horarec, vlrec, operador, estorno) 
VALUES (1, '21100000', '1', 'TXP', '20', 0, '2025-08-29', '00:00', 0.00, '00000359', '');

ALTER TABLE `studio`.`amizpre` 
CHANGE COLUMN `recib` `recib` CHAR(8) NULL DEFAULT NULL,
CHANGE COLUMN `vlrec` `vlrec` DECIMAL(10,2) NULL DEFAULT NULL;

INSERT INTO formapag (codpag, modpag, siglapag) VALUES (99, 'Gratuidade', 'GRT'); 

ALTER TABLE registro ADD COLUMN mat_vend VARCHAR(8);
ALTER TABLE registro ADD COLUMN vendedora VARCHAR(100);
ALTER TABLE registro ADD COLUMN cliente VARCHAR(100);

SELECT * FROM registro WHERE datarec = '2026-07-21';

SELECT * FROM registro_parcial WHERE dt_parcial = '2026-07-21';